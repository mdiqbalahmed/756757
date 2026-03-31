<?php

use Cake\Core\Configure;

$this->Form->unlockField('building_id');
// $this->Form->unlockField('room_id');

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<div class="header">
			<h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
				<?= __d('attendance', 'Report') ?>
			</h3>
		</div>
		<?php echo $this->Form->create('', ['type' => 'file']); ?>
		<div class="form">
			<section class="bg-light mt-1 p-2 m-auto" action="#">
				<fieldset>
					<div class=" p-3">
						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-3">
										<p class="label-font13"><?= __d('students', 'Building') ?></p>
									</div>
									<div class="col-lg-9 row2Field">
										<select class="form-control" name="building_id" id="building_id">
											<option value=""><?= __d('students', '-- Choose --') ?></option>
											<?php foreach ($buildingList as $building) { ?>
												<option value="<?php echo $building['id']; ?>"><?php echo $building['name']; ?></option>
											<?php } ?>
										</select>
									</div>

								</div>
							</div>
							<!-- <div class="col-lg-4">
								<div class="row">
									<div class="col-lg-3">
										<p class="label-font13"><?= __d('students', 'Room') ?></p>
									</div>
									<div class="col-lg-9 row2Field">
										<select class="form-control" name="room_id" id="room_id" required>
											<option value=""><?= __d('students', '-- Choose --') ?></option>
										</select>
									</div>
								</div>
							</div> -->
						</div>

						<div class="row mb-3">
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-3">
									</div>
									<div class="col-lg-9 row2Field mt-5">
										<button type="submit" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</fieldset>
			</section>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>



</html>
<script>
	$("#building_id").change(function() { //@shovon 10/06/23
		var building_id = $("#building_id").val();
		$.ajax({
			url: 'getBuildingAjax',
			cache: false,
			type: 'GET',
			dataType: 'HTML',
			data: {
				"building_id": building_id,
			},
			success: function(data) {
				// console.log(data);
				data = JSON.parse(data);
				var text1 = '<option value="">-- Choose --</option>';
				for (let i = 0; i < data.length; i++) {
					var name = data[i]["room_number"];
					var id = data[i]["id"];
					text1 += '<option value="' + id + '" >' + name + '</option>';
				}
				$('#room_id').html(text1);

			}
		});
	});
</script>