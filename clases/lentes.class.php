<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class lentes extends conexion {

   //nombre de la tabla
    private $table = "lentes";

    //campos de la tabla requeridos
    private $id_marca = "";
    private $modelo = "";
    private $id_paquete = "";
    private $cantidad = "";
    private $foto_1 = "";
    private $foto_2 = "";
    private $foto_3 = "";
    private $precio = "";

    //autentificacion
    private $token = "";
    //"token": "f18950a97dc7ac5887a4542c7413d0b7"

    //Controlador lista de Lentes o por id
    public function listaLentes($pagina = 1){
        $inicio = 0;
        $cantidad = 25;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de Lentes
        $query = "SELECT id_lentes,id_marca,modelo,id_paquete,cantidad,foto_1,foto_2,foto_3,precio FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Lentes por id 
    public function obtenerLentes($id){
        $query = "SELECT id_lentes,id_marca,modelo,id_paquete,cantidad,foto_1,foto_2,foto_3,precio FROM " . $this->table . " WHERE id_lentes = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Lentes
    public function postLentes($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
      if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['id_marca']) || !isset($datos['modelo']) || !isset($datos['id_paquete']) || !isset($datos['cantidad'])|| !isset($datos['precio'])){
                            return $_respuestas->error_400();
                           }else{
                               $this->id_marca = $datos['id_marca'];
                               $this->modelo = $datos['modelo'];
                               $this->id_paquete = $datos['id_paquete'];
                               $this->cantidad = $datos['cantidad'];
                               $this->precio = $datos['precio'];
                               if(isset($datos['foto_1'])) {$this->foto_1 = $datos['foto_1']; }
                               if(isset($datos['foto_2'])) {$this->foto_2 = $datos['foto_2']; }
                               if(isset($datos['foto_3'])) {$this->foto_3 = $datos['foto_3']; }
                               $resp = $this->insertarLentes();
                               if($resp){
                                  $respuesta = $_respuestas->response;
                                  $respuesta["result"] = array(
                                      "id_lentes" => $resp
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


    //Funcion SQL para insertar Lentes 
    private function insertarLentes(){
    $query = "INSERT INTO " . $this->table . " (id_marca,modelo,id_paquete,cantidad,foto_1,foto_2,foto_3,precio) values
     ('" . $this->id_marca ."','" . $this->modelo ."','" . $this->id_paquete ."','" . $this->cantidad ."','" . $this->foto_1 ."','" . $this->foto_2 ."','" . $this->foto_3 ."','" . $this->precio ."' )";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Lentes
    public function putLentes($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
    if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['id_lentes'])){
                return $_respuestas->error_400();
               }else{
                   $this->id_lentes = $datos['id_lentes'];
                   if(isset($datos['id_marca'])) {$this->id_marca = $datos['id_marca']; }
                   if(isset($datos['modelo'])) {$this->modelo = $datos['modelo']; }
                   if(isset($datos['id_paquete'])) {$this->id_paquete = $datos['id_paquete']; }
                   if(isset($datos['cantidad'])) {$this->cantidad = $datos['cantidad']; }
                   if(isset($datos['foto_1'])) {$this->foto_1 = $datos['foto_1']; }
                   if(isset($datos['foto_2'])) {$this->foto_2 = $datos['foto_2']; }
                   if(isset($datos['foto_3'])) {$this->foto_3 = $datos['foto_3']; }
                   if(isset($datos['precio'])) {$this->precio = $datos['precio']; }
                   $resp = $this->modificarLentes();
                   if($resp){
                     $respuesta = $_respuestas->response;
                     $respuesta["result"] = array(
                         "id_lentes" => $this->id_lentes
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

    //Funcion SQL para Actualizar Lentes
    private function modificarLentes(){
        $query = "UPDATE " . $this->table . " SET id_marca = '" . $this->id_marca . "' ,modelo = '" . $this->modelo . "' ,id_paquete = '" . $this->id_paquete . "' ,cantidad = '" . $this->cantidad . "' 
        ,foto_1 = '" . $this->foto_1 . "' ,foto_2 = '" . $this->foto_2 . "' ,foto_3 = '" . $this->foto_3 . "' ,precio = '" . $this->precio . "' WHERE id_lentes = '" . $this->id_lentes . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
       }

    //Controlador ELiminar Lentes
    public function deleteLentes($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['token'])){
            return $_respuestas->error_401();
          }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['id_lentes'])){
                    return $_respuestas->error_400();
                   }else{
                       $this->id_lentes = $datos['id_lentes'];
                       $resp = $this->eliminarLentes();
                       if($resp){
                         $respuesta = $_respuestas->response;
                         $respuesta["result"] = array(
                             "id_lentes" => $this->id_lentes
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

    //Funcion SQL para Eliminar Lentes
    private function eliminarLentes(){
        $query = "DELETE FROM " . $this->table . " WHERE id_lentes= '" . $this->id_lentes . "'";
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
