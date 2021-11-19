<?php include_once __DIR__ . '/header-dashboard.php'  ; ?>     


<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver a Perfil</a>

    <form action="/cambiar-password" method="POST" class="formulario">
        <div class="campo">
            <label for="password_actual">Password Actual:</label>
            <input 
                type="password" 
                id="password_actual"
                name="password_actual" 
                placeholder="Pon Tu Password Actual"
            >
        </div>
        <div class="campo">
            <label for="password_nuevo">Password Nuevo:</label>
            <input 
                type="password" 
                id="password_nuevo"
                name="password_nuevo" 
                placeholder="Pon tu nuevo Password"
            >
        </div>
        <div class="campo">
            <label for="password_nuevo2">Repite Password Nuevo:</label>
            <input 
                type="password" 
                id="password_nuevo2"
                name="password_nuevo2" 
                placeholder="Repite Password Nuevo"
            >
        </div>

        <input type="submit" value="Guardar Password Nuevo">
    </form>
</div>






<?php include_once __DIR__ . '/footer-dashboard.php'  ; ?>     