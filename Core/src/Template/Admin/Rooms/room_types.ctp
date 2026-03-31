<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>

	<div class="rows">
		<h3 class="text-center"><?= __d('buildings', 'List Of Room Types') ?></h3>

		<span class="text-right float-right mb-3"><?= $this->Html->link('Add Room Type', ['action' => 'addRoomType'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('buildings', 'SL') ?></th>
					<th><?= __d('buildings', 'Type') ?></th>
					<th><?= __d('buildings', 'Action') ?></th>

				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($rooms_type as $type) {
				?>
					<tr>
						<td><?= $type->id  ?></td>
						<td><?= $type->type ?></td>
						<td>
							<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'editRoomType', $type->id], ['class' => 'btn action-btn btn-warning', 'escape' => false]) ?>
							</td>

					</tr>
				<?php } ?>

			</tbody>
		</table>
	</div>
	<nav aria-label="Page navigation example">
		<ul class="pagination mt-5 custom-paginate justify-content-center">
			<li class="page-item"> <?= $this->Paginator->first("First") ?></li>
			<li class="page-item"><?= $this->Paginator->prev("<<") ?></li>
			<li class="page-item"><?= $this->Paginator->numbers() ?></li>
			<li class="page-item"><?= $this->Paginator->next(">>") ?></li>
			<li class="page-item"><?= $this->Paginator->last("Last") ?></li>
		</ul>
	</nav>
</body>

</html>