<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');

$this->Form->unlockField('block_id');
$this->Form->unlockField('box_title');
$this->Form->unlockField('box_description');
$this->Form->unlockField('node_page_id');
$this->Form->unlockField('box_image');
$this->Form->unlockField('box_order');
$this->Form->unlockField('url');
$this->Form->unlockField('status');

if ($siteTemplate == 1) { ?>
    <div>
        <?= $this->Form->create('', ['type' => 'file']); ?>

        <section>
            <h4><?= __d('boxes', 'Edit box') ?></h4>
            <div class="row mx-3 mt-2 p-3 form-box">
                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Select Block') ?></label>
                    <select class="form-select option-class dropdown260" name="block_id" id="block-select" required>
                        <option value="">-- Choose --</option>
                        <?php foreach ($blocks as $block) { ?>
                            <option value="<?= $block['id']; ?>" <?php if ($block['id'] == $boxes['block_id']) {
                                                                        echo 'Selected';
                                                                    } ?>>
                                <?= $block['title']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Location') ?></label>
                    <select class="form-select option-class dropdown260" name="node_page_id" required>
                        <option>-- Choose --</option>
                        <option value="0" <?php if ($boxes['node_page_id'] == 0) {
                                                echo 'Selected';
                                            } ?>>Home
                        </option>
                        <?php foreach ($nodes as $node) { ?>
                            <option value="<?= $node['id']; ?>" <?php if ($node['id'] == $boxes['node_page_id']) {
                                                                    echo 'Selected';
                                                                } ?>>
                                <?= $node['title']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Status') ?></label>
                    <select class="form-select option-class dropdown260" name="status" required>
                        <option value="" <?php if ($boxes['status'] == null) {
                                                echo 'Selected';
                                            } ?>>-- Choose --</option>
                        <option value="1" <?php if ($boxes['status'] == 1) {
                                                echo 'Selected';
                                            } ?>>Active</option>
                        <option value="0" <?php if ($boxes['status'] == 0) {
                                                echo 'Selected';
                                            } ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box title') ?></label>
                    <input name="box_title" type="text" class="form-control" id="box-title" placeholder="Select Block for Title" value="<?= $boxes['box_title']; ?>">
                </div>
                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Target URL') ?></label>
                    <input name="url" type="text" class="form-control" placeholder="Target URL" value="<?= $boxes['url']; ?>">
                </div>
                <div class="col-md-2 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box Order') ?></label>
                    <input name="box_order" type="text" class="form-control" placeholder="Box Order" value="<?= $boxes['box_order']; ?>" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="Xlabel-height form-label"><?= __d('Gallery', 'Box Image') ?></label>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <?= $this->form->file('box_image'); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->Html->image('/webroot/uploads/cms/boxes/thumbnail/' . $boxes['box_image'], ['width' => '100px']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function() {
                $('#block-select').change(function() {
                    var selectedBlockId = $(this).val();
                    var selectedBlockTitle = '';

                    <?php foreach ($blocks as $block) { ?>
                        if (selectedBlockId === '<?php echo $block['id']; ?>') {
                            selectedBlockTitle = '<?php echo $block['title']; ?>';
                        }
                    <?php } ?>

                    $('#box-title').val(selectedBlockTitle);
                });
            });
        </script>

        <div class="text-right mt-5">
            <button type="submit" class="btn btn-dark"><?= __d('boxes', 'Update') ?></button>

            <?= $this->Html->Link('Back', ['action' => 'Boxes'], ['class' => 'btn btn-sucess']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>



<?php } else { ?>
    <div>
        <?= $this->Form->create('', ['type' => 'file']); ?>
        <section>
            <h4><?= __d('boxes', 'Add a box') ?></h4>
            <div class="row mx-3 mt-2 p-3 form-box">
                <div class="col-8 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box title') ?></label>
                    <input name="box_title" type="text" class="form-control" placeholder="Box title" value="<?= $boxes['box_title']; ?>" required>
                </div>
                <div class="col-4 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Location') ?></label>
                    <select class="form-select option-class dropdown260" name="node_page_id" required>
                        <option>-- Choose --</option>
                        <option value="0" <?php if ($boxes['node_page_id'] == 0) {
                                                echo 'Selected';
                                            } ?>>Home
                        </option>
                        <?php
                        foreach ($nodes as $node) { ?>
                            <option value="<?= $node['id']; ?>" <?php if ($node['id'] == $boxes['node_page_id']) {
                                                                    echo 'Selected';
                                                                } ?>>
                                <?= $node['title']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box Description') ?></label>
                    <textarea name="box_description" class="form-control" rows="2" placeholder="Description"><?= $boxes['box_description']; ?></textarea>
                </div>

                <div class="col-md-3  mt-2">
                    <label class="form-label"><?= __d('boxes', 'Status') ?></label>
                    <select class="form-select option-class dropdown260" name="status" required>
                        <option value="" <?php if ($boxes['status'] == null) {
                                                echo 'Selected';
                                            } ?>>-- Choose --</option>
                        <option value="1" <?php if ($boxes['status'] == 1) {
                                                echo 'Selected';
                                            } ?>>Active</option>
                        <option value="0" <?php if ($boxes['status'] == 0) {
                                                echo 'Selected';
                                            } ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-6 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Target URL') ?></label>
                    <input name="url" type="text" class="form-control" placeholder="Target URL" value="<?= $boxes['url']; ?>">
                </div>
                <div class="col-md-3 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box Order') ?></label>
                    <input name="box_order" type="text" class="form-control" placeholder="Box Order" value="<?= $boxes['box_order']; ?>" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="Xlabel-height form-label"><?= __d('Gallery', 'Box Image') ?></label>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <?= $this->form->file('box_image'); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->Html->image('/webroot/uploads/cms/boxes/thumbnail/' . $boxes['box_image'], ['width' => '100px']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <div class="text-right mt-5">
            <button type="submit" class="btn btn-dark"><?= __d('boxes', 'Update') ?></button>

            <?= $this->Html->Link('Back', ['action' => 'Boxes'], ['class' => 'btn btn-sucess']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

<?php } ?>