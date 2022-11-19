<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class usuarios extends conexion {

    //Nombre de la tabla
    private $table = "usuarios";

    //Campos de la tabla requeridos
    private $id_usuario = "";
    private $nombre = "";
    private $email = "";
    private $pasword = "";

    //Listar Usuarios Administradores
    public function listaUsuarios($pagina = 1){
        $inicio = 0;
        $cantidad = 5;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

        $query = "SELECT id_usuario,nombre,email FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Agregar Usuario Administrador
    public function postUsuarios($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);

        if(!isset($datos['nombre']) || !isset($datos['email']) || !isset($datos['pasword'])){
            return $_respuestas->error_400();
           }else{
               $this->nombre = $datos['nombre'];
               $this->email = $datos['email'];
               $this->pasword =$datos['pasword'];
               $resp = $this->insertarUsuario();
               if($resp){
                  $respuesta = $_respuestas->response;
                  $respuesta["result"] = array(
                      "id_usuario" => $resp
                  );
                  return $respuesta;
               }else{
                  return $_respuestas->error_500();
                    }
           }  
    }
  
    //Funcion SQL para Instertar Usuario Administrador
    private function insertarUsuario(){
      $query = "INSERT INTO " . $this->table . " (nombre,email,pasword) values 
      ('" . $this->nombre ."','" . $this->email . "','" .$this->pasword . "' )";
      $resp = parent::nonQueryId($query);
      if($resp){
          return $resp;
      }else{
          return 0;
      }
     }

    //Eliminar Usuario Administrador
    public function deleteUsuario($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
    
        if(!isset($datos['id_usuario'])){
        return $_respuestas->error_400();
       }else{
           $this->id_usuario = $datos['id_usuario'];
           $resp = $this->eliminarUsuario();
           if($resp){
             $respuesta = $_respuestas->response;
             $respuesta["result"] = array(
                 "id_usuario" => $this->id_usuario 
             );
                return $respuesta;
            }else{
              return $_respuestas->error_500();
               }
           }
      }

    //Funcion SQL para Eliminar usuario  
    private function eliminarUsuario(){
    $query = "DELETE FROM " . $this->table . " WHERE id_usuario= '" . $this->id_usuario . "'";
    $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0 ;
            }
        }
}

?>
