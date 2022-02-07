<?php 
    require __DIR__.'/../../includes/app.php';

    // El usuario esta autenticado
    estaAutenticado();

    // Incluimos el template del header
    incluirTemplate('header');

    use App\Propiedad;

    $carpetaImagenes = __DIR__.'/../../imagenes';

    // Arreglo con mensajes de error
    $mensajes =[];

    // Placeholder para que no halla error si no existe el resultado
    $idPropiedad = $_GET['id'];

    // Validamos si el id es entero
    $idEsEntero = filter_var($idPropiedad, FILTER_VALIDATE_INT);

    //Creamos una nueva propiedad vacia
    $propiedadActual = null;

    // Creamos una nueva propiedad vacia para almacenar los cambios
    $propiedadModificada = null;

    // Verificamos si el valor en la url es entero
    if(!$idEsEntero){

        // Redireccionamos
        header('Location: /bienesRaicesPHP/bienesraices/admin');
    }
    else{

        // Llamo el metodo de encontrar
        $propiedadActual = Propiedad::find($idPropiedad);
        
        
        if($propiedadActual===null){
            header('Location: /bienesRaicesPHP/bienesraices/admin');
        }
         
    }

    // Al hacer click en el boton verde
    if($_SERVER['REQUEST_METHOD']=== 'POST'){
        
        // Carpeta de imagenes
        
        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';
        //Verificamos si se ha ingresado una imagen nueva
        if($_FILES['imagen']['tmp_name']){
            // Hacemos un nuevo nombre a la imagen que esta 
            $nombreImagen = md5( uniqid( rand(), true ));
            
        }
        else{
            // Guardamos el nombre de la imagen que ya tenia
            $nombreImagen = $propiedadActual->getImagen();
        }
        // Arreglo para todos los componentes

        $arreglo = $_POST;
        $arreglo['imagen'] = $nombreImagen;

        // Creamos la nueva propiedad con la informacion que queda en el formulario 
        $propiedadModificada = new Propiedad($arreglo);

        //Actualizamos la propiedad actual
        $mensajes = $propiedadActual->actualizar($propiedadModificada);

        if($_FILES['imagen']['tmp_name'] && empty($mensajes)){
            // Eliminamos la imagen de la propiedad
            unlink($carpetaImagenes.'/'.$propiedadActual->getImagen().'.jpg');

            // Agregamos la imagen nueva
            move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaImagenes."/".$nombreImagen.".jpg");
        }

        if(empty($mensajes)){
            header('Location: /bienesRaicesPHP/bienesraices/admin?resultado=2');
        }
    }

?>

     <main class="contenedor seccion">

        <h1>Actualizar </h1>

        <?php foreach($mensajes as $error): ?>

        <div class="alerta error">
            <?php  echo $error; ?>
        </div>
        <?php  endforeach; ?>

        <!--MULTIPART/form-data para las imagenes, subir imagenes con la super global $_FILES-->
        <form class="formulario" method="POST" enctype="multipart/form-data">

            <?php 
            if($propiedadModificada === null){
                incluirTemplate('formulario_propiedad', false, $propiedadActual);
            }
            else{
                incluirTemplate('formulario_propiedad', false, $propiedadModificada);
            }?>
           
           <div class="extremos" >
                <!--Boton para retroceder a la pagina principal -->
                <a href="/bienesRaicesPHP/bienesraices/admin" class="boton boton-amarillo">Inicio</a>

                <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
            </div>
        </form>

        

     </main>

    <?php incluirTemplate('footer',true); ?>