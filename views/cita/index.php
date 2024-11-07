<h1 class="nombre-pagina">Crear una Cita</h1>
<p class="descripcion-pagina">Elige un servicio: </p>

<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Reserva</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">¿Cuál servicio deseas?</p>
        <div class="listado-servicios" id="servicios">
            
        </div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Reserva</h2>
        <p class="text-center" >Ingresa tus datos</p>
        <form action="" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre" value="<?php echo $nombre ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>
        </form>
    </div>
    <div id="paso-3" class="seccion">
        <h2>Resumen Cita</h2>
        <p class="text-center" >Verifica que todo este correcto</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button> <!--&laquo; son unas flechas hacia atras-->
        <button id="siguiente" class="boton">Siguiente &raquo;</button> <!--&raquo; son unas flechas hacia adelante-->

    </div>
</div>

<?php 
    $script = " <script src='build/js/app.js'></script> ";

?>