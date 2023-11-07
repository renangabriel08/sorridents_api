<?php

namespace Source\Controllers\Api;

use Source\Core\Controller; 
use Source\Models\Login;
use Source\Models\Schedule;

class Api extends Controller {
    protected $user; 
    protected $headers;
    protected $response;

    public function __construct() {
        parent::__construct("/"); 
        header('Content-Type: application/json; charset=UTF-8'); 
        
        $this->headers = getallheaders();
        $request = $this->requestLimit ("Api", 1, 1);

        if(!$request) { 
            exit;
        } 

        $login = $this->login();
        if(!$login) {
            exit;
        }
        
        (new Schedule())->find("paciente = :user", "user={$this->user->id}")->count();
    }

    protected function call(int $code, string $type = null, string $message = null, string $rule = "response"): Api {

        http_response_code($code);
        
        if (!empty($type)) {
            $this->response = [
                $rule => [
                    "type" => $type,
                    "message" => (!empty($message) ? $message : null)
                ]
            ];
        }
        
        return $this;
    }

    protected function back(array $response = null):Api {
        
        if (!empty($response)) {
            $this->response = (!empty($this->response) ? array_merge($this->response, $response) : $response);
        }
        
        echo json_encode($this->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $this;

    }
    
    private function login(): bool {

        $request = $this->requestLimit("ApiLogin", 3, 68, true);

        if(!$request){
            return false;
        }
        
        if(empty($this->headers["email"]) || empty($this->headers["senha"])){
            $this->call( 
                400,
                "auth_empty",
                "Favor informe o e-mail e senha"
            )->back();
            return false;
        }

        $objLogin = new Login();
        $result = $objLogin->logar($this->headers['email'],$this->headers['senha']);

        if(!$result) {
            $this->requestLimit("ApiLogin", 3, 60);
            $this->call( 
                401,
                "invalid_auth",
                "Verifique os dados. Usuário ou senha inválido."
            )->back();
            return false;
        }

        $this->user = $result; 
        return true;
    }
    
    protected function requestLimit(string $endpoint, int $limit, int $seconds, bool $attempt = false) :bool {

        $userToken = (!empty($this->headers["email"]) ? base64_encode($this->headers["email"]) : null);
             
        if(!$userToken) {
            $this->call( 
                code: 400,
                type: "invalid_data", 
                message: "Você precisa informar e-mail e senha para continuar" 
            )->back();
            return false;
        }

        $cacheDir = __DIR__ . "/../../". CONF_UPLOAD_DIR. "/requests";

        if (!file_exists($cacheDir) || !is_dir($cacheDir)) { 
            mkdir($cacheDir, 0755);
        }
         
        $cacheFile = $cacheDir . "/" . $userToken . ".json";

        if (!file_exists($cacheFile) || !is_file($cacheFile)) { 
            fopen($cacheFile, "w");
        }
        
        $userCache = json_decode(file_get_contents($cacheFile)); $cache = (array) $userCache; 
            
            
        $save = function ($cacheFile, $cache) {
            $saveCache = fopen($cacheFile, "w"); fwrite($saveCache, json_encode($cache, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            fclose($saveCache);
        };
            
            
        if (empty($cache[$endpoint]) || $cache[$endpoint]->time <= time()) {
            if (!$attempt) {
                $cache[$endpoint] = [ 
                    "limit" => $limit,
                    "requests" => 1, 
                    "time" => time() + $seconds,
                ];
                $save($cacheFile, $cache);
            }
            return true;
        }
            
            
        if ($cache[$endpoint]->requests >= $limit) {
            $this->call( 
                code: 400,
                type: "request_limit",
                message: "Você atingiu o limite de requisições para essa ação"
            )->back(); 
            return false;
        }
        
        if (!$attempt) {
            $cache[$endpoint] = [ 
                "limit" => $limit,
                "requests" => $cache[$endpoint]->requests + 1,
                "time" => $cache[$endpoint]->time
            ];
            $save($cacheFile, $cache);
        }
        return true;
    }

}