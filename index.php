<?php

// Mise en place de l'autoloader.
require 'autoload.php';
Autoloader::register();

// On définie une variable ROOT_DIR pour mémoriser la racine du projet
define('ROOT_DIR', 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/php-quizz');

// On récupère l'url de la barre d'adresse
$request = $_SERVER['REQUEST_URI'];

// On nettoie l'url du nom du dossier dans lequel on travaille
$uri = str_replace("/php-quizz", '',$request);

//On éclate la chaine de caractère en tab
$final = explode('/',$uri);

// Avec un switch on prend en charge l'affichage des vues de départ
switch($final[1]) {
	case 'admin':
		require __DIR__.'/src/views/admin.php';
		break;
	default:
		require __DIR__.'/src/views/error404.php';
}


?>