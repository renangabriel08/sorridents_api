<?php

namespace Source\Controllers\Api;

use Source\Core\Controller;
use Source\Models\Login;
use Source\Models\Setting;

class Settings extends Api {

    //Construtor
    public function __construct() {
        parent::__construct();
    }

    //Retorna dados da estrutura da agenda
    public function index(): void {

        $settings = (new Setting())->find()->fetch();

        if(!$settings) {
            $this->call(
                404,
                'not_found',
                'Estrutura da agenda não configurada, entre em contato com o suporte'
            )->back();
            return;
        }

        $response['settings'] = $settings->data();
        $this->back($response);

    }
    
}