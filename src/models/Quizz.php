<?php

namespace models;

class Quizz {
	// PROPRIETES
	private $id;
	private $intitule;
	private $questions;

	// CONSTRUCTEUR
	public function __construct(){
		$this->questions = [];
	}

	// GETTERS/SETTERS
	/**
	 * Get the value of id
	 */ 
	public function getId() {
		return $this->id;
	}

	/**
	 * Set the value of id
	 * @return  self
	 */ 
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Get the value of intitule
	 */ 
	public function getIntitule() {
		return $this->intitule;
	}

	/**
	 * Set the value of intitule
	 * @return  self
	 */ 
	public function setIntitule($intitule) {
		$this->intitule = $intitule;
		return $this;
	}

	/**
	 *	Ajoute une question à la collection de questions du quizz.
	 */
	public function addQuestion($question) {
		array_push($this->questions, $question);
	}

	/**
	 * Get the value of questions
	 */ 
	public function getQuestions() {
		return $this->questions;
	}

	/**
	 * Set the value of questions
	 * @return  self
	 */ 
	public function setQuestions($questions) {
		$this->questions = $questions;
		return $this;
	}
}

?>