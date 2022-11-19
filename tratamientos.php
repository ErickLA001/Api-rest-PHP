<?php
require_once 'clases/respuestas.php';
require_once 'clases/tratamientos.class.php';

$_respuestas = new respuestas;
$_tratamientos = new tratamientos;

// Ver Todos los Tratamientos y Tratamientos por Id
if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaTratamientos = $_tratamientos->listaTratamientos($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaTratamientos);
        http_response_code(200);
    }else if(isset($_GET["id"])){
        $tratamientolid = $_GET["id"];
        $datosTratamientos = $_tratamientos->obtenerTratamiento($tratamientolid);
        header("Content-Type: application/json");
        echo json_encode($datosTratamientos);
        http_response_code(200);
    }

//Agregar Tratamientos Metodo POST
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    $datosArray = $_tratamientos->postTratamiento($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Actualizar Tratamientos Metodo PUT
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_tratamientos->putTratamiento($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Eliminar Tratamientos Metodo DELETE
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_tratamientos->deleteTratamiento($postBody);
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