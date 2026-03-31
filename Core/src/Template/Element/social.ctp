<?php

use Cake\ORM\TableRegistry;

$link = TableRegistry::getTableLocator()->get('links'); //Execute First
$links = $link
    ->find()
    ->join([
        'slug' => [
            'table' => 'menus',
            'type' => 'INNER',
            'conditions' => [
                'links.menu_id = slug.id'
            ]
        ],
    ])
    ->where(['slug.alias' => 'social']) //Matching the "Alias"
    ->toArray();
?>

<?php foreach ($links as $link) {
    $social_title = $link["title"];
    $fontawesome_class = strtolower($social_title);
    $link_url = urldecode($link["link"]);
    ?>
    <a href="<?= $link_url ?>" class="mx-1" target="_blank"><i class="fa fa-<?= $fontawesome_class ?> circle_social <?= $fontawesome_class ?>"></i></a>
<?php } ?>
