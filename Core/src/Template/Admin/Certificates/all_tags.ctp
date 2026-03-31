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
		<h3 class="text-center"><?= __d('Certificates', 'List of All Tag') ?></h3>

		<span class="text-right float-right mb-3"><?php echo $this->Html->link('Add a New Tag', ['action' => 'addTags'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('Certificates', '#') ?></th>
					<th><?= __d('Certificates', 'Tag Name') ?></th>
					<th><?= __d('Certificates', 'Tag Description') ?></th>
					<th><?= __d('Certificates', 'Action') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($tags as $tag) {
				?>
					<tr>
						<td><?php echo $tag['tag_id']   ?></td>
						<td><?php echo $tag['tag'] ?></td>
						<td><?php echo $tag['tag_description'] ?></td>
						<td>
							<?php echo $this->Html->link('Edit', ['action' => 'editTags', $tag['tag_id']], ['class' => 'btn action-btn btn-warning']) ?>
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