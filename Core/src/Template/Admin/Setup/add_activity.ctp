<?php

$this->Form->unlockField('activity_name');
$this->Form->unlockField('multiple');
$this->Form->unlockField('new_remark_name');
$this->Form->unlockField('new_remark_default');
$this->Form->unlockField('comment');
?>

<div>
	<?php echo $this->Form->create(); ?>
    <section>
        <h4><?= __d('setup', 'Add a Activity') ?></h4>
        <div class="row mx-3 mt-2 p-1">
            <div class="col-12">
                <label for="inputBR" class="form-label"><?= __d('setup', 'Activity Name') ?></label>
                <input name="activity_name" type="text" class="form-control" id="inputBR" placeholder="Activity Name" required>
            </div>

            <div class="col-12 mt-3">
                 <label for="inputBR" class="form-label"><?= __d('setup', 'Comment') ?></label>
                <textarea name="comment" class="form-control" rows="2" placeholder="Comment"></textarea>
            </div>
            <div class="col-md-1 col-sm-2 mt-4">
                <label for="my-input" class="form-label"><?= __d('setup', 'Multiple :') ?></label>
            </div>
            <div class="col-1" >
                <input class="form-check-input " type="checkbox" name="multiple">
            </div>

        </div>
    </section>

    <section class="mt-3 p-1">
        <h5><?= __d('setup', 'Add Remark For This Activity') ?></h5>
        <p class="col-lg-12 inner_heading mt-2">
            <input type="button" class="add_remark" value="Add Remark">
        </p>
        <div class="form">
            <div class="row mt-2 ml-2" id="single_row">
                <div class="col-md-2">
                    <p><?= __d('setup', 'Remark Name ') ?>:</p>
                </div>
                <div class="col-md-3">
                    <input id=""  name="new_remark_name[]" type="text" class="form-control" value="" required>
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-1 col-sm-2">
                    <label for="my-input" class="form-label"><?= __d('setup', 'Is Default :') ?></label>
                </div>
                <div class="col-1" >
                    <select id="inputState" class="form-select dropdown260" name="new_remark_default[]">
                        <option value="no">NO</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button id="delete" class="btn-danger" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>

    </section>




    <div class="text-right mt-5">
        <button type="submit" class="btn btn-info"><?= __d('setup', 'Submit') ?></button>
            <?php echo $this->Html->Link('Back', ['action' => 'Activity'], ['class' => 'btn btn-sucess']); ?>
		<?php echo $this->Form->end(); ?>
    </div>

</div>
<script type="text/javascript">

    var form = $(".form").html();

    $('.add_remark').click(function () {
        console.log(form);
        $('.form').append(form);
    });
    $('.form').on('click', '#delete', function (eq) {
        $(this).closest('#single_row').remove();
    });

</script>