<?php $this->Form->unlockField('building_id'); ?>
<?php $this->Form->unlockField('room_number'); ?>
<?php $this->Form->unlockField('seat'); ?>
<?php $this->Form->unlockField('room_type_id'); ?>
<?php $this->Form->unlockField('hostel_id'); ?>



<div>
	<?= $this->Form->create(); ?>
	<section>

		<h4><?= __d('buildings', 'Bank Information') ?> </h4>
		<div class="row mx-3 mt-2 p-3 form-box">
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('rooms', 'Select Building') ?> </label>

				<select class="form-control" name="building_id">

					<?php foreach ($get_buildings as $building) { ?>
						<option value="<?php echo $building['id']; ?>" <?php if ($building->id == $get_room[0]['building_id']) {
																			echo 'selected';
																		} ?>><?php echo $building['name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('rooms', 'Room Types') ?> </label>
				<select name="room_type_id" required>
					<option value=""><?= __d('rooms', '-- Choose --') ?></option>
					<?php foreach ($get_room_types as $get_room_type) { ?>
						<option value="<?php echo $get_room_type['id']; ?>" <?php if ($get_room_type->id == $get_room[0]['room_type_id']) {
																				echo 'selected';
																			} ?>><?php echo $get_room_type['type']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('rooms', 'Room No') ?> </label>
				<input name="room_number" type="text" class="form-control" placeholder="Building name..." value="<?= $get_room[0]['room_number']; ?>" required>
			</div>
			<div class="col-md-6 col-12 mt-2">
				<label for="inputBR" class="form-label"><?= __d('rooms', 'Seat No') ?> </label>
				<input name="seat" type="text" class="form-control" placeholder="Description..." value="<?= $get_room[0]['seat']; ?>">
			</div>
		</div>
	</section>

	<div class="text-right mt-5">
		<button type="submit" class="btn btn-info"><?= __d('rooms', 'Update') ?></button>
		<?= $this->Form->end(); ?>
	</div>
</div>