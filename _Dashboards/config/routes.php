<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Croogo/Dashboards', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->setExtensions(['json']);
        $route->applyMiddleware('csrf');
        $route->connect('/getSearchMonth/*', [
            'controller' => 'Ajax',
            'action' => 'getSearchMonth',
        ]);

        $route->connect('/getTotalStudent', [
            'controller' => 'Ajax',
            'action' => 'getTotalStudent',
        ]);
        $route->connect('/getReligions', [
            'controller' => 'Ajax',
            'action' => 'getReligions',
        ]);
        $route->connect('/getGroups', [
            'controller' => 'Ajax',
            'action' => 'getGroups',
        ]);
        $route->connect('/getQuata', [
            'controller' => 'Ajax',
            'action' => 'getQuata',
        ]);
        $route->connect('/dashboards/updateStatus/*', [
            'plugin' => 'Croogo/Dashboards',
            'controller' => 'Ajax',
            'action' => 'updateStatus',
        ]);

        $route->scope('/dashboards', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});
