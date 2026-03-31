<?php

//Academic Information table => "scms_qualification"
$this->Form->unlockField('room');

?>
<div class="noprint">
    <div class="formTopWrapper">
        <div class="displayWrapper"<?php if( empty($students) || !empty($this->request->data) ) echo ' style="display:block"'; ?>>
                    	<?php echo $this->Form->create('Admission',array('url' => array('controller'=>'Students', 'action' => 'admissionRoom'))); ?>

            <div class="col-lg-3">
                <p class="label-font13"><?= __d('students', 'Room') ?></p>
            </div>
            <div class="col-lg-9 row2Field">
                <select class="form-control" name="room">
                    <option value=""><?= __d('students', '-- Choose --') ?></option>
                                                 <?php foreach ($list as $li) { ?>
                    <option value="<?php echo $li['room']; ?>"><?php echo $li['room']; ?></option>
                                              <?php } ?>
                </select>
            </div><!-- end of infofoset-->


            <div class="mt-5">
                <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
		                    <?php echo $this->Form->end(); ?>
            </div>   
            <div class="clear_both">&nbsp;</div>
        </div><!-- end of displayWrapper-->
        <div class="arrowwrapper">
            <a class="close1" href="javascript:void(0);">&nbsp;</a>
        </div><!-- end of arrowwrapper-->

    </div><!-- end of formTopWrapper-->
</div>
<?php if(empty($students))  { ?>
<center style="margin-top:50px; font-weight:bold; font-size:1.2em"></center>
<?php } else {
?>
<div class="ExbtnWrap">
    <?php //<a class="account" href="#">???? ????</a>     ?><a class="account" href="javascript:window.print();">Print</a>
</div>
<div class="room-print admitWrapEx">
    <div class="room-header">
        <?php
        echo 'Examination Room : ' . $students[0]['room'] . '<br />';
        echo 'Class of Admission : ' . $level_str . '<br />';
        echo 'Examination Room Location : ' . $students[0]['location'] . '<br />';
        ?>
    </div>
    <table  id="table1" cellpadding="0" cellspacing="0" >
        <?php
        $tableHeaders = $this->Html->tableHeaders(array(
            'Roll',
            'Class',
            'Photo',
            'Name',
            'Ref',
           // 'Roll',
            "Fater's Name",
            "Mother's Name",
            'Mobile',
            //('Admission.shift', 'Shift'),
            'DOB',
            'Version',
            'Quota',
            'Signature',
                //__('Actions', true),
                ));
        echo '<thead>';
        echo $tableHeaders;
        echo '</thead>';
        $rows = array();
        foreach ($students AS $student) {
            //$actions = $this->Html->link(__('Edit', true), array('controller' => 'Admission', 'action' => 'edit', $student['Admission']['id']));
            //$actions .= ' ' . $this->Layout->adminRowActions($student['Admission']['id']);
            // $actions .= ' ' . $this->Form->postLink(__('Delete', true), array(
            // 'controller' => 'students',
            //  'action' => 'delete',
            //  $student['Student']['id'],
            //  ), null, __('Are you sure?', true));

            $defaultPath = '/students_tmp_design/images/default-' . (empty($student['Admission']['gender']) || $student['Admission']['gender'] == 'Female' ? 'girl' : 'boy') . '.png';
            $thumbPath = trim($student['photo']);
            $thumbPath = empty($thumbPath) ? $defaultPath : '/img/admission/thumbnail/' . $thumbPath; //THUMBNAIL_LOCATION4

            $rows[] = array(
                //$student['Student']['id'],
               // $student['Admission']['id'],
                sprintf("%05s", $student['roll']),
		$student['level'],
                $this->Html->image($thumbPath, array('alt' => 'Photo', 'style' => 'width:40px')),
                $student['name'],
                $student['ref'],
                $student['fname'],
                $student['mname'],
                $student['mobile'],
                //$student['Admission']['shift'],
                $student['dob'],
                $student['version'],
                implode(', ', explode(',', $student['quota'])),
                //$actions,
                ''
            );
        }
        echo '<tbody>';
        echo $this->Html->tableCells($rows);
        echo '</tbody>';
        echo $tableHeaders;
        ?>
    </table>
</div>
 <?php } ?>
<style>

    table tr th {
        padding: 3px;
        background: #e5e5e5;
        color: #333;
        border-bottom: 0px;
        text-align: left;
        font-weight: bold;
    }

    table tr td {
        padding: 10px;
        border-bottom: 1px solid #dfdfdf;
        vertical-align: middle;
    }

    .room-header {
        padding: 10px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
    }

    .account {
        background: #ff7805;
    }

    .account {
        padding: 8px 5% 8px;
        /*position: fixed;*/
        right: 5px;
        top: 242px;
        border: 1px solid #cacaca;
        font-size: 24px;
        display: inline-block;
        color: #fefefe;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
        transition: all 700ms;
        -moz-transition: all 700ms;
        -o-transition: all 700ms;
        -webkit-transition: all 700ms;
    }
</style>
