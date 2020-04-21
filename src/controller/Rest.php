<?php

namespace Budkit\Api\Controller;

use Budkit\Dependency\Container;
use Budkit\Routing\Controller;

class Rest extends Controller {

    public function __construct(Container $application) {
        parent::__construct($application);
    }

    public function index(){
        echo "{test: RESTful API}";
    }

    public function checkPermission(){
        return true;
    }

}