<?php 
    require __DIR__.'/../../includes/app.php';

    // El usuario esta autenticado
    estaAutenticado();

    // Incluimos el template del header
    incluirTemplate('header');

    use App\Vendedor;

    // Arreglo con mensajes de error
    $mensajes =[];

    // Placeholder para que no halla error si no existe el resultado
    $id = $_GET['id'];

    // Validamos si el id es entero
    $idEsEntero = filter_var($id, FILTER_VALIDATE_INT);

    //Creamos una nueva propiedad vacia
    $vendedorActual = null;

    // Creamos una nueva propiedad vacia para almacenar los cambios
    $vendedorModificado = null;

    // Verificamos si el valor en la url es entero
    if(!$idEsEntero){

        // Redireccionamos
        header('Location: /bienesRaicesPHP/bienesraices/admin');
    }
    else{

        // Llamo el metodo de encontrar
        $vendedorActual = Vendedor::find($id);
        
        if($vendedorActual===null){
            header('Location: /bienesRaicesPHP/bienesraices/admin');
        }
        
         
    }

    // Al hacer click en el boton verde
    if($_SERVER['REQUEST_METHOD']=== 'POST'){
        
        // Creamos la nueva  con la informacion que queda en el formulario 
        $vendedorModificado = new Vendedor($_POST);

        //Actualizamos la propiedad actual
        $mensajes = $vendedorActual->actualizar($vendedorModificado);
        

        if(empty($mensajes)){
            header('Location: /bienesRaicesPHP/bienesraices/admin?resultado=5');
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
            if($vendedorModificado === null){
                incluirTemplate('formulario_vendedor', false, $vendedorActual);
            }
            else{
                incluirTemplate('formulario_vendedor', false, $vendedorModificado);
            }?>
           

           <div class="extremos" >
                <!--Boton para retroceder a la pagina principal -->
                <a href="/bienesRaicesPHP/bienesraices/admin" class="boton boton-amarillo">Inicio</a>

                <input type="submit" value="Actualizar Vendedor" class="boton boton-verde">
            </div>
        </form>

       

     </main>

    <?php incluirTemplate('footer',true); ?>