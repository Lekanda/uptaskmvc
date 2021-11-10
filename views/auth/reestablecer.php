<div class="contenedor reestablecer">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Reestablece tu Contraseña</p>

        <form method="POST" action="/reestablecer" class="formulario">
            <div class="campo">
                <label for="password">Contraseña</label>
                <input type="password" name="password" id="password" placeholder="Tu password">
            </div>
            <div class="campo">
                <label for="password2">Repite Contraseña</label>
                <input type="password" name="password2" id="password2" placeholder="Repite password">
            </div>

            <input type="submit" class="boton" value="Reestablece contraseña">
        </form>

        <div class="acciones">
            <a href="/crear">¿Aun no tienes una Cuenta? Crea una</a>
            <a href="/olvide">¿Olvidaste tu Contraseña?</a>
        </div>


    </div>
    <!--.contenedor-sm-->
</div>