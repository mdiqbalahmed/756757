<?php

$this->Form->unlockField('search_session');
?>
<div>
    <?php echo $this->Form->create(); ?>
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
                            <option value="<?php echo $session['session_id']; ?>" <?php if ($session['session_id'] == $selected) { echo 'Selected';} ?> ><?php echo $session['session_name']; ?></option>
					<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info"><?= __d('sms', 'Search') ?></button>
                    </div>
                </div>
            </div>
    </section>
      <?php echo $this->Form->end(); ?>
</div>
<?php
$this->Form->unlockField('session_id');
$this->Form->unlockField('section_id');
$this->Form->unlockField('sms');
$this->Form->unlockField('sms_to');
$this->Form->unlockField('department_id');
$this->Form->unlockField('stuff');
$this->Form->unlockField('extra_number');       
$this->Form->unlockField('extra_sid');
?>


<body>

    <?php echo $this->Form->create(); ?>
    <input type="hidden" class="session_id"  name="session_id" value="<?php echo $selected; ?>">
    <input type="hidden"  id="box_size" class="box_size" value="<?php echo $box_count; ?>">
    <input type="hidden"  id="foot_size" class="foot_size" value="<?php echo $foot_size; ?>">
    <div>
        <label class="ml-1" style="font-weight:600;" for="exampleFormControlTextarea1"><?= __d('sms', 'SMS') ?></label>
        <div class="form-group mx-4">
            <textarea name="sms" maxlength="<?php echo $char_count; ?>" id="sms" class="form-control" required placeholder="Write SMS Here...." id="sms-area" rows="4" cols="120"></textarea>
            <p id='count' style="text-align:right;">Characters: <strong>0/<?php echo $char_count; ?></strong> SMS Parts: <strong>0/<?php echo $box_count; ?></strong> </p>


        </div>


    </div>

    <section id="space_sms">
        <input type="checkbox"  id="check_all" value="1"><label class="check_all ml-2" style="font-weight: 600;"><?= __d('sms', 'Check All') ?></label>
        <div class="row">
         <?php if(count($levels)) { ?>
            <div class="col-md-4 col-sm-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th><?= __d('sms', 'Class') ?></th>
                            <th colspan="3"><input type="checkbox" class="studnet_select" id="studnet_select"  value="1"><?= __d('sms', 'All Students') ?> </th>
                        </tr>
                    </thead>
                    <tbody class="old">
                            <?php foreach ($levels as $key => $level) { ?>
                        <tr>
                            <td> <button style="padding: 0rem 0.25rem;" id="<?php echo $key ?>" class="btn-danger btn-sm" type="button"><i class="fa fa-plus"></i></button>  <?php echo "  ".$level['level_name']; ?>
                            </td>


                            <td colspan="3" align="center"> <input style="width: 20px;  height: 20px;" type="checkbox" id="<?php echo $level['level_name']; ?>" class="student select_section"  value="1"> </td>
                        </tr>
                               <?php foreach ($level['section'] as $section) { ?>
                        <tr class="section_<?php echo $key ?>" style="display:none">
                            <td><?php echo ' ---'.$section['section_name']; ?></td>
                            <td colspan="3"> <input type="checkbox" class="student <?php echo $level['level_name']; ?>"  name="section_id[]" value="<?php echo $section['section_id']; ?>"></td>
                        </tr>
                               <?php } ?>

                        <?php } ?>

                        <tr>
                            <td colspan="4" style="background-color: #b5c4c1;">
                                <h6 class="mt-2" style="font-weight:600;"><?= __d('sms', 'Send SMS to:') ?></h6>
                                <div class="row mb-2">
                                    <select id="inputState" class="form-select option-class dropdown260" name="sms_to">
					<?php foreach ($sms_to as $key => $sms) { ?>
                                        <option value="<?php echo $key ?>"><?php echo $sms ?></option>
					<?php } ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
            </div>
            </table>

        </div>
         <?php } ?>
         <?php if(count($departments)) { ?>
        <div class="col-md-4 col-sm-12">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('sms', 'Departments') ?></th>
                        <th colspan="3"> <input type="checkbox"  class="department_select" id="department_select" value="1"><?= __d('sms', ' All Teachers') ?></th>
                    </tr>
                </thead>

                <tbody>
                        <?php foreach ($departments as $department) { ?>
                    <tr>
                        <td><?php echo $department['department_name']; ?></td>
                        <td colspan="3"> <input type="checkbox" id="department" class="department"  name="department_id[]" value="<?php echo $department['department_id'];  ?>">
                        </td>
                    </tr>
                        <?php } ?>

                </tbody>

        </div>
    </table>

</div>
         <?php } ?>

         <?php if(count($staff)) { ?>
<div class="col-md-4 col-sm-12">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th><?= __d('sms', 'Staffs') ?></th>
                <th colspan="3"><input type="checkbox" class="check_all" id="check_al3" name="stuff" value="1"><?= __d('sms', ' All Staffs') ?></th>
            </tr>
        </thead>
    </table>

</div>
         <?php } ?>

</div>
</section>

<div class="row mt-3">
    <div class="col-6">
        <label for="exampleFormControlTextarea1" style="margin-left: 10px; font-weight:600;"><?= __d('sms', 'External SID') ?></label>
        <div class="form-group mx-4">
            <textarea name="extra_sid" class="form-control" placeholder="Please add Comma Seperated SID...." id="" rows="4" cols="120"></textarea>
        </div>
    </div>
    <div class="col-6">
        <label for="exampleFormControlTextarea1" style="margin-left: 10px; font-weight:600;"><?= __d('sms', 'External Number') ?></label>
        <div class="form-group mx-4">
            <textarea name="extra_number" class="form-control" placeholder="Please add Comma Seperated Numbers...." id="" rows="4" cols="120"></textarea>
        </div>
    </div>
</div>
<div class="text-right mt-5">
    <button type="submit" class="btn btn-info"><?= __d('sms', 'Submit') ?></button>
</div>
  <?php echo $this->Form->end(); ?>

</body>


<script>
    $('#check_all').click(function (event) {
        if (this.checked) {
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });
    $('.department_select').click(function (event) {
        var clist = document.getElementsByClassName('department');
        for (var i = 0; i < clist.length; ++i) {
            if (this.checked) {
                clist[i].checked = true;
            } else {
                clist[i].checked = false;
            }
        }
    });
    $('.studnet_select').click(function (event) {
        var clist = document.getElementsByClassName('student');
        for (var i = 0; i < clist.length; ++i) {
            if (this.checked) {
                clist[i].checked = true;
            } else {
                clist[i].checked = false;
            }
        }
    });

    $('.select_section').click(function (event) {
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

    $("button").click(function () {
        var id = this.id;
        var key = '.section_' + id;
        $(key).toggle();
    });

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
        regex: function () {
            return {
                gsm: RegExp(`^[${this.charset.gsm}]*$`),
                gsmEscaped: RegExp(`^[\\${this.charset.gsmEscaped}]*$`),
                gsmFull: RegExp(`^[${this.charset.gsm}${this.charset.gsmEscaped}]*$`),
            };
        },

        // Method
        detectEncoding: function (text) {
            if (text.match(this.regex().gsm)) {
                return '7BIT';
            } else if (text.match(this.regex().gsmFull)) {
                return '7BIT_EX';
            } else {
                return 'UTF16';
            }
        },
        getEscapedCharCount: function (text) {
            return [...text].reduce((acc, char) => acc + (char.match(this.regex().gsmEscaped) ? 1 : 0), 0);
        },
        
        getCount: function (text) {
            console.log(text);
            var box_size = document.getElementById("box_size").value;
            var foot_size = document.getElementById("foot_size").value;
            let length = text.length;
            const type = this.detectEncoding(text);
            if (type === '7BIT_EX') {
                length += this.getEscapedCharCount(text);
            }
            if (type === 'UTF16') {
                var max_char = (box_size === 1) ? 70 - foot_size : (box_size * 67) - foot_size;
                if (length <= 70) {
                    var part_count = 1;
                } else {
                    var part_count = ceil(length / 67);
                }
            } else {
                var max_char = (box_size === 1) ? 160 - foot_size : (box_size * 153) - foot_size;
                if (length <= 160) {
                    var part_count = 1;
                } else {
                    var part_count = ceil(length / 153);
                }
            }
            //set maxlength
            var sms = document.getElementById("sms");
            sms.maxLength = max_char;
            document.getElementById('count').innerText = 'Characters:' + length + '/' + max_char + ' SMS Parts:' + part_count + '/' + box_size;

            console.log(length);

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


</script>