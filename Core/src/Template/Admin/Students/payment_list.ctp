
<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
        <title>Student</title>
    </head>

    <body>



    <?php    if (empty($payments)) { ?>
    
    <center style="margin-top:50px; font-weight:bold; font-size:1.2em">!!!!!<?php /* ?>Please search above.<?php */ ?></center>

                <?php } else { ?>
    <div class="blockWrapper">
        <div class="leftblock" style="width:100%">
            <h3 style="text-align: center">Payment List</h3>
            <span class="text-right float-right mb-3"><?= $this->Html->link('Add Payment', ['action' => 'addPayment'], ['class' => 'btn btn-info']) ?></span>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><?= __d('students', 'Action') ?></th>
                        <th><?= __d('students', 'ID') ?></th>
                        <th><?= __d('students', 'TrxId') ?></th>
                        <th><?= __d('students', 'Amount') ?></th>
                        <th><?= __d('students', 'Proxy') ?></th>
                        <th><?= __d('students', 'Sender') ?></th>
                        <th><?= __d('students', 'Receiver') ?></th>
                        <th><?= __d('students', 'Pay_Date') ?></th>
                        <th><?= __d('students', 'Media') ?></th>
                        <th><?= __d('students', 'Added-On') ?></th>
                        <th><?= __d('students', 'Status') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($payments as $payment) {
                ?>
                    <tr>
                        <td>
                            <?php echo $this->Html->link('Edit', ['action' => 'addeditPayment', $payment['id']], ['class' => 'btn action-btn btn-warning']) ?>
                        </td>
                        <td><?php echo $payment['id'] ?></td>
                        <td><?php echo $payment['trxId'] ?></td>
                        <td><?php echo $payment['amount'] ?></td>
                        <td><?php echo $payment['ref_proxy'] ?></td>
                        <td><?php echo $payment['sender'] ?></td>
                        <td><?php echo $payment['receiver'] ?></td>
                        <td><?php echo $payment['pay_date'] ?></td>
                        <td><?php echo $payment['pay_media'] ?></td>
                        <td><?php echo $payment['created'] ?></td>
                        <td><?php echo $payment['status'] ?></td>

                    </tr>
                <?php } ?>

                </tbody>
            </table>


        </div><!-- end of leftblock-->

        <div class="clear_both">&nbsp;</div>
    </div><!-- end of blockWrapper-->
<?php } ?>





</body>

</html>
<script>
    $("#level_id").change(function () {
        getSectionAjax();
    });
    $("#shift_id").change(function () {
        getSectionAjax();
    });

    function getSectionAjax() {
        var level_id = $("#level_id").val();
        var shift_id = $("#shift_id").val();
        $.ajax({
            url: 'getSectionAjax',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            data: {
                "level_id": level_id, "shift_id": shift_id
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