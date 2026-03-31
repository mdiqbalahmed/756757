<?php
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Croogo\Core\Nav;
use Croogo\Core\Utility\StringConverter;

$showActions = isset($showActions) ? $showActions : true;

$dashboardUrl = (new StringConverter())->linkStringToArray(
    Configure::read('Site.dashboard_url')
);

function getSettingsKey($key) {
    $settingsTable = TableRegistry::getTableLocator()->get('settings');
    $keyValue = $settingsTable
        ->find()
        ->where(['`key`' => $key])
        ->first();
    return $keyValue ? $keyValue->value : null;
}

$smsCredit = getSettingsKey('SMS.SMS_Credit');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title><?= $this->fetch('title') ?> - <?= $_siteTitle ?></title>
    <?= $this->element('admin/stylesheets') ?>
    <?= $this->element('admin/javascripts') ?>
    <?= $this->fetch('script') ?>
    <?= $this->fetch('css') ?>
</head>

 <style>


        .sidebar-toggler {
            font-size: 1.5rem;
            cursor: pointer;
            color: #fff;
            background: none;
            border: none;
            margin-right: 15px;
        }

        .nav-sidebar {
            width: 180px;

            position: absolute;
            top: -30px; /* height of fixed-top navbar */
            bottom: 0;
            left: 0;
            background: #000;
            z-index: 1000;
            transform: translateX(0);
            transition: transform 0.3s ease-in-out;
               
        }
        .nav-sidebar .bg-black .nav > li > a {
            text-decoration: none;


            height: 35px;       /* Adjust height as needed */
            width: 180px;        /* Full width of parent */
            display: flex;      /* Helps align content nicely */
            align-items: center; /* Vertically center text */
            padding: 8px 8px;     /* Optional: add horizontal padding */
            /* box-sizing: border-box; */
            font: 14px sans-serif;
        }
    .nav-sidebar .bg-black .nav > li > a:hover {
        background-color: #333; /* Darker shade on hover */
        color: #f0f0f0; /* Lighter text color on hover */
        text-decoration: none;
    }

    body.sidebar-collapsed .nav-sidebar {
         transform: translateX(-100%);
     }

        .content-container {
            margin-left: 180px;
            width: calc(100% - 180px);
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
            padding: 20px;
        } 
        body .content-container {
            margin-left: 180px ;
            width: calc(100% - 180px) ;
        }
        #content {

            min-height: 1250px !important;
        }

        body.sidebar-collapsed .content-container {
            margin-left: 0;
            width: 100%;
        }


 /* mobile view */
    @media (max-width: 768px) {
        
    .nav-sidebar {
           position: fixed;
           overflow: auto;
            width: 180px;

      
      
        }

    body .content-container {
        margin-left: 0 !important;
        width: 100% !important;
    }

    body.sidebar-open #content-container {
        filter: blur(3px);
        pointer-events: none;
        user-select: none;
    }

}
.nav-sidebar .nav-item > a {
    color: white;
    padding: 8px 16px;
    display: block;
}

/* .nav-sidebar .nav-item.has-submenu > a {
    cursor: pointer;
} */

.nav-sidebar .nav-item.active > a {
    background-color: #343a40;
    font-weight: bold;
}
header .navbar-nav:last-child {
    text-align: left;
   
}

.nav-sidebar .bg-black .nav > li> a .fa-caret-down {
    display: none !important;

}




#top-right-menu>li {
    border-left: 2px solid;
    color: #fff;
    padding: 4px;
    height: 40px;
}

a:-webkit-any-link {
       text-decoration: none !important;
    
}

@media print {
    
    .nav-sidebar
    
     {
        display: none !important;
    }

    body {
        margin: 0 !important;
    }

    #content-container {
        width: 100% !important;
        margin-left: 0 !important;
    }
}
/* Add border-bottom to all li except last */
.nav-sidebar .bg-black .nav > li:not(:last-child) {
  border-bottom: 1px solid #495057;

}

/* Optional: remove border-bottom from last li */
.nav-sidebar .bg-black .nav > li:last-child {
  border-bottom: none;
}

.select2-container--bootstrap .select2-results__option {
    padding: .5rem .75rem;
    border-bottom: 1px solid #0000001c;
}

.select2-container--bootstrap .select2-selection--single .select2-selection__arrow b {
    left: -10px;
}

.nav-sidebar .bg-black .nav > li > div > a:hover {
  color: #ced4da !important;
}

 .fa-caret-down {
  margin-top: 0 !important;           
  align-self: center;   
}
#top-right-menu li.has-submenu > a > .fa-caret-down {
    margin-top: 10px !important;           
  align-self: center;   
}
.dropdown-divider {
    height: 5px !important;
    margin: 0px !important;
    overflow: hidden;
    border-top: 1px solid rgba(0, 0, 0, .15);
}

    /* Preloader */
        #preloader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: #fff;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

</style>


<body>

<!-- Preloader -->
<div id="preloader">
  <div class="spinner-border text-primary" role="status" style="width:3rem;height:3rem;">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<header class="navbar navbar-expand-md navbar-dark bg-black fixed-top ">
    <button id="sidebarToggle" class="btn btn-dark sidebar-toggler d-flex align-items-center px-2 py-2 rounded shadow-sm" type="button" data-toggle="collapse" data-target="#sidebar">
    <i class="fas fa-bars"></i>
  
</button>

        <?= $this->Html->link(Configure::read('Site.title'), $dashboardUrl, ['class' => 'navbar-brand d-none d-sm-flex ']) ?>

        <!-- Top-left Menu -->
        <?= $this->Croogo->adminMenus(Nav::items('top-left'), [
            'type' => 'dropdown',
            'htmlAttributes' => [
                'id' => 'top-left-menu',
                'class' => 'navbar-nav d-none d-sm-flex mr-auto'
            ]
        ]) ?>

        <?php if ($this->getRequest()->getSession()->read('Auth.User.id')) : ?>
            <!-- Right Section -->
    <div style="
    position: fixed;
    top: 0px;
    right: 0px;
    z-index: 1050;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 10px;

    padding: 8px 0px;

    max-width: 100%;
    flex-wrap: wrap;
">
    <p class="mb-0" style="font-size: 13px; font-weight: 600; white-space: nowrap;">
        SMS Credit: <?= $smsCredit ?>
    </p>

    <?= $this->Croogo->adminMenus(Nav::items('top-right'), [
        'type' => 'dropdown',
        'htmlAttributes' => [
            'id' => 'top-right-menu',
            'class' => 'navbar-nav',
            'style' => 'margin-bottom: 0;'
        ]
    ]) ?>
</div>

        <?php endif; ?>
</header>


<div id="wrap" >
    <div class="nav-sidebar ">
        <?= $this->element('Croogo/Core.admin/navigation') ?>
    </div>
    <div id="content-container" class="content-container <?= $this->Theme->getCssClass('containerFluid') ?>">
        <div id="content" class="content">
            <div id="breadcrumb-container" class="col-12 p-0 d-flex justify-content-between align-items-center">
                <?= $this->element('Croogo/Core.admin/breadcrumb') ?>
                <?php if ($showActions && $actionsBlock = $this->fetch('action-buttons')) : ?>
                    <div class="actions m-2 ml-auto">
                        <?= $actionsBlock ?>
                    </div>
                <?php endif ?>
            </div>
            <div id="inner-content" class="p-0 mt-2 <?= $this->Theme->getCssClass('columnFull') ?>">
                <?= $this->Layout->sessionFlash() ?>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>
</div>

<?= $this->element('Croogo/Core.admin/footer') ?>
<?= $this->element('Croogo/Core.admin/initializers') ?>
<?= $this->fetch('body-footer') ?>
<?= $this->fetch('postLink') ?>
<?= $this->fetch('scriptBottom') ?>
<?= $this->Js->writeBuffer() ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const body = document.body;
    const sidebar = document.querySelector('.nav-sidebar');
    const toggler = document.getElementById('sidebarToggle');

    const updateSidebar = () => {
        if (window.innerWidth > 768) {
            body.classList.remove('sidebar-collapsed','sidebar-open');
        } else {
            body.classList.add('sidebar-collapsed');
            body.classList.remove('sidebar-open');
        }
    };

    toggler?.addEventListener('click', e => {
        e.stopPropagation();
        body.classList.toggle('sidebar-collapsed');
        body.classList.toggle('sidebar-open');
        toggler.classList.toggle('active');
    });

    document.addEventListener('click', e => {
        if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !toggler.contains(e.target)) {
            body.classList.add('sidebar-collapsed');
            body.classList.remove('sidebar-open');
        }
    });

    window.addEventListener('resize', updateSidebar);
    updateSidebar();

    // Preloader fade out
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.style.transition = 'opacity .4s ease';
        window.addEventListener('load', () => {
            preloader.style.opacity = '0';
            setTimeout(()=> preloader.style.display='none',400);
        });
    }
});
</script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

</body>
</html>
