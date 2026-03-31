<?php

namespace Croogo\Settings\Config;

use Croogo\Core\Nav;

Nav::add('sidebar', 'settings', [
    'icon' => 'cog',
    'title' => __d('croogo', 'Settings'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Croogo/Settings',
        'controller' => 'Settings',
        'action' => 'prefix',
        'Site',
    ],
    'weight' => 60,
    'children' => [
        'site' => [
            'title' => __d('croogo', 'Site'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Site',
            ],
            'weight' => 10,
        ],

        'theme' => [
            'title' => __d('croogo', 'Theme'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Theme',
            ],
            'weight' => 15,
        ],

        'reading' => [
            'title' => __d('croogo', 'Reading'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Reading',
            ],
            'weight' => 30,
        ],

        'comment' => [
            'title' => __d('croogo', 'Comment'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Comment',
            ],
            'weight' => 50,
        ],

        'service' => [
            'title' => __d('croogo', 'Service'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Service',
            ],
            'weight' => 60,
        ],

        'languages' => [
            'title' => __d('croogo', 'Languages'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Languages',
                'action' => 'index',
            ],
            'weight' => 70,
        ],

        'cache' => [
            'title' => __d('croogo', 'Cache'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Caches',
                'action' => 'index',
            ],
            'weight' => 70,
        ],
        'Footer' => [
            'title' => __d('croogo', 'Footer'),
        'url' => [
            'prefix' => 'admin',
            'plugin' => 'Croogo/Settings',
            'controller' => 'Settings',
            'action' => 'prefix',
            'Footer',
        ],
            'weight' => 80,
        ],
        'Widget' => [
            'title' => __d('croogo', 'Widget'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Widget',
            ],
            'weight' => 90,
        ],
        'Home Menu' => [
            'title' => __d('croogo', 'Home Menu'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Menu',
            ],
            'weight' => 100,
        ],
        'Result' => [
            'title' => __d('croogo', 'Result'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Result',
            ],
            'weight' => 110,
        ],
        'Recipt' => [
            'title' => __d('croogo', 'Recipt'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Recipt',
            ],
            'weight' => 120,
        ],
        'SMS' => [
            'title' => __d('croogo', 'SMS'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'SMS',
            ],
            'weight' => 130,
        ],

        'Select Session' => [
            'title' => __d('croogo', 'Select Session'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Croogo/Core',
                'controller' => 'Setup',
                'action' => 'selectSession',
            ],
            'weight' => 140,
        ],

    ],
]);



