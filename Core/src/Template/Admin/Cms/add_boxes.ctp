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
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
        <section>
            <h4><?= __d('boxes', 'Add a box') ?></h4>
            <div class="row mx-3 mt-2 p-3 form-box">

                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Select Block') ?></label>
                    <select class="form-select option-class dropdown260" name="block_id" id="block-select" required>
                        <option value="">-- Choose --</option>
                        <?php foreach ($blocks as $block) { ?>
                            <option value="<?php echo $block['id']; ?>"><?php echo $block['title']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Location') ?></label>
                    <select class="form-select option-class dropdown260" name="node_page_id" required>
                        <option>-- Choose --</option>
                        <option value="0">Home</option>
                        <?php foreach ($nodes as $node) { ?>
                            <option value="<?php echo $node['id']; ?>"><?php echo $node['title']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Status') ?></label>
                    <select class="form-select option-class dropdown260" name="status" required>
                        <option>-- Choose --</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box title') ?></label>
                    <input name="box_title" type="text" class="form-control" id="box-title" placeholder="Select Block for Title">
                </div>
                <div class="col-5 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Target URL') ?></label>
                    <input name="url" type="text" class="form-control" placeholder="Target URL">
                </div>
                <div class="col-md-2 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box Order') ?></label>
                    <input name="box_order" type="text" class="form-control" placeholder="Box Order" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="Xlabel-height form-label"><?= __d('Gallery', 'Box Image') ?></label>
                    <div class="card">
                        <div class="card-body">
                            <?php echo $this->form->file('box_image'); ?>
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
            <button type="submit" class="btn btn-info"><?= __d('boxes', 'Submit') ?></button>
            <?php echo $this->Html->Link('Back', ['action' => 'Boxes'], ['class' => 'btn btn-sucess']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
<?php } else { ?>
    <div>
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
        <section>
            <h4><?= __d('boxes', 'Add a box') ?></h4>
            <div class="row mx-3 mt-2 p-3 form-box">
                <div class="col-8 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box title') ?></label>
                    <input name="box_title" type="text" class="form-control" placeholder="Box title" required>
                </div>
                <div class="col-4 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Location') ?></label>
                    <select class="form-select option-class dropdown260" name="node_page_id" required>
                        <option>-- Choose --</option>
                        <option value="0">Home</option>
                        <?php foreach ($nodes as $node) { ?>
                            <option value="<?php echo $node['id']; ?>"><?php echo $node['title']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box Description') ?></label>
                    <textarea name="box_description" class="form-control" rows="2" placeholder="Description"></textarea>
                </div>

                <div class="col-md-3 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Status') ?></label>
                    <select class="form-select option-class dropdown260" name="status" required>
                        <option>-- Choose --</option>
                        <option value="1">Active</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
                <div class="col-6 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Target URL') ?></label>
                    <input name="url" type="text" class="form-control" placeholder="Target URL">
                </div>
                <div class="col-md-3 mt-2">
                    <label class="form-label"><?= __d('boxes', 'Box Order') ?></label>
                    <input name="box_order" type="text" class="form-control" placeholder="Box Order" required>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="Xlabel-height form-label"><?= __d('Gallery', 'Box Image') ?></label>
                    <div class="card">
                        <div class="card-body">
                            <?php echo $this->form->file('box_image'); ?>
                        </div>
                    </div>
                </div>
        </section>

        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('boxes', 'Submit') ?></button>

            <?php echo $this->Html->Link('Back', ['action' => 'Boxes'], ['class' => 'btn btn-sucess']); ?>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
<?php } ?>