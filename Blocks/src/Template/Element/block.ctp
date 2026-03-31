<?php

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

$WidgetImage = Configure::read('Widget.icon');
$topColor = Configure::read('Widget.startColor');
$BottomColor = Configure::read('Widget.endColor');
$siteTemplate = Configure::read('Site.template');

$this->set(compact('block'));
$class = 'block block-' . $block->alias;
$openclass = '';
if ($block->class != null) {
    $class .= ' ' . $block->class;
    if ($block->class == 'accordianIn') {
        $openclass = ' accordianOpen';
    }
}

$node = TableRegistry::getTableLocator()->get('nodes');
$count = $node
    ->find()
    ->where(['nodes.type' => $block->alias])
    ->count();
$this->set('count', $count); ?>

<style>
    .accordianIn h6,
    .sidebarComn h6 {
        background-image: -webkit-gradient(linear, left top, left bottom, from(<?= $topColor ?>), to(<?= $BottomColor ?>));
        background-image: -moz-linear-gradient(top, <?= $topColor ?> 0%, <?= $BottomColor ?> 100%);
        background-image: -o-linear-gradient(top, <?= $topColor ?> 0%, <?= $BottomColor ?> 100%);
        background-image: -ms-linear-gradient(top, <?= $topColor ?> 0%, <?= $BottomColor ?> 100%);
        background-image: linear-gradient(top, <?= $topColor ?> 0%, <?= $BottomColor ?> 100%);
        background-repeat: no-repeat;
        position: relative;
    }
    
   .flex-column > .nav-link {
    border-bottom: 1px solid black;
}

</style>
<?php
if ($siteTemplate == 1) { ?>
    <div id="block-<?= $block->id ?>" class="<?= $class ?> sidebar_area_gov">
        <?php if ($block->show_title == 1) : ?>
            <h6><?= $block->title ?></h6>
        <?php endif ?>

        <div class="<?php $openclass ?>"> <!-- BODY and TITLE for Block -->
            <?= $this->Layout->filter($block->body, ['id' => $block->id]); ?>
        </div>
    </div>

<?php } else if ($siteTemplate == 0) { ?>
    <div id="block-<?= $block->id ?>" class="<?= $class ?> sidebar_area">
        <?php if ($block->show_title == 1) : ?>
            <h6><?= $block->title ?></h6>
            <?php if (!empty($openclass)) : ?>
                <a href="javascript:void(0);" class="btnOpen<?php if ($block->alias == 'notice') echo ' btnClose'; ?>">
                    <?= $this->Html->image($WidgetImage, array("alt" => "Bullet Icon")); ?></a>
            <?php endif; ?>
        <?php endif ?>

        <div class="block-body <?= $openclass; ?> "> <!-- BODY and TITLE for Block -->
            <?= $this->Layout->filter($block->body, ['id' => $block->id]); ?>
            <?php if ($count >= 5) { ?>
                <div align="right" style="margin-top: -15px;">
                    <a class="right_more pr-2" href="<?= $this->request->getAttribute('webroot') ?><?= $block->alias ?>">সবগুলো জানতে &raquo;</a>
                </div>
            <?php } else { ?>
                <?php } ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var accordianOpenDivs = $("div.accordianOpen");
            if (accordianOpenDivs.length > 0) {
                accordianOpenDivs.hide();
                accordianOpenDivs.first().show();

                heightFixed();
                $(window).resize(function() {
                    heightFixed();
                });

                $('a.btnOpen').click(function() {
                    if (!$(this).hasClass('btnClose')) {
                        $('a.btnOpen').removeClass('btnClose');
                        $('div.accordianOpen').slideUp('');
                        $(this).addClass('btnClose').next('div.accordianOpen').stop(true).slideDown();
                    }
                    return false;
                });
            }
        });

        function heightFixed() {
            var contentHeight = jQuery('div.node-list ul li')[0].offsetHeight;
            var totalHgt = jQuery("div.accordianOpen").css('height', '0');
            jQuery("div.accordianOpen").css('height', (contentHeight * 6));
        };
    </script>

<?php } else { ?>
    <?php
    $this->set(compact('block'));
    $class = 'block block-' . $block->alias;
    if ($block->class != null) {
        $class .= ' ' . $block->class;
    }
    ?>

    <div class="col-md-6 p-2 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
        <div class=" row block_row">
            <div class="col-md-8">
                <div id="block-<?= $block->id ?>" class="<?= $class ?>">
                    <?php if ($block->show_title == 1) : ?>
                        <h4><?= $block->title ?></h4>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-4 btn_div">
                <a class=" btn btn-outline-primary py-2 px-3 all_btn" href="<?= $this->request->getAttribute('webroot') ?><?= $block->alias ?>">See All</a>
            </div>
            <div class="col-md-12">
                <div class="block-body">
                    <?php
                    echo $this->Layout->filter($block->body, array(
                        'model' => 'Block', 'id' => $block->id
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
