<?php

class Autoloader {
	/**
	 * 	Fonction static permet l'enregistrement de l'autoloader dans l'app.
	 */
	static function register() {
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	/**
	 * 	Fonction qui charge les classes appelées.
	 * 	@param className
	 */
	static function autoload($className) {
		require 'src/'.$className.'.php';
	}
}

?>