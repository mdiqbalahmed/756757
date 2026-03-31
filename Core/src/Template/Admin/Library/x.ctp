<table class="table table-bordered table-striped">
	<thead class="thead-dark">
		<tr>
			<th><?= __d('attendance', 'ID') ?></th>
			<th><?= __d('attendance', 'Name') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($book_searchings as $book_searching) { ?>
			<tr style="padding: 10px;">
				<td><?php echo $book_searching['book_id'];  ?></td>
				<td><?php echo $book_searching['book_name']; ?></td>
			</tr>
		<?php } ?>

	</tbody>
</table>
<input type="hidden" class="hidden" id="hidden" name="Level_id" value="<?php echo $data['book_id'];  ?>">
<div class="text-right mt-4 mb-4">
	<button type="submit" class="btn btn-info"><?= __d('attendance', 'Give Attendance') ?></button>
	<?php echo $this->Form->end(); ?>
</div>
<?php echo $this->Form->end(); ?>