<?php

namespace Source\Controllers\Api;

use Source\Core\Controller;
use Source\Models\Login;
use Source\Models\User;

class Users extends Api{

    //Construtor
    public function __construct() {
        parent::__construct();
    }

    //Retorna dados do usuário a partir de email e senha
    public function index(): void{
        $user = $this->user->data();

        if(!$user) {
            $this->call(
                404,
                "not_found",
                "Erro ao retornar dados do usuário"
            )->back();
            return;
        }

        unset($user->senha);
        $response["user"] = $user;
        $this->back($response);
    }

    //Retorna dados do usuário a partir do id
    public function read(array $data){
        $request = $this->requestLimit("usersRead", 5, 60);
        if(!$request){
            return false;
        }

        if (empty($data["user_id"]) || !$user_id = filter_var($data["user_id"],FILTER_VALIDATE_INT)){
            $this->call(
                400,
                "invalid_data",
                "Informe um id de usuário para ocorrer a pesquisa"
            )->back();
            return false;
        }
        
        $user = (new User())->find("id = :user_id", "user_id={$user_id}")->fetch();

        if(!$user){
            $this->call(
                404,
                "not_found",
                "Usuário não encontrado"
            )->back();
            return;
        }

        unset($user->data()->senha);
        $response["user"] = $user->data();
        $this->back($response);
    }

    //Cadastra usuários
    public function create(array $data) {
        $request = $this->requestLimit("usersCreate", 5, 60);
        if(!$request){
            return false;
        }

        if(empty($data["nome"]) || empty($data["email"]) || empty($data["senha"]) || empty($data["rg"]) || empty($data["cpf"]) || empty($data["celular"]) || empty($data["cep"]) || empty($data["logradouro"]) || empty($data["numero"]) || empty($data["complemento"]) || empty($data["bairro"]) || empty($data["cidade"]) || empty($data["estado"]) || empty($data["convenio"]) || empty($data["conv_numero"]) || empty($data["crm"])) {
            $this->call(
                400,
                "invalid_data",
                "Parâmetros inválidos ou faltantes"
            )->back();
            return false;
        }

        $user = new User();

        $result = $user->find("email = :user_email", "user_email={$data['email']}")->fetch();

        if($result) {
            $this->call(
                400,
                "invalid_data",
                "Email já cadastrado em nosso sistema."
            )->back();
            return false;
        }
        
        $user->nome = $data["nome"];
        $user->email = $data["email"];
        $user->senha = password_hash($data["senha"],CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
        $user->rg = $data["rg"];
        $user->cpf = $data["cpf"];
        $user->celular = $data["celular"];

        $user->cep = $data["cep"];
        $user->logradouro = $data["logradouro"];
        $user->numero = $data["numero"];
        $user->complemento = $data["complemento"];
        $user->bairro = $data["bairro"];
        $user->cidade = $data["cidade"];
        $user->estado = $data["estado"];

        $user->convenio = $data["convenio"];
        $user->conv_numero = $data["conv_numero"];
        $user->crm = $data["crm"];
        $user->tipo = 3;

        if(!$user->save()) {
            $this->call(
                400,
                "invalid_data",
                "Erro ao cadastrar usuário, dados enviados com formato incorreto"
            )->back();
            return false;
        }

        unset($user->data()->senha);
        $response["user"] = $user->data();

        $this->call(
            200,
            "created",
            "Usuário cadastrado com sucesso"
        )->back($response);
    }

    //Atualiza dados do usuário logado
    public function update(array $data){
        $request = $this->requestLimit("usersUpdate", 5, 60);
        if(!$request){
            return false;
        }

        $user = (new User())->findById($this->user->id);

        if(!empty($data['email'])) {
            $result = $user->find("email = :user_email", "user_email={$data['email']}")->fetch();

            if($result) {
                $this->call(
                    400,
                    "invalid_data",
                    "Email já cadastrado em nosso sistema."
                )->back();
                return false;
            }
        }

        $user->nome = (!empty($data["nome"])) ? $data['nome'] : $this->user->nome;
        $user->email = (!empty($data["email"])) ? $data['email'] : $this->user->email;
        $user->senha = (!empty($data["senha"])) ? password_hash($data["senha"],CONF_PASSWD_ALGO, CONF_PASSWD_OPTION) : $this->user->senha;
        $user->rg = (!empty($data["rg"])) ? $data['rg'] : $this->user->rg;
        $user->cpf = (!empty($data["cpf"])) ? $data['cpf'] : $this->user->cpf;
        $user->celular = (!empty($data["celular"])) ? $data['celular'] : $this->user->celular;

        $user->cep = (!empty($data["cep"])) ? $data['cep'] : $this->user->cep;
        $user->logradouro = (!empty($data["logradouro"])) ? $data['logradouro'] : $this->user->logradouro;
        $user->numero = (!empty($data["numero"])) ? $data['numero'] : $this->user->numero;
        $user->complemento = (!empty($data["complemento"])) ? $data['complemento'] : $this->user->complemento;
        $user->bairro = (!empty($data["bairro"])) ? $data['bairro'] : $this->user->bairro;
        $user->cidade = (!empty($data["cidade"])) ? $data['cidade'] : $this->user->cidade;
        $user->estado = (!empty($data["estado"])) ? $data['estado'] : $this->user->estado;

        $user->convenio = (!empty($data["convenio"])) ? $data['convenio'] : $this->user->convenio;
        $user->conv_numero = (!empty($data["conv_numero"])) ? $data['conv_numero'] : $this->user->conv_numero;
        $user->crm = (!empty($data["crm"])) ? $data['crm'] : $this->user->crm;

        $user->tipo = $this->user->tipo;

        if(!$user->save()) {
            $this->call(
                400,
                "invalid_data",
                "Erro ao atualizar dados, verifique as informações"
            )->back();
            return false;
        }

        unset($user->data()->senha);
        $response['user'] = $user->data();

        $this->call(
            200,
            "success_updated",
            "Usuário atualizado com sucesso"
        )->back($response);

    }

    //Deleta usuário logado
    public function delete(){
        $request = $this->requestLimit("usersDelete", 5, 60);
        if(!$request){
            return false;
        }

        if($this->user->destroy()) {
            $this->call(
                400,
                'error_deleted',
                'Erro ao tentar excluir usuário, verifique se há consultas agendadas para o mesmo. Dúvidas, entre em contato com o suporte'
            )->back();
            return false;
        }

        $this->call(
            200,
            'success_deleted',
            'Usuário deletado com sucesso.'
        )->back();
        
    }           
    
}