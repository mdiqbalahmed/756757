<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Widget</title>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }
    </style>
</head>

<body>
    <div class="rows">
        <h3 class="text-center"><?= __d('setup', 'Dashboard Widget') ?></h3>



    </div>
    <div class="table-responsive-sm">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th><?= __d('setup', 'ID') ?></th>
                    <th><?= __d('setup', 'name') ?></th>
                    <th><?= __d('setup', 'Active') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($dashboards as $dashboard) {
                    ?>
                    <tr>
                        <td><?php echo $dashboard['id'] ?></td>
                        <td><?php echo $dashboard['name'] ?></td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" class="status-toggle" data-id="<?= $dashboard['id'] ?>"
                                    <?= $dashboard['status'] ? 'checked' : '' ?>>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</body>

</html>
<script>
    $(document).on('change', '.status-toggle', function () {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: 'updateStatus',
            cache: false,
            type: 'GET',
            data: {
                id: id,
                status: status
            },
            dataType: 'HTML',
            success: function (response) {
                $('#detailsModal').html(response).fadeIn();
            }
        });
    });

</script>