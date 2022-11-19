<?php

require_once 'clases/respuestas.php';
require_once 'clases/usuarios.class.php';

$_respuestas = new respuestas;
$_usuarios = new usuarios;


// Ver Todos los Usuarios
if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaUsuarios = $_usuarios->listaUsuarios($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaUsuarios);
        http_response_code(200);
    }

//Agregar Usuario Metodo POST
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    $datosArray = $_usuarios->postUsuarios($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

// Eliminar Usuario Metodo DELETE
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_usuarios->deleteUsuario($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}



?>