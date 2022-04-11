<?php
namespace controllers;

use mysqli;

class ConnexionController {
	// PROPRIETES
	private	$bddUser = 'root';
	private	$bddPassword = '';
	private	$server = 'localhost';
	private	$bddName = 'php_quizz';
	public	$connexion;

	// CONSTRUCTEUR
	/**
	 * 	@return $connexion boolean	Valeur de retour.
	 */
	public function __construct() {
		// On vérifie si il n'y a pas de connexion existante.
		if (!isset($this->connexion)) {
			$this->connexion = new mysqli($this->server, $this->bddUser, $this->bddPassword, $this->bddName);
			// On déclenche une erreur si on ne s'est pas co ($this->connexion == false).
			if (!isset($this->connexion)) {
				echo 'Erreur de connexion à la base de données.';
				exit;
			}
		}
		// On renvoie la connexion active
		return $this->connexion;
	}
}



?>