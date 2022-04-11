<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include('_head.php'); ?>
		<title>Erreur 404</title>
	</head>
	<body>
		<?php include('_admin-navbar.php'); ?>
		<main>
			<div class="container text-center py-5">
				<div class="row p-4 pb-0 pe-lg-0 pt-lg-5 rounded-3 border shadow-lg bg-light">
					<div class="col-2"></div>
					<div class="col-lg-8 p-3 p-lg-5 pt-lg-3">
						<h1 class="display-4 fw-bold lh-1 pb-4"><i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i> Erreur 404 <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i></h1>
						<p class="lead pb-2">L'adresse demandé ne correspond à aucune adresse connue. Veuillez réessayer en modifiant l'url. Ou cliquez sur le bouton ci-dessous pour vous rediriger vers le menu Quizz.</p>
						<a href="<?php echo ROOT_DIR.'/admin/quizz'; ?>">
							<button type="button" class="btn btn-outline-success btn-lg px-4 me-md-2 fw-bold">QUIZZ</button>
						</a>
					</div>
				</div>
			</div>
		</main>
		<?php include('_admin-footer.php'); ?>
	</body>
</html>