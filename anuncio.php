<?php 
    require 'includes/app.php';
    use App\Propiedad;

    // Leer el id de la propiedad

    $idPropiedad = $_GET['id'] ;

    // Validamos el entero
    $idEsEntero = filter_var($idPropiedad, FILTER_VALIDATE_INT);
    
    if(!$idEsEntero){
        header('Location: /bienesRaicesPHP/bienesraices/index.php');
    }

    $propiedad = Propiedad::find($idPropiedad);
    
    if($propiedad == NULL){
        header('Location: /bienesRaicesPHP/bienesraices/index.php');
    }
    
    incluirTemplate('header');
?>

     <main class="contenedor seccion">

        <h1><?php echo $propiedad->titulo;?></h1>

        <picture>
            <!--<source srcset="build/img/destacada.webp" type="image/webp">-->

            <img src="imagenes/<?php echo $propiedad->imagen.'.jpg';?>" alt="Imagen destacada">
        </picture>

        <p class="precio"> $<?php echo number_format($propiedad->precio); ?></p>

        <div class="contenedor-iconos">

            
            <ul class="iconos-caracteristicas">
                <li>
                    <img loading="lazy" src="build/img/icono_wc.svg" alt="Icono wc">
                    <p><?php echo $propiedad->wc;?></p>
                </li>
    
                <li>
                    <img loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono estacionamiento">
                    <p><?php echo $propiedad->estacionamiento?></p>
                </li>
    
                <li>
                    <img loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono dormitorios">
                    <p><?php echo $propiedad->habitaciones;?></p>
                </li>
            </ul>
        </div>
       

        <p><?php echo $propiedad->descripcion; ?></p>
        
        

        <p>Creado: <?php echo $propiedad->creado;?></p>
        

     </main>
<?php
    incluirTemplate('footer',true);
?>