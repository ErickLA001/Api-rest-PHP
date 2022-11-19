<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class envios extends conexion {

   //nombre de la tabla
    private $table = "envio";

    //campos de la tabla requeridos
    private $id_sucursal = "";
    private $id_compra = "";

    
/*
    //autentificacion
    private $token = "";
*/

    //Controlador lista de Paquete o por id
    public function listaEnvios($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de Envio
        $query = "SELECT id_envio,id_sucursal,id_compra FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Envio por id 
    public function obtenerEnvio($id){
        $query = "SELECT id_envio,id_sucursal,id_compra FROM " . $this->table . " WHERE id_envio = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Envio
    public function postEnvio($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
            if(!isset($datos['id_sucursal']) || !isset($datos['id_compra'])){
                            return $_respuestas->error_400();
                           }else{
                               $this->id_sucursal = $datos['id_sucursal'];
                               $this->id_compra = $datos['id_compra'];
                               $resp = $this->insertarEnvio();
                               if($resp){
                                  $respuesta = $_respuestas->response;
                                  $respuesta["result"] = array(
                                      "id_envio" => $resp
                                  );
                                  return $respuesta;
                               }else{
                                  return $_respuestas->error_500();
                                }
                           }
                        }


    //Funcion SQL para insertar Envio 
    private function insertarEnvio(){
    $query = "INSERT INTO " . $this->table . " (id_sucursal,id_compra) values ('" . $this->id_sucursal ."','" . $this->id_compra ."')";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Envio
    public function putEnvio($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
            if(!isset($datos['id_envio'])){
                return $_respuestas->error_400();
               }else{
                   $this->id_envio = $datos['id_envio'];
                   if(isset($datos['id_sucursal'])) {$this->id_sucursal = $datos['id_sucursal']; }
                   if(isset($datos['id_compra'])) {$this->id_compra = $datos['id_compra']; }
                   $resp = $this->modificarEnvio();
                   if($resp){
                     $respuesta = $_respuestas->response;
                     $respuesta["result"] = array(
                         "id_envio" => $this->id_envio
                     );
                        return $respuesta;
                    }else{
                      return $_respuestas->error_500();
                       }
                   }
    }

    //Funcion SQL para Actualizar Envio
    private function modificarEnvio(){
        $query = "UPDATE " . $this->table . " SET id_sucursal = '" . $this->id_sucursal . "', id_compra = '" . $this->id_compra . "' WHERE id_envio = '" . $this->id_envio . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
       }

    //Controlador ELiminar Envio
    public function deleteEnvio($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        
                if(!isset($datos['id_envio'])){
                    return $_respuestas->error_400();
                   }else{
                       $this->id_envio = $datos['id_envio'];
                       $resp = $this->eliminarEnvio();
                       if($resp){
                         $respuesta = $_respuestas->response;
                         $respuesta["result"] = array(
                             "id_envio" => $this->id_envio
                         );
                            return $respuesta;
                        }else{
                          return $_respuestas->error_500();
                           }
                       }
    }

    //Funcion SQL para Eliminar Envio
    private function eliminarEnvio(){
        $query = "DELETE FROM " . $this->table . " WHERE id_envio= '" . $this->id_envio . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0 ;
        }
    }
/*
    //Funcion SQL buscar Token
    private function buscarToken(){
        $query = "SELECT  id_token,id_usuario,estado from usuario_token WHERE token = '" . $this->token . "' AND Estado = 'Activo'";
        $resp = parent::obtenerDatos($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }

    //Funcion SQL Actualizar Token
    private function actualizarToken($id_token){
        $date = date("Y-m-d H:i");
        $query = "UPDATE usuario_token SET fecha = '$date' WHERE id_token = '$id_token' ";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

*/

}


?>
