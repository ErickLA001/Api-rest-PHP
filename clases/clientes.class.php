<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class clientes extends conexion {

   //nombre de la tabla
    private $table = "clientes";

    //campos de la tabla requeridos
    private $id_cliente = "";
    private $nombre = "";
    private $ap_pa = "";
    private $ap_ma = "";
    private $email = "";
    private $pasword = "";

    //autentificacion
    private $token = "";
    //"token": "f18950a97dc7ac5887a4542c7413d0b7"

    //Controlador lista de clientes o poor id
    public function listaClientes($pagina = 1){
        $inicio = 0;
        $cantidad = 50;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de Clientes
        $query = "SELECT id_cliente,nombre,ap_pa,ap_ma,email FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Clientes por id 
    public function obtenerClientes($id){
        $query = "SELECT id_cliente,nombre,ap_pa,ap_ma,email FROM " . $this->table . " WHERE id_cliente = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Cliente
    public function postCliente($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
      if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['nombre']) || !isset($datos['ap_pa']) || !isset($datos['ap_ma']) || !isset($datos['email']) || !isset($datos['pasword'])){
                            return $_respuestas->error_400();
                           }else{
                               $this->nombre = $datos['nombre'];
                               $this->ap_pa = $datos['ap_pa'];
                               $this->ap_ma = $datos['ap_ma'];
                               $this->email = $datos['email'];
                               $this->pasword =$datos['pasword'];
                               $resp = $this->insertarCliente();
                               if($resp){
                                  $respuesta = $_respuestas->response;
                                  $respuesta["result"] = array(
                                      "id_cliente" => $resp
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
    private function insertarCliente(){
    $query = "INSERT INTO " . $this->table . " (nombre,ap_pa,ap_ma,email,pasword) values 
    ('" . $this->nombre ."','" . $this->ap_pa . "','" . $this->ap_ma . "','" . $this->email . "','" .$this->pasword . "' )";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Cliente
    public function putCliente($json){
    $_respuestas = new respuestas;
    $datos = json_decode($json,true);
    if(!isset($datos['token'])){
        return $_respuestas->error_401();
      }else{
        $this->token = $datos['token'];
        $arrayToken = $this->buscarToken();
        if($arrayToken){
            if(!isset($datos['id_cliente'])){
                return $_respuestas->error_400();
               }else{
                   $this->id_cliente = $datos['id_cliente'];
                   if(isset($datos['nombre'])) {$this->nombre = $datos['nombre']; }
                   if(isset($datos['ap_pa'])) {$this->ap_pa = $datos['ap_pa'];}
                   if(isset($datos['ap_ma'])) {$this->ap_ma = $datos['ap_ma'];}
                   if(isset($datos['email'])) {$this->email = $datos['email'];}
                   if(isset($datos['pasword'])) {$this->pasword =$datos['pasword'];}
                   $resp = $this->modificarCliente();
                   if($resp){
                     $respuesta = $_respuestas->response;
                     $respuesta["result"] = array(
                         "id_cliente" => $this->id_cliente
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

    //Funcion SQL para Actualizar Cliente
    private function modificarCliente(){
        $query = "UPDATE " . $this->table . " SET nombre = '" . $this->nombre . "' ,ap_pa = '" . $this->ap_pa . "' ,ap_ma = '" . $this->ap_ma .
        "' ,email = '" . $this->email . "' ,pasword = '" . $this->pasword . "' WHERE id_cliente = '" . $this->id_cliente . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
       }

    //Controlador ELiminar Cliente
    public function deleteCliente($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['token'])){
            return $_respuestas->error_401();
          }else{
            $this->token = $datos['token'];
            $arrayToken = $this->buscarToken();
            if($arrayToken){
                if(!isset($datos['id_cliente'])){
                    return $_respuestas->error_400();
                   }else{
                       $this->id_cliente = $datos['id_cliente'];
                       $resp = $this->eliminarCliente();
                       if($resp){
                         $respuesta = $_respuestas->response;
                         $respuesta["result"] = array(
                             "id_cliente" => $this->id_cliente
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

    //Funcion SQL para Eliminar cliente
    private function eliminarCliente(){
        $query = "DELETE FROM " . $this->table . " WHERE id_cliente= '" . $this->id_cliente . "'";
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


