<?php $this->Form->unlockField('album_id'); ?>
<?php $this->Form->unlockField('photos_title'); ?>
<?php $this->Form->unlockField('description'); ?>
<?php $this->Form->unlockField('thumbnail'); ?>
<?php $this->Form->unlockField('large_version'); ?>
<?php $this->Form->unlockField('url'); ?>
<?php $this->Form->unlockField('target'); ?>
<?php $this->Form->unlockField('photo_id'); ?>

<div>

    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <section>
        <h4><?= __d('Gallery', 'Edit Photo') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <input type="hidden" name="photo_id" value="<?php echo $photos['photo_id']; ?>">
            <div class="col-4 mt-3">
                <label class="form-label"><?= __d('Gallery', 'Album') ?></label>
                <select class="form-select dropdown260" name="album_id" required>
                    <option value=""><?= __d('Gallery', '-- Choose --') ?></option>
                    <?php foreach ($albums as $album) { ?>
                        <option value="<?php echo $album['album_id']; ?>" <?php if ($album['album_id'] == $photos['album_id']) {
                                                                                echo 'Selected';
                                                                            } ?>><?php echo $album['album_title']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-8 mt-3">
                <label class="form-label"><?= __d('Gallery', 'Photo Title') ?></label>
                <input name="photos_title" type="text" class="form-control" placeholder="Photo Name" value="<?php echo $photos['photos_title']; ?>">
            </div>
            <div class="col-4 mt-2">
                <label class="form-label"><?= __d('gallery', 'Description') ?></label>
                <textarea name="description" class="form-control" rows="2" placeholder="Description"> <?php echo $photos['description']; ?></textarea>
            </div>
            <div class="col-4 mt-3">
                <label class="form-label"><?= __d('Gallery', 'URL') ?></label>
                <input name="url" type="text" class="form-control" placeholder="Image URL" value="<?php echo $photos['url']; ?>">
            </div>
            <div class="col-4 mt-3">
                <label class="form-label"><?= __d('Gallery', 'Target') ?></label>
                <select class="form-select option-class dropdown260" name="target">
                    <option value="">-- Choose --</option>
                    <option value="_new" <?php if ($photos['target'] == '_new') {
                                                echo 'Selected';
                                            } ?>>_New</option>
                    <option value="_blank" <?php if ($photos['target'] == '_blank') {
                                                echo 'Selected';
                                            } ?>>_Blank</option>
                </select>
            </div>
            <div class="col-12 mt-2">
                <label class="Xlabel-height form-label"><?= __d('Gallery', 'Gallery Image') ?></label>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <?php echo $this->form->file('large_version'); ?>
                            </div>
                            <div class="col-4">
                                <?php echo $this->Html->image('/webroot/uploads/gallery/thumbnail/' . $photos['thumbnail'], ['width' => '100px']); ?>
                            </div>

                        </div>
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
