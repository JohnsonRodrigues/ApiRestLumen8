<?php

/** @var \Laravel\Lumen\Routing\Router $router */


use App\Routes\Employee\EmployeeRoutes;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

EmployeeRoutes::routes($router);
