<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class tratamientos extends conexion {

   //nombre de la tabla
    private $table = "tratamiento";

    //campos de la tabla requeridos
    private $tratamiento = "";
    private $descripcion = "";
    private $precio = "";

    //autentificacion
    private $token = "";
    //"token": "f18950a97dc7ac5887a4542c7413d0b7"

    //Controlador lista de Tratamiento o por id
    public function listaTratamientos($pagina = 1){
        $inicio = 0;
        $cantidad = 10;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de tratemiento
        $query = "SELECT id_tratamiento,tratamiento,descripcion,precio FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Tratamiento por id 
    public function obtenerTratamiento($id){
        $query = "SELECT id_tratamiento,tratamiento,descripcion,precio FROM " . $this->table . " WHERE id_tratamiento = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Tratamiento
    public function postTratamiento($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
      if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['tratamiento']) || !isset($datos['descripcion']) || !isset($datos['precio'])){
                            return $_respuestas->error_400();
                           }else{
                               $this->tratamiento = $datos['tratamiento'];
                               $this->descripcion = $datos['descripcion'];
                               $this->precio = $datos['precio'];
                               $resp = $this->insertarTratamiento();
                               if($resp){
                                  $respuesta = $_respuestas->response;
                                  $respuesta["result"] = array(
                                      "id_tratamiento" => $resp
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


    //Funcion SQL para insertar Tratamiento 
    private function insertarTratamiento(){
    $query = "INSERT INTO " . $this->table . " (tratamiento,descripcion,precio) values ('" . $this->tratamiento ."','" . $this->descripcion ."','" . $this->precio ."' )";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Trtamiento
    public function putTratamiento($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
    if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['id_tratamiento'])){
                return $_respuestas->error_400();
               }else{
                   $this->id_tratamiento = $datos['id_tratamiento'];
                   if(isset($datos['tratamiento'])) {$this->tratamiento = $datos['tratamiento']; }
                   if(isset($datos['descripcion'])) {$this->descripcion = $datos['descripcion']; }
                   if(isset($datos['precio'])) {$this->precio = $datos['precio']; }
                   $resp = $this->modificarTratamiento();
                   if($resp){
                     $respuesta = $_respuestas->response;
                     $respuesta["result"] = array(
                         "id_tratamiento" => $this->id_tratamiento
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

    //Funcion SQL para Actualizar Ttratameitno
    private function modificarTratamiento(){
        $query = "UPDATE " . $this->table . " SET tratamiento = '" . $this->tratamiento . "' ,descripcion = '" . $this->descripcion . "' ,precio = '" . $this->precio . "' WHERE id_tratamiento = '" . $this->id_tratamiento . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
       }

    //Controlador ELiminar Tratamiento
    public function deleteTratamiento($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['token'])){
            return $_respuestas->error_401();
          }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['id_tratamiento'])){
                    return $_respuestas->error_400();
                   }else{
                       $this->id_tratamiento = $datos['id_tratamiento'];
                       $resp = $this->eliminarTratamiento();
                       if($resp){
                         $respuesta = $_respuestas->response;
                         $respuesta["result"] = array(
                             "id_tratamiento" => $this->id_tratamiento
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

    //Funcion SQL para Eliminar Tratamiento
    private function eliminarTratamiento(){
        $query = "DELETE FROM " . $this->table . " WHERE id_tratamiento= '" . $this->id_tratamiento . "'";
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
