<?php
$this->Form->unlockField('certificate_title');
?>

<body>
	<div class="p-5" style="background-color: #f2f2f2; padding: 10px;">
		<div class="header">
			<h1 class="h1 text-center mb-5"><?= __d('Certificates', 'Add a Certificate Type') ?>
			</h1>
		</div>
		<?php echo $this->Form->create(); ?>
		<div class="row">
			<div class="col-lg-2">
				<p class="label-font"><?= __d('Certificates', 'Certificate title') ?></p>
			</div>
			<div class="col-lg-10 mt-2">
				<input name="certificate_title" type="text" class="form-control" placeholder="Enter Certificate title">
			</div>
		</div>
		<div class="text-right mt-5">
			<button type="submit" class="btn btn-info"><?= __d('Certificates', 'Add Type') ?></button>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	</div>