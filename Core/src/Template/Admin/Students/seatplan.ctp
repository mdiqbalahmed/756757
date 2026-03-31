<?php
$this->Form->unlockField('name');
$this->Form->unlockField('quantity');
$this->Form->unlockField('location');

echo $this->Form->create('Seatplan', array( 'url' => array('controller'=>'Students', 'action' => 'addSeatplan'))); ?>
 <section class="bg-light mt-3 p-4 m-auto" action="#">
                    <fieldset>
                        <legend class=" mb-4"><?= __d('students', 'Admission Seatplan') ?>
                            <input type="button" class="eduAdd btn btn-info" value="Add More"></legend>
                        <div class="education">
                            <div class="education_block form_area p-3 mb-2" id="education_block">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Room Name') ?></p>
                                            </div>
                                            <div class="col-lg-10 row3Field">
                                                <input name="name[]" type="text" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p class="label-font13"><?= __d('students', 'Quantity') ?></p>
                                            </div>
                                            <div class="col-lg-4 row2Field">
                                                <input name="quantity[]" type="text" class="form-control"  >
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="label-font13"><?= __d('students', 'Location') ?></p>
                                            </div>
                                            <div class="col-lg-9 row2Field">
                                                <input name="location[]" type="text" class="form-control"  >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1 mb-3">
                                    <button id="delete" class=" btn btn-danger" type="button"><?= __d('students', 'Remove') ?></button>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </section>
<?php echo $this->Form->submit('Submit', array('div' => false,'class' => 'SubmitSeat', 'value' => 'Submit')); ?>
<?php echo $this->Form->end(); ?>
<script>
 var form = $(".education").html();

    $('.eduAdd').click(function() {
        $('.education').append(form);
    });
    $('.form').on('click', '#delete', function(eq) {
        $(this).closest('#single_row').remove();
    });
    $('.education').on('click', '#delete', function(eq) {
        alert("Are you sure, You want remove this?");
        $(this).closest('#education_block').remove();
    });
</script>

