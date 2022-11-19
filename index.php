<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Opticos Letco</title>
    <link rel="stylesheet" href="estilo.css" type="text/css">
</head>
<body>
<div  class="container">
    <h1>Api Opticos Letco</h1>
    <h2>End Pints - Usuarios de Administracion  </h2>
    <div class="divbody">
    <h3>Usuarios de Administracion </h3>
        <code>
        GET  - /Api-Letco/usuarios?page=1 (Cada numero de pagina muestra 5 usuarios)
        </code>
        <code>
        POST - /Api-Letco/usuarios
           <br><br>
           {
               <br>  
               "nombre" : "", -> REQUERIDO 
               <br>
               "usuario" :"",  -> REQUERIDO
               <br>
               "password": "" -> REQUERIDO
               <br>
            }
        
        </code>
        <code>
        DELETE - /Api-Letco/usuarios
           <br><br>
           {
               <br>  
               "id_usuario" : "", -> REQUERIDO 
               <br>
            }
        
        </code>
        <h3>Login con Token</h3>
        <code>
        POST - /Api-Letco/usuarios
           <br><br>
           {
                <br>  
               "nombre" : "", -> REQUERIDO 
               <br>
               "usuario" :"",  -> REQUERIDO
               <br>
            }
        
        </code>
    </div>
    <h2>End Pints - Compras</h2>      
    <div class="divbody">   
        <h3>Compras</h3>
        <code>
           GET  /Api-Letco/compras?page=1 (El numero de pagina muestra 50 compras por pagina)
           <br>
           GET  /Api-Letco/compras?id=2
        </code>
        <code>
           POST  /Api-Letco/compras
           <br><br> 
           {
            <br> 
               "id_cliente" : "",               -> REQUERIDO
               <br> 
               "id_lente" : "",                  -> REQUERIDO
               <br> 
               "id_tratamiento":"",                 -> REQUERIDO
               <br> 
               "graduacion" :"",             
               <br>  
               "ti_graduacion" : "",        
               <br>        
               "precio_fi" : "",                 -> REQUERIDO
               <br>         
           }
        </code>
        <code>
           PUT  /Api-Letco/compras
           <br><br> 
           {
            <br> 
               "id_compra" : "",                 -> REQUERIDO
               <br> 
               "id_cliente" : "",                -> REQUERIDO
               <br> 
               "id_lente" : "",                  -> REQUERIDO
               <br> 
               "id_tratamiento":"",              -> REQUERIDO
               <br> 
               "graduacion" :"",                 -> REQUERIDO
               <br>  
               "ti_graduacion" : "",             -> REQUERIDO
               <br>        
               "precio_fi" : "",                 -> REQUERIDO
               <br>         
           }
        </code>
        <code>
           DELETE  /Api-Letco/compras
           <br> 
           {         
               <br>       
               "id_compra" : ""   -> REQUERIDO
               <br>
           }
        </code>
    </div>
    <h2>End Pints - Clientes</h2>      
    <div class="divbody">   
        <h3>Clientes</h3>
        <code>
           GET  /Api-Letco/clientes?page=1 (El numero de pagina muestra 50 clientes por pagina)
           <br>
           GET  /Api-Letco/clientes?id=1
        </code>
        <code>
           POST  /Api-Letco/clientes
           <br><br> 
           {
            <br> 
               "nombre" : "",                 -> REQUERIDO
               <br> 
               "ap_pa" : "",                  -> REQUERIDO
               <br>
               "ap_ma" : "",                  -> REQUERIDO
               <br> 
               "email" : "",                  -> REQUERIDO
               <br>
               "pasword":"",                  -> REQUERIDO
               <br>
               "token":"",                    -> REQUERIDO
               <br>            
           }
        </code>
        <code>
           PUT  /Api-Letco/clientes
           <br><br> 
           {
            <br> 
               "id_cliente" : "",             -> REQUERIDO
               <br> 
               "nombre" : "",                 -> REQUERIDO
               <br> 
               "ap_pa" : "",                  -> REQUERIDO
               <br>
               "ap_ma" : "",                  -> REQUERIDO
               <br> 
               "email" : "",                  -> REQUERIDO
               <br>
               "pasword":"",                  -> REQUERIDO
               <br>
               "token":"",                    -> REQUERIDO
               <br>    
                       
           }
        </code>
        <code>
           DELETE  /Api-Letco/clientes
           <br> 
           {         
               <br>       
               "id_cliente" : ""                -> REQUERIDO
               <br>
               "token" : "",                    -> REQUERIDO
               <br>  
           }
        </code>
    </div>
    <h2>End Pints - Lentes</h2>      
    <div class="divbody">   
        <h3>Lentes</h3>
        <code>
           GET  /Api-Letco/lentes?page=1 (El numero de pagina muestra 25 lentes por pagina)
           <br>
           GET  /Api-Letco/lentes?id=1
        </code>
        <code>
           POST  /Api-Letco/lentes
           <br><br> 
           {
            <br> 
               "id_marca" : "",               -> REQUERIDO
               <br> 
               "modelo" : "",                 -> REQUERIDO
               <br>
               "id_paquete" : "",             -> REQUERIDO
               <br> 
               "cantidad" : "",               -> REQUERIDO
               <br>
               "foto_1":"",                 
               <br>
               "foto_2":"",                 
               <br>
               "foto_3":"",                 
               <br>   
               "precio" :"",                 -> REQUERIDO
               <br>  
               "token" : ""                  -> REQUERIDO
               <br>              
           }
        </code>
        <code>
           PUT  /Api-Letco/lentes
           <br><br> 
           {
            <br> 
               "id_lentes" : "",              -> REQUERIDO
               <br> 
               "id_marca" : "",               -> REQUERIDO
               <br> 
               "modelo" : "",                 -> REQUERIDO
               <br>
               "id_paquete" : "",             -> REQUERIDO
               <br> 
               "cantidad" : "",               -> REQUERIDO
               <br>
               "foto_1":"",                 
               <br>
               "foto_2":"",                 
               <br>
               "foto_3":"",                 
               <br>   
               "precio" :"",                 -> REQUERIDO
               <br>  
               "token" : ""                  -> REQUERIDO
               <br>   
                       
           }
        </code>
        <code>
           DELETE  /Api-Letco/lentes
           <br> 
           {         
               <br>       
               "id_lentes" : ""                 -> REQUERIDO
               <br>
               "token" : "",                    -> REQUERIDO
               <br>  
           }
        </code>
    </div>
</div>
<h2>End Pints - Tratamientos</h2>      
    <div class="divbody">   
        <h3>Tratamientos</h3>
        <code>
           GET  /Api-Letco/tratamientos?page=1 (El numero de pagina muestra 10 tratamientos por pagina)
           <br>
           GET  /Api-Letco/tratamientos?id=1
        </code>
        <code>
           POST  /Api-Letco/tratamientos
           <br><br> 
           {
            <br> 
               "tratamiento" : "",                -> REQUERIDO
               <br> 
               "descripcion" : "",                -> REQUERIDO
               <br>
               "precio" : "",                     -> REQUERIDO
               <br>
               "token" : "",                      -> REQUERIDO
               <br>           
           }
        </code>
        <code>
           PUT  /Api-Letco/tratamientos
           <br><br> 
           {
            <br> 
               "id_tratamiento" : "",             -> REQUERIDO
               <br>
               "tratamiento" : "",                -> REQUERIDO
               <br> 
               "descripcion" : "",                -> REQUERIDO
               <br>
               "precio" : "",                     -> REQUERIDO
               <br>
               "token" : "",                      -> REQUERIDO
               <br>        
           }
        </code>
        <code>
           DELETE  /Api-Letco/tratamientos
           <br> 
           {         
               <br>       
               "id_tratamiento" : ""            -> REQUERIDO
               <br>
               "token" : "",                    -> REQUERIDO
               <br>  
           }
        </code>
    </div>
<h2>End Pints - Envio</h2>      
    <div class="divbody">   
        <h3>Envio</h3>
        <code>
           GET  /Api-Letco/envios?page=1 (El numero de pagina muestra 10 clientes por pagina)
           <br>
           GET  /Api-Letco/envios?id=1
        </code>
        <code>
           POST  /Api-Letco/envios
           <br><br> 
           {
            <br> 
               "id_sucursal" : "",                -> REQUERIDO
               <br> 
               "id_compra" : "",                  -> REQUERIDO
               <br>           
           }
        </code>
        <code>
           PUT  /Api-Letco/envios
           <br><br> 
           {
            <br> 
               "id_envio" : "",                   -> REQUERIDO
               <br> 
               "id_sucursal" : "",                -> REQUERIDO
               <br> 
               "id_compra" : "",                  -> REQUERIDO
               <br>      
           }
        </code>
        <code>
           DELETE  /Api-Letco/envios
           <br> 
           {         
               <br>       
               "id_envio" : ""   -> REQUERIDO
               <br>
           }
        </code>
    </div>
    <h2>End Pints - Paquetes</h2>      
    <div class="divbody">   
        <h3>Paquetes</h3>
        <code>
           GET  /Api-Letco/paquetes?page=1 (El numero de pagina muestra 10 paquetes por pagina)
           <br>
           GET  /Api-Letco/paquetes?id=1
        </code>
        <code>
           POST  /Api-Letco/paquetes
           <br><br> 
           {
            <br> 
               "paquete" : "",                -> REQUERIDO
               <br> 
               "token" : "",                  -> REQUERIDO
               <br>           
           }
        </code>
        <code>
           PUT  /Api-Letco/paquetes
           <br><br> 
           {
            <br> 
               "id_paquete" : "",             -> REQUERIDO
               <br> 
               "paquete" : "",                -> REQUERIDO
               <br> 
               "token" : "",                  -> REQUERIDO
               <br>      
           }
        </code>
        <code>
           DELETE  /Api-Letco/paquetes
           <br> 
           {         
               <br>       
               "id_paquete" : ""                -> REQUERIDO
               <br>
               "token" : "",                    -> REQUERIDO
               <br>  
           }
        </code>
    </div>
    <h2>End Pints - Marcas</h2>      
    <div class="divbody">   
        <h3>Marcas</h3>
        <code>
           GET  /Api-Letco/marcas?page=1 (El numero de pagina muestra 10 marcas por pagina)
           <br>
           GET  /Api-Letco/marcas?id=1
        </code>
        <code>
           POST  /Api-Letco/marcas
           <br><br> 
           {
            <br> 
               "marca" : "",                  -> REQUERIDO
               <br> 
               "token" : "",                  -> REQUERIDO
               <br>           
           }
        </code>
        <code>
           PUT  /Api-Letco/marcas
           <br><br> 
           {
            <br> 
               "id_marca" : "",               -> REQUERIDO
               <br> 
               "marca" : "",                  -> REQUERIDO
               <br> 
               "token" : "",                  -> REQUERIDO
               <br>      
           }
        </code>
        <code>
           DELETE  /Api-Letco/marcas
           <br> 
           {         
               <br>       
               "id_marca" : ""                  -> REQUERIDO
               <br>
               "token" : "",                    -> REQUERIDO
               <br>  
           }
        </code>
    </div>
    <h2>End Pints - Sucrusales</h2>      
    <div class="divbody">   
        <h3>Sucrusales</h3>
        <code>
           GET  /Api-Letco/sucursales?page=1 (El numero de pagina muestra 5 sucursales por pagina)
           <br>
           GET  /Api-Letco/sucursales?id=1
        </code>
        <code>
           POST  /Api-Letco/sucursales
           <br><br> 
           {
            <br> 
               "municipio" : "",                -> REQUERIDO
               <br> 
               "direccion" : "",                -> REQUERIDO
               <br> 
               "id_estado" : "",                -> REQUERIDO
               <br> 
               "token" : "",                  -> REQUERIDO
               <br>           
           }
        </code>
        <code>
           PUT  /Api-Letco/sucursales
           <br><br> 
           {
            <br> 
               "id_sucursal" : "",              -> REQUERIDO
               <br>
               "municipio" : "",                -> REQUERIDO
               <br> 
               "direccion" : "",                -> REQUERIDO
               <br> 
               "id_estado" : "",                -> REQUERIDO
               <br> 
               "token" : "",                    -> REQUERIDO
               <br>     
           }
        </code>
        <code>
           DELETE  /Api-Letco/sucursales
           <br> 
           {         
               <br>       
               "id_sucursal" : ""               -> REQUERIDO
               <br>
               "token" : "",                    -> REQUERIDO
               <br>  
           }
        </code>
    </div>
    <h2>End Pints - Estados</h2>      
    <div class="divbody">   
        <h3>Estados</h3>
        <code>
           GET  /Api-Letco/estados?page=1 (El numero de pagina muestra 5 estados por pagina)
           <br>
           GET  /Api-Letco/estados?id=1
        </code>
        <code>
           POST  /Api-Letco/estados
           <br><br> 
           {
            <br> 
               "estado" : "",                   -> REQUERIDO
               <br> 
               "token" : "",                    -> REQUERIDO
               <br>           
           }
        </code>
        <code>
           PUT  /Api-Letco/estados
           <br><br> 
           {
            <br> 
               "id_estado" : "",                -> REQUERIDO
               <br>
               "estado" : "",                   -> REQUERIDO
               <br> 
               "token" : "",                    -> REQUERIDO
               <br>     
           }
        </code>
        <code>
           DELETE  /Api-Letco/estados
           <br> 
           {         
               <br>       
               "id_estados" : ""                -> REQUERIDO
               <br>
               "token" : "",                    -> REQUERIDO
               <br>  
           }
        </code>
    </div>
    
    
</body>
</html>