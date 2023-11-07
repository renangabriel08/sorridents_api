<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Agreement extends DataLayer{
    
    public function __construct() {
        parent::__construct("agreements", ["nome"], "id", false);
    }
    
}