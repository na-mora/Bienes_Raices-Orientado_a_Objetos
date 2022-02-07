<?php 

// Configuracion (Conexion a la base de datos)
function conectarDB(): mysqli{
    // puerto, usuario, contrasena, nombre BBDD
    $db = new mysqli('localhost', 'root', 'root', 'bienes_raices');

    if(!$db){
        echo 'error: No se pudo conectar';
        exit; // Las instrucciones de abajo no se ejecutaran
    }

    return $db;
    
}




?>