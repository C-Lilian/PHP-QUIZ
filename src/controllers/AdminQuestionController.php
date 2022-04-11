<?php

namespace controllers;

use models\Reponse;
use models\Question;
use controllers\ConnexionController;

class AdminQuestionController {
	// PROPRIETES
	private $connexion;

	// CONSTRUCTEUR
	public function __construct() {
		$this->connexion = new ConnexionController();
	}

	// METHODES
	/**
	 *	Fonction qui renvoie le nombre de question total.
	 *	@return int				Le nombre de question.
	 */
	public function nbrQuestion() {
		$sql = 'SELECT count(*) as nbrLigne FROM question;';
		$req = $this->connexion->connexion->query($sql);
		// Avec une boucle on met en place les questions.
		$nbrQue = $req->fetch_object()->nbrLigne;
		return $nbrQue;
	}

	/**
	 *	Récupère toutes les questions et les renvoie en tableau.
	 *	@return array			Le tableau de question retourné.
	 */
	public function findAll() {
		// On execute une requête via le ConnexionController instancié dans le constructeur
		// et sa propriété public $connexion ($this->connexion).
		// Ensuite on utilise la propriété connexion de mysqlid pour exécuter la requête (->connexion).
		$req = $this->connexion->connexion->query('SELECT * FROM question ;');
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
	 * 	Méthode qui renvoie une question et ses réponses.
	 * 	@param	int $idQuestion	L'identifiant de la question que l'on cherche.
	 * 	@return Question				La question cherchée.
	 */
	public function find(int $idQuestion) {
		$sql = 'SELECT * FROM question as q JOIN reponse as r On r.rep_question_id = q.que_id WHERE q.que_id='.$idQuestion.' ORDER BY r.rep_id ASC;';
		$req = $this->connexion->connexion->query($sql);
		// Mise en palce de la question (Objet)
		$question = new Question();
		$i = 0;
		while($obj = $req->fetch_object()) {
			if ($i == 0) {
				$question->setIntitule($obj->que_intitule);
			}
			// Instanciation et set de la réponse.
			$reponse = new Reponse();
			$reponse->setId($obj->rep_id);
			$reponse->setText($obj->rep_text);
			$reponse->setIsTrue($obj->rep_istrue);
			// Ajout de la réponse dans le collection de la question.
			$question->addReponse($reponse);
		}
		return $question;
	}

	/**
	 * 	Fonction qui permet de supprimer une question.
	 * 	@param int $idQuestion 	L'identifiant de la question à retirer.
	 */
	public function remove(int $idQuestion) {
		// On commence par supprimer les réponses liées aux questions.
		$sql = 'DELETE FROM reponse where rep_question_id='.$idQuestion.';';
		$this->connexion->connexion->query($sql);
		// On supprime la question une fois que plus aucune réponse y est liée.
		$sql = 'DELETE FROM question where que_id ='.$idQuestion.';';
		return $this->connexion->connexion->query($sql);
	}

	/**
	 * 	Fonction qui permet d'ajouter une question et ses réponses associées.
	 * 	@param	mixed $post			Le formulaire d'ajout en POST.
	 *	@return boolean
	 */
	public function add($post) {
		$intitule = $this->conformDataText($post['intitule']);
		$sql = 'INSERT INTO question (que_intitule) VALUES ("'.$intitule.'");';
		$this->connexion->connexion->query($sql);
		// Récupération de l'Id de la question qui vient d'être insérée.
		$id = $this->connexion->connexion->insert_id;
		// Prise en charge des réponses.
		$i = 0;
		foreach($post['reponses'] as $reponse) {
			$texte = $this->conformDataText($reponse);
			$isTrue = (!isset($post['results'][$i])) ? 0 : 1;
			$sql = 'INSERT INTO reponse (rep_text, rep_istrue, rep_question_id) VALUES ("'.$texte.'",'.$isTrue.','.$id.')';
			$this->connexion->connexion->query($sql);
			$i++;
		}
		return true;
	}

	/**
	 * 	Function qui permet de mettre à jour une question et ses réponses.
	 * 	@param	int $idQuestion		L'identifiant de la quesion à mettre à jour.
	 * 	@param	mixed $post				Toutes les informations retournées en post.
	 * 	@return boolean						Si tous c'est bien passé alors return True.
	 */
	public function update($idQuestion, $post) {
		$intitule = $this->conformDataText($post['intitule']);
		$sql = 'UPDATE question SET que_intitule="'.$intitule.'" WHERE que_id='.$idQuestion.';';
		$this->connexion->connexion->query($sql);
		$sql = 'SELECT rep_id FROM reponse WHERE rep_question_id='.$idQuestion.';';
		$req = $this->connexion->connexion->query($sql);
		$numRepEx = mysqli_num_rows($req);
		$i = 0;
		// Le foreach $key-$value permet avec $key de récupérer l'id de la réponse.
		foreach($post['reponses'] as $key=>$value) {
			$texte =  $this->conformDataText($value);
			$isTrue = (!isset($post['results'][$key])) ? 0 : 1;
			if ($i < $numRepEx) {
				$sql = 'UPDATE reponse SET rep_text="'.$texte.'", rep_istrue='.$isTrue.' WHERE rep_id='.$key.';';
			} else {
				$sql = 'INSERT INTO reponse (rep_text, rep_istrue, rep_question_id) VALUES ("'.$texte.'",'.$isTrue.','.$idQuestion.')';
			}
			$i++;
			$this->connexion->connexion->query($sql);
		}
		return true;
	}

	/**
	 *	Function qui permet de mettre à jour une question et ses réponses. (Version Prof)
	 * 	@param	int		$idQuestion		L'identifiant de la quesion à mettre à jour.
	 * 	@param	mixed	$post					Toutes les informations retournées en post.
	 * 	@param	mixed	$question			La question a modifier.
	 * 	@return boolean							Si tous c'est bien passé alors return True.
	 */
	public function updateBis($idQuestion, $post, $question) {
		// Dans un premier temps on récupère les réponses actuelles.
		$reponseActuelles = [];
		foreach($question->getReponses() as $reponses) {
			$rId = $reponses->getId();
			array_push($reponseActuelles, $rId);
		}
		// On mets à jour l'intitulé de la question.
		$intitule = $this->conformDataText($post['intitule']);
		$sql = 'UPDATE question SET que_intitule="'.$intitule.'" WHERE que_id='.$idQuestion.';';
		$this->connexion->connexion->query($sql);
		// Si il y a des réponses. (devrait être changer en au moins 2 réponses.)
		if (!is_null($post['reponses'])) {
			// Le foreach $key-$value permet avec $key de récupérer l'id de la réponse.
			foreach($post['reponses'] as $key=>$value) {
				$texte =  $this->conformDataText($value);
				$isTrue = (!isset($post['results'][$key])) ? 0 : 1;
				// Si la réponse faisait déjà parties de la question alors Update sinn INSERT.
				if (in_array($key, $reponseActuelles)) {
					$sql = 'UPDATE reponse SET rep_text="'.$texte.'", rep_istrue='.$isTrue.' WHERE rep_id='.$key.';';
					array_splice($reponseActuelles, array_keys($reponseActuelles, $key)[0], 1);
				} else {
					'INSERT INTO reponse (rep_text, rep_istrue, rep_question_id) VALUES ("'.$texte.'",'.$isTrue.','.$idQuestion.')';
				}
				$this->connexion->connexion->query($sql);
			}
		}
		die();
		// Si parmi la maj il y a plus l'ancienne réponse alors on DELETE.
		if (count($reponseActuelles)>0) {
			foreach($reponseActuelles as $id) {
				$sql = 'DELETE FROM reponse WHERE rep_id='.$id.';';
				$this->connexion->connexion->query($sql);
			}
		}
		return true;
	}

	/**
	 * 	Fonction qui met en forme un text, pour que le format soit sécur pour la BDD.
	 * 	@param	string $text		Le texte a vérifier.
	 * 	@return string 					Le texte véifié.
	 */
	public function conformDataText($text) {
		return htmlentities(htmlspecialchars(ucfirst($text)));
	}

	/** DEPRECATED -- DEPLACER DANS AdminQuizzController.php
	 * 	Fonction qui permet de faire vérifier ces questions à un quizz.
	 * 	@param	mixed $post			Toutes les infos retounées.
	 * 	@return int							Le score obtenu après vérification des réponses.
	 */
	public function validate($post) {
		$score = 0;
		foreach($post['reponses'] as $key=>$value) {
			$sql = 'SELECT rep_id FROM reponse WHERE rep_istrue=1 AND rep_question_id='.$key.';';
			$req = $this->connexion->connexion->query($sql);
			$true = $req->fetch_object()->rep_id;
			if ($value == $true) {
				$score++;
			}
		}
		return $score;
	}
}

?>