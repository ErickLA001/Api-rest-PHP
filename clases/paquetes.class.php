<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class paquetes extends conexion {

   //nombre de la tabla
    private $table = "paquete";

    //campos de la tabla requeridos
    private $paquete = "";
    

    //autentificacion
    private $token = "";
    //"token": "f18950a97dc7ac5887a4542c7413d0b7"

    //Controlador lista de Paquete o por id
    public function listaPaquetes($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de Paquete
        $query = "SELECT id_paquete,paquete FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Paquete por id 
    public function obtenerPaquete($id){
        $query = "SELECT id_paquete,paquete FROM " . $this->table . " WHERE id_paquete = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Paquete
    public function postPaquete($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
      if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['paquete'])){
                            return $_respuestas->error_400();
                           }else{
                               $this->paquete = $datos['paquete'];
                               $resp = $this->insertarPaquete();
                               if($resp){
                                  $respuesta = $_respuestas->response;
                                  $respuesta["result"] = array(
                                      "id_paquete" => $resp
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


    //Funcion SQL para insertar Paquete 
    private function insertarPaquete(){
    $query = "INSERT INTO " . $this->table . " (paquete) values ('" . $this->paquete ."')";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Paquete
    public function putPaquete($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
    if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['id_paquete'])){
                return $_respuestas->error_400();
               }else{
                   $this->id_paquete = $datos['id_paquete'];
                   if(isset($datos['paquete'])) {$this->paquete = $datos['paquete']; }
                   $resp = $this->modificarPaquete();
                   if($resp){
                     $respuesta = $_respuestas->response;
                     $respuesta["result"] = array(
                         "id_paquete" => $this->id_paquete
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

    //Funcion SQL para Actualizar Paquete
    private function modificarPaquete(){
        $query = "UPDATE " . $this->table . " SET paquete = '" . $this->paquete . "' WHERE id_paquete = '" . $this->id_paquete . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
       }

    //Controlador ELiminar Paquete
    public function deletePaquete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['token'])){
            return $_respuestas->error_401();
          }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['id_paquete'])){
                    return $_respuestas->error_400();
                   }else{
                       $this->id_paquete = $datos['id_paquete'];
                       $resp = $this->eliminarPaquete();
                       if($resp){
                         $respuesta = $_respuestas->response;
                         $respuesta["result"] = array(
                             "id_paquete" => $this->id_paquete
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
    private function eliminarPaquete(){
        $query = "DELETE FROM " . $this->table . " WHERE id_paquete= '" . $this->id_paquete . "'";
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
