<?php

namespace controllers;

use models\Quizz;
use models\Question;
use controllers\ConnexionController;
use controllers\AdminQuestionController;

class AdminQuizzController {
	// PROPRIETES
	private $connexion;
	private $admQuesCont;

	// CONSTRUCTEUR
	public function __construct() {
		$this->connexion = new ConnexionController();
		$this->admQuesCont = new AdminQuestionController();
	}

	// METHODES
	/**
	 *	Function permettant de retrouver tous les quizz.
	 *	@return array $datas	Le tableau de quizz.
	 */
	public function findAll() {
		$sql = 'SELECT * FROM quizz;';
		$req = $this->connexion->connexion->query($sql);
		// On instancie un tableau qui va recevoir toutes les questions de la BDD.
		$datas = [];
		// Avec une boucle on met en place les questions.
		while($obj = $req->fetch_object()) {
			$quizz = new Quizz();
			$quizz->setId($obj->qui_id);
			$quizz->setIntitule($obj->qui_intitule);
			array_push($datas, $quizz);
		}
		return $datas;
	}

	/**
	 *	Fonction qui retourne toutes les informations d'un quizz.
	 *	@param int $idQuizz		L'identifiant du quizz a rechercher.
	 *	@return Quizz					Le quizz qui est retourné.
	 */
	public function findOne($idQuizz) {
		$sql = 'SELECT * FROM quizz qi, question qe, qui_que qq WHERE qi.qui_id=qq.qui_que_quizz_id AND qe.que_id=qq.qui_que_question_id AND qi.qui_id='.$idQuizz.';';
		$req = $this->connexion->connexion->query($sql);
		// Mise en palce du Quizz (Objet)
		$quizz = new quizz();
		$i = 0;
		while($obj = $req->fetch_object()) {
			if ($i == 0) {
				$quizz->setIntitule($obj->qui_intitule);
			}
			// Instanciation et set de la réponse.
			$question = new Question();
			$question->setId($obj->que_id);
			$question->setIntitule($obj->que_intitule);
			// Ajout de la réponse dans le collection de la question.
			$quizz->addQuestion($question);
		}
		return $quizz;
	}

	/**
	 *	Fonction qui retourne toutes les questions associées à un quizz.
	 *	@param	int $idQuizz		L'identifiant du quizz pour lequel on recherche les questions.
	 *	@return array						Le tableau contenant les questions correspondant au quizz sélectionné.
	 */
	public function findAllQuesQuizz(int $idQuizz) {
		$sql = 'SELECT DISTINCT q.que_id, q.que_intitule FROM question q, qui_que qq WHERE q.que_id=qq.qui_que_question_id AND qq.qui_que_quizz_id='.$idQuizz.';';
		$req = $this->connexion->connexion->query($sql);
		// On instancie un tableau qui va recevoir toutes les questions de la BDD.
		$datas = [];
		// Avec une boucle on met en place les questions.
		while($obj = $req->fetch_object()) {
			$question = new Question();
			$question->setId($obj->que_id);
			$question->setIntitule($obj->que_intitule);
			array_push($datas, $question);
		}
		return $datas;
	}

	/**
	 *	Fonction qui permet l'ajout d'un quizz avec les questions selectionnés.
	 *	@param	mixed $post			Les données transmises via le formulaire.
	 *	@return boolean
	 */
	public function addQuizz($post) {
		$intitule = $this->admQuesCont->conformDataText($post['intitule']);
		$sql = 'INSERT INTO quizz (qui_intitule) VALUES ("'.$intitule.'");';
		$this->connexion->connexion->query($sql);
		// Récupération de l'Id de la question qui vient d'être insérée.
		$id = $this->connexion->connexion->insert_id;
		// Si la question est cochée alors on l'ajoute au quizz.
		foreach($post['dedans'] as $idQuestion) {
			$sql = 'INSERT INTO qui_que (qui_que_quizz_id, qui_que_question_id) VALUES ('.$id.','.$idQuestion.');';
			$this->connexion->connexion->query($sql);
		}
		return true;
	}

	/**
	 *	Fonction permettant la mise à jour d'un quizz.
	 *	@param int		$idQuizz		L'identifiant du quizz à mettre à jour.
	 *	@param mixed	$post				Les données transmises via le formulaire POST.
	 *	@param boolean
	 */
	public function updateQuizz(int $idQuizz,$post) {
		$intitule = $this->admQuesCont->conformDataText($post['intitule']);
		$sql = 'UPDATE quizz SET qui_intitule="'.$intitule.'" WHERE qui_id='.$idQuizz.';';
		$req = $this->connexion->connexion->query($sql);
		// Si la requete est passé alors on continue.
		if ($req) {
			$sql = 'DELETE FROM qui_que WHERE qui_que_quizz_id='.$idQuizz.';';
			$req = $this->connexion->connexion->query($sql);
			// Si la requete est passé alors on continue.
			if ($req) {
				foreach($post['dedans'] as $idQuestion) {
					$sql = 'INSERT INTO qui_que (qui_que_quizz_id, qui_que_question_id) VALUES ('.$idQuizz.','.$idQuestion.');';
					$req = $this->connexion->connexion->query($sql);
				}
			}
		}
		return $req;
	}

	/**
	 *	Fonction qui permet de supprimer un quizz.
	 *	@param	int $idQuizz		L'identifiant du quizz à supprimer.
	 *	@return boolean
	 */
	public function delete(int $idQuizz) {
		// On commence par supprimer les questions lié au quizz dans la qui_que. 
		$sql = 'DELETE FROM qui_que WHERE qui_que_quizz_id='.$idQuizz.';';
		$req = $this->connexion->connexion->query($sql);
		// Si réponse positive alors on DELETE le quizz.
		if ($req) {
			$sql = 'DELETE FROM quizz where qui_id='.$idQuizz.';';
			$req = $this->connexion->connexion->query($sql);
		}
		return $req;
	}

	/**
	 * 	Fonction qui permet de faire vérifier ces questions à un quizz.
	 * 	@param	mixed $post			Toutes les infos retounées.
	 * 	@return int 						Le score obtenu après vérification des réponses.
	 */
	public function validate($post) {
		$score = 0;
		foreach($post['reponses'] as $key=>$value) {
			$sql = 'SELECT rep_id FROM reponse WHERE rep_istrue=1 AND rep_question_id='.$key.';';
			$req = $this->connexion->connexion->query($sql);
			$true = $req->fetch_object()->rep_id;
			// Si la valeur correspond à la réponse correct alors on incrémente le score de 1.
			if ($value == $true) {
				$score++;
			}
		}
		return $score;
	}

	/**
	 *	Fonction qui permet renvoyer le message adéquat.
	 *	@param int $score					Le score obtenue par l'user sur le quizz.
	 *	@param int $nbrQuestion		Le nombre de question du quizz.
	 */
	public function msgScore(int $score, int $nbrQuestion) {
		if ($score <= $nbrQuestion/3) {
			$msgType = 'danger';
		} else if ($score <= $nbrQuestion/2) {
			$msgType = 'warning';
		} else {
			$msgType = 'success';
		}
		return $msgType;
	}
}
?>