<?php

namespace App\Routes\Employee;

use Laravel\Lumen\Routing\Router;

class EmployeeRoutes
{
    public static function routes(Router $router)
    {
        $router->group(['prefix' => 'employee'], function () use ($router) {
            $router->get('/', 'Employee\EmployeeController@index');
            $router->get('/{id}', 'Employee\EmployeeController@show');
            $router->post('/', 'Employee\EmployeeController@store');
            $router->put('/{id}', 'Employee\EmployeeController@update');
            $router->post('/link_salary', 'Employee\EmployeeController@linkSalary');
            $router->delete('/{id}', 'Employee\EmployeeController@destroy');
           $router->get('/search/{search}', 'Employee\EmployeeController@search');
        });
    }
}

