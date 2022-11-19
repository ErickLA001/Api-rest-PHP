<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class estados extends conexion {

   //nombre de la tabla
    private $table = "estados";

    //campos de la tabla requeridos
    private $id_estado = "";
    private $estado = "";

    //autentificacion
    private $token = "";
    //"token": "f18950a97dc7ac5887a4542c7413d0b7"

    //Controlador lista de Estado o poor id
    public function listaEstados($pagina = 1){
        $inicio = 0;
        $cantidad = 5;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de Estados
        $query = "SELECT id_estado,estado FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Estados por id 
    public function obtenerEstados($id){
        $query = "SELECT id_estado,estado FROM " . $this->table . " WHERE id_estado = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Estados
    public function postEstado($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
      if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['estado'])){
                            return $_respuestas->error_400();
                           }else{
                               $this->estado = $datos['estado'];
                               $resp = $this->insertarEstado();
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


    //Funcion SQL para insertar Cliente  
    private function insertarEstado(){
    $query = "INSERT INTO " . $this->table . " (estado) values ('" . $this->estado ."' )";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Estado
    public function putEstado($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
    if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['id_estado'])){
                return $_respuestas->error_400();
               }else{
                   $this->id_estado = $datos['id_estado'];
                   if(isset($datos['estado'])) {$this->estado = $datos['estado']; }
                   $resp = $this->modificarEstado();
                   if($resp){
                     $respuesta = $_respuestas->response;
                     $respuesta["result"] = array(
                         "id_estado" => $this->id_estado
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

    //Funcion SQL para Actualizar Estado
    private function modificarEstado(){
        $query = "UPDATE " . $this->table . " SET estado = '" . $this->estado . "' WHERE id_estado = '" . $this->id_estado . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
       }

    //Controlador ELiminar Estado
    public function deleteEstado($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['token'])){
            return $_respuestas->error_401();
          }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['id_estado'])){
                    return $_respuestas->error_400();
                   }else{
                       $this->id_estado = $datos['id_estado'];
                       $resp = $this->eliminarEstado();
                       if($resp){
                         $respuesta = $_respuestas->response;
                         $respuesta["result"] = array(
                             "id_estado" => $this->id_estado
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
    private function eliminarEstado(){
        $query = "DELETE FROM " . $this->table . " WHERE id_estado= '" . $this->id_estado . "'";
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
