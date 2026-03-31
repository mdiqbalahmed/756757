<?php

$css = [
    'style','user_style' // an external CSS file
];
echo $this->Html->css($css); // Assigning CSS in the webroot>css folder.
$js = [
    'script' // an external JS file
];
echo $this->Html->script($js); // Assigning JS in the webroot>js folder.

$rightRegionBlocks = $this->Regions->blocks('right');
echo $this->Meta->meta();
echo $this->Layout->feed();
echo $this->Layout->js();
$this->element('stylesheets');
$this->element('javascripts');
echo $this->Blocks->get('css');
echo $this->Blocks->get('script');
?>

<body>
    <?php
    echo $this->Layout->sessionFlash();
    echo $this->fetch('content');
    ?>


    <?php
    echo $this->Blocks->get('scriptBottom');
    echo $this->Js->writeBuffer();
    ?>
    <script>
        $("title").html("Student Dashboard");
    </script>
</body>
