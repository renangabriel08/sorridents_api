<?php

namespace Source\Controllers;

use http\Env\Request;
use Source\Core\Controller;
use Source\Models\Agreement;
use Source\Models\Schedule;
use Source\Models\Settings;
use Source\Models\Login;
use Source\Models\User;

class App extends Controller
{
    public function __construct()
    {
        parent::__construct(CONF_VIEW_PATH);

        if(!$this->user = Login::user()){
            header('Location:'.CONF_URL_BASE);
        }
    }


    public function home()
    {
        $data = [
            'title'=> "Home - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/home"
        ];

        echo $this->objView->render('home', ["data"=> $data]);
    }

    public function schedule(array $form)
    {
        if(empty($form['data']) || !$form){
            $pesquisa = date('Y-m-d');
        }
        else {
            $pesquisa = $form['data'];
        }

        //trás a estrutura da agenda referente ao dia da semana, da data pesquisada para preecher na tela
        $dSemana = date('w', strtotime($pesquisa));
        $objSettings = new Settings();
        $estruturaAgenda = $objSettings->find("dia_semana = :dia", "dia=".$dSemana)->fetch();

        //trás os dados da agenda referente a data pesquisada
        $objSchedule = new Schedule();
        $dadosAgenda = $objSchedule->find("dia = :dia", "dia=".$pesquisa)->order("hora")->fetch(true);

        $data = [
            'title'=> "Agenda - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/agenda",
            'pesquisa'=>$pesquisa,
            'estrutura'=>$estruturaAgenda,
            'agenda'=>$dadosAgenda
        ];
        echo $this->objView->render('schedule', ["data"=> $data]);
    }

    public function delete_schedule(array $form){
        $dadosConsulta = (new Schedule())->find("id = :cid", "cid={$form['id']}")->fetch();
        $dadosUsuario = (new User())->find("id = :cid", "cid={$dadosConsulta->paciente}")->fetch();

        if(isset($form["sim"])){
            $dadosConsulta->destroy();
            redirect('/agenda/'.$form['dia']);
        }
        if(isset($form["nao"])){
            redirect('/agenda/'.$form['dia']);
        }

        $data = [
            'title'=> "Cancelamento de Conulta - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/deleta-agendamento",
            'consulta'=>$dadosConsulta,
            'paciente'=>$dadosUsuario
        ];

        echo $this->objView->render('delete-schedule', ["data"=> $data]);
    }

    function register_schedule(array $form){
        $dadosUsuarios = (new User())->find()->fetch(true);
        $dadosConvenios = (new Agreement())->find()->fetch(true);

        if(isset($form["agendar"])){
            $objAgendamento = new Schedule();
            $dia = date_fmt_back($form['data']);
            $objAgendamento->dia = $dia;
            $objAgendamento->hora = $form['hora'];
            $objAgendamento->medico = 2;
            $objAgendamento->paciente = $form['id'];
            $objAgendamento->convenio = $form['convenio'];
            $objAgendamento->observacoes = $form['observacoes'];

            $objAgendamento->save();

            redirect('/agenda/'.$objAgendamento->dia);
        }

        $data = [
            'title'=> "Cancelamento de Conulta - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/deleta-agendamento",
            'pacientes'=>$dadosUsuarios,
            'convenios'=>$dadosConvenios,
            'data'=>$form['data'],
            'hora'=>$form['hora']
        ];

        echo $this->objView->render('register-schedule', ["data"=> $data]);
    }

    public function search_users(array $form){

        $nomePaciente = filter_var($form['chave'], FILTER_SANITIZE_STRIPPED);
        if(!empty($nomePaciente)){
            $objUser = new User();
            $result = $objUser->find("nome LIKE :nome", "nome=%{$nomePaciente}%", 'id, nome, convenio')->fetch(true);
            if($result){
                foreach ($result as $user){
                    $dados[] = ['id'=>$user->id,
                            'nome'=>$user->nome,
                            'convenio'=>$user->convenio];
                }
                $retorno = ['status'=>true, 'dados'=>$dados];
            }
            else{
                $retorno = ['status'=>false, 'msg'=>"Paciente não encontrado."];
            }
        }
        else{
            $retorno = ['status'=>false, 'msg'=>"Paciente não encontrado."];
        }
        echo json_encode($retorno);
    }

    public function logout(){

        $this->user = Login::logout();

        $data = [
            'title'=> "Login - ". CONF_SITE_NAME,
            'description'=> CONF_SITE_DESC,
            'url'=> "/"
        ];

        echo $this->objView->render('login', ["data"=> $data]);
    }

 }
