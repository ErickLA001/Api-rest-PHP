<?php
require_once 'clases/respuestas.php';
require_once 'clases/sucursales.class.php';

$_respuestas = new respuestas;
$_sucursales = new sucursales;

// Ver Todos los Sucursales y Sucursales por Id
if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaSucursales = $_sucursales->listaSucursales($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaSucursales);
        http_response_code(200);
    }else if(isset($_GET["id"])){
        $sucursalid = $_GET["id"];
        $datosSucursales = $_sucursales->obtenerSucursal($sucursalid);
        header("Content-Type: application/json");
        echo json_encode($datosSucursales);
        http_response_code(200);
    }

//Agregar Sucursales Metodo POST
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    $datosArray = $_sucursales->postSucursal($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Actualizar Sucursales Metodo PUT
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_sucursales->putSucursal($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Eliminar Sucursal Metodo DELETE
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_sucursales->deleteSucursal($postBody);
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