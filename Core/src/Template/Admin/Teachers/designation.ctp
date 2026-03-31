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
		<h3 class="text-center"><?= __d('setup', 'All designations') ?></h3>

		<span class="text-right float-right mb-3"><?php echo $this->Html->link('Add designation', ['action' => 'addDesignation'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('setup', 'ID') ?></th>
					<th><?= __d('setup', 'Designation') ?></th>
					<th><?= __d('setup', 'Action') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($datas as $data) {
				?>
					<tr>
						<td><?php echo $data->id  ?></td>
						<td><?php echo $data->name ?></td>
						<td>
							<?php echo $this->Html->link('Edit', ['action' => 'editDesignation', $data->id], ['class' => 'btn action-btn btn-warning']) ?>
							<?php $this->Form->postLink('Delete', ['action' => 'editDesignation', $data->id], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>

						</td>
					</tr>
				<?php } ?>

			</tbody>
		</table>
	</div>
</body>

</html>