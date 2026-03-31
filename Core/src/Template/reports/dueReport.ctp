<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    </head>
    <style>
        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
    <body>
        <h3 style="text-align: center;background-color: rgba(0, 0, 0, 0.2);padding: 10px;overflow-x:auto;font-colour: red;">Due Report <?php echo $type; ?> Wise </h3>
        <div style="background-color: rgba(0, 0, 0, 0.2); padding: 10px; margin-top: 10px; overflow-x:auto;">
            <p style="position: relative;">
                 <?php echo $head; ?>
                <span style="position: absolute; right: 0;">Report Time:  <?php echo $date=date('d-m-Y h:i A'); ?></span>
            </p>


            <table class="table table-bordered table-striped">

                <thead class="thead-dark">
                    <tr>
                       <?php   foreach ($table_row as $key => $row) { 
                            $align='center';
                            if($key==count($table_row)-1){
                              $align='right';   
                            }
                           ?>
                        <th style="text-align: <?php echo $align; ?> "> <?php echo $row; ?></th>

                       <?php  } ?>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($show_data as  $data_array) {  ?>
                    <tr>
                        <?php foreach ($data_array as $key => $data) { 
                            $align='center';
                            if($key==count($data_array)-1){
                              $align='right';  
                             $data= number_format((float)$data, 2, '.', '');
                            }
                           ?>
                        <td style="text-align: <?php echo $align; ?> "> <?php echo $data; ?></td>
                        <?php } ?>
                    </tr>
                     <?php } ?>
                    <tr>
                        <th style="text-align: center;" colspan="<?php echo count($table_row)-1; ?>"> Total</th>
                        <th style="text-align: right;"><?php echo number_format((float)$total, 2, '.', '');?></th>
                    </tr>

                </tbody>
            </table>
        </div>
    </body>
</html>
