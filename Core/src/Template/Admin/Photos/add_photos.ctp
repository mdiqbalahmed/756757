<?php $this->Form->unlockField('album_id'); ?>
<?php $this->Form->unlockField('photos_title'); ?>
<?php $this->Form->unlockField('description'); ?>
<?php $this->Form->unlockField('thumbnail'); ?>
<?php $this->Form->unlockField('large_version'); ?>
<?php $this->Form->unlockField('url'); ?>
<?php $this->Form->unlockField('target'); ?>

<div>

      <?php echo $this->Form->create('', ['type' => 'file']); ?>
      <section>
            <h4><?= __d('Gallery', 'Add a Photo') ?></h4>
            <div class="row mx-3 mt-2 p-3 form-box">
                  <div class="col-4 mt-3">
                        <label class="form-label"><?= __d('Gallery', 'Album') ?></label>
                        <select class="form-select dropdown260" name="album_id" required>
                              <option value=""><?= __d('Gallery', '-- Choose --') ?></option>
                              <?php foreach ($albums as $album) { ?>
                                    <option value="<?php echo $album['album_id']; ?>"><?php echo $album['album_title']; ?></option>
                              <?php } ?>
                        </select>
                  </div>
                  <div class="col-8 mt-3">
                        <label class="form-label"><?= __d('Gallery', 'Photo Title') ?></label>
                        <input name="photos_title" type="text" class="form-control" placeholder="Photo Name">
                  </div>
                  <div class="col-12 mt-2">
                        <label class="form-label"><?= __d('gallery', 'Description') ?></label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Description"></textarea>
                  </div>
                  <div class="col-4 mt-3">
                        <label class="form-label"><?= __d('Gallery', 'URL') ?></label>
                        <input name="url" type="text" class="form-control" placeholder="Image URL">
                  </div>
                  <div class="col-3 mt-3">
                        <label class="form-label"><?= __d('Gallery', 'Target') ?></label>
                        <select class="form-select option-class dropdown260" name="target">
                              <option value="">-- Choose --</option>

                              <option value="_new">_New</option>
                              <option value="_blank">_Blank</option>
                        </select>
                  </div>
                  <div class="col-md-5 mt-2">
                        <label for="inputSId" class="Xlabel-height form-label"><?= __d('Gallery', 'Gallery Image') ?></label>
                        <div class="card">
                              <div class="card-body">
                                    <?php echo $this->form->file('large_version'); ?>
                              </div>
                        </div>
                  </div>
      </section>
      <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('Gallery', 'Submit') ?></button>

            <?php echo $this->Html->Link('Back', ['action' => 'viewPhotos'], ['class' => 'btn btn-sucess']); ?>
            <?php echo $this->Form->end(); ?>
      </div>
</div>