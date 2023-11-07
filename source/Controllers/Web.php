<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Core\Controller;
use Source\Models\Login;
use Source\Models\Settings;
use Source\Models\Schedule;
use Source\Core\Session;

class Web extends Controller
{
    public function __construct()
    {
        parent::__construct(CONF_VIEW_PATH);
    }

    //Registro
    public function register(?array $form): void
    {
        $msg = "";

        if(!empty($form))
        {
            if(empty($form['nome']) || empty($form['cep']) || empty($form['logradouro']) || empty($form['numero']) || empty($form['bairro']) || empty($form['cidade']) || empty($form['estado']) || empty($form['rg']) || empty($form['cpf']) || empty($form['email']) || empty($form['senha'])){
                $msg = "Preencha todos os campos obrigatórios.";
            }
        }

        $data = [
            'title'=> "Home - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/cadastro",
            'form'=> $form,
            'msg'=> $msg
        ];
        echo $this->objView->render('register', ["data"=> $data]);
    }

    //Login
    public function login(?array $form): void
    {
        $msg = "";

        if(!empty($form))
        {
            if(empty($form['email']) || empty($form['senha'])){
                $msg = "Preencha todos os campos obrigatórios.";
            }
        }

        $data = [
            'title'=> "Home - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/",
            'form'=> $form,
            'msg'=> $msg
        ];
        echo $this->objView->render('login', ["data"=> $data]);
    }

    /**
     * Site Nav Error
     * @param array $data
     */
    public function error(array $data):void
    {
        $data = [
            'url'=> "/error"
        ];
        echo $this->objView->render('error', ["data"=> $data]);
    }

    //Esqueci Senha
    public function forget()
    {
        $msg = "";

        if(!empty($form))
        {
            if(empty($form['email']) || empty($form['cpf']) || empty($form['senha'])){
                $msg = "Preencha todos os campos obrigatórios.";
            }
        }

        $data = [
            'title'=> "Home - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/esqueci-senha",
            'msg'=> $msg
        ];
        echo $this->objView->render('forget', ["data"=> $data]);
    }

}