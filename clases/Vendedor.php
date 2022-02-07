<?php

namespace App;

/**
 * Clase encargada de representar un Vendedor en la aplicacion  
 */
class Vendedor extends Principal{

    /**
     * Herencia de Principal, nombre de la tabla en la base de datos
     */
    protected static $tabla = 'vendedores';

    /**
     * Columnas de la base de datos como atributo estatico
     */
    protected static $columnasBD =[
        'id', 'nombre', 'apellido', 'telefono'
    ];

    //-------------------------------------------------------------
    // Atributos
    //-------------------------------------------------------------

    /**
     * Id del vendedor
     */
    public $id;

    /**
     * Nombre del vendedor
     */
    public $nombre;

    /**
     * Apellido del vendedor
     */
    public $apellido;

    /**
     * Telefono del vendedor
     */
    public $telefono;

    /**
     * El constructor inicializa las variables con la informacion pasada por
     * parametro en el arreglo args
     */
    public function __construct($args=[])
    {
        $this->id = $args['id']?? '';
        $this->nombre = $args['nombre']??'';
        $this->apellido = $args['apellido']??'';
        $this->telefono = $args['telefono'] ?? '';
    }

    //-------------------------------------------------------------
    // Metodos GET-SET  
    //-------------------------------------------------------------

    public function getId(){
        return $this->id;
    }

    public function setId($nuevo){
        $this->id = $nuevo;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nuevo){
        $this->nombre = $nuevo;
    }

    public function getApellido(){
        return $this->apellido;
    }
    public function setApellido($nuevo){
        $this->apellido = $nuevo;
    }

    public function getTelefono(){
        return $this->telefono;
    }
    public function setTelefono($nuevo){
        $this->telefono = $nuevo;
    } 

    //----------------------------------------------------
    // Metodos Generales
    //----------------------------------------------------

    public function guardar(): array{
        $atributos = $this->sanitizarDatos();

        // Recolectamos los errores
        $errores = $this->validarVariables($atributos);

        if(empty($errores)){
            // Aplanamos $atributos por su llave en un string con join
            $columnasAplanadas = join(', ', array_keys($atributos));
            $valoresAplanados = join("' , '", array_values($atributos));

            // Creamos al query
            $query = "INSERT INTO ".self::$tabla." (";
            $query .= $columnasAplanadas.") VALUES";
            $queryFinal = $query." ( '".$valoresAplanados."' );";
           
            // Ingresamos a la base de datos
            $resultado = self::$baseDeDatos->query($queryFinal);
            // Si fue exitoso retornamos 
            if($resultado){
               return $errores;
            }
        }
        return $errores;
    }

    
        /**
     * Metodo encargado de actualizar en la base de datos
     */
    public function actualizar($vendedorModificado): array{

        // Id de la propiedad actual
        $idActual = $this->getId();

        // Hay cambios en el formulario
        $hayCambios = $this->hayCambios($vendedorModificado);

        $errores = [];
        
        if($hayCambios){
            // Ubicamos la variables que ingresaran en el query
            $nombre = $vendedorModificado->getNombre();
            $apellido = $vendedorModificado->getApellido();
            $telefono= $vendedorModificado->getTelefono();
            
            // Convertimos en objeto
            $arregloAsociativo = $this->crearArregloAsociativo($vendedorModificado);
            

            // Validamos los datos de la propiedad modificadas
            $errores = $this->validarVariables($arregloAsociativo);

            if(empty($errores))
            {    
                // Escribimos el query de actualizacion
                $query ="UPDATE ".self::$tabla." SET 
                nombre =  '$nombre' , 
                apellido = '$apellido' , 
                telefono = '$telefono'
                WHERE id = $idActual ;";
                
                // Ejecutamos el query
                $resultado = self::$baseDeDatos->query($query);

                // Ingresamo mensaje si ha ahbido un error
                if(!$resultado){
                    array_push($errores,'No se ha podido ingresar a a base de datos');
                }
            }
            else {
                return $errores;
            }
        }
        
        return $errores;
        
    }
    
    /**
     * Metodo encargado de eliminar la propiedad con el id
     */
    public function eliminar(): bool{

        // Guardamos el id
        $id = $this->getId();

        // Query de eliminar
        $query = "DELETE FROM ".self::$tabla." WHERE id = $id";

        // Ejecutamos el query
        $resultado = self::$baseDeDatos->query($query);
        
        if($resultado){
            return true;
        }
        
        return false;
        
    }





}

?>