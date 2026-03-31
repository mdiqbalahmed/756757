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
		<h3 class="text-center"><?= __d('Library', 'Issues Record') ?></h3>

		<span class="text-right float-right mb-3"><?php echo $this->Html->link('Issue Books', ['action' => 'issueBooks'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('Library', 'ID') ?></th>
					<th><?= __d('Library', 'Issued To (Member_Name)') ?></th>
					<th><?= __d('Library', 'Member ID') ?></th>
					<th><?= __d('Library', 'Book Name') ?></th>
					<th><?= __d('Library', 'Copies Left') ?></th>
					<th><?= __d('Library', 'Issue Date') ?></th>
					<th><?= __d('Library', 'Deadline') ?></th>

					<th><?= __d('Library', 'Action') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($issues as $issue) {
				?>
					<tr>
						<td><?php echo $issue['issue_id']  ?></td>
						<td><?php if ($issue['member_type'] == 1) {//Chooses the member type always check the DB before assigning it.
								echo $issue['issue_to_student'];
							} else {
								echo $issue['issue_to_employee'];
							} ?>
						</td>
						<td><?php echo $issue['member_id']  ?></td>
						<td><?php echo $issue['book_name'] ?></td>
						<td><?php echo $issue['copies'] ?></td>
						<td><?php echo $issue['issue_date'] ?></td>
						<td><?php echo $issue['deadline'] ?></td>
						<td>
							<?php echo $this->Html->link('Edit', ['action' => 'editIssue', $issue['issue_id']], ['class' => 'btn action-btn btn-warning']) ?>
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