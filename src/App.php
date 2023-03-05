<?php

namespace Ganesh\PhpRestApi;

use Ganesh\PhpRestApi\Routes\Router;

class App
{

    public   Router $router;


    public static App $app;


    public function __construct()
    {
        $this->router = new Router();
    }

    public function run()
    {
        echo $this->router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
