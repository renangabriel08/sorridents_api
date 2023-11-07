<?php

namespace Source\Controllers\Api;

use Source\Core\Controller;
use Source\Models\Login;
use Source\Models\Schedule;

class Schedules extends Api {

    //Construtor
    public function __construct() {
        parent::__construct();
    }

    //Retorna consultas do usuário logado
    public function index(): void{
        $response['consultas'] = array();
        $schedules = (new Schedule())->find("paciente = :user_id", "user_id={$this->user->id}")->fetch(true);

         for ($i = 0; $i < count($schedules) ; $i++) {
            array_push($response['consultas'], $schedules[$i]->data());
        }

        $this->call(
            200,
            "success_returned_data",
            "Consultas retornadas com sucesso."
        )->back($response);
  
    }

    //Retorna consulta por id
    public function read(array $data){
        $request = $this->requestLimit("schedulesRead", 5, 60);
        if(!$request){
            return false;
        }

        if (empty($data["schedule_id"]) || !$schedule_id = filter_var($data["schedule_id"],FILTER_VALIDATE_INT)){
            $this->call(
                400,
                "invalid_data",
                "Informe um id de consulta para ocorrer a pesquisa"
            )->back();
            return false;
        }
        
        $schedule = (new Schedule())->find("id = :schedule_id", "schedule_id={$schedule_id}")->fetch();

        if(!$schedule){
            $this->call(
                404,
                "not_found",
                "Consulta não encontrada"
            )->back();
            return;
        }

        $response["consulta"] = $schedule->data();
        $this->back($response);
    }

    //Cadastra nova consulta para o usuário logado
    public function create(array $data) {
        $request = $this->requestLimit("schedulesCreate", 5, 60);
        if(!$request){
            return false;
        }

        if(empty($data["dia"]) || empty($data["hora"]) || empty($data["medico"]) || empty($data["convenio"]) || empty($data["observacoes"])) {
            $this->call(
                400,
                "invalid_data",
                "Parâmetros inválidos ou faltantes"
            )->back();
            return false;
        }

        $schedule = new Schedule();

        $schedule->dia = $data['dia'];
        $schedule->hora = $data['hora'];
        $schedule->medico = $data['medico'];
        $schedule->paciente = $this->user->id;
        $schedule->convenio = $data['convenio'];
        $schedule->observacoes = $data['observacoes'];

        if(!$schedule->save()) {
            $this->call(
                400,
                "invalid_data",
                "Erro ao cadastrar consulta, dados enviados com formato incorreto"
            )->back();
            return false;
        }

        $response["consulta"] = $schedule->data();

        $this->call(
            200,
            "created",
            "Consulta cadastrada com sucesso"
        )->back($response);
    }

    //Atualiza consulta do usuário de acordo com o id informado
    public function update(array $data){
        $request = $this->requestLimit("schedulesUpdate", 5, 60);
        if(!$request){
            return false;
        }

        if (empty($data["schedule_id"]) || !$schedule_id = filter_var($data["schedule_id"],FILTER_VALIDATE_INT)){
            $this->call(
                400,
                "invalid_data",
                "Informe um id de consulta para ocorrer a pesquisa"
            )->back();
            return false;
        }

        $schedule = (new Schedule())->findById($data["schedule_id"]);

        if(!$schedule){
            $this->call(
                404,
                "not_found",
                "Consulta não encontrada"
            )->back();
            return;
        }

        $schedule->dia = (!empty($data["dia"])) ? $data['dia'] : $schedule->dia;
        $schedule->hora = (!empty($data["hora"])) ? $data['hora'] : $schedule->hora;
        $schedule->medico = (!empty($data["medico"])) ? $data['medico'] : $schedule->medico;
        $schedule->paciente = (!empty($data["paciente"])) ? $data['paciente'] : $schedule->paciente;
        $schedule->convenio = (!empty($data["convenio"])) ? $data['convenio'] : $schedule->convenio;
        $schedule->observacoes = (!empty($data["observacoes"])) ? $data['observacoes'] : $schedule->observacoes;

        if(!$schedule->save()) {
            $this->call(
                400,
                "invalid_data",
                "Erro ao atualizar dados, verifique as informações"
            )->back();
            return false;
        }

        $response['consulta'] = $schedule->data();

        $this->call(
            200,
            "success_updated",
            "Consulta atualizada com sucesso"
        )->back($response);

    }

    //Deleta consulta existente por id
    public function delete(array $data){
        $request = $this->requestLimit("schedulesDelete", 5, 60);
        if(!$request){
            return false;
        }
        
        if (empty($data["schedule_id"]) || !$schedule_id = filter_var($data["schedule_id"],FILTER_VALIDATE_INT)){
            $this->call(
                400,
                "invalid_data",
                "Informe um id de consulta para ocorrer a pesquisa"
            )->back();
            return false;
        }

        $schedule = (new Schedule())->findById($data["schedule_id"]);

        if(!$schedule){
            $this->call(
                404,
                "not_found",
                "Consulta não encontrada"
            )->back();
            return false;
        }

        if(!$schedule->destroy()) {
            $this->call(
                400,
                'error_deleted',
                'Erro ao tentar excluir consulta. Dúvidas, entre em contato com o suporte'
            )->back();
            return false;
        }

        $this->call(
            200,
            'success_deleted',
            'Consulta deletada com sucesso.'
        )->back();
    }
    
}