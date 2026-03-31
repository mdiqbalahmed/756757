<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container  mt-5 mb-5">
        <h3 class="text-center"><?= __d('students', 'Student DATA') ?></h3>
        <?= $this->Html->link('Download xlsx File', ['action' => 'export']) ?>
    </div>
</body>

</html>