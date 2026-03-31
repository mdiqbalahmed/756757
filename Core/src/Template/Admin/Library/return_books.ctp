<?php $this->Form->unlockField('member_id'); ?>

<body>
	<div class="p-5" style="background-color: #f2f2f2; padding: 10px;">
		<h4 class="text-left"><?= __d('Library', 'Search Member') ?></h4>
		<?php echo $this->Form->create(); ?>
		<div class="row">
			<div class="col-md-6 col-sm-12 mt-2">
				<label for="inputState" class="form-label"><?= __d('Library', 'Member ID') ?></label>
				<select id="member_id" class="form-select dropdown260" name="member_id">
					<option value=""><?= __d('Library', 'Choose...') ?></option>
					<?php foreach ($members as $member) { ?><option value="<?php echo $member['member_id']; ?>"><?php echo $member['member_id'] . ' : ' . $member['name']; ?>
						</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="text-right mt-5">
			<button type="submit" class="btn btn-info"><?= __d('Library', 'Search') ?></button>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>

	<!-- ^=^Search Section^=^ -->

	<?php if (isset($issues)) { ?>

		<?php if (count($issues) > 0) { ?>

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
							<th><?= __d('Library', 'Status') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($issues as $issue) { ?>
							<tr>
								<td><?php echo $issue['issue_id']  ?></td>
								<td><?php if ($issue['member_type'] == 1) { //Chooses the member type always check the DB before assigning it.
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
								<td><?php if ($issue['status'] == 1 || $issue['status'] != 0) {
										echo $this->Html->link('Return', ['action' => 'returnAction', $issue['issue_id']], ['class' => 'btn action-btn btn-success']);
									} else {
										echo $this->Html->link('Return', ['action' => 'returnAction', $issue['issue_id']], ['class' => ' disabled btn action-btn btn-secondary']);
									}
									?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } else { ?>
			<div class="mt-5 text-center alert alert-warning" style="padding-top: 40px;
    height: 100px;font-size: 110%; color:#993b00 !important;" role="alert">
				Ops! The member has no previous Book Issue History.
			</div>
	<?php }} ?>