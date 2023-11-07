<?php

namespace Source\Models;
use Source\Core\Session;

class Login extends User
{
    private $session;
    public function __construct()
    {
        parent::__construct("user",["id"],["email","password"]);
        $this->session = new Session();
    }
    
    public static function user(){
        $session = new Session();
        if(!$session->has('idUser')){
            return null;
        }

        return (new User())->findById($session->get("idUser"));
    }

    public static function logout(){
        $session = new Session();
        $session->unset("idUser");
        
    }
    
    // public function logar(string $email, string $pass){
       
    //     $user = new User();
    //     $result = $user->find("email = :email", "email=".$email)->fetch();
       
    //    if(!$result){
    //     $message = "Usuário não existe";
    //     return $message;
    //    }
       
    //    if(!password_verify($pass, $result->senha)){
    //     $message = "Senha incorreta";
    //     return $message;
    //    }
    //    $message = [
    //     'type'=> 'sucess',
    //     'message'=> 'Login efetuado com sucesso.'
    //    ];

    //    $this->session->set("message", $message);
    //    $this->session->set("idUser", $result->id);
    //    $message = "ok";
    //    return $message;

    // }

    public function logar(string $email, string $password, bool $save = false) : ?User
    {
        if(!is_email($email)){
            $message = [
                'type'=> 'warning',
                'message'=> 'O E-mail informado é invalido.'
            ];
            $this->session->set("message", $message);
            return false;
        }

        if($save){
            setcookie("Email", $email, time() + 604800, "/");
        }
        else{
            setcookie("Email", null, time() - 3600, "/");
        }

        if(!is_passwd($password)){
            $message = [
                'type'=> 'warning',
                'message'=> 'O formato da senha informada é invalido.'
            ];
            $this->session->set("message", $message);
            return false;
        }

        $user = new User();
        $result = $user->find("email = :email", "email=".$email)->fetch();

        if(!$result){
            $message = [
                'type'=> 'warning',
                'message'=> 'O E-mail não está cadastrado.'
            ];
            $this->session->set("message", $message);
            return false;
        }

        if(!password_verify($password, $result->senha)){
            $message = [
                'type'=> 'warning',
                'message'=> 'A senha informada incorreta.'
            ];
            return false;
        }

        //Se passou por todas as validações acima, Login efetivo
        $message = [
            'type'=> 'sucess',
            'message'=> 'Login efetuado com sucesso.'
        ];
        $this->session->set("message", $message);
        $this->session->set("idUser", $result->id);

        //$this->session->set("tipoUser", $user->tipo);
        //$this->session->set("nomeUser", $user->nome);
        return $result;
    }

}
