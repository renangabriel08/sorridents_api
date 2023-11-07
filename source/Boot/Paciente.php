<?php

namespace Source\Boot;
//use Source\Models\User;
/*
$nomePaciente = "paci";//filter_input(INPUT_GET, 'pesquisa', FILTER_DEFAULT);

if(!empty($nomePaciente)){
    $objUser = new User();
    $result = $objUser->find("nome = :nome", "nome=%{$nomePaciente}%", 'id, nome');
    if($result->rowCount() > 0){
        $retorno = ['status'=>true, 'msg'=>"Paciente encontrado."];
    }
    else{
        $retorno = ['status'=>false, 'msg'=>"Paciente não encontrado."];
    }
}
else{
    $retorno = ['status'=>false, 'msg'=>"Paciente não encontrado."];
}

echo json_encode($retorno);
*/

use Source\Models\User;
use Source\Models\Schedule;
$t = new User();
$objUser = new User();
