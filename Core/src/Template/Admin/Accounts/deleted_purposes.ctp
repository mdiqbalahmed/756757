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
		<h3 class="text-center"><?= __d('accounts', 'All Purposes') ?></h3>

		<span class="text-right float-right mb-3"><?= $this->Html->link('Add Purpose', ['action' => 'addPurpose'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('accounts', 'ID') ?></th>
					<th><?= __d('accounts', 'Purpose name') ?></th>
					<th><?= __d('accounts', 'Purpose Parent') ?></th>
					<th><?= __d('accounts', 'Action') ?></th>

				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($purposes as $purpose) {
				?>
					<tr>
						<td><?= $purpose->purpose_id ?></td>
						<td><?= $purpose->purpose_name ?></td>
						<td><?= $purpose->parent_name ?></td>
						<td>
							<?= $this->Form->postLink('Restore', ['action' => 'restorePurposes',  $purpose['purpose_id']], ['class' => 'btn action-btn btn-success', 'confirm' => 'Are you sure, You want restore this?']) ?>
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