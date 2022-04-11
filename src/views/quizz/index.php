<div class="text-center">
	<h1>Quizz :</h1>
	<div class="d-grid gap-3 col-3 mx-auto my-4">
		<select id="selectQuizz" class="form-select" aria-label="Default select example">
			<option value="placeholder">Choisissez le quizz</option>
		<?php
			foreach ($quizz as $quiz) {
		?>
			<option value="<?php echo $quiz->getId();?>"><?php echo $quiz->getIntitule();?></option>
		<?php
			}
		?>
		</select>
		<div id="divActionQuizz-container" class="col-12 d-grid gap-3"></div>
		<hr>
		<a href="./quizz/new"class="btn btn-outline-info" type="button"><i class="fa fa-plus" aria-hidden="true"></i> Ajouter un quizz</a>
	</div>
</div>

<script type="text/javascript">
	$('#selectQuizz').change( function(e) {
		var valSelect = $('#selectQuizz').val();
		if (valSelect === 'placeholder') {
			$('a').remove('#actionQuizz');
		} else {
			var alreadyAppend = $('#ActionQuizz');
			if (alreadyAppend) {
				$('a').remove('#actionQuizz');
			}
			$('#divActionQuizz-container').append('<a id="actionQuizz" href="./quizz/lancement/'+valSelect+'" class="btn btn-outline-primary" type="button"><i class="fa fa-arrow-right" aria-hidden="true"></i> Lancer</a><a id="actionQuizz" href="./quizz/edit/'+valSelect+'" class="btn btn-outline-success" type="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifier le quizz</a><a id="actionQuizz" href="./quizz/delete/'+valSelect+'" class="btn btn-outline-danger" type="button"><i class="fa fa-trash-o" aria-hidden="true"></i> Supprimer le quizz</a>');
		}
	});
</script>