<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="/" class="formulario" method="post">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email" value="<?php echo s($auth->email);?>">
    </div>

    <div class="campo">
        <label for="contrasena">Contraseña</label>
        <input type="password" id="contrasena" placeholder="******" name="contrasena">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/olvide">Olvide mi contraseña</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>