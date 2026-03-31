<?php
$this->Form->unlockField('tag');
$this->Form->unlockField('tag_description');
?>

<body>
	<div class="p-5" style="background-color: #f2f2f2; padding: 10px;">
		<div class="header">
			<h1 class="h1 text-center mb-5"><?= __d('Certificates', 'Add a New Tag') ?>
			</h1>
		</div>
		<?php echo $this->Form->create(); ?>
		<div class="row">
			<div class="col-md-6">
				<div class="row">

					<div class="col-lg-3">
						<p class="label-font"><?= __d('Certificates', 'Short Tag:') ?></p>
					</div>
					<div class="col-lg-9 mt-2">
						<input name="tag" type="text" class="form-control" placeholder="Enter Tag" value=" <?php echo $tags['tag']; ?>">
					</div>

				</div>
			</div>
			<div class="col-md-6">
				<div class="col-lg-12 mt-2">
					<p class="label-font"><?= __d('Certificates', 'Tag Description') ?></p>
				</div>
				<div class="col-lg-12 mt-3">
					<textarea name="tag_description" class="form-control" rows="2" placeholder="Enter Tag Description"><?php echo $tags['tag_description']; ?></textarea>
				</div>
			</div>
		</div>
		<div class="text-right mt-5">
			<button type="submit" class="btn btn-info"><?= __d('Certificates', 'Update Tag') ?></button>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	</div>