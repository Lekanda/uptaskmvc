<div class="contenedor login">
    <h1 class="uptask">UpTask</h1>
    <p class="tagline">Crea y Administra tus Proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesion</p>

        <form method="POST" action="/" class="formulario">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    placeholder="Tu Email"
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
            <input type="submit" class="boton" value="Iniciar Sesion">
        </form>

        <div class="acciones">
            <a href="/crear">¿Aun no tienes una Cuenta? Crea una</a>
            <a href="/olvide">¿Olvidaste tu Contraseña?</a>
        </div>


    </div><!--.contenedor-sm-->
</div>