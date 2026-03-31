<?php

use Cake\Core\Configure;

$siteTemplate = Configure::read('Site.template');
?>


<?php if ($siteTemplate == 1) { ?>
    <div id="node-list-<?= $alias ?>" class="node-list_gov">
        <ul>
            <?php
            foreach ($nodesList as $node) {
                $date = $node->publish_start;
                $title = $node->title;
                if ($options['link']) { ?>
                    <li class="sidebar_gov">
                        <i class="fa fa-check-circle text-limegreen" style="font-size:large"></i>
                <?php
                    $titletrim = $title;
                    $limit = 180;

                    if (strlen($titletrim) > $limit) {
                        $titletrim = substr($titletrim, 0, $limit);
                        $lastWord = strrpos($titletrim, ' ');
                        if ($lastWord !== false) {
                            $titletrim = substr($titletrim, 0, $lastWord);
                        }
                        $titletrim .= '...';
                    }
                    echo $this->Html->link($titletrim, $node->url->getUrl(0), array('class' => 'text-justify'));
                    echo '</li>';
                } else {
                    echo '<li class="sidebar_gov  ">' . $title . '</li>';
                    echo '<i class="fa fa-check-circle text-limegreen"></i>';
                }
            }
                ?>
        </ul>
    </div>


<?php } else if ($siteTemplate ==  0) { ?>
    <div id="node-list-<?= $alias ?>" class="node-list">
        <ul>
            <?php
            foreach ($nodesList as $node) {
                $date = $node->publish_start;
                $title = $node->title;
                if ($options['link']) {
                    echo '<li class="sidebar ">';
            ?>
                    <span class="sidebar_left"><span class="date_top"> <?= $this->Time->i18nFormat($date, 'dd MMMM') ?> </span><?= $this->Time->i18nFormat($date, 'yyyy') ?></span>
                    <?php
                    $titletrim = $title;
                    $limit = 180;

                    if (strlen($titletrim) > $limit) {
                        $titletrim = substr($titletrim, 0, $limit);
                        $lastWord = strrpos($titletrim, ' ');
                        if ($lastWord !== false) {
                            $titletrim = substr($titletrim, 0, $lastWord);
                        }
                        $titletrim .= '...';
                    }
                    echo $this->Html->link($titletrim, $node->url->getUrl(0), array('class' => 'text-justify'));
                    echo '</li>';
                } else {
                    ?>
                    <span class="sidebar_left"><span class="date_top"> <?= $this->Time->i18nFormat($date, 'dd MMMM') ?> </span><?= $this->Time->i18nFormat($date, 'yyyy') ?></span>
            <?php
                    echo '<li class="sidebar  ">' . $title . '</li>';
                }
            }
            ?>
        </ul>
    </div>
<?php } else { ?>
    <div id="node-list-<?= $alias ?>" class="node-list marmc_node_list">
        <ul>
            <?php
            foreach ($nodesList as $node) {
                if ($options['link']) {
                    echo '<li>';
                    echo $this->Html->link($node->title, $node->url->getUrl(0));
                    echo '</li>';
                } else {
                    echo '<li>' . $node->title . '</li>';
                }
            }
            ?>
        </ul>
    </div>
<?php } ?>