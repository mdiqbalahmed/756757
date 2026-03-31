<?php
$this->Form->unlockField('session_id');
?>
<div class="header">
    <h3 class="text-center" style="letter-spacing: 1px; word-spacing: 10px; text-transform:uppercase;">
        <?= __d('sms', 'Active Academic Sessions') ?>
    </h3>
</div>
<?php echo $this->Form->create('', ['type' => 'file']); ?>
<div class="form">
    <div style="text-align: right;"><?= __d('sms', 'Select All') ?> <input type="checkbox" class="check_all" id="check_all" value="1"></div>

    <legend class="dbc-card p-3" style="font-size:12px"> Sessions
        <div class="row mt-3">
            <?php foreach ($sessions as $session) { ?>
                <div class="col-md-2" style="font-size: 16px;">
                    <?php

                    $selectedSessionsArray = json_decode($selectedSession);

                    $checked = '';
                    if (in_array($session->session_id, $selectedSessionsArray)) {
                        $checked = 'checked'; // Set checked attribute if session ID is found in the selectedSessionsArray
                    }
                    ?>
                    <input type="checkbox" class="session_checkbox" id="session_<?= $session->session_id ?>" name="session_id[]" value="<?= $session->session_id ?>" <?= $checked ?>>
                    <label for="session_<?= $session->session_id ?>"><?= $session->session_name ?></label>
                </div>
            <?php } ?>
        </div>

        <div class="text-right mt-3">
            <button type="submit" class="btn btn-info"><?= __d('sms', 'Submit') ?></button>
        </div>
    </legend>
    <?php echo $this->Form->end(); ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var selectAllCheckbox = document.getElementById("check_all");
        var sessionCheckboxes = document.querySelectorAll(".session_checkbox");

        selectAllCheckbox.addEventListener("change", function() {
            sessionCheckboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    });
</script>
