<?php 

    // Vamos a usar la clase App\Propiedad (Traer las constantes en Propiedad)
    use App\Propiedad;
    use App\Vendedor;
?>

<!--Creamos la primera division del formulario-->
<fieldset>
    <!--Agregamos la leyenda del formulario-->
    <legend>Informacion General</legend>

    <label for="nombre">Nombres</label>

    <!--Campo de texto para el titulo con id=titulo name=titulo-->
    <!--Colocamos el valor a guardar en php, para no tener que llenar los campos otra vez-->
    <input type="text" id="nombre" name="nombre" placeholder="Nombres del vendedor" value="<?php echo escapar($objeto->nombre); ?>">

    <label for="apellido">Apellidos</label>
    <input type="text" id="apellido" name="apellido" placeholder="Apellidos del vendedor" value="<?php echo escapar($objeto->apellido); ?>">

</fieldset>

<!--Creamos la segunda division del campo de texto-->
<fieldset>
    <legend>Contacto</legend>

    <label for="telefono">Número de telefono</label>
    <input type="number" id="telefono" required autocomplete="off" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
    name="telefono" value="<?php echo escapar($objeto->telefono); ?>" placeholder="Ej: 3, 4" min="1" max="10000000000">

</fieldset>