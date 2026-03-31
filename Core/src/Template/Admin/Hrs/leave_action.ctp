<?php
$this->Form->unlockField('config_action_setup_id');
$this->Form->unlockField('user_id');
$this->Form->unlockField('date_from');
$this->Form->unlockField('date_to');
$this->Form->unlockField('half_leave');
$this->Form->unlockField('body');
$this->Form->unlockField('file');
$this->Form->unlockField('comment');
$this->Form->unlockField('approval');


?>

<div class="container border-bottom ">

    <?php echo $this->Form->create('', ['type' => 'file']); ?>
    <div class="row">
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Leave Type :') ?></label>
                </div>
                <div class="col-md-10">

                    <select id="inputState" class="form-select option-class dropdown260" name="config_action_setup_id" disabled>
                        <option value=""><?= __d('hrs', 'Choose Leave Type') ?></option>
                        <?php foreach ($leave_type as $leave) { ?>
                            <option value="<?php echo $leave['config_action_setup_id']; ?>" <?php if ($leave['config_action_setup_id'] == $datas['config_action_setup_id']) {
                                                                                                    echo 'Selected';
                                                                                                } ?> readonly>
                                <?php echo $leave['config_action_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Start Date :') ?></label>
                </div>
                <div class="col-md-8">
                    <input name="date_from" type="date" class="form-control" id="inputSId" placeholder="Leave Type" value="<?php echo $datas['date_from']; ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'End Date :') ?></label>
                </div>
                <div class="col-md-8">
                    <input name="date_to" type="date" class="form-control" id="inputSId" value="<?php echo $datas['date_to']; ?>" placeholder="Leave Type" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Half Leave :') ?></label>
                </div>
                <div class="col-md-10 form-check form-switch">
                    <input name="half_leave" class="form-check-input ml-1" type="checkbox" id="checkboxNoLabel" onclick="return false;" value="1" <?php echo ($datas['half_leave'] == '1') ? 'checked' : NULL; ?>>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Body :') ?></label>
                </div>
                <div class="col-md-10">
                    <textarea name="body" class="form-control " placeholder="Write a few more about the leave reason" rows="4" cols="120" readonly><?php echo $datas['body']; ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 ">
                    <label for="inputSId" class=" Xlabel-height form-label"><?= __d('hrs', 'Attachments :') ?></label>
                </div>
                <div class="col-md-10 mt-2">
                    <div class="card">
                        <div class="card-body py-3 ">
                            <div class="leave-attachments-action"><?php echo $this->Html->image('/webroot/uploads/leave_attachments/' . $datas['file']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6  mt-3">
            <div class="row">
                <div class="col-md-4 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Approval :') ?></label>
                </div>
                <div class="col-md-8">
                    <select id="inputState" class="form-select option-class dropdown260" name="approval">
                        <option value="">Choose Action</option>
                        <?php foreach ($approvals as $approval) { ?>
                            <option value="<?php echo $approval ?>" <?php if ($approval == $datas['approval']) {
                                                                        echo 'Selected';
                                                                    } ?>>
                                <?php echo $approval ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12  mt-3">
            <div class="row">
                <div class="col-md-2 text-right">
                    <label for="inputSId" class="Xlabel-height form-label"><?= __d('hrs', 'Comment :') ?></label>
                </div>
                <div class="col-md-10">
                    <textarea name="comment" class="form-control" placeholder="Comment anything if requires.. " rows="4" cols="120"><?php echo $datas['comment']; ?></textarea>
                </div>
            </div>
        </div>
        <input name="user_id" type="hidden" value="<?php echo $datas['user_id']; ?>">
        <input name="config_action_setup_id" type="hidden" value="<?php echo $datas['config_action_setup_id']; ?>">

        <div class="col-md-12 text-right mt-5 mb-4">
            <button type="submit" class="btn btn-info"><?= __d('hrs', 'Update') ?></button>
            <?php echo $this->Form->end(); ?>
        </div>

    </div>
</div>