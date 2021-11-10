<div class="contenedor olvide">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera cuenta UpTask</p>

        <form method="POST" action="/olvide" class="formulario">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    placeholder="Tu Email"
                >
            </div>
            <input type="submit" class="boton" value="Recuperar Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/crear">¿No tienes cuenta? Crear Una</a>
        </div>


    </div><!--.contenedor-sm-->
</div>