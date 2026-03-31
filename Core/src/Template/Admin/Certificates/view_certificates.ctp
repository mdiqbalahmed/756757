<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
</head>

<body>

      <div class="rows">
            <h3 class="text-center"><?= __d('Certificates', 'Saved Certificates') ?></h3>

            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Certificate', ['action' => 'addCertificates'], ['class' => 'btn btn-info']) ?></span>

      </div>
      <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                        <tr>
                              <th><?= __d('Certificates', 'Student ID') ?></th>
                              <th><?= __d('Certificates', 'Name') ?></th>
                              <th><?= __d('Certificates', 'Certificate Type') ?></th>
                              <th><?= __d('Certificates', 'Configuration Title') ?></th>
                              <th><?= __d('Certificates', 'Action') ?></th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php
                        foreach ($values as $value) {
                        ?>
                              <tr>
                                    <td><?php echo $value['sid'] ?></td>
                                    <td><?php echo $value['name'] ?></td>
                                    <td><?php echo $value['certificate_title'] ?></td>
                                    <td><?php echo $value['config_name'] ?></td>
                                    <td>
                                          <?php echo $this->Html->link('View', ['action' => 'printCertificate', $value['tag_values_id']], ['class' => 'btn action-btn btn-warning']) ?>
                                          <?php echo $this->Form->postLink('Delete', ['action' => 'deleteCertificates', $value['tag_values_id']],['confirm' => 'Are you sure you wish to delete this Certificate?']) ?>
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
