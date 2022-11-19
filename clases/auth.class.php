<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.php';


class auth extends conexion{

    // Controlador del Login
    public function login($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['email']) || !isset($datos{'password'})){
            //Error de campos
            return $_respuestas->error_400();
        }else{
            $email = $datos['email'];
            $password = $datos['password'];
            //$password = parent::encriptar($password); "para pasword en md5
            $datos = $this->obtenerDatosCliente($email);
            if($datos){
                //Vereficacion de la contraseña
                if($password == $datos[0]['pasword']){
                        //Creacion del token
                        $verificar  = $this->insertarToken($datos[0]['id_usuario']);
                        if($verificar){
                                $result = $_respuestas->response;
                                $result["result"] = array(
                                    "token" => $verificar
                                );
                                return $result;
                        }else{
                                //Error al guardar
                                return $_respuestas->error_500("Error interno, No hemos podido guardar");
                            }    
                }else{
                    return $_respuestas->error_200("Password invalido");
                }
            }else{
                //Error Si no existe un Usuario Administrador
                return $_respuestas->error_404();
            }
        }
    }

    //Funcion SQL Para obtener datos
    private function obtenerDatosCliente($email){
    $query = "SELECT id_usuario,nombre,email,pasword FROM usuarios WHERE email = '$email'";
    $datos = parent::obtenerDatos($query);
    if(isset($datos[0]["id_usuario"])){
        return $datos;
    }else{
        return 0;
        }
    }

    //Funcion para Insertar token
    private function insertarToken($id_usuario){
    $val = true;
    $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
    $date =  date("Y-m-d H:i");
    $estado = "Activo";
    $query = "INSERT INTO usuario_token (id_usuario,token,estado,fecha) VALUES ('$id_usuario','$token','$estado','$date')";
    $verificar = parent::nonQuery($query);
    if($verificar){
        return $token;
    }else{
        return false;
    }
    }
}

?>