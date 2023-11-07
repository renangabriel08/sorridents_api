<?php

namespace Source\Core;

use CoffeeCode\Router\Router;

class Controller {
    protected $objView;

    public function __construct(string $pathToViews = null) {
        $this->objView = new View($pathToViews);
    }
    
}