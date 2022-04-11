<?php

namespace models;

class Reponse {
	// PROPRIETES
	private $id;
	private $text;
	private $isTrue;

	// GETTERS/SETTERS
	/**
	 *	Get the value of id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 *	Set the value of id
	 *	@return  self
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 *	Get the value of text
	 */
	public function getText() {
		return $this->text;
	}

	/**
	 *	Set the value of text
	 *	@return  self
	 */
	public function setText($text) {
		$this->text = $text;
		return $this;
	}

	/**
	 *	Get the value of isTrue
	 */
	public function getIsTrue() {
		return $this->isTrue;
	}

	/**
	 *	Set the value of isTrue
	 *	@return  self
	 */
	public function setIsTrue($isTrue) {
		$this->isTrue = $isTrue;
		return $this;
	}
}

?>