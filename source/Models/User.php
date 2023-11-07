<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer {
    
    public function __construct() {
        parent::__construct("users", ["nome", "email", "senha", "rg", "cpf", "crm", "cep", "logradouro", "numero", "complemento", "bairro", "cidade", "estado", "tipo", "convenio", "conv_numero", "celular"], "id", true);
    }

}