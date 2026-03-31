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
		<h3 class="text-center"><?= __d('allotements', 'Alloted Students') ?></h3>


	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('allotements', 'SL') ?></th>
					<th><?= __d('allotements', 'Name') ?></th>
					<th><?= __d('allotements', 'SID') ?></th>
					<th><?= __d('allotements', 'Room Number') ?></th>
					<th><?= __d('allotements', 'Building') ?></th>
					<th><?= __d('allotements', 'Status') ?></th>

				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($hostel_allotements as $allotements) {
					// pr($allotements);die;
					if ($allotements['seat'] == 1) {

						$seat = 'Alloted';
					} else {
						$seat = 'Not-Alloted';
					}
				?>
					<tr>
						<td><?= $allotements->id  ?></td>
						<td><?= $allotements->name ?></td>
						<td><?= $allotements->sid ?></td>
						<td><?= $allotements->room ?></td>
						<td><?= $allotements->building_name ?></td>
						<td><?= $seat ?></td>
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