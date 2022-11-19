<?php
require_once 'clases/respuestas.php';
require_once 'clases/envios.class.php';

$_respuestas = new respuestas;
$_envios = new envios;

// Ver Todos los Envios y Envios por Id
if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaEnvios = $_envios->listaEnvios($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaEnvios);
        http_response_code(200);
    }else if(isset($_GET["id"])){
        $envioid = $_GET["id"];
        $datosEnvios = $_envios->obtenerEnvio($envioid);
        header("Content-Type: application/json");
        echo json_encode($datosEnvios);
        http_response_code(200);
    }

//Agregar Envios Metodo POST
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    $datosArray = $_envios->postEnvio($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Actualizar Envios Metodo PUT
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_envios->putEnvio($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Eliminar Envio Metodo DELETE
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_envios->deleteEnvio($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Error Metodo no Permitido
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>