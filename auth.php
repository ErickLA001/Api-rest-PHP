<?php
require_once 'clases/auth.class.php';
require_once 'clases/respuestas.php';

$_auth = new auth;
$_respuestas = new respuestas;


// Login con Token
if($_SERVER['REQUEST_METHOD'] == "POST"){
    //reciibir datos
    $postbody = file_get_contents("php://input");

    //enviamos datos
    $datosArray = $_auth->login($postbody);

    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}


?>