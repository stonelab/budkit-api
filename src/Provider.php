<?php

namespace Budkit\Api;

use Budkit\Application\Support\Service;
use Budkit\Dependency\Container;
use Route;

class Provider implements Service {

    protected $application;

    public function __construct(Container $application) {
        $this->application = $application;
    }


    public static function  getPackageDir(){
        return __DIR__."/";
    }

    public function onRegister() {

        $this->application->observer->attach([$this, "onAfterRouteMatch"], "Dispatcher.afterRouteMatch");

        //Request check Check Keys and everything...
        $this->application->observer->attach([$this, "onBeforeDispatch"], "'Dispatcher.beforeDispatch'");

        //Response check
        $this->application->observer->attach([$this, "onAfterDispatch"], "'Dispatcher.afterDispatch'");


        $this->registerRoutes();

    }


    public function registerRoutes(){

        Route::attach("/api", "Budkit\\Api\\Controller\\Rest", function($route){
            $route->setSecure( true );
            $route->setTokens(array(
                'format'	=> '(\.[^/]+)?'
            ));

            //@TODO extend this route with the API definition

            //$route->setIsStateless(); //session destroyed after each requested; authenticate in Dispatch.afterRouteMatch
            $route->add('{format}','index')
                ->setSecure( true )
                ->setIsStateless()
                ->setPermissionHandler("view", "checkPermission");
        });

    }

    public function onAfterRouteMatch($Event){

        $session = $this->application->session;

        //authenticate using oauth 2;

        //print_R($session);


    }


    public function onBeforeDispatch($Event){

    }

    public function onAfterDispatch($Event){

    }

    public function definition() {
        return ["app.register" => "onRegister"];
    }
}