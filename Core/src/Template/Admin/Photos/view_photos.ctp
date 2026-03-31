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
            <h3 class="text-center"><?= __d('Gallery', 'All Photos') ?></h3>

            <span class="text-right float-right mb-3"><?php echo $this->Html->link('Add Photo', ['action' => 'addPhotos'], ['class' => 'btn btn-info']) ?></span>

      </div>
      <div class="table-responsive-sm">
            <table class="table table-bordered table-striped">
                  <thead class="thead-dark">
                        <tr>
                              <th><?= __d('Gallery', 'ID') ?></th>
                              <th><?= __d('Gallery', 'Photo Title') ?></th>
                              <th><?= __d('Gallery', 'Thumbnail') ?></th>
                              <th><?= __d('Gallery', 'Action') ?></th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php foreach ($photos as $photo) {?>
                              <tr>
                                    <td><?php echo $photo['photo_id'] ?></td>
                                    <td><?php echo $photo['photos_title'] ?></td>
                                    <td class="gallery-thumbnail"><?php echo $this->Html->image('/webroot/uploads/gallery/thumbnail/' . $photo['thumbnail']); ?></td>

                                    <td>
                                          <?php echo $this->Html->link('Edit', ['action' => 'editPhotos', $photo['photo_id']], ['class' => 'btn action-btn btn-warning']) ?>
                                          <?php echo $this->Form->postLink('Delete', ['action' => 'deletePhotos', $photo['photo_id']], ['class' => 'btn action-btn btn-danger', 'confirm' => 'Are you sure, You want delete this?']) ?>
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