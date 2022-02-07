<?php

namespace App;

/**
 * Clase principal encargada de las partes generales de las dependencias
 */
class Principal{

     /**
     * Base de datos como atributo estatico ya que lo vamos a reutilizar 
     */
    protected static $baseDeDatos;
 
    /**
     * Columnas de la base de datos como atributo estatico
     */
    protected static $columnasBD = [];

    /**
     * Nombre de la tabla
     */
    protected static $tabla = '';

    //--------------------------------------------------
    // Metodos estaticos
    //--------------------------------------------------

    public static function setBaseDeDatos($database){
        // Llamamos el atributo statico y la asignamos a la base de datos
        self::$baseDeDatos = $database;
    }

    public static function getBaseDeDatos(){
        return self::$baseDeDatos;
    }

    //---------------------------------------------------
    // Metodos Auxiliares (reutilizables)
    //---------------------------------------------------

    /**
     * Metodo encargado de validar las variables antes de ingresarlas 
     * a la base de datos 
     */
    public function validarVariables($atributos): array{

        $errores = [];
        // Validaciones de los datos
        foreach(static::$columnasBD as $columna){
            
            if($columna !== 'id'){
                if($atributos[$columna] ==='' && $columna != 'vendedorId'){
                    array_push($errores, "El campo de ".$columna." no puede estar vacio");
                }
                else if($atributos[$columna] ==='' && $columna === 'vendedorId'){
                    array_push($errores, "No hay ningun vendedor asociado");
                }
            }
            
        }
        
        return $errores;
    }

    /**
     * Metodo que retorna un arreglo asosiativo llave -> valor
     */
    private function atributos(): array{
        $atributos = [];
        foreach(static::$columnasBD as $columna){
            // Omitimos la columna de id
            // Siguiente elemento en el foreach
            if($columna ==='id') continue;
            // Arreglo asociativo con los mismos nombres de los atributos con las columnas de la base de datos
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    /**
     * Metodo encaragdo de filtrar todos los datos
     */
    public function sanitizarDatos(){
        $atributos = $this->atributos();
        
        $sanitizado = [];

        foreach($atributos as $key=> $value){
            //key son las llaves, value es el valor
            // Limpiamos los valores
            $sanitizado[$key] = static::$baseDeDatos->escape_string($value);

        }
        return $sanitizado;
    }

    /**
     * Metodo encargado de consultar en la base de datos y mostrarlos en un arreglo
     */
    private static function consultarSQL($query): array{
        
        // 1. Consultar la base de datos
        $resultado = static::$baseDeDatos->query($query);
        // 2. Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }
        // 3. Liberar la memoria
        $resultado -> free();
        // Retornar 
        return $array;
    }
 
    /**
     * Metodo encargado de crear un objeto con los datos de un registro
     */
    private static function crearObjeto($registro){
        // Creamos un objeto vacio
        $objeto = new static;

        //Iteramos el registro
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto -> $key = $value;
            }
        }
        return $objeto;
    }

    /**
     * Metodo encargado de crear un arreglo asiciativo con los datos de un objeto
     */
    public function crearArregloAsociativo($objeto){
        $array = [];
        
        foreach(static::$columnasBD as $columna){
            $array[$columna] = $objeto->$columna;
        }
        //Retornamos el array
        return $array;
    }

    /**
     * Metodo encaragdo de decirnos si han habido cambios en el formulario
     * Asi evitamos ingresar a la base de datos la informacion que ya estaba 
     */
    public function hayCambios($objeto1): bool{

        foreach(static::$columnasBD as $columna){
            
            if($columna !== 'id'){
                
                if($objeto1->$columna !== $this->$columna){
                
                    return true;
                }
            }
            
        }
    
        return false;
    }

    //---------------------------------------------------
    // Metodos Generales
    //---------------------------------------------------

    /**
     * Metodo encargado de obtener todas las propedades de la base de datos
     */
    public static function all(){
        // Hacemos el query
         $query = 'SELECT * FROM '.static::$tabla;
        // Traemos un arreglo de propiedades 
        $resultado = static::consultarSQL($query);
        // Retornamos 
        return $resultado; 
    }

    /**
     * Metodo encargado de obtener un numero determinado de propiedades
     */
    public static function allLimit($numero){
        // Hacemos el query
         $query = 'SELECT * FROM '.static::$tabla.' LIMIT '. $numero. ' ;';
        // Traemos un arreglo de propiedades 
        $resultado = static::consultarSQL($query);
        // Retornamos 
        return $resultado; 
    }


    /**
     * Metodo encaragdo de encontrar una propiedad por su id en la base de datos
     */
    public static function find($id){

        // Creamos el query
        $query = "SELECT * FROM ".static::$tabla." WHERE id = '$id';";
        
        $resultado = static::consultarSQL($query);
        // Verificar si existe el registro
        if(empty($resultado)){
            return null;
        }
        else{
            // Retornamos el objeto
            return $resultado[0];
        }
    }

    



}

?>
