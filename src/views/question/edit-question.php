<div class="row my-5">
	<div class="col-2"></div>
	<div class="col-8">
		<h3>Modifier la question : </h3>
		<form action="" method="post">
			<div class="form-floating form-group my-3">
				<input name="intitule" type="text" class="form-control" id="floatingInput" placeholder="Quel âge as-tu ?" value="<?php echo $question->getIntitule(); ?>" required>
				<label for="floatingInput">Intitulé</label>
			</div>
			<button type="submit" class="btn btn-outline-success">Enregistrer</button>
			<hr>
			<h5>Ajouter des réponses :</h5>
			<div id="reponses-container" class="my-3">
				<div class="form-group">
				<?php
					$idRep;
					foreach($question->getReponses() as $reponses) {
						// var_dump($reponses);
						$isTrue = '';
						$check = '';
						if ($reponses->getIsTrue() == 1) {
							$isTrue = 'on';
							$check = 'checked';
						}
						$text = $reponses->getText();
						$idRep = $reponses->getId();
				?>
						<div class="input-group mb-3">
							<div class="input-group-text">
								<input name="results[<?php echo $idRep ?>]" id="check<?php echo $idRep ?>" class="form-check-input mt-0" type="checkbox" value="on" aria-label="Checkbox for following text input" <?php echo $check ?>>
							</div>
							<input type="text" name="reponses[<?php echo $idRep ?>]" class="form-control" placeholder="Tapez votre réponse..." value="<?php echo $text ?>">
							<button class="btn btn-outline-danger" type="button" id="bt-supp-reponse"><i class="fa fa-times" aria-hidden="true"></i></button>
						</div>
				<?php
					}
				?>
				</div>
			</div>
			<div class="d-grid gap-2 my-3">
				<button id="bt-add-reponse" class="btn btn-outline-primary" type="button"><i class="fa fa-plus-circle fa-2" aria-hidden="true"></i></button>
			</div>
		</form>
	</div>
	<div class="col-2"></div>
</div>

<script>
	$("#bt-add-reponse").on('click', function(e) {
		// On récupère le nombre de form-group se rouvant dans le container des réponses
		// afin de déterminer l'index de la réponse à insérer.
		// var num = $("#reponses-container").find('.form-group').length;
		var num = <?php echo $idRep+1; ?>;
		$("#reponses-container").append('<div class="form-group"><div class="input-group mb-3"><div class="input-group-text"><input name="results['+num+']" id="check'+num+'" class="form-check-input mt-0" type="checkbox" value="on" aria-label="Checkbox for following text input"></div><input type="text" name="reponses[]" class="form-control" id="floatingInput" placeholder="Tapez votre réponse..."><button id="bt-supp-reponse" class="btn btn-outline-danger" type="button"><i class="fa fa-times" aria-hidden="true"></i></button></div></div>')
	});
</script>