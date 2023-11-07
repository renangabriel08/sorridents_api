<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class UserTypes extends DataLayer {
    
    public function __construct() {
        parent::__construct("users_types", ["nome", "descricao"], "id", false);
    }
    
}