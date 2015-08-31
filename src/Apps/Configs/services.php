<?php
use Cygnite\Foundation\Application as App;

if (!defined('CF_SYSTEM')) {
    exit('External script access not allowed');
}

// Register all service provider
App::service(function ($app) {
    // Add multiple Service Provider into the array
    /*
     $app->registerServiceProvider([
            "Apps\Services\Providers\Payment\ApiServiceProvider",
     ]);
    
    // Use Controller as Service manual configuration
    $app['user.controller'] = function () use($app)
    {
        return new \Apps\Controllers\HelloController(new \Cygnite\Mvc\Controller\ServiceController, $app);
    }; 
    // OR 
    // Controller as Service automatic configuration
    $app->setServiceController('hello.controller', '\Apps\Controllers\HelloController');*/
});
