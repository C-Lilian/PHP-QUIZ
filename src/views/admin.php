<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			use controllers\AdminQuizzController;
			use controllers\AdminQuestionController;
			include('_head.php');
		?>
		<title>Admin</title>
	</head>
	<body>
		<?php include('_admin-navbar.php'); ?>
		
		<main class="container bg-white shadow py-5">
		<?php
			// Si des paramètres de session :
			if (isset($_SESSION['message'])) {
				if ($_SESSION['message'][0] === 'success') {
					$icon = '<i class="fa fa-check-circle-o fa-2x me-2" aria-hidden="true"></i>';
				}
				if ($_SESSION['message'][0] === 'danger' || $_SESSION['message'][0] === 'warning' ) {
					$icon = '<i class="fa fa-exclamation-triangle fa-2x me-2" aria-hidden="true"></i>';
				}
				echo '<div class="row"><div class="col-2"></div><div class="col-8"><div class="alert alert-'.$_SESSION['message'][0].' d-flex align-items-center border border-'.$_SESSION['message'][0].'">'.$icon.' '.$_SESSION['message'][1].'</div></div></div>';
				// Suppression du message
				unset($_SESSION['message']);
			}

			// On récupère la variable $uri disponible au niveau d'index.php.
			// On explode en tableau.
			$toAdmin = explode('/', $uri);
			if (count($toAdmin) === 2) {
				require(__DIR__.'/dashboard.php');
			} else {
				// On vérifie si on a question dans la route.
				if (in_array("question", $toAdmin)) {
					// On instancie un controller dédié.
					$controller = new AdminQuestionController();
					if (count($toAdmin) >= 4) {
						if ($toAdmin[3] === 'delete') {
							if ($controller->remove($toAdmin[4])) {
								$_SESSION['message'] = ['success', 'Question supprimée !'];
							} else {
								$_SESSION['message'] = ['danger', 'Un problème est survenu lors de la suppression.'];
							}
							header('Location:'.ROOT_DIR.'/admin/question');
						}
						if ($toAdmin[3] === 'new') {
							// On vérifie si il existe des données postées dans la requête.
							if (!empty($_POST)) {
								// Ajout de la question en BDD
								if ($controller->add($_POST)) {
									$_SESSION['message'] = ['success', 'Votre question a bien été ajoutée !'];
								} else {
									$_SESSION['message'] = ['danger', 'Un problème est survenu lors de l\'ajout.'];
								}
								header('Location:'.ROOT_DIR.'/admin/question');
							}
							// Sinon on affiche le formulaire d'ajout.
							require(__DIR__.'/question/new-question.php');
						}
						if ($toAdmin[3] === 'edit') {
							// On vérifie qu'il existe des données postées dans le requête.
							if (!empty($_POST)) {
								// Méthode Prof
								$question = $controller->find($toAdmin[4]);
								if ($controller->updateBis($toAdmin[4], $_POST, $question)) {
								// if ($controller->update($toAdmin[4], $_POST)) {
									$_SESSION['message'] = ['success', 'Votre question a bien été modifiée !'];
								} else {
									$_SESSION['message'] = ['danger', 'Un problème est survenu lors de la modification.'];
								}
								header('Location:'.ROOT_DIR.'/admin/question');
							}
							$question = $controller->find($toAdmin[4]);
							require(__DIR__.'/question/edit-question.php');
						}
					} else {
						$questions = $controller->findAll();
						require(__DIR__.'/question/index.php');
					}
				}
				if (in_array("quizz", $toAdmin)) {
					// On instancie les controllers dédiés.
					$controllerQuizz = new AdminQuizzController();
					$controllerQuestion = new AdminQuestionController();
					if (count($toAdmin) >= 4) {
						if ($toAdmin[3] === 'delete') {
							if ($controllerQuizz->delete($toAdmin[4])) {
								$_SESSION['message'] = ['success', 'Quizz supprimée !'];
							} else {
								$_SESSION['message'] = ['danger', 'Un problème est survenu lors de la suppression du quizz.'];
							}
							header('Location:'.ROOT_DIR.'/admin/quizz');
						}
						if ($toAdmin[3] === 'new') {
							if (!empty($_POST)) {
								if($controllerQuizz->addQuizz($_POST)) {
									$_SESSION['message'] = ['success', 'Le quizz et ses questions associés ont bien été ajoutés !'];
								} else {
									$_SESSION['message'] = ['danger', 'Un problème est survenu lors de l\'ajout du quizz.'];
								}
								header('Location:'.ROOT_DIR.'/admin/quizz');
							}
							$questions = $controllerQuestion->findAll();
							require(__DIR__.'/quizz/new-quizz.php');
						}
						if ($toAdmin[3] === 'edit') {
							// On vérifie qu'il existe des données postées dans le requête.
							if (!empty($_POST)) {
								if ($controllerQuizz->updateQuizz($toAdmin[4], $_POST)) {
									$_SESSION['message'] = ['success', 'Votre quizz a bien été modifiée !'];
								} else {
									$_SESSION['message'] = ['danger', 'Un problème est survenu lors de la modification du quizz.'];
								}
								header('Location:'.ROOT_DIR.'/admin/quizz');
							}
							$quizz = $controllerQuizz->findOne($toAdmin[4]);
							$questions = $controllerQuestion->findAll();
							require(__DIR__.'/quizz/edit-quizz.php');
						}
						if ($toAdmin[3] === 'lancement') {
							if (!empty($_POST)) {
								$score = $controllerQuizz->validate($_POST);
								if (is_int($score)) {
									$nbrLigne = $controllerQuestion->nbrQuestion();
									$msgType = $controllerQuizz->msgScore($score,$nbrLigne);
									$_SESSION['message'] = [$msgType, 'Quizz terminé, votre score est de '.$score.' !'];
								} else {
									$_SESSION['message'] = ['danger', 'Un problème est survenu lors de la validation du quizz.'];
								}
								header('Location:'.ROOT_DIR.'/admin/quizz');
							}
							$questions = $controllerQuizz->findAllQuesQuizz($toAdmin[4]);
							require(__DIR__.'/quizz/lancement-quizz.php');
						}
					} else {
						$quizz = $controllerQuizz->findAll();
						require(__DIR__.'/quizz/index.php');
					}
				}
			}
		?>
		</main>
		<?php include('_admin-footer.php'); ?>
	</body>
</html>