<h1 class="nombre-pagina">Recuperar contraseña</h1>
<p class="descripcion-pagina">Reestablece tu contraseña con tu email</p>

<form action="/olvide" class="formulario" method="post">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email">
    </div>

    <!-- <div class="campo">
        <label for="password">Contraseña nueva</label>
        <input type="password" id="password" placeholder="******" name="password">
    </div> -->

    <input type="submit" class="boton" value="Continuar">
</form>

<div class="acciones">
    <a href="/">Inicio de sesión</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>