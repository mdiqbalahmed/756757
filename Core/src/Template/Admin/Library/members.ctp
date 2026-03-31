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
		<h3 class="text-center"><?= __d('Library', 'List of All Members') ?></h3>

		<span class="text-right float-right mb-3"><?php echo $this->Html->link('add Member', ['action' => 'addMember'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('Library', 'ID') ?></th>
					<th><?= __d('Library', 'Member Name') ?></th>
					<th><?= __d('Library', 'Member Type') ?></th>
					<th><?= __d('Library', 'Action') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($members as $member) {
				?>
					<tr>
						<td><?php echo $member['member_id']  ?></td>
						<td><?php if ($member['member_type'] == 1) { //Chooses the member type always check the DB before assigning it.
								echo $member['member_as_student'];
							} else {
								echo $member['member_as_employee'];
							} ?>
						</td>
						<td><?php echo $member['member_type_title']  ?></td>
						<td>
							<?php echo $this->Html->link('Edit', ['action' => 'editMember', $member['member_id']], ['class' => 'btn action-btn btn-warning']) ?>
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