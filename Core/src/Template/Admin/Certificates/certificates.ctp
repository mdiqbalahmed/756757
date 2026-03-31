<?php
$this->Form->unlockField('session_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('student_id');
$this->Form->unlockField('certificate_type_id');
$this->Form->unlockField('config_id');
$this->Form->unlockField('generate');

?>

<?php echo $this->Form->create(); ?>
<input name="generate" type="hidden" value="">

<section>
	<h4><?= __d('Certificates', 'Search for Students') ?></h4>
	<div class="row mx-3 mt-2 p-3">

		<div class="col-md-4   mt-2">
			<label for="inputState" class="form-label"><?= __d('Certificates', 'Certificate Type') ?></label>
			<select class="form-select dropdown260" name="certificate_type_id" id="certificate_type_id">
				<option value=""><?= __d('Certificates', 'Choose...') ?></option>
				<?php foreach ($types as $type) { ?>
					<option value="<?php echo $type['certificate_type_id']; ?>">
						<?php echo $type['certificate_title']; ?>
					</option>
				<?php } ?>
			</select>
		</div>

		<div class="col-md-4   mt-2">
			<label for="inputState" class="form-label"><?= __d('Certificates', 'Configuration Name') ?></label>
			<select class="form-select dropdown260" name="config_id" id="config_id" required>
				<option value=""><?= __d('Certificates', 'Choose...') ?></option>
				<?php foreach ($configs as $config) { ?>
					<option value="<?php echo $config['config_id']; ?>">
						<?php echo $config['config_name']; ?>
					</option>
				<?php } ?>
			</select>
		</div>
	<div class="col-md-4   mt-2">
		<label for="inputState" class="form-label"><?= __d('Certificates', 'Student ID') ?></label>
		<select class="form-select dropdown260" name="student_id" id="student_id" required>
			<option value=""><?= __d('Certificates', 'Choose...') ?></option>
			<?php foreach ($student_ids as $student_id) { ?>
				<option value="<?php echo $student_id['student_id']; ?>">
					<?php echo $student_id['sid']; ?>
				</option>
			<?php } ?>
		</select>
	</div>
	</div>
	<div class="text-right mt-2">
		<button type="submit" class="btn btn-info"><?= __d('Certificates', 'Search') ?></button>
		<?php echo $this->Form->end(); ?>
	</div>
	</div>
</section>

<div>
	<?php if (isset($tags)) {

		foreach ($tags as $key => $tag) {
			$unlock = $tag['tag'];
			$this->Form->unlockField($unlock);
		}
		$this->Form->unlockField('generate');
		$this->Form->unlockField('student_id');
		$this->Form->unlockField('config_id');
		echo $this->Form->create(); ?>


		<input name="student_id" type="hidden" value="<?php echo $request_data['student_id'] ?>">
		<input name="config_id" type="hidden" value="<?php echo $request_data['config_id'] ?>">
		<input name="generate" type="hidden" value="1">
		<div class="row">
			<?php
			foreach ($tags as $key => $tag) { ?>
				<div class="col-lg-2 mt-2">
					<p class="label-font"><?php echo $tag['tag_description'] ?></p>
				</div>
				<div class="col-lg-4 mt-2">
					<input name="<?php echo $tag['tag'] ?>" type="text" class="form-control" value="<?php if (isset($tag['tag_value'])) {echo $tag['tag_value'];} ?>" required>
				</div>
			<?php } ?>
		</div>
		<div class="text-right mt-2">
			<button type="submit" class="btn btn-info"><?= __d('Certificates', 'Generate') ?></button>
			<?php echo $this->Form->end(); ?>
		</div>
	<?php } ?>
</div>


<script>
	$("#certificate_type_id").change(function() {
		var certificate_type_id = $("#certificate_type_id").val();
		$.ajax({
			url: 'getConfigurationAjax',
			cache: false,
			type: 'GET',
			dataType: 'HTML',
			data: {
				"certificate_type_id": certificate_type_id
			},
			success: function(data) {
				data = JSON.parse(data);
				var text = '<option value="">Choose...</option>';
				for (let i = 0; i < data.length; i++) {
					var name = data[i]["config_name"];
					var id = data[i]["config_id"];
					text += '<option value="' + id + '" >' + name + '</option>';
				}
				$('#config_id').html(text);
			}
		});
	});
</script>