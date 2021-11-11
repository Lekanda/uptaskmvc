<div class="contenedor crear">
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crear cuenta UpTask</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form method="POST" action="/crear" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text" 
                    name="nombre" 
                    id="nombre" 
                    placeholder="Tu Nombre"
                    value="<?php echo $usuario->nombre; ?>"
                >
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Tu Email"
                    value="<?php echo $usuario->email; ?>"
                >
            </div>
            <div class="campo">
                <label for="password">Contraseña</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Tu password"
                >
            </div>
            <div class="campo">
                <label for="password2">Repite Contraseña</label>
                <input 
                    type="password" 
                    name="password2" 
                    id="password2" 
                    placeholder="Repite password"
                    
                >
            </div>
            <input type="submit" class="boton" value="Crear Cuenta">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/olvide">¿Olvidaste tu Contraseña?</a>
        </div>


    </div><!--Fin.contenedor-sm-->
</div>