<?php

require_once 'conexion/conexion.php';
require_once 'respuestas.php';

class compras extends conexion {

   //nombre de la tabla
    private $table = "compra";

    //campos de la tabla requeridos
    private $id_compra = "";
    private $id_cliente = "";
    private $id_lente = "";
    private $id_tratamiento = "";
    private $graducion = "";
    private $ti_gradu = "";
    private $precio_fi = "";

    //autentificacion
    private $token = "";
    //"token": "f18950a97dc7ac5887a4542c7413d0b7"

    //Controlador lista de compras o poor id
    public function listaCompras($pagina = 1){
        $inicio = 0;
        $cantidad = 50;
        if($pagina > 1){
            $inicio = ($cantidad * ($pagina -1 )) +1 ;
            $cantidad = $cantidad * $pagina;
        }

    //Consula SQL de Compra
        $query = "SELECT id_compra,id_cliente,id_lente,id_tratamiento,graducion,ti_gradu,precio_fi FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return($datos);
     }

    //Consulta SQL de Compra por id 
    public function obtenerCompra($id){
        $query = "SELECT id_compra,id_cliente,id_lente,id_tratamiento,graducion,ti_gradu,precio_fi FROM " . $this->table . " WHERE id_compra = '$id'";
         $datos= parent::obtenerDatos($query);
         return($datos);
     }

    //Controlador Agregar Compra
    public function postCompra($json){
      $_respuestas = new respuestas;
      $datos = json_decode($json,true);
      if(!isset($datos['id_cliente']) || !isset($datos['id_lente']) || !isset($datos['id_tratamiento']) || !isset($datos['graducion']) || !isset($datos['ti_gradu']) || !isset($datos['precio_fi'])){
        return $_respuestas->error_400();
       }else{
           $this->id_cliente = $datos['id_cliente'];
           $this->id_lente = $datos['id_lente'];
           $this->id_tratamiento = $datos['id_tratamiento'];
           $this->graducion = $datos['graducion'];
           $this->ti_gradu =$datos['ti_gradu'];
           $this->precio_fi =$datos['precio_fi'];
           $resp = $this->insertarCompra();
           if($resp){
              $respuesta = $_respuestas->response;
              $respuesta["result"] = array(
                  "id_compra" => $resp
              );
              return $respuesta;
           }else{
              return $_respuestas->error_500();
            }
       }
  }


    //Funcion SQL para insertar Compra  
    private function insertarCompra(){
    $query = "INSERT INTO " . $this->table . " (id_cliente,id_lente,id_tratamiento,graducion,ti_gradu,precio_fi) values 
    ('" . $this->id_cliente ."','" . $this->id_lente . "','" . $this->id_tratamiento . "','" . $this->graducion . "','" .$this->ti_gradu . "','" . $this->precio_fi . "' )";
    $resp = parent::nonQueryId($query);
    if($resp){
        return $resp;
    }else{
        return 0;
    }
   }

    //Controlador Actualizar Compra
    public function putCompra($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['id_compra'])){
            return $_respuestas->error_400();
        }else{
            $this->id_compra = $datos['id_compra'];
            if(isset($datos['id_cliente'])) { $this->id_cliente = $datos['id_cliente']; }
            if(isset($datos['id_lente'])) { $this->id_lente = $datos['id_lente']; }
            if(isset($datos['id_tratamiento'])) { $this->id_tratamiento = $datos['id_tratamiento']; }
            if(isset($datos['graducion'])) { $this->graducion = $datos['graducion']; }
            if(isset($datos['ti_gradu'])) { $this->ti_gradu = $datos['ti_gradu']; }
            if(isset($datos['precio_fi'])) { $this->precio_fi = $datos['precio_fi']; }
            

            $resp = $this->modificarCompra();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "id_compra" => $this->id_compra
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
}

    //Funcion SQL para Actualizar Compra
    private function modificarCompra(){
        $query = "UPDATE " . $this->table . " SET id_cliente ='" . $this->id_cliente . "',id_lente = '" . $this->id_lente . "', id_tratamiento = '" . $this->id_tratamiento . "', graducion = '" .
        $this->graducion . "', ti_gradu = '" . $this->ti_gradu . "', precio_fi = '" . $this->precio_fi . "' WHERE id_compra = '" . $this->id_compra . "'"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1){
             return $resp;
        }else{
            return 0;
        }
    }

    //Controlador ELiminar Compra
    public function deleteCompra($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['id_compra'])){
            return $_respuestas->error_400();
           }else{
               $this->id_compra = $datos['id_compra'];
               $resp = $this->eliminarCompra();
               if($resp){
                 $respuesta = $_respuestas->response;
                 $respuesta["result"] = array(
                     "id_compra" => $this->id_compra
                 );
                    return $respuesta;
                }else{
                  return $_respuestas->error_500();
                   }
        }
    }

    //Funcion SQL para Eliminar Compra
    private function eliminarCompra(){
        $query = "DELETE FROM " . $this->table . " WHERE id_compra= '" . $this->id_compra . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ){
            return $resp;
        }else{
            return 0 ;
        }
    }


 /* Funciones de Seguridad
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
