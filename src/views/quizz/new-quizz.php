<div class="row my-5">
	<div class="col-2"></div>
	<div class="col-8">
		<h3>Nouveau quizz</h3>
		<form action="" method="post">
			<div class="form-floating form-group my-3">
				<input name="intitule" type="text" class="form-control" id="floatingInput" placeholder="Quel âge as-tu ?" required>
				<label for="floatingInput">Intitulé du quizz</label>
			</div>
			<table class="table table-striped table-hover table-bordered my-2">
				<thead>
					<tr>
						<th class="text-center">In</th>
						<th>Question</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (count($questions) === 0) {
						echo '<p>Aucune question dans le BDD</p>';
					} else {
						foreach ($questions as $question) {
					?>
						<tr>
							<td class="text-center"><input class="form-check-input" type="checkbox" name="dedans[<?php echo $question->getId()?>]" id="check<?php echo $question->getId()?>" value="<?php echo $question->getId()?>"></td>
							<td><?php echo $question->getIntitule(); ?></td>
						</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
			<div class="text-end">
				<button type="submit" class="btn btn-outline-success">Enregistrer</button>
			</div>
		</form>
	</div>
	<div class="col-2"></div>
</div>