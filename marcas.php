<?php
require_once 'clases/respuestas.php';
require_once 'clases/marcas.class.php';

$_respuestas = new respuestas;
$_marcas = new marcas;

// Ver Todos los Marcas y Marcas por Id
if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaMarcas = $_marcas->listaMarcas($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaMarcas);
        http_response_code(200);
    }else if(isset($_GET["id"])){
        $marcaid = $_GET["id"];
        $datosMarcas = $_marcas->obtenerMarca($marcaid);
        header("Content-Type: application/json");
        echo json_encode($datosMarcas);
        http_response_code(200);
    }

//Agregar Marcas Metodo POST
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    $datosArray = $_marcas->postMarca($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Actualizar Marca Metodo PUT
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_marcas->putMarca($postBody);
    //devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

//Eliminar Marca Metodo DELETE
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    // enviamos datos 
    $datosArray = $_marcas->deleteMarca($postBody);
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