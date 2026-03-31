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
		<h3 class="text-center"><?= __d('accounts', 'All Delete Banks') ?></h3>

		<span class="text-right float-right mb-3"><?= $this->Html->link('Add bank', ['action' => 'addBank'], ['class' => 'btn btn-info']) ?></span>

	</div>
	<div class="table-responsive-sm">
		<table class="table table-bordered table-striped">
			<thead class="thead-dark">
				<tr>
					<th><?= __d('accounts', 'ID') ?></th>
					<th><?= __d('accounts', 'Bank Code') ?></th>
					<th><?= __d('accounts', 'Bank Name') ?></th>
					<th><?= __d('accounts', 'Branch') ?> </th>
					<th><?= __d('accounts', 'Bank Account Number') ?></th>
					<th><?= __d('accounts', 'Balance') ?> </th>
					<th><?= __d('accounts', 'Action') ?></th>

				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($banks as $bank) {
				?>
					<tr>
						<td><?= $bank->bank_id  ?></td>
						<td><?= $bank->bank_code ?></td>
						<td><?= $bank->bank_name ?></td>
						<td><?= $bank->bank_branch ?></td>
						<td><?= $bank->bank_acc_no ?></td>
						<td class="text-right"><?= number_format($bank->bank_balance, 2, '.', ''); ?></td>
						<td>
							<?= $this->Form->postLink('Restore', ['action' => 'restoreBanks',  $bank['bank_id']], ['class' => 'btn btn-success action-btn', 'confirm' => 'Are you sure, You want restore this?']) ?>
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