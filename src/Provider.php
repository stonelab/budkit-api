<?php

namespace Budkit\Api;

use Budkit\Application\Support\Service;
use Budkit\Dependency\Container;

class Provider implements Service {

    protected $application;

    public function __construct(Container $application) {
        $this->application = $application;
    }


    public static function  getPackageDir(){
        return __DIR__."/";
    }

    public function onRegister() {

        \Route::attach("/api", "Budkit\\Api\\Controller\\Protocol", function($route){
            $route->setTokens(array(
                'id'		=> '\d+',
                'format'	=> '(\.[^/]+)?'
            ));
            //subroutes
            $route->add('{format}','index');
            $route->add('{/id}{format}', "view");
            $route->add('{/id}/edit{format}', "edit");

        });
    }

    public function definition() {
        return ["app.register" => "onRegister"];
    }
}