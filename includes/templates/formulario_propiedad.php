<?php 

    // Vamos a usar la clase App\Propiedad (Traer las constantes en Propiedad)
    use App\Propiedad;
    use App\Vendedor;
    $resultadoVendedores = Vendedor::all();
?>

<!--Creamos la primera division del formulario-->
<fieldset>
    <!--Agregamos la leyenda del formulario-->
    <legend>Informacion General</legend>

    <label for="titulo">Titulo</label>

    <!--Campo de texto para el titulo con id=titulo name=titulo-->
    <!--Colocamos el valor a guardar en php, para no tener que llenar los campos otra vez-->
    <input type="text" id="titulo" name="titulo" placeholder="Titulo de la propiedad" value="<?php echo escapar($objeto->getTitulo()); ?>">

    <label for="precio">Precio</label>
    <input type="number" id="precio" required autocomplete="off" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
    name="precio" placeholder="Precio de la propiedad" value="<?php echo escapar($objeto->getPrecio()) ?>">

    <label for="imagen">Imagen</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
    <?php  if($objeto != null):?>
            <img src="../../imagenes/<?php echo $objeto->getImagen().'.jpg';?>" alt="" class="imagen-small">
    <?php  endif; ?>

    <label for="descripcion">Descripcion</label>
    <textarea name="descripcion" id="descripcion"><?php echo escapar($objeto->getDescripcion()); ?></textarea>
</fieldset>

<!--Creamos la segunda division del campo de texto-->
<fieldset>
    <legend>Informacion de la propiedad</legend>

    <label for="habitaciones">Número de habitaciones</label>
    <input type="number" id="habitaciones" required autocomplete="off" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
    name="habitaciones" value="<?php echo escapar($objeto->getHabitaciones()); ?>" placeholder="Ej: 3, 4" min="1" max="9">

    <label for="wc">Número de baños</label>
    <input type="number" id="wc" required autocomplete="off" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
    name="wc" value="<?php echo escapar($objeto->getWC()); ?>" placeholder="Ej: 3, 4" min="1" max="9">

    <label for="parqueaderos">Número de parqueaderos</label>
    <input type="number" id="parqueaderos" required autocomplete="off" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
    name="parqueaderos" value="<?php echo escapar($objeto->getEstacionamiento()); ?>" placeholder="Ej: 3, 4" min="0" max="9">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>

    <!--Creamos un campo de seleccion con elementos que traemos de la base de datos-->
    <select name="vendedorId" id="">
        <option value="" default>-- Seleccione --</option>
        <?php 
        
        foreach ($resultadoVendedores as $v) : ?>
            <option <?php echo $objeto->getVendedorId() === $v->id ? 'selected' : ''; ?> value="<?php echo $v->id; ?>"><?php echo $v->nombre . ' ' . $v->apellido; ?></option>

        <?php endforeach; ?>

    </select>
</fieldset>

<!--Boton para enviar el formuario-->