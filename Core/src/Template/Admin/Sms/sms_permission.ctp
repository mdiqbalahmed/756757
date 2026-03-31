<?php
$this->Form->unlockField('section');
$this->Form->unlockField('role');
$this->Form->unlockField('user');
?>

<body>

    <div class="">
        <div class="header">
            <h3 class=" text-center" style="letter-spacing: 3px; word-spacing: 7px; text-transform:capitalize;">
                <?= __d('sms', 'SMS Permission') ?>
            </h3>
        </div>
        <?php echo $this->Form->create('', ['type' => 'file']); ?>
        <div class="form">
            <div class="row">
                <div class="col-10">
                    <h4><?= __d('sms', 'Sessions') ?> </h4>
                </div>
                <div class="col-2">
                    <div style="text-align: right;"> <?= __d('sms', 'Select All') ?> <input type="checkbox" class="check_all" id="check_all" value="1"></div>
                </div>
            </div>

            <?php foreach ($sessions as  $session) { ?>
                <p style="font-weight: 600;">Session Name: <?php echo $session['session_name'] ?></p>
                <?php foreach ($session['level_data'] as  $level_data) { ?>
                    <div class="row">
                        <div class="col-8">
                            <p style="margin-left: 20px; font-weight: 500;">Level Name: <?php echo $level_data['level_name'] ?></p>
                        </div>
                        <div class="col-4">
                            <div style="text-align: right; margin-top: -15px;"> <?= __d('sms', 'Check All') ?> <input type="checkbox" id="<?php echo $level_data['level_name'] . $session['session_name'] ?>" class="check_all_session" value="1"></div>
                        </div>
                    </div>
                    <div class="row sections" style="margin-top: -15px; margin-bottom: 15px;">
                        <?php foreach ($level_data['sections'] as  $section) { ?>
                            <div class="col-2">
                                <div style="text-align: right;">
                                    <?php echo $section['section_name'] ?>
                                    <input class="<?php echo $level_data['level_name'] . $session['session_name'] ?>" type="checkbox" name="section[<?php echo $session['session_id'] ?>][<?php echo $level_data['level_id'] ?>][<?php echo $section['section_id'] ?>]" value="1" <?php echo $section['checked'] ?>>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="row">
                <div class="col-8">
                    <h4><?= __d('sms', 'Roles') ?> </h4>
                </div>
                <!-- <div class="col-4">
                    <div class="text-right"> < ?= __d('sms', 'Select All Roles') ?> <input type="checkbox" class="role_select" id="role_select" name="" value="1"></div>
                </div> -->
            </div>
            <?php foreach ($roles as $role) { ?>
                <div class="row">
                    <div class="col-8">
                        <p style="margin-left: 20px; font-weight: 600;"><?php echo $role['title'] ?></p>
                    </div>
                    <div class="col-4">
                        <div class="text-right"> <?= __d('sms', 'Check All') ?> <input type="checkbox" class="employee_select" id="employee_select" value="1"></div>
                    </div>
                </div>
                <div class="row users mx-3" style="margin-top: -15px; margin-bottom: 15px;">
                    <?php foreach ($role['users'] as $user) { ?>
                        <div class="col-4">
                            <div style="text-align: left;">
                                <input class="user<?= $user['id'] ?>" type="checkbox" name="user[<?= $role['id'] ?>][<?= $user['id'] ?>]" value="1" <?= $user['checked'] ?>>
                                <?= $user['name'] ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>

        <div class="text-right mt-5">
            <button type="submit" class="btn btn-info"><?= __d('sms', 'Submit') ?></button>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</body>


<script>
    $('#check_all').click(function(event) {
        if (this.checked) {
            $(':checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    $('.check_all_session').click(function(event) {
        let id = this.id;
        var clist = document.getElementsByClassName(id);
        for (var i = 0; i < clist.length; ++i) {
            if (this.checked) {
                clist[i].checked = true;
            } else {
                clist[i].checked = false;
            }
        }
    });
    $('.role_select').click(function(event) {
        var clist = document.getElementsByClassName("role");
        for (var i = 0; i < clist.length; ++i) {
            if (this.checked) {
                clist[i].checked = true;
            } else {
                clist[i].checked = false;
            }
        }
    });
</script>
