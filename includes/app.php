<?php
require 'funciones.php';
require 'config/database.php';
require __DIR__.'/../vendor/autoload.php';

// Agregamos las clases
use App\Principal;

// Conectar a la base de datos
$baseDeDatos = conectarDB();

// Inicializamos las clases
Principal::setBaseDeDatos($baseDeDatos);


?>