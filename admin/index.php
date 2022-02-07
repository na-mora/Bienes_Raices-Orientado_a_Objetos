<?php 
    // 20) Revisamos si esta autenticado y redireccionamos

use App\Propiedad;
use App\Vendedor;

require __DIR__.'../../includes/app.php';

    // Usamos la funcion para comprobar si esta autenticado
    estaAutenticado();

    // Incluir Template
    incluirTemplate('header');

    $carpetaImagenes = __DIR__.'/../imagenes';

    // Implementar un metodo para obtener todas las propiedades
    $propiedades = Propiedad::all();

    // Implementar un metodo para obtener todos los vendedores
    $vendedores = Vendedor::all();

    // Placeholder para que no halla error si no existe el resultado
    $resultado = $_GET['resultado']??null ;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idEliminar = $_POST['id']??null;
        $esEnteroIdEliminar = filter_var($idEliminar, FILTER_VALIDATE_INT);

        if($esEnteroIdEliminar){
                $propiedad = Propiedad::find($idEliminar);

                if($propiedad){
                    // Traemos el nombre de la imagen actualmente
                    $nombreImagen = $propiedad->getImagen();

                    // Eliminamos la imagen
                    unlink($carpetaImagenes.'/'.$propiedad->getImagen().'.jpg');

                    // Eliminamos el registro
                    $resultado = $propiedad->eliminar();

                    if($resultado){
                        header('Location: /bienesRaicesPHP/bienesraices/admin?resultado=3');
                    }
                }
                else{
                    header('Location: /bienesRaicesPHP/bienesraices/admin');
                }
        }

        $idVendedor = $_POST['idVend'];
        $esEnteroVend = filter_var($idVendedor, FILTER_VALIDATE_INT);

        if($esEnteroVend){
            $vendedor = Vendedor::find($idVendedor);
           
            if($vendedor){
                //Eliminamos el registro
                $resultado = $vendedor->eliminar();


            }
            if($resultado){
                header('Location: /bienesRaicesPHP/bienesraices/admin?resultado=6');
            }
        }
        else{
            header('Location: /bienesRaicesPHP/bienesraices/admin');
        }
    }  
?>

     <main class="contenedor seccion">

        <h1>Administrador de Bienes Raices</h1>

        <?php if($resultado == 1): ?>
            <p class="alerta exito"> El anuncio se ha creado correctamente</p>
            <?php elseif($resultado == 2) :?>
                <p class="alerta exito"> El anuncio ha sido actualizado correctamente</p>
            <?php elseif($resultado == 3) :?>
                <p class="alerta error"> El anuncio ha sido eliminado correctamente</p>
                <?php elseif($resultado == 4) :?>
                <p class="alerta exito"> El vendedor ha sido ingresado correctamente</p>
                <?php elseif($resultado == 5) :?>
                <p class="alerta exito"> El vendedor se ha actualizado correctamente</p>
                <?php elseif($resultado == 6) :?>
                <p class="alerta error"> El vendedor se ha eliminado correctamente</p>
            <?php endif; ?>
        

        <a href="/bienesRaicesPHP/bienesraices/admin/propiedades/crear.php" class="boton boton-verde">Crear Propiedad</a>
        <a href="/bienesRaicesPHP/bienesraices/admin/vendedores/crear.php" class="boton boton-amarillo">Ingresar Vendedor</a>
     </main>

     <!--Mostramos las propiedades que ya existen en la base de datos (Listar) (GET)-->

     <div class = "contenedor seccion">

        <h2>Propiedades en Venta</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Precio</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!--(4)-->
                <?php foreach($propiedades as $propiedad ): ?>
                <tr>
                    <td> <?php echo $propiedad->getId();?> </td>
                    <td> <?php echo $propiedad->getTitulo();?> </td>
                    <td><?php echo '$'.$propiedad->getPrecio();?></td>
                    <td><?php echo $propiedad->getCreado();?></td>
                    <td class="flex">
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->getId();?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                            
                        </form>
                        
                        <a class ="boton-amarillo-block" href="/bienesRaicesPHP/bienesraices/admin/propiedades/actualizar.php?id=<?php echo $propiedad->getId(); ?>">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores Activos</h2>
        <table class="vendedores">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!--(4)-->
                <?php foreach($vendedores as $vendedor ): ?>
                <tr>
                    <td> <?php echo $vendedor->id;?> </td>
                    <td> <?php echo $vendedor->nombre.' '.$vendedor->apellido;?> </td>
                    <td><?php echo  $vendedor->telefono;?></td>
                    
                    <td class="flex">
                        <form method="POST" class="w-100">
                            <input type="hidden" name="idVend" value="<?php echo $vendedor->id;?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                            
                        </form>
                        
                        <a class ="boton-amarillo-block" href="/bienesRaicesPHP/bienesraices/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                
            </tbody>
        </table>
     </div>
     
     <?php
    
    

     // Incluir 
    incluirTemplate('footer',true);
?>