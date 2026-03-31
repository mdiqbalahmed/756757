<?php

use Cake\ORM\TableRegistry;

$node = TableRegistry::getTableLocator()->get('Nodes'); //Execute First
$nodes = $node
      ->find()
      ->where(['type' => 'news'])
      ->order(['created' => 'DESC'])
      ->limit(5)
      ->toArray();
$this->set('nodes', $nodes); ?>

<?php foreach ($nodes as $node) : ?>
      <a href="<?= $node["type"]; ?>/<?= $node["slug"]; ?>">
            <span class="news_title" style="display:inline-block; margin-right: 10em; ">
                  <?= $node["title"]; ?>
            </span>
      </a>
<?php endforeach; ?>