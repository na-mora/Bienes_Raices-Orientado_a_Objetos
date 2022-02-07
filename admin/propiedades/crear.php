<?php 
    // Incluimos las dependendencias desde la app.php
    require __DIR__.'/../../includes/app.php';

    // Vamos a usar la clase App\Propiedad
    use App\Propiedad; 

    // Vamos a utilizar para las imagenes
    use Intervention\Image\ImageManagerStatic as Imagen;
    
    // Verificamos si esta autenticado
    estaAutenticado();

    // Arreglo con mensajes de error
    $mensajes =[];

    // Generar un nombre unico (random)
    $nombreImagen = md5( uniqid( rand(), true ));

    // Arreglo a ingresar
    $arreglo = $_POST;
    $arreglo['imagen'] = $nombreImagen;
    

    // Inicializamos una propiedad
    $propiedad = new Propiedad($arreglo);

    if($_SERVER['REQUEST_METHOD']=== 'POST'){
        
        // Si ya se selecciono una imagen
        if($_FILES['imagen']['tmp_name']){
            // Guardamos la propiedad
            $mensajes = $propiedad->guardar();
        }
        else{
            array_push($mensajes,'Debe seleccionar una imagen');
        }
        
        if(empty($mensajes)){
            // Creamos el directorio de las imagenes
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }

            // Guardamos la imagen
            $imagen = Imagen::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
            $imagen -> save(CARPETA_IMAGENES.$nombreImagen.'.jpg');

            // Redireccionamoss
            header('Location: /bienesRaicesPHP/bienesraices/admin?resultado=1');
            
        }
    }
    // Incluimos el template para el header
    incluirTemplate('header');   
?>
    <!----------------------------------------------->
    <!-- HTML -->
    <!----------------------------------------------->
     <main class="contenedor seccion">

        <h1>Crear </h1>

        <!--Traemos todos los mensajes que estan en el arreglo de mensajes 
         y los mostramos en pantalla-->
        <?php foreach($mensajes as $error): ?>

        <div class="alerta error">
            <?php  echo $error; ?>
        </div>
        <?php  endforeach; ?>

        <!--Creamos el formulario en html  -->
        <!--MULTIPART/form-data para las imagenes, subir imagenes con la super global $_FILES-->
        <form class="formulario" method="POST" action="/bienesRaicesPHP/bienesraices/admin/propiedades/crear.php" enctype="multipart/form-data" >
            <!--Incluimos e template para el formulario de una propiedad-->
            <?php incluirTemplate('formulario_propiedad', false, $propiedad);?>

            <div class="extremos" >
                <!--Boton para retroceder a la pagina principal -->
                <a href="/bienesRaicesPHP/bienesraices/admin" class="boton boton-amarillo">Inicio</a>

                <input type="submit" value="Crear Propiedad" class="boton boton-verde">
            </div>
            
        </form>
        

     </main>
    <!--Incluimos el template para el footer-->
    <?php incluirTemplate('footer',true); ?>