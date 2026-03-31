<?php

use Cake\Core\Configure;

$main_top_bg = Configure::read('Menu.main_top_bg');
$main_bottom_bg = Configure::read('Menu.main_bottom_bg');
$main_text_color = Configure::read('Menu.main_text_color');
$main_border_color = Configure::read('Menu.main_border_color');
$submenu_top_bg = Configure::read('Menu.submenu_top_bg');
$submenu_bottom_bg = Configure::read('Menu.submenu_bottom_bg');
$submenu_text_color = Configure::read('Menu.submenu_text_color');

?>
<style>
    .menu,
    .menu ul {
        margin: 0px;
        padding: 0px;
        list-style: none;
    }

    .menu {
        width: 100%;
        background-image: -webkit-gradient(linear, left top, left bottom, from(<?= $main_top_bg ?>), to(<?= $main_bottom_bg ?>));
        background-image: -moz-linear-gradient(top, <?= $main_top_bg ?> 0%, <?= $main_bottom_bg ?> 100%);
        background-image: -o-linear-gradient(top, <?= $main_top_bg ?> 0%, <?= $main_bottom_bg ?> 100%);
        background-image: -ms-linear-gradient(top, <?= $main_top_bg ?> 0%, <?= $main_bottom_bg ?> 100%);
        background-image: linear-gradient(top, <?= $main_top_bg ?> 0%, <?= $main_bottom_bg ?> 100%);
        box-shadow: 0px 2px 2px #ccc;
    }

    .menu:before,
    .menu:after {
        content: "";
        display: block;
    }

    .menu:after {
        clear: both;
    }

    #menu-wrap>ul.menu>li.nav-item>a {
        color: <?= $main_text_color ?>;
    }

    #menu-wrap>ul.menu>li.nav-item {
        display: flex;
        height: 40px;
        float: left;
        padding: 0 !important;
        font-weight: 500;
        border-right: 1px solid #c4c4c4;
        position: relative;
        align-items: center;
    }

    .menu ul:first-child li:last-child {
        border-right: none;
    }

    .menu a {
        float: left;
        /* padding: 12px 30px; */
        color: <?= $submenu_text_color ?>;
        text-decoration: none;
        font: bold 12px Arial, Helvetica; 
    }

    .menu ul {
        margin: 20px 0px 0px 0px;
        opacity: 0;
        visibility: hidden;
        position: absolute;
        top: 38px;
        left: 0px;
        z-index: 1;
        background: linear-gradient(<?= $submenu_top_bg ?>, <?= $submenu_bottom_bg ?>);
        box-shadow: 0px -1px 0px rgba(255, 255, 255, .3);
        border-radius: 3px;
        transition: all .2s ease-in-out;
    }

    .menu li:hover>ul {
        opacity: 1;
        visibility: visible;
        margin: 0px;
    }

    .menu ul ul {
        top: 0px;
        left: 150px;
        margin: 0px 0px 0px 20px;
        box-shadow: 0px -1px 0px rgba(255, 255, 255, .3);
    }

    .menu ul a {
        padding: 10px;
        width: 160px;
        display: block;
        white-space: wrap;
        float: none;
        text-transform: none;
    }

    .menu ul a:hover {
        background: linear-gradient(<?= $submenu_top_bg ?>, <?= $submenu_bottom_bg ?>);
    }

    .menu ul li:first-child>a:after {
        content: '';
        position: absolute;
        left: 40px;
        top: -6px;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid <?= $submenu_top_bg ?>;
    }

    .menu ul ul li:first-child>a:after {
        left: -12px;
        top: 50%;
        margin-top: -6px;
        border-top: 6px solid transparent;
        border-right: 6px solid <?= $submenu_bottom_bg ?>;
        border-bottom: 6px solid transparent;
    }

    #menu-trigger {
        display: none;
    }


    @media(max-width: 700px) {

        #menu-wrap {
            position: relative;
        }

        #menu-wrap * {
            box-sizing: border-box;
        }

        #menu-trigger {
            margin-top: 1em;
            display: block;
            height: 40px;
            line-height: 40px;
            cursor: pointer;
            padding: 0px 0px 0px 10px;
            border: 1px solid <?= $submenu_bottom_bg ?>;
            color: <?= $submenu_text_color ?>;
            font-weight: bold;
            background-color: #111;
            background: no-repeat 10px center, linear-gradient(<?= $submenu_top_bg ?>, <?= $submenu_bottom_bg ?>);
            /* border-radius: 6px; */
        }

        .menu {
            margin: 0px;
            padding: 10px;
            position: relative;
            /* top: 40px; */
            top: 100%;
            width: 100%;
            z-index: 1;
            display: none;
            box-shadow: none;
            background: linear-gradient(<?= $submenu_top_bg ?>, <?= $submenu_bottom_bg ?>);

        }

        .menu:after {
            content: '';
            position: absolute;
            left: 25px;
            top: -8px;
        }

        .menu ul {
            width: 130px;
            position: static;
            visibility: visible;
            opacity: 1;
            margin: 0px;
            background: none;
            box-shadow: none;
        }

        .menu ul ul {

            margin: 0px 0px 0px 20px;
            box-shadow: none;
        }

        .menu ul ul li:first-child>a:after {
            border-top: 0px;
            border-bottom: 0;
        }

        .menu li {
            position: static;
            display: block;
            float: none;
            border: 0px;
            margin: 5px;
            box-shadow: none;
            background: none !important;
        }

        .menu ul li {
            margin-left: 20px;
            box-shadow: none;
        }

        .menu a {
            font-size: 14px;
            width: 100%;
            display: block;
            float: none;
            padding: 0px;
            color: <?= $submenu_text_color ?>;
        }

        .menu a:hover {
            color: #fafafa;
        }

        .menu ul a {
            padding: 0px;
            width: auto;
        }

        .menu ul a:hover {
            background: none !important;
        }
    }


    ul.menu li.nav-item.dropdown>a::after {
        content: "▼";
        margin-left: 1px;
        color: <?= $main_text_color ?>;
        font-size: 8px;
    }

    ul.menu li.nav-item.dropdown ul li.nav-link::after {
        content: none;
    }

    ul.menu ul i {
        display: none;
    }
</style>


<script>
    $(document).ready(function() {
        $('#menu-wrap').prepend('<div id="menu-trigger"><i class="fa fa-bars mr-2"></i>Menu</div>');
        $('#menu-trigger').on('click', function() {
            $('.menu').slideToggle();
        });
    });
</script>

<nav id="menu-wrap">
    <?=
    $this->Menus->menu('main', [
        'class' => '',
        'dropdown' => true,
        'dropdownClass' => 'menu',
        'subTagAttributes' => [
            'class' => 'nav-item',
        ],
        'linkAttributes' => [
            'class' => 'nav-link',
        ],
    ]);
    ?>
</nav>


<script>
    var elementsWithBgDarkClass = document.querySelectorAll(".bg-dark");
    var elementsWithDropdownClass = document.querySelectorAll(".dropdown-toggle");

    // Function to remove classes based on screen size
    function removeClassesBasedOnScreenSize() {
        if (window.innerWidth < 700) {
            var elementsWithNavItemClass = document.querySelectorAll(".nav-item");
            var elementsWithNavLinkClass = document.querySelectorAll(".nav-link");

            elementsWithNavItemClass.forEach(function(element) {
                element.classList.remove("nav-item");
            });

            elementsWithNavLinkClass.forEach(function(element) {
                element.classList.remove("nav-link");
            });
        }
    }


    elementsWithBgDarkClass.forEach(function(element) {
        element.classList.remove("bg-dark");
        element.classList.remove("dropdown-menu");
        element.classList.remove("dropdown-item");
    });
    elementsWithDropdownClass.forEach(function(element) {
        element.classList.remove("dropdown-toggle");
    });

    // Call the function on page load and when the window is resized
    removeClassesBasedOnScreenSize();

    window.addEventListener("resize", removeClassesBasedOnScreenSize);
</script>
