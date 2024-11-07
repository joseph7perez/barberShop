<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Diligencia el formulario</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="/crear-cuenta" class="formulario" method="post">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($usuario->nombre)?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php echo s($usuario->apellido)?>">
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" placeholder="###" name="telefono" value="<?php echo s($usuario->telefono)?>">
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo s($usuario->email)?>">
    </div>

    <div class="campo">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" placeholder="******" name="contrasena">
    </div>
    <div class="campo">
        <label for="contrasenaC">Confirmar contraseña</label>
        <input type="password" id="contrasenaC" placeholder="******" name="contrasenaC">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">Ya tengo una cuenta</a>
</div>