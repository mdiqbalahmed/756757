<?php

use Cake\Core\Configure;

$instituteTag = Configure::read('SMS.SMS_institute_tag');
$additionalNumber = Configure::read('SMS.additionalNumber');
$additionalNumberLimit = Configure::read('SMS.additionalNumberLimit');
$this->Form->unlockField('search_session');
?>
<div>
    <?= $this->Form->create(); ?>
    <section class="std_info">
        <div class="row mx-3 mt-2 p-3">
            <div class="col-md-12  mt-3">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputSId" class="form-label"><?= __d('sms', 'Search Session') ?></label>
                    </div>
                    <div class="col-md-8">
                        <select id="inputState" class="form-select option-class dropdown260" name="search_session">
                            <?php foreach ($sessions as $session) { ?>
                                <option value="<?= $session['session_id']; ?>" <?php if ($session['session_id'] == $selected) {
                                                                                    echo 'Selected';
                                                                                } ?>><?= $session['session_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info"><?= __d('sms', 'Search') ?></button>
                    </div>
                </div>
            </div>
    </section>
    <?= $this->Form->end(); ?>
</div>
<?php
$this->Form->unlockField('session_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('sms');
$this->Form->unlockField('sms_to');
$this->Form->unlockField('role_id');
$this->Form->unlockField('user_id');
$this->Form->unlockField('extra_number');
$this->Form->unlockField('extra_sid');

$smsFooter = "\n\n\n" . $instituteTag;
?>

<body>

    <?= $this->Form->create(); ?>
    <input type="hidden" class="session_id" name="session_id" value="<?= $selected; ?>">
    <input type="hidden" id="box_size" class="box_size" value="<?= $box_count; ?>">
    <div>
        <label class="ml-1" style="font-weight:600;" for="exampleFormControlTextarea1"><?= __d('sms', 'SMS') ?></label>
        <div class="form-group mx-4">
            <textarea name="sms" maxlength="<?= $char_count; ?>" class="form-control" required placeholder="Write SMS Here...." id="sms-area" rows="4" cols="120"><?= $smsFooter ?></textarea>
            <p id='count' style="text-align:right;">Characters: <strong>0/<?= $char_count; ?></strong> SMS Parts: <strong>0/<?= $box_count; ?></strong> </p>
        </div>
    </div>

    <section id="space_sms">
        <input type="checkbox" id="check_all" value="1"><label class="check_all ml-2" style="font-weight: 600;"><?= __d('sms', 'Check All') ?></label>
        <div class="row">
            <?php if (count($levels)) { ?>
                <div class="col-md-4 col-sm-12">
                    <table class="table table-bordered table-striped" id="level_table">
                        <thead class="thead-dark">
                            <tr>
                                <th><?= __d('sms', 'Class') ?></th>
                                <th colspan="3"><input type="checkbox" class="studnet_select" id="studnet_select" value="1"><?= __d('sms', 'All Students') ?> </th>
                            </tr>
                        </thead>
                        <tbody class="old">
                            <?php foreach ($levels as $key => $level) { ?>
                                <tr>
                                    <td><button class="expandlevel btn btn-warning" style="padding: 0rem 0.25rem;" id="<?= $key ?>" class="btn-danger btn-sm" type="button"><i class="fa fa-plus"></i></button> <?= "  " . $level['level_name']; ?>
                                    </td>
                                    <td colspan="3" align="center"> <input style="width: 20px;  height: 20px;" type="checkbox" id="<?= $level['level_name']; ?>" class="student select_section" value="1"> </td>
                                </tr>
                                <?php foreach ($level['section'] as $section) { ?>
                                    <tr class="section_<?= $key ?>" style="display:none">
                                        <td class="pl-3 level_display">
                                            <li><?= $section['section_name']; ?></li>
                                        </td>
                                        <td colspan="3" align="center">
                                            <input type="checkbox" class="student <?= $level['level_name']; ?>" name="section_id[]" value="<?= $section['section_id']; ?>">
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <tr>
                                <td colspan="4" style="background-color: #b5c4c1;">
                                    <h6 class="mt-2" style="font-weight:600;"><?= __d('sms', 'Send SMS to:') ?></h6>
                                    <div class="row mb-2">
                                        <select id="inputState" class="form-select option-class dropdown260" name="sms_to">
                                            <?php foreach ($sms_to as $key => $sms) { ?>
                                                <option value="<?= $key ?>"><?= $sms ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            <?php if (count($roles)) { ?>
                <div class="col-md-4 col-sm-12">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th><?= __d('sms', 'Roles') ?></th>
                                <th colspan="3"> <input type="checkbox" class="role_select" id="role_select" value="1"><?= __d('sms', ' All Employees') ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($roles as $roleKey => $role) { ?>
                                <tr>
                                    <td>
                                        <button class="expandRole btn btn-info" style="padding: 0rem 0.25rem;" id="<?= $roleKey ?>" class="btn-danger btn-sm" type="button"><i class="fa fa-plus"></i></button>
                                        <?= "  " . $role['role_title']; ?>
                                    </td>
                                    <td colspan="3" align="center">
                                        <input style="width: 20px; height: 20px;" type="checkbox" id="<?= $role['role_title']; ?>" class="user select_role" value="1">
                                    </td>
                                </tr>
                                <?php foreach ($role['users'] as $user) { ?>
                                    <tr class="users_<?= $roleKey ?>" style="display:none">
                                        <td class="pl-3 user_display">
                                            <li><?= $user['user_name']; ?></li>
                                        </td>
                                        <td colspan="3" align="center">
                                            <input type="checkbox" class="user <?= $role['role_title']; ?>" name="user_id[]" value="<?= $user['user_id']; ?>">
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>
    </section>

    <div class="row mt-3">
        <div class="col-6">
            <label for="exampleFormControlTextarea1" style="margin-left: 10px; font-weight:600;">Additional SID</label>
            <select id="input_sid" class="form-select option-class dropdown260" multiple>
                <?php foreach ($all_sid as $sid) { ?>
                    <option value="<?= $sid['sid'] ?>" data-name="<?= $sid['name'] ?>" <?php if (isset($sid['active'])) { ?>data-mobile="<?= $sid['active'] ?>" <?php } ?>><?= $sid['sid'] ?></option>
                <?php } ?>
            </select>
            <input type="hidden" name="extra_sid" id="extra_sid">
            <table class="table table-borderless table-striped">
                <thead class="thead-dark" style="line-height: normal;font-size: 14px;">
                    <tr>
                        <th width="17%">SID</th>
                        <th>Name</th>
                        <th width="23%">Mobile</th>
                    </tr>
                </thead>
                <tbody id="selected_sid_list" style="line-height: normal;font-size: 12px;">
                </tbody>
            </table>
        </div>
        <?php if ($additionalNumber == 1) { ?>
            <div class="col-6">
                <label for="exampleFormControlTextarea1" style="margin-left: 10px; font-weight:600;"><?= __d('sms', 'Additional Numbers') ?></label>
                <div class="form-group mx-4">
                    <textarea name="extra_number" class="form-control" placeholder="Please add Comma Seperated Numbers..." id="commaTextarea" rows="4" cols="120"></textarea>
                    <p id="commaCount"></p>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-6">
            </div>
        <?php } ?>
    </div>
    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('sms', 'Submit') ?></button>
    </div>
    <?= $this->Form->end(); ?>
</body>

<script>
    var maxCommas = <?= $additionalNumberLimit ?>; // Maximum number of commas allowed
    var maxCharactersAfterComma = 11;
    var recepient = maxCommas + 1
    // Maximum characters after each comma

    document.getElementById('commaTextarea').addEventListener('input', function() {
        var textareaValue = this.value;
        var commaCount = (textareaValue.match(/,/g) || []).length; // Count commas

        if (commaCount > maxCommas) {
            alert("You have reached the Recepient limit of " + recepient);
            this.value = this.value.slice(0, -1); // Remove the last character (comma)
            return;
        }

        var parts = textareaValue.split(',');
        for (var i = 0; i < parts.length; i++) {
            if (parts[i].length > maxCharactersAfterComma) {
                alert("You can't add more than " + maxCharactersAfterComma + " characters after each comma.");
                parts[i] = parts[i].substring(0, maxCharactersAfterComma); // Truncate the string
                this.value = parts.join(',');
                return;
            }
        }
    });

    document.getElementById('commaTextarea').addEventListener('paste', function(event) {
        event.preventDefault(); // Prevent default paste behavior

        // Get the pasted data as plain text
        var clipboardData = (event.clipboardData || window.clipboardData);
        var pastedText = clipboardData.getData('text/plain');

        // Process the pasted text
        var newText = this.value + pastedText;
        // Check if the new text meets the criteria
        var commaCount = (newText.match(/,/g) || []).length;
        if (commaCount <= maxCommas) {

            var parts = newText.split(',');
            for (var i = 0; i < parts.length; i++) {
                if (parts[i].length > maxCharactersAfterComma) {
                    alert("You can't add more than " + maxCharactersAfterComma + " characters after each comma.");
                    return;
                }
            }
            // If all conditions are met, update the textarea value
            this.value = newText;
        } else {
            alert("You have reached the Recepient limit of " + recepient);
        }
    });
</script>

<script>
    // Function to update the hidden input field with selected SID values
    function updateHiddenInput() {
        var selectedSidValues = $('#input_sid').val();
        $('#extra_sid').val(selectedSidValues.join(','));
    }

    // Function to update the list of selected SID values
    function updateSelectedSidList() {
        var selectedSidList = $('#selected_sid_list');
        var selectedSidValues = $('#input_sid').val();

        // Clear the existing list
        selectedSidList.empty();

        // Create a row for each selected SID value
        selectedSidValues.forEach(function(sid) {
            var name = $('#input_sid option[value="' + sid + '"]').data('name');
            var mobile = $('#input_sid option[value="' + sid + '"]').data('mobile');
            selectedSidList.append('<tr><td>' + sid + '</td><td>' + name + '</td><td>' + mobile + '</td></tr>');
        });
    }

    $(document).ready(function() {
        // Initialize Select2
        $('#input_sid').select2({
            placeholder: 'Search or select SID...',
            allowClear: true, // Adds a clear button
            closeOnSelect: false // Keep the dropdown open after selection
        });

        // Update hidden input and selected SID list when selection changes
        $('#input_sid').on('change', function() {
            updateHiddenInput();
            updateSelectedSidList();
        });
    });
</script>

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

    $('.studnet_select').click(function(event) {
        var clist = document.getElementsByClassName('student');
        for (var i = 0; i < clist.length; ++i) {
            if (this.checked) {
                clist[i].checked = true;
            } else {
                clist[i].checked = false;
            }
        }
    });

    $('.select_section').click(function(event) {
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

    $(".expandlevel").click(function() {
        var id = this.id;
        var key = '.section_' + id;
        $(key).toggle();
    });



    // Script for the role-user selection
    $('.role_select').click(function(event) {
        var clist = document.getElementsByClassName('user');
        for (var i = 0; i < clist.length; ++i) {
            if (this.checked) {
                clist[i].checked = true;
            } else {
                clist[i].checked = false;
            }
        }
    });
    $('.select_role').click(function(event) {
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

    $('.expandRole').click(function() {
        var id = this.id;
        var key = '.users_' + id;
        $(key).toggle();
    });


    $(document).ready(function() {
        const SMSCalculator = {
            // Encoding
            encoding: {
                UTF16: [70, 64, 67],
                GSM_7BIT: [160, 146, 153],
                GSM_7BIT_EX: [160, 146, 153]
            },

            // Charset
            charset: {
                gsmEscaped: '\\^{}\\\\\\[~\\]|€',
                gsm: '@£$¥èéùìòÇ\\nØø\\rÅåΔ_ΦΓΛΩΠΨΣΘΞÆæßÉ !"#¤%&\'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà',
            },

            // Regular Expression
            regex: function() {
                return {
                    gsm: RegExp(`^[${this.charset.gsm}]*$`),
                    gsmEscaped: RegExp(`^[\\${this.charset.gsmEscaped}]*$`),
                    gsmFull: RegExp(`^[${this.charset.gsm}${this.charset.gsmEscaped}]*$`),
                };
            },

            // Method
            detectEncoding: function(text) {
                if (text.match(this.regex().gsm)) {
                    return '7BIT';
                } else if (text.match(this.regex().gsmFull)) {
                    return '7BIT_EX';
                } else {
                    return 'UTF16';
                }
            },
            getEscapedCharCount: function(text) {
                return [...text].reduce((acc, char) => acc + (char.match(this.regex().gsmEscaped) ? 1 : 0), 0);
            },
            getCount: function(text) {
                var box_size = document.getElementById("box_size").value;
                let length = text.length;
                const type = this.detectEncoding(text);
                if (type === '7BIT_EX') {
                    length += this.getEscapedCharCount(text);
                }
                if (type === 'UTF16') {
                    var max_char = (box_size === 1) ? 70 : (box_size * 67);
                    if (length <= 70) {
                        var part_count = 1;
                    } else {
                        var part_count = Math.ceil(length / 67);
                    }
                } else {
                    var max_char = (box_size === 1) ? 160 : (box_size * 153);
                    if (length <= 160) {
                        var part_count = 1;
                    } else {
                        var part_count = Math.ceil(length / 153);
                    }
                }
                //set maxlength
                var sms = document.getElementById("sms-area");
                sms.maxLength = max_char;
                document.getElementById('count').innerText = 'Characters:' + length + '/' + max_char + ' SMS Parts:' + part_count + '/' + box_size;
            }
        };

        let value = '';

        const calculate = () => {
            const count = SMSCalculator.getCount(value);

        };

        setInterval(() => {
            const area = document.getElementById('sms-area');
            if (value !== area.value) {
                value = area.value;
                calculate();
            }

        }, 100);

        calculate();
    });
</script>

<!--
<script>
    function sidFetchedNumberAjax() {
        var input_sid = $("#input_sid").val(last);
        console.log(input_sid);
        $.ajax({
            url: 'sidFetchedNumberAjax', // Update the URL to the correct endpoint
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "input_sid": input_sid
            },
            success: function(data) {
                console.log(data);
                // Further processing of the returned data can be added here
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Trigger the function on page load to handle pre-selection after searching
    $(document).ready(function() {
        sidFetchedNumberAjax();
    });

    // Bind the function to the change event of input_sid
    $("#input_sid").change(function() {
        sidFetchedNumberAjax();
    });
</script> -->
