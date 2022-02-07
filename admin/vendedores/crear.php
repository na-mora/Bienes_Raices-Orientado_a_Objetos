<?php 
    // Incluimos las dependendencias desde la app.php
    require __DIR__.'/../../includes/app.php';

    // Vamos a usar la clase App\Vendedor
    use App\Vendedor; 
    
    // Verificamos si esta autenticado
    estaAutenticado();

    // Arreglo con mensajes de error
    $mensajes =[];
    
    // Inicializamos un vendedor
    $vendedor = new Vendedor($_POST);

    if($_SERVER['REQUEST_METHOD']=== 'POST'){
        
        // Metodo de guardar
        $mensajes = $vendedor->guardar();

        if(empty($mensajes)){

            // Redireccionamoss
            header('Location: /bienesRaicesPHP/bienesraices/admin?resultado=4');
            
        }
    }
    // Incluimos el template para el header
    incluirTemplate('header');   
?>
    <!----------------------------------------------->
    <!-- HTML -->
    <!----------------------------------------------->
     <main class="contenedor seccion">

        <h1>Ingresar Vendedor</h1>

        <!--Traemos todos los mensajes que estan en el arreglo de mensajes 
         y los mostramos en pantalla-->
        <?php foreach($mensajes as $error): ?>

        <div class="alerta error">
            <?php  echo $error; ?>
        </div>
        <?php  endforeach; ?>

        <!--Creamos el formulario en html  -->
        <!--MULTIPART/form-data para las imagenes, subir imagenes con la super global $_FILES-->
        <form class="formulario" method="POST" action="/bienesRaicesPHP/bienesraices/admin/vendedores/crear.php" enctype="multipart/form-data" >
            <!--Incluimos e template para el formulario de una propiedad-->
            <?php incluirTemplate('formulario_vendedor', false, $vendedor);?>

            <div class="extremos" >
                <!--Boton para retroceder a la pagina principal -->
                <a href="/bienesRaicesPHP/bienesraices/admin" class="boton boton-amarillo">Inicio</a>

                <input type="submit" value="Ingresar Vendedor" class="boton boton-verde">
            </div>
        </form>
        

     </main>
    <!--Incluimos el template para el footer-->
    <?php incluirTemplate('footer',true); ?>