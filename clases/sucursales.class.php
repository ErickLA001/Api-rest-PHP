<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class sucursales extends conexion {

   //nombre de la tabla
    private $table = "sucursal";

    //campos de la tabla requeridos
    private $id_sucursal = "";
    private $id_estado = "";
    private $municipio = "";
    private $direccion = "";

    //autentificacion
    private $token = "";
    //"token": "f18950a97dc7ac5887a4542c7413d0b7"

    //Controlador lista de Sucursal o poor id
    public function listaSucursales($pagina = 1){
        $inicio = 0;
        $cantidad = 5;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de Sucursal
        $query = "SELECT id_sucursal,municipio,direccion,id_estado FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Sucursal por id 
    public function obtenerSucursal($id){
        $query = "SELECT id_sucursal,municipio,direccion,id_estado FROM " . $this->table . " WHERE id_sucursal = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Sucursal
    public function postSucursal($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
      if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['municipio']) || !isset($datos['direccion']) || !isset($datos['id_estado'])){
                            return $_respuestas->error_400();
                           }else{
                               $this->municipio = $datos['municipio'];
                               $this->direccion = $datos['direccion'];
                               $this->id_estado = $datos['id_estado'];
                               $resp = $this->insertarSucursal();
                               if($resp){
                                  $respuesta = $_respuestas->response;
                                  $respuesta["result"] = array(
                                      "id_estado" => $resp
                                  );
                                  return $respuesta;
                               }else{
                                  return $_respuestas->error_500();
                                }
                           }
        }else{
            return $_respuestas->error_401("Token invalido o ah caduco");
        }
      }
  }


    //Funcion SQL para insertar Sucursal  
    private function insertarSucursal(){
    $query = "INSERT INTO " . $this->table . " (municipio,direccion,id_estado) values ('" . $this->municipio ."','" . $this->direccion ."','" . $this->id_estado ."' )";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Sucursal
    public function putSucursal($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
    if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['id_sucursal'])){
                return $_respuestas->error_400();
               }else{
                   $this->id_sucursal = $datos['id_sucursal'];
                   if(isset($datos['municipio'])) {$this->municipio = $datos['municipio']; }
                   if(isset($datos['direccion'])) {$this->direccion = $datos['direccion']; }
                   if(isset($datos['id_estado'])) {$this->id_estado = $datos['id_estado']; }
                   $resp = $this->modificarSucrusal();
                   if($resp){
                     $respuesta = $_respuestas->response;
                     $respuesta["result"] = array(
                         "id_sucrsal" => $this->id_sucursal
                     );
                        return $respuesta;
                    }else{
                      return $_respuestas->error_500();
                       }
                   }
        }else{
            return $_respuestas->error_401("Token invalido o ah caduco");
        }

      }
    }

    //Funcion SQL para Actualizar Sucursal
    private function modificarSucrusal(){
        $query = "UPDATE " . $this->table . " SET municipio = '" . $this->municipio . "' ,direccion = '" . $this->direccion . "' ,id_estado = '" . $this->id_estado . "' WHERE id_sucursal = '" . $this->id_sucursal . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
       }

    //Controlador ELiminar Sucursal
    public function deleteSucursal($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['token'])){
            return $_respuestas->error_401();
          }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['id_sucursal'])){
                    return $_respuestas->error_400();
                   }else{
                       $this->id_sucursal = $datos['id_sucursal'];
                       $resp = $this->eliminarSucursal();
                       if($resp){
                         $respuesta = $_respuestas->response;
                         $respuesta["result"] = array(
                             "id_sucursal" => $this->id_sucursal
                         );
                            return $respuesta;
                        }else{
                          return $_respuestas->error_500();
                           }
                       }
            }else{
                return $_respuestas->error_401("Token invalido o ah caduco");
            }
          }
    }

    //Funcion SQL para Eliminar Estado
    private function eliminarSucursal(){
        $query = "DELETE FROM " . $this->table . " WHERE id_sucursal= '" . $this->id_sucursal . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0 ;
        }
    }

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
}


?>
