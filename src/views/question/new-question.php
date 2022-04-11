
<div class="row my-5">
	<div class="col-2"></div>
	<div class="col-8">
		<h3>Nouvelle question</h3>
		<form action="" method="post">
			<div class="form-floating form-group my-3">
				<input name="intitule" type="text" class="form-control" id="floatingInput" placeholder="Quel âge as-tu ?" required>
				<label for="floatingInput">Intitulé</label>
			</div>
			<button type="submit" class="btn btn-outline-success">Enregistrer</button>
			<hr>
			<h5>Ajouter des réponses :</h5>
			<div id="reponses-container" class="my-3"></div>
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
		var num = $("#reponses-container").find('.form-group').length;
		$("#reponses-container").append('<div class="form-group"><div class="input-group mb-3"><div class="input-group-text"><input name="results['+num+']" id="check'+num+'" class="form-check-input mt-0" type="checkbox" value="on" aria-label="Checkbox for following text input"></div><input type="text" name="reponses[]" class="form-control" id="floatingInput" placeholder="Tapez votre réponse..."></div></div>')
	});
</script>