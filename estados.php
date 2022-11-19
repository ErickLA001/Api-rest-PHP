<?php
require_once 'clases/respuestas.php';
require_once 'clases/estados.class.php';

$_respuestas = new respuestas;
$_estados = new estados;

// Ver Todos los Estados y Estados por Id
if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaEstados = $_estados->listaEstados($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaEstados);
        http_response_code(200);
    }else if(isset($_GET["id"])){
        $estadoid = $_GET["id"];
        $datosEstados = $_estados->obtenerEstados($estadoid);
        header("Content-Type: application/json");
        echo json_encode($datosEstados);
        http_response_code(200);
    }

//Agregar Estados Metodo POST
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    $datosArray = $_estados->postEstado($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Actualizar Estados Metodo PUT
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_estados->putEstado($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Eliminar Estado Metodo DELETE
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_estados->deleteEstado($postBody);
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