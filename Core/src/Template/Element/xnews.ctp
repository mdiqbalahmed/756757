<?php

use Cake\ORM\TableRegistry;

$node = TableRegistry::getTableLocator()->get('Nodes'); // Execute First
$nodes = $node
    ->find()
    ->where(['type' => 'news'])
    ->order(['created' => 'DESC'])
    ->limit(5)
    ->toArray();
$this->set('nodes', $nodes);

$siteURL = $this->Url->build([
    "plugin" => "Croogo/Nodes",
    "controller" => "Nodes",
    "action" => "promoted",
]);
$currentURL = $this->request->getPath() === '/';
?>

<style>
    .acme-news-ticker {
        background: #fff;
        position: relative;
        height: 30px;
        border-top: 1px solid #cfcfcf;
        border-bottom: 1px solid #cfcfcf;
        margin-top: 45px;
    }

    @media (min-width: 768px) {
        .acme-news-ticker {
            margin-top: 0;
        }
    }

    .acme-news-ticker-label {
        background: #f19300;
        padding-top: 3px;
        width: auto;
        float: left;
        margin-right: 15px;
        line-height: normal;
        height: 100%;
        color: #fff;
        border-right: 3px double;
    }

    @media (max-width: 575px) {
        .acme-news-ticker-label {
            position: absolute;
            top: -45px;
        }
    }

    .acme-news-ticker-box {
        height: 100%;
        padding-top: 3px;
        overflow: hidden;
    }

    @media (max-width: 575px) {
        .acme-news-ticker-box {
            padding-left: 10px;
            padding-right: 120px;
        }
    }

    .acme-news-ticker-box ul {
        width: 100%;
        list-style-type: none !important;
        padding: 0;
        margin: 0;
    }

    .acme-news-ticker-box ul li a {
        text-decoration: none;
        color: #f19300;
        text-wrap: nowrap;
        position: relative;
    }

    .acme-news-ticker-box ul li a:hover {
        text-decoration: none;
        color: #000;
        font-weight: 700;
    }
</style>

<div class="acme-news-ticker">
    <div class="acme-news-ticker-label px-2">News: </div>
    <div class="acme-news-ticker-box">
        <ul class="my-news-ticker">
            <?php foreach ($nodes as $node) : ?>
                <li>
                    <a href="<?php if ($currentURL != null) {
                                    echo $node["type"];
                                } else {
                                    echo $siteURL . '/' . $node["type"];
                                } ?>/<?= $node["slug"]; ?>"><?= $node["title"]; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.my-news-ticker').AcmeTicker({
            type: 'typewriter',
            direction: 'right',
            autoplay: 3000,
            speed: 50,
            pauseOnHover: true,
        });
    })
</script>

<script>
    (function($) {
        'use strict';
        $.fn.AcmeTicker = function(options) {
            /*Merge options and default options*/
            let opts = $.extend({}, $.fn.AcmeTicker.defaults, options);

            /*Functions Scope*/
            let thisTicker = $(this),
                intervalID, timeoutID, isPause = false;



            /*Always wrap, used in many place*/
            thisTicker.wrap("<div class='acmeticker-wrap'></div>");

            /*Wrap is always relative*/
            thisTicker.parent().css({
                position: 'relative'
            })
            /*Hide expect first*/
            thisTicker.children("li").not(":first").hide();

            /*Lets init*/
            init();

            function init() {
                switch (opts.type) {
                    case 'vertical':
                    case 'horizontal':
                        vertiZontal()
                        break;

                    case 'marquee':
                        marQuee()
                        break;

                    case 'typewriter':
                        typeWriter()
                        break;

                    default:
                        break
                }
            }



            /*Type-Writer
             * **Do not change code lines*/
            function typeWriter(prevNext = false) {
                if (isPause) {
                    return false;
                }
                if (prevNext) {
                    clearInterval(intervalID);
                    intervalID = false;

                    clearTimeout(timeoutID);
                    timeoutID = false;

                    if (prevNext === 'prev') {
                        thisTicker.find('li:last').detach().prependTo(thisTicker);
                    } else {
                        thisTicker.find('li:first').detach().appendTo(thisTicker);
                    }
                }

                let speed = opts.speed,
                    autoplay = opts.autoplay,
                    typeEl = thisTicker.find('li:first'),
                    wrapEl = typeEl.children(),
                    count = 0;

                if (typeEl.attr('data-text')) {
                    wrapEl.text(typeEl.attr('data-text'))
                }

                let allText = typeEl.text();

                thisTicker.find('li').css({
                    opacity: '0',
                    display: 'none'
                });

                function tNext() {
                    thisTicker.find('li:first').detach().appendTo(thisTicker);

                    clearTimeout(timeoutID);
                    timeoutID = false;

                    typeWriter();
                }

                function type() {
                    count++;
                    let typeText = allText.substring(0, count);
                    if (!typeEl.attr('data-text')) {
                        typeEl.attr('data-text', allText);
                    }

                    if (count <= allText.length) {
                        wrapEl.text(typeText);
                        typeEl.css({
                            opacity: '1',
                            display: 'block',
                        });
                    } else {
                        clearInterval(intervalID);
                        intervalID = false;
                        timeoutID = setTimeout(tNext, autoplay);
                    }
                }
                if (!intervalID) {
                    intervalID = setInterval(type, speed);
                }
            }
        };
    })(jQuery);
</script>
