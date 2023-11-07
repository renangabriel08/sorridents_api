<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Setting extends DataLayer{
    
    public function __construct() {
        parent::__construct("settings", ["dia_semana", "agenda_inicio", "agenda_fim", "agenda_inicio_almoco", "agenda_fim_almoco", "tempo_consulta"], "id", false);
    }
    
}