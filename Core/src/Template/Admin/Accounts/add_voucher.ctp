<?php

$this->Form->unlockField('purpose_id'); ?>
<?php $this->Form->unlockField('amount'); ?>
<?php $this->Form->unlockField('create_date'); ?>
<?php $this->Form->unlockField('sid'); ?>
<?php $this->Form->unlockField('session_id'); ?>
<?php $this->Form->unlockField('month_id'); ?>
<?php $this->Form->unlockField('level_id'); ?>
<?php $this->Form->unlockField('section_id'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div>
    <?= $this->Form->create(); ?>
    <section>
        <h4><?= __d('accounts', 'Add Voucher') ?></h4>
        <div class="row mx-3 mt-2 p-3 form-box">
            <div class='col-md-6 col-12 mt-2'>
                <label class="form-label"><?= __d('accounts', 'Vouchers Date') ?></label>
                <input type="datetime-local" name="create_date" class="form-control"
                    value="<?= date("Y-m-d H:i:s", time() + 6 * 3600); ?>" required>
            </div>

            <div class="col-md-6 col-12 mt-2">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Purpose') ?></label>
                <select id="inputState" class="form-select option-class" name="purpose_id" required>
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($options as $value => $text) { ?>
                        <option value="<?= $value ?>"><?= h($text) ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Session') ?></label>
                <select id="session_id" class="form-select option-class" name="session_id" required>
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($sessions as $session) { ?>
                        <option value="<?= $session->session_id; ?>" <?php if ($session->active) {
                              echo "selected";
                          } ?>>
                            <?= $session->session_name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Level') ?></label>
                <select id="level_id" class="form-select option-class" name="level_id">
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($levels as $level) { ?>
                        <option value="<?= $level['level_id']; ?>">
                            <?= $level['level_name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Section') ?></label>
                <select id="section_id" class="form-select option-class" name="section_id">
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>

                </select>
            </div>



            <div class="col-md-6 col-12 mt-1">
                <div class="" id="student">
                    <label for="inputState" class="form-label"><?= __d('accounts', 'Student ID') ?></label>
                    <input type="number" name="sid" id="sid" class="form-control">
                </div>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <label for="inputState" class="form-label"><?= __d('accounts', 'Months') ?></label>
                <select id="month_id" class="form-select option-class" name="month_id" required>
                    <option value=""><?= __d('accounts', 'Choose...') ?></option>
                    <?php foreach ($months as $month) { ?>
                        <option value="<?= $month['id']; ?>"><?= $month['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-12 mt-1">
                <label class="form-label"><?= __d('accounts', 'Amount') ?></label>
                <input name="amount" type="number" class="form-control" placeholder="Enter Amount..." required>
            </div>
        </div>
    </section>

    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info text-light"><?= __d('accounts', 'Submit') ?></button>
        <?= $this->Html->Link('Back', ['action' => 'purposes'], ['class' => 'btn ']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>
<script type="text/javascript">
    $("#session_id").change(function () {
        var session_id = $("#session_id").val();
        $.ajax({
            url: 'getMonthsFrromSessionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "session_id": session_id
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["name"];
                    var id = data[i]["id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#month_id').html(text1);
            }
        });
    });
    $("#level_id").change(function () {
        getSectionAjax();

    });
    function getSectionAjax() {
        var level_id = $("#level_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id,
            },
            success: function (data) {
                data = JSON.parse(data);
                var text1 = '<option value="">-- Choose --</option>';
                for (let i = 0; i < data.length; i++) {
                    var name = data[i]["section_name"];
                    var id = data[i]["section_id"];
                    text1 += '<option value="' + id + '" >' + name + '</option>';
                }
                $('#section_id').html(text1);

            }
        });
    }
</script>

<script type="text/javascript">
    config = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        today
    };
    flatpickr("input[type=datetime-local]", config);
</script>