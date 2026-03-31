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
		<h3 class="text-center"><?= __d('rooms', 'Room Wise Seat Status') ?></h3>

		<span class="text-right float-right mb-3"><?= $this->Html->link('Add Room', ['action' => 'addRoom'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('rooms', 'SL') ?></th>
					<th><?= __d('rooms', 'Building Name') ?></th>
					<th><?= __d('rooms', 'Room No') ?></th>
					<th><?= __d('rooms', 'No. Of Seat') ?></th>
					<th><?= __d('rooms', 'Alloted') ?></th>
					<th><?= __d('rooms', 'Seat Available') ?></th>
					<th><?= __d('rooms', 'Extra') ?></th>
					<th><?= __d('rooms', 'Action') ?></th>

				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($rooms as $room) {
					// pr($room);die;
					$seat_available = $room['seat'] - $room['status'];
				?>
					<tr>
						<td><?= $room->id  ?></td>
						<td><?= $room->building_name ?></td>
						<td><?= $room->room_number ?></td>
						<td><?= $room->seat ?></td>
						<td><?= $room->status ?></td>
						<td><?= $seat_available ?></td>
						<td><?= $room['extra'] ?></td>

						<td>
							<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'editRoom', $room->id], ['class' => 'btn action-btn btn-warning', 'escape' => false]) ?>
							<?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['action' => 'deleteRoom', $room->id], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want to delete this?', 'escape' => false]) ?>
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