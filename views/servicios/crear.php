<?php 
    @include_once __DIR__ . '/../templates/barra.php'; 
    @include_once __DIR__ . '/../templates/alertas.php'; 
?>

<h1 class="nombre-pagina">Crear Servicios</h1>
<p class="descripcion-pagina">Creación de los servicios</p>

<form action="/servicios/crear" class="formulario" method="post">
    <?php @include_once __DIR__ . '/formulario.php'; ?>

    <input type="submit" class="boton" value="Guardar Servicio">
</form> 

