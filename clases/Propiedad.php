<?php

/**
 * Nombre del namespace para el active record
 */
namespace App;

/**
 * Clase encargada de representar una Propiedad en la aplicacion  
 */
class Propiedad extends Principal{

   
    /**
     * Herencia de Principal, nombre de la tabla en la base de datos
     */
    protected static $tabla = 'propiedades';

    /**
     * Columnas de la base de datos como atributo estatico
     */
    protected static $columnasBD =[
        'id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc',
        'estacionamiento', 'creado', 'vendedorId'
    ];

    //---------------------------------------------
    // Atributos
    //---------------------------------------------

    /**
     * Id de la propiedad
     */
    public $id;

    /**
     * Titulo de la propiedad
     */
    public $titulo ;

    /**
     * Precio de la propiedad
     */
    public $precio;

    /**
     * Imagen de la propiedad
     */
    public $imagen;

    /**
     * Descripcion de la propiedad
     */
    public $descripcion;

    /**
     * Numero de habitaciones de la propiedad
     */
    public $habitaciones;

    /**
     * Numero de banos de la propiedad
     */
    public $wc;

    /**
     * Numero de parqueaderos de la propiedad
     */
    public $estacionamiento;

    /**
     * Fecha de creacion del anuncio
     */
    public $creado;

    /**
     * Id del vendedor de la propiedad
     */
    public $vendedorId;

    //---------------------------------------------------
    // Constructor
    //---------------------------------------------------

    /**
     * Constructor de la clase que inicializa los atributos con la 
     * informacion que entra por parametro 
     */
    public function __construct($args=[])
    {
        $this->id = $args['id']?? '';
        $this->titulo = $args['titulo']??'';
        $this->precio = $args['precio']??'';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion']??'';
        $this->habitaciones = $args['habitaciones']??'';
        $this->wc = $args['wc']??'';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId']??'';
        $this->estacionamiento = $args['parqueaderos']??'';
    }
    
    //---------------------------------------------------
    // Metodos GET-SET
    //---------------------------------------------------

    /**
     * Obtener la id 
     */
    public function getId(){
        return $this->id;
    }
    /**
     * Cambiar la id
     */
    public function setId($nuevaId){
        $this->id = $nuevaId;
    }

    /**
     * Obtener el titulo 
     */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
     * Cambiar el titulo
     */
    public function setTitulo($nueva){
        $this->titulo = $nueva;
    }

    /**
     * Obtener el precio
     */
    public function getPrecio(){
        return $this->precio;
    }

    /**
     * Cambiar el precio 
     */
    public function setPrecio($nueva){
        $this->precio = $nueva;
    }

    /**
     * Obtener la imagen
     */
    public function getImagen(){
        return $this->imagen;
    }

    /**
     * Cambiar la imagen
     */
    public function setImagen($nueva){
        $this->imagen = $nueva;
    }

    /**
     * Obtener la descripcion
     */
    public function getDescripcion(){
        return $this->descripcion;
    }
    
    /**
     * Cambiar la descripcion
     */
    public function setDescripcion($nueva){
        $this->descripcion = $nueva;
    }

    /**
     * Obtener el numero de habitaciones
     */
    public function getHabitaciones(){
        return $this->habitaciones;
    }

    /**
     * Cambiar el numero de habitaciones
     */
    public function setHabitaciones($nueva){
        $this->habitaciones = $nueva;
    }

    /**
     * Obtener el numero de banos 
     */
    public function getWC(){
        return $this->wc;
    }

    /**
     * Cambiar el numero de banos
     */
    public function setWC($nueva){
        $this->wc = $nueva;
    }

    /**
     * Obtener la fecha en que fue creado el anuncio
     */
    public function getCreado(){
        return $this->creado;
    }

    /**
     * Cambiar el dia que fue creado el anuncio
     */
    public function setCreado($nueva){
        $this->creado = $nueva;
    }

    /**
     * Obtener la id del vendedor asociado
     */
    public function getVendedorId(){
        return $this->vendedorId;
    }

    /**
     * Cambiar la id del vendedor asociado
     */
    public function setVendedorId($nueva){
        $this->vendedorId = $nueva;
    }

    /**
     * Obtener el numero de parqueaderos
     */
    public function getEstacionamiento(){
        return $this->estacionamiento;
    }

    /**
     * Cambiar el numero de parqueaderos
     */
    public function setEstacionamiento($nueva){
        $this->estacionamiento = $nueva;
    }

    //---------------------------------------------------
    // Metodos Generales
    //---------------------------------------------------

    /**
     * Metodo encargado de guardar en la base de datos
     */
    public function guardar():array
    {
        $atributos = $this->sanitizarDatos();

        // Recolectamos los errores
        $errores = $this->validarVariables($atributos);

        // Hacemos el query
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
    public function actualizar($propiedadModificada): array{

        // Id de la propiedad actual
        $idActual = $this->getId();

        // Hay cambios en el formulario
        $hayCambios = $this->hayCambios($propiedadModificada);

        $errores = [];
        
        if($hayCambios){
            // Ubicamos la variables que ingresaran en el query
            $titulo = $propiedadModificada->getTitulo();
            $precio = $propiedadModificada->getPrecio();
            $imagen = $propiedadModificada->getImagen();
            $descripcion = $propiedadModificada->getDescripcion();
            $habitaciones = $propiedadModificada->getHabitaciones();
            $wc =  $propiedadModificada->getWC();
            $estacionamiento = $propiedadModificada->getEstacionamiento();
            $vendedorId = $propiedadModificada->getVendedorId();

            // Convertimos en objeto
            $arregloAsociativo = $this->crearArregloAsociativo($propiedadModificada);
            

            // Validamos los datos de la propiedad modificadas
            $errores = $this->validarVariables($arregloAsociativo);

            if(empty($errores))
            {    
                // Escribimos el query de actualizacion
                $query ="UPDATE ".self::$tabla." SET 
                titulo =  '$titulo' , 
                precio = '$precio' , 
                imagen = '$imagen' , 
                descripcion =  '$descripcion', 
                habitaciones = '$habitaciones', 
                wc = '$wc', 
                estacionamiento = '$estacionamiento', 
                vendedorId = $vendedorId 
                WHERE id = $idActual ";
                
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