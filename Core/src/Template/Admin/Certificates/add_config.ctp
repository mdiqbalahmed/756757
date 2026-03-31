<?php
$this->Form->unlockField('config_name');
$this->Form->unlockField('certificate_type_id');
$this->Form->unlockField('left_head');
$this->Form->unlockField('right_head');
$this->Form->unlockField('main_content');
$this->Form->unlockField('left_footer');
$this->Form->unlockField('right_footer');
$this->Form->unlockField('config_image');
$this->Form->unlockField('office_left_head');
$this->Form->unlockField('office_right_head');
$this->Form->unlockField('office_main_content');
$this->Form->unlockField('office_left_footer');
$this->Form->unlockField('office_right_footer');
$this->Form->unlockField('office_copy_image');

?>

<div class="container  mt-5 mb-5">
    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <div class="form-border">
        <section class="bg-light  p-4 m-auto" action="#">
            <div class="header">
                <h1 class="h1 text-center mb-5"><?= __d('Configure_Certificates', 'Add Certificate Configuration') ?>
                </h1>
            </div>
            <div class="form_area p-3">
                <div>
                    <h5 class="text-center mb-5" style="font-weight:700; text-decoration:underline"><?= __d('Configure_Certificates', 'Main Certificate') ?>
                    </h5>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Configuration Name') ?></p>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" name="config_name" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Certificate type') ?></p>
                    </div>
                    <div class="col-lg-4">
                        <select class="form-select option-class dropdown260" name="certificate_type_id" required>
                            <option value=""><?= __d('Configure_Certificates', '-- Choose --') ?></option>
                            <?php foreach ($types as $type) { ?>
                                <option value="<?php echo $type['certificate_type_id']; ?>"><?php echo $type['certificate_title']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Left Header') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="left_head" class="form-control" rows="2" placeholder="Left Header"></textarea>
                    </div>
                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Right Header') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="right_head" class="form-control" rows="2" placeholder="Right Header"></textarea>
                    </div>

                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Body Content') ?></p>
                    </div>
                    <div class="col-lg-10 mt-3">
                        <textarea name="main_content" class="form-control" rows="8" placeholder="Content of the Certificate"></textarea>
                    </div>

                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Left Footer') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="left_footer" class="form-control" rows="2" placeholder="Left Footer"></textarea>
                    </div>
                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Right Footer') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="right_footer" class="form-control" rows="2" placeholder="Right Footer"></textarea>
                    </div>

                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Certificate Image') ?></p>
                    </div>
                    <div class="col-lg-10 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <?= $this->form->file('config_image'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_area p-3 mt-4" style="background: #fff2f6">
                <div>
                    <h5 class="text-center mb-5" style="font-weight:700; text-decoration:underline"><?= __d('Configure_Certificates', 'Office Copy') ?>
                    </h5>
                </div>
                <div class="row">
                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Left Header') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="office_left_head" class="form-control" rows="2" placeholder="Left Header"></textarea>
                    </div>
                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Right Header') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="office_right_head" class="form-control" rows="2" placeholder="Right Header"></textarea>
                    </div>

                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Body Content') ?></p>
                    </div>
                    <div class="col-lg-10 mt-3">
                        <textarea name="office_main_content" class="form-control" rows="8" placeholder="Content of the Certificate"></textarea>
                    </div>

                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Left Footer') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="office_left_footer" class="form-control" rows="2" placeholder="Left Footer"></textarea>
                    </div>
                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Right Footer') ?></p>
                    </div>
                    <div class="col-lg-4 mt-3">
                        <textarea name="office_right_footer" class="form-control" rows="2" placeholder="Right Footer"></textarea>
                    </div>
                    <div class="col-lg-2 mt-3">
                        <p class="label-font"><?= __d('Configure_Certificates', 'Office-Copy Image') ?></p>
                    </div>
                    <div class="col-lg-10 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <?= $this->form->file('office_copy_image'); ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-12 mt-5 mb-3">
                    <button class="btn btn-lg btn-info text-white btn-right" type="submit"><?= __d('Configure_Certificates', 'Save Configuration') ?></button>
                    <?= $this->Html->Link('Back', ['action' => 'configCirtificates'], ['class' => 'btn btn-lg btn-sucess btn-right']); ?>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </section>

        <div class="tag-list">
            <h3 class="text-center bg-dark text-light p-3 mb-5">All Available Tags Lists</h3>
            <div class="row">
                <div class="col-6" style="vertical-align: top">
                    <h5 class="text-center py-3 m-0" style="background:lightgreen;">Tag Has Database Record</h5>
                    <table class="table no-border m-0">
                        <thead class="thead-dark">
                            <tr>
                                <th><?= __d('Certificates', 'Tag Name') ?></th>
                                <th><?= __d('Certificates', 'Tag Description') ?></th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($rectags as $key => $rectag) {
                            $tag_name = $rectag['tag'];
                            $tag_description = $rectag['tag_description']; ?>
                            <tr>
                                <td><?= $tag_name ?></td>
                                <td><?= $tag_description ?></td>
                            </tr>
                        <?php    } ?>
                    </table>
                </div>
                <div class="col-6">
                    <h5 class="text-light text-center py-3 m-0" style="background:maroon;">Tag Has No Database Record</h5>
                    <table class="table no-border m-0">
                        <thead class="thead-dark">
                            <tr>
                                <th><?= __d('Certificates', 'Tag Name') ?></th>
                                <th><?= __d('Certificates', 'Tag Description') ?></th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($notags as $key => $notag) {
                            $tag_name = $notag['tag'];
                            $tag_description = $notag['tag_description']; ?>
                            <tr>
                                <!-- (< ? =) Means ( < ? php echo ) -->
                                <td><?= $tag_name ?></td>
                                <td><?= $tag_description ?></td>
                            </tr>
                        <?php    } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
