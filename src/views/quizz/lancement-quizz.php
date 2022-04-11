<div class="row my-5">
	<div class="col-2"></div>
	<div class="col-8">
		<h3 aria-describedby="emailHelp">Bon courage, </h3>
		<div id="emailHelp" class="form-text mb-5">Une seule bonne réponse est attendue par question.</div>
		<form action="" method="POST">
		<?php
			foreach($questions as $question) {
		?>
			<div class="my-4">
				<label for="intitule" class="form-label fs-5" ><?php echo $question->getIntitule(); ?></label>
				<div>
				<?php
					$newQuestion = $controllerQuestion->find($question->getId());
					foreach($newQuestion->getReponses() as $reponses) {
				?>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="reponses[<?php echo $question->getId(); ?>]" id="Q<?php echo $question->getId(); ?>R<?php echo $reponses->getId(); ?>" value="<?php echo $reponses->getId(); ?>">
						<label class="form-check-label" for="Q<?php echo $question->getId(); ?>R<?php echo $reponses->getId(); ?>"><?php echo $reponses->getText(); ?></label>
					</div>
				<?php
					}
				?>
				</div>
			</div>

		<?php
			}
		?>
			<div class="d-grid gap-2">
				<button type="submit" class="btn btn-outline-success mt-4">Valider</button>
			</div>
		</form>
	</div>
</div>