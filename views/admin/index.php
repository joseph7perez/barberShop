<?php @include_once __DIR__ . '/../templates/barra.php'; ?>

<h1 class="nombre-pagina">Panel de Administracion</h1>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php 
    if (count($citas) === 0) {
        echo "<h2>No hay citas para este día</h2>";
    }
?>

<div class="citas-admin">
    <ul class="citas">
        <?php 
            foreach ($citas as $key => $cita) {
                if ($idCita !== $cita->id) {   
                    $idCita = $cita->id;
                    $total = 0;
        ?>

        <li>
            <p>ID: <span><?php echo $cita->id; ?></span></p>
            <p>Hora: <span><?php echo $cita->hora; ?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
            <p>Email: <span><?php echo $cita->email; ?></span></p>
            <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

            <h3>Servicios</h3>
            <?php } //Fin if
                $total += $cita->precio;
            ?>
            <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?></p>

            <?php 
                $actual = $cita->id;
                $proximo = $citas[$key + 1 ]->id ?? 0;
                 
                if (esUltimo($actual, $proximo)) { ?>
                      <p class="total">Total a pagar: <?php echo $total;?></p>  

                      <form action="/api/eliminar" method="post">
                        <input type="hidden" name="id" value="<?php echo $cita->id;?>"> <!--Para enviar el id de la cita a eliminar-->
                        <input type="submit" class="boton-eliminar" value="ELIMINAR"> 
                      </form>
            <?php  } ?>
        <?php } //Fin de foreach?>
    </ul>
   
</div>


<?php 
    $script = "<script src='build/js/buscador.js'> </script>"

?>