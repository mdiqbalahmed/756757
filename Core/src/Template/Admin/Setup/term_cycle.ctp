<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses</title>
</head>

<body>
    
    <?php

$this->Form->unlockField('session_id');
$this->Form->unlockField('level_id');
$this->Form->unlockField('term_cycle_id');

?>
        <?php echo $this->Form->create(); ?>
            <section>
                <h4><?= __d('setup', 'Search Term Course Cycle') ?></h4>
                <div class="row mx-3 mt-2 p-3">
                    <div class="col-md-4 ">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Session') ?></label>
                        <select class="form-select dropdown260" name="session_id" id="session_id">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
				<?php foreach ($sessions as $session) { ?>
                            <option value="<?php echo $session['session_id']; ?>" <?php if ($session['session_id'] == $request_data['session_id']) {echo 'Selected';} ?>><?php echo $session['session_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4  mt-2">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Class') ?></label>
                        <select  class="form-select dropdown260" name="level_id" id="level_id">
                            <option value=""><?= __d('setup', 'Choose...') ?></option>
                                <?php foreach ($levels as $level) { ?>
                            <option value="<?php echo $level['level_id']; ?>" <?php if ($level['level_id'] == $request_data['level_id']) {echo 'Selected';} ?>><?php echo $level['level_name']; ?></option>
				<?php } ?>
                        </select>
                    </div>

                    <div class="col-md-4  mt-4">
                        <label for="inputState" class="form-label"><?= __d('setup', 'Term Name') ?></label>
                        <select class="form-control" name="term_cycle_id" id="term_cycle_id">
                                            <option value=""><?= __d('setup', '-- Choose --') ?></option>
                                        </select>
                    </div>
                    
                </div>
            </section>
            <div class="text-right mt-2">
                <button type="submit" style="margin-right: 919px;" class="btn btn-info"><?= __d('setup', 'Search') ?></button>
            </div>
            <?php echo $this->Form->end(); ?>

    <div class="rows">
        <h3 class="text-center"><?= __d('setup', 'All Term Cycle') ?></h3>
        <span class="text-right float-right mb-3"><?php echo $this->Html->link(__d('setup', 'Add Term Cycle'), ['action' => 'addTermCycle'], ['class' => 'btn btn-info']) ?></span>
    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('setup', 'ID') ?></th>
                    <th><?= __d('setup', 'Term Name') ?></th>
                    <th><?= __d('setup', 'Level Name') ?></th>
                    <th><?= __d('setup', 'Session Name') ?></th>
                    <th><?= __d('setup', 'Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result['term_cycle_id'] ?></td>
                        <td><?php echo $result['term_name'] ?></td>
                        <td><?php echo $result['level_name'] ?></td>
                        <td><?php echo $result['session_name'] ?></td>
                        <td>
                            <?php echo $this->Html->link('Details', ['action' => 'detailsTermCycle', $result['term_cycle_id']], ['class' => 'btn action-btn btn-info']) ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination mt-5 custom-paginate justify-content-center">
            <li class="page-item"> <?= $this->Paginator->first("First") ?></li>
            <li class="page-item"><?= $this->Paginator->prev("<<") ?></li>
            <li class="page-item"><?= $this->Paginator->numbers() ?></li>
            <li class="page-item"><?= $this->Paginator->next(">>") ?></li>
            <li class="page-item"><?= $this->Paginator->last("Last") ?></li>
        </ul>
    </nav>
</body>

</html>
<script>
    $("#level_id").change(function() {
        getTermAjax();
    });
    $("#session_id").change(function() {
        getTermAjax();
    });
    

    function getTermAjax() {
    var session_id = $("#session_id").val();
    var level_id = $("#level_id").val();
    $.ajax({
        url: 'getTermAjax',
        cache: false,
        type: 'GET',
        dataType: 'json', // Change to JSON
        data: {
            "level_id": level_id,
            "session_id": session_id
        },
        success: function(data) {
            var options = '<option value="">-- Choose --</option>';
            $.each(data, function(index, term) {
                options += '<option value="' + term.term_cycle_id + '">' + term.term_name + '</option>';
            });
            $('#term_cycle_id').html(options); // Update dropdown
        },
        error: function(xhr, status, error) {
            console.log("Error:", error);
        }
    });
}


    function confirmDelete() {
        return confirm("Are you sure you want to delete this file?");
    }
</script>