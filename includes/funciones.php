<?php

//---------------------------------------------------
// Constantes
//---------------------------------------------------

/**
 * Direccion de los templates (carpeta)
 */
define('TEMPLATE_URL', __DIR__.'./templates/');

/**
 * Direccion de las funciones.php
 */
define('FUNCIONES_URL', __DIR__.'funciones.php');

/**
 * Direccion de las imagenes (carpeta)
 */
define('CARPETA_IMAGENES', __DIR__.'/../imagenes/');

//---------------------------------------------------
// Funciones
//---------------------------------------------------

/**
 * Funcion encargada de incluir un template en el html
 * No es necesario el isset
 */
function incluirTemplate($nombre, $inicio=false, $objeto=null){
    include TEMPLATE_URL.$nombre.".php"; 
}

/**
 * Funcion encargada de decirnos si el usuario ya ha sido autenticado
 */
function estaAutenticado(): void{
    // 18) Recibimos la informacion de $session 
    session_start(); // Ya podemos ingresar a la informacion de $_SESSION  

    // 19) Solo dejamos que entren a esta pagina las personas que estan autenticadas
    
    if(!$_SESSION['login']){
        header('Location: /bienesRaicesPHP/bienesraices/index.php');
    }
}

/**
 * Funcion encargada de debugear una variable en especifico 
 * para mostrarla en pantalla
 */
function debuguear($variable): void{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

/**
 * Funcion encargada de escapar/sanitizar los valores que estamos
 * imprimendo en los campos de texto 
 * Evita inyecciones de codigo, retorna un string con el valor a imprimir en 
 * el campo de texto
 */
function escapar($html): string{
    return htmlspecialchars($html);
}

?>