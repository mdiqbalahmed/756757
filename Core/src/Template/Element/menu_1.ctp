<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
<style>
    @media (min-width:992px) {
        .dropdown-menu {
            width: 150px;
            background-color: rgb(26, 167, 98, 0.9) !important;
        }

        .dropdown-item {
            border-bottom: 1px solid #00572d;
            background-color: rgb(26, 167, 98, 0) !important;
            padding-bottom: 0;
            /* margin-bottom: 0; */
        }

        .dropdown-item a {
            padding: 0;
            color: #fff !important;
        }
    }

    #navbarNav>ul>li {
        display: flex;
        align-items: center;
        font-size: 11pt;
        padding: 0 !important;
        font-weight: 500;
        border-right: 1px solid #c4c4c4;
        color: #202020 !important;
    }

    #navbarNav>ul>li::after {
        font-size: 11pt;
        padding: 0 !important;
        font-weight: 500;
        border-right: 1px solid #c4c4c4;
    }

    #navbarNav>ul>li:last-child {
        border-right: none;
    }

    #navbarNav>ul {
        text-align: center;
        height: fit-content;
    }

    .custom_bg_nav {
        background-image: -webkit-gradient(linear, left top, left bottom, from(#ffffff), to(#e2e2e2));
        background-image: -moz-linear-gradient(top, #ffffff 0%, #e2e2e2 100%);
        background-image: -o-linear-gradient(top, #ffffff 0%, #e2e2e2 100%);
        background-image: -ms-linear-gradient(top, #ffffff 0%, #e2e2e2 100%);
        background-image: linear-gradient(top, #ffffff 0%, #e2e2e2 100%);
    }

    /* hover dropdown menus */
    @media only screen and (max-width: 991px) {
        .navbar-hover .show>.dropdown-toggle::after {
            transform: rotate(-90deg);
        }
    }

    @media only screen and (min-width: 992px) {
        .navbar-hover .collapse ul li {
            position: relative;
        }

        .navbar-hover .collapse ul li:hover>ul {
            display: block
        }

        .navbar-hover .collapse ul ul {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 250px;
            display: none
        }

        .navbar-hover .collapse ul ul ul {
            position: absolute;
            top: 0;
            left: 100%;
            min-width: 250px;
            display: none
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light custom_bg_nav navbar-hover">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <?=
        $this->Menus->menu('main', [
            'class' => '',
            'dropdown' => true,
            'dropdownClass' => 'navbar-nav',
            'subTagAttributes' => [
                'class' => 'nav-item',
            ],
            'linkAttributes' => [
                'class' => 'nav-link',
                'onmouseover' => '',
            ],
        ]);
        ?>
    </div>
</nav>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
<script>
    // Prevent closing from click inside dropdown
    $(document).on('click', '.dropdown-menu', function(e) {
        e.stopPropagation();
    });

    // make it as accordion for smaller screens
    if ($(window).width() < 992) {
        $('.dropdown-menu a').click(function(e) {
            e.preventDefault();
            if ($(this).next('.submenu').length) {
                $(this).next('.submenu').toggle();
            }
            $('.dropdown').on('hide.bs.dropdown', function() {
                $(this).find('.submenu').hide();
            })
        });
    }

    // Get all elements with the class ".bg-dark"
    var elementsWithBgDarkClass = document.querySelectorAll(".bg-dark");

    // Iterate through the elements and remove the class
    elementsWithBgDarkClass.forEach(function(element) {
        element.classList.remove("bg-dark");
    });
</script>
