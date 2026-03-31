<?php $this->Form->unlockField('album_title'); ?>
<?php $this->Form->unlockField('slug'); ?>
<?php $this->Form->unlockField('album_location'); ?>
<?php $this->Form->unlockField('description'); ?>
<?php $this->Form->unlockField('types'); ?>
<?php $this->Form->unlockField('params'); ?>
<?php $this->Form->unlockField('status'); ?>
<?php $this->Form->unlockField('thumbnail'); ?>


<div>
      <?php echo $this->Form->create('', ['type' => 'file']); ?>
      <section>
            <h4><?= __d('gallery', 'Edit Album') ?></h4>
            <div class="row mx-3 mt-2 p-3 form-box">
                  <div class="col-12 mt-2">
                        <label class="form-label"><?= __d('gallery', 'Album title') ?></label>
                        <input name="album_title" type="text" class="form-control" placeholder="Album title" value=" <?php echo $albums['album_title']; ?>" required>
                  </div>


                  <div class="col-4 mt-2">
                        <label class="form-label"><?= __d('gallery', 'Slug') ?></label>
                        <input name="slug" type="text" class="form-control" placeholder="Slug" value=" <?php echo $albums['slug']; ?>" required>
                  </div>
                  <div class="col-md-4 mt-2">
                        <label class="form-label"><?= __d('gallery', 'Params') ?></label>
                        <input name="params" type="text" class="form-control" placeholder="Params" value=" <?php echo $albums['params']; ?>" required>
                  </div>
                  <div class="col-4 mt-2">
                        <label class="form-label"><?= __d('gallery', 'Location') ?></label>
                        <select class="form-select option-class dropdown260" name="album_location">
                              <option value="" <?php if ($albums['album_location'] === null) {
                                                      echo 'Selected';
                                                } ?>>-- Choose --</option>
                              <option value="main" <?php if ($albums['album_location'] == 'main') {
                                                            echo 'Selected';
                                                      } ?>>Main</option>
                              <option value="slider" <?php if ($albums['album_location'] == 'slider') {
                                                            echo 'Selected';
                                                      } ?>>Slider</option>
                              <option value="other" <?php if ($albums['album_location'] == 'other') {
                                                            echo 'Selected';
                                                      } ?>>Other</option>
                        </select>
                  </div>
                  <div class="col-12 mt-2">
                        <label class="form-label"><?= __d('gallery', 'Description') ?></label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Description"> <?php echo $albums['description']; ?></textarea>
                  </div>
                  <div class="col-md-4  mt-2">
                        <label class="form-label"><?= __d('gallery', 'Status') ?></label>
                        <select class="form-select option-class dropdown260" name="status" required>
                              <option value="" <?php if ($albums['status'] === null) {
                                                      echo 'Selected';
                                                } ?>>-- Choose --</option>
                              <option value="1" <?php if ($albums['status'] == 1) {
                                                      echo 'Selected';
                                                } ?>>Active</option>
                              <option value="0" <?php if ($albums['status'] == 0) {
                                                      echo 'Selected';
                                                } ?>>Inactive</option>
                        </select>
                  </div>
                  <div class="col-8 mt-2">
                        <label class="Xlabel-height form-label"><?= __d('Gallery', 'Album Cover') ?></label>
                        <div class="card">
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-8">
                                                <?php echo $this->form->file('thumbnail'); ?>
                                          </div>
                                          <div class="col-4">
                                                <?php echo $this->Html->image('/webroot/uploads/gallery/alnum/thumbnail/' . $albums['thumbnail'], ['width' => '100px']); ?>
                                          </div>

                                    </div>
                              </div>
                        </div>
                  </div>
      </section>
      <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('gallery', 'Update') ?></button>

            <?php echo $this->Html->Link('Back', ['action' => 'viewAlbum'], ['class' => 'btn btn-sucess']); ?>
            <?php echo $this->Form->end(); ?>
      </div>
</div>