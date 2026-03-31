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
            <h3 class="text-center"><?= __d('Album', 'All Albums') ?></h3>

            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Album', ['action' => 'addAlbum'], ['class' => 'btn btn-info']) ?></span>

      </div>
      <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                        <tr>
                              <th><?= __d('Album', 'ID') ?></th>
                              <th><?= __d('Album', 'Album Name') ?></th>
                              <th><?= __d('Album', 'Location') ?></th>
                              <th><?= __d('Album', 'Position') ?></th>
                              <th><?= __d('Album', 'Status') ?></th>
                              <th><?= __d('Album', 'Action') ?></th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php
                        foreach ($albums as $album) {
                        ?>
                              <tr>
                                    <td><?php echo $album['album_id'] ?></td>
                                    <td><?php echo $album['album_title'] ?></td>
                                    <td><?php echo $album['album_location'] ?></td>
                                    <td><?php echo $album['album_position'] ?></td>
                                    <td><?php if($album['status']==1){ Print_r('Active');}else{
                                                Print_r('Inactive');}; ?></td>
                                    <td>
                                          <?php echo $this->Html->link('Edit', ['action' => 'editAlbum', $album['album_id']], ['class' => 'btn action-btn btn-warning']) ?>
                                          <?php echo $this->Form->postLink('Delete', ['action' => 'deleteAlbum', $album['album_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
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