<?php

use Cake\ORM\TableRegistry;

$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);

$data = TableRegistry::getTableLocator()->get('asset_usages');
$results = $data
    ->find()
    ->enableAutoFields(true)
    ->where(['asset_usages.foreign_key' => $this->Nodes->field('id')])
    ->select([
        'model' => 'ast.model',
        'extension' => 'ast.extension',
        'path' => 'ast.path',
        'attch_id' => 'attch.id',
        'title' => 'attch.title',
    ])
    ->join([
        'ast' => [
            'table' => 'assets',
            'type' => 'INNER',
            'conditions' => ['ast.id = asset_usages.asset_id'],
        ],
        'attch' => [
            'table' => 'attachments',
            'type' => 'LEFT',
            'conditions' => ['attch.id = ast.foreign_key'],
        ],
    ])
    ->toArray();

?>
<?php if ($results[0]['type'] == 'pageBanner') { ?>
    <div class="node-body my-2">
        <?= $this->Layout->filter($this->Nodes->field('body')) ?>
    </div>
<?php } else { ?>
    <?php if (empty($results[0]['attch_id'])) { ?>
        <div class="node-body my-2">
            <?= $this->Layout->filter($this->Nodes->field('body')) ?>
        </div>
    <?php } else { ?>
        <div class="node-body my-2">
            <?= $this->Layout->filter($this->Nodes->field('body')) ?>
            <div class="mt-4" style="border-bottom: 1px dashed #222222;">
                <h6 class="h6" style="color: darkred; font-weight: 700">
                    Attachments:
                </h6>
            </div>
            <style>
                body>iframe {
                    display: none;
                }

                iframe {
                    width: 100%;
                    min-height: 842px;
                    border: 1px dotted #222222;
                }

                iframe body>img {
                    width: 100% !important;
                }
            </style>
            <?php
            foreach ($results as $key => $result) {
                $download = $result['path'];

                // Extension Matching and defining Icons
                $imageExtensions = array('jpg', 'png', 'gif', 'webp');
                $pdfExtensions = array('pdf');
                $docExtensions = array('doc', 'docx');
                $extension = $result['extension'];

                if (in_array($extension, $imageExtensions)) {
                    $iconClass = 'fa fa-2x fa-file-image-o';
                } elseif (in_array($extension, $pdfExtensions)) {
                    $iconClass = 'fa fa-2x fa-file-pdf-o';
                } elseif (in_array($extension, $docExtensions)) {
                    $iconClass = 'fa fa-2x fa-file-word-o';
                } else {
                    $iconClass = 'fa fa-2x fa-paperclip';
                }
            ?>

                <table class="table">
                    <tbody>
                        <tr>
                            <td style="width: 10%; text-align: center;"><i class="<?php echo $iconClass; ?>" style="color: darkred" aria-hidden="true"></i></td>
                            <td><a href="<?= $download ?>"><?= $result['title'] ?></a></td>
                            <td style="width: 10%; text-align: center"><a href="<?= $download ?>" download>Download</a></td>
                        </tr>
                    </tbody>
                </table>
                <iframe src="<?= $download; ?>" height="auto"></iframe>
            <?php } ?>
        </div>
    <?php } ?>

    <script>
        $(document).ready(function() {
            $('iframe').on('load', function() {
                $("iframe").contents().find("img").css({
                    "width": "100%",
                    "height": "auto"
                });
            });
        });
    </script>
<?php } ?>
