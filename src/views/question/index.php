<div class="row my-5">
	<div class="col-1"></div>
	<div class="col-10">
		<div class="d-flex justify-content-between align-items-center">
			<h2>Liste des questions</h2>
			<a href="question/new"><button type="button" class="btn btn-primary">Ajouter</button></a>
		</div>
		<?php
			if (count($questions) === 0) {
				echo '<p>Aucune question dans le BDD</p>';
			} else { ?>
				<table class="table table-striped table-hover table-bordered my-2">
					<thead>
						<tr>
							<th class="text-center">Id</th>
							<th>Intitulé</th>
							<th class="text-center">Actions</th>
						</tr>
					</thead>
					<tbody>
					<?php
						foreach ($questions as $question) {
							echo '<tr><td class="text-center">'.$question->getId().'</td>';
							echo '<td>'.$question->getIntitule().'</td>';
							echo '<td class="text-center"><a href="question/delete/'.$question->getId().'" class="btn btn-outline-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
							echo '<a href="question/edit/'.$question->getId().'" class="btn btn-outline-primary ms-3"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>';
							echo '</tr>';
						}
					?>
					</tbody>
				</table>
		<?php
			}
		?>
	</div>
</div>