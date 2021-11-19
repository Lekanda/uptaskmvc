<?php include_once __DIR__ . '/header-dashboard.php'  ; ?>     


<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambia Password</a>

    <form action="/perfil" method="POST" class="formulario">
        <div class="campo">
            <label for="nombre">Nombre:</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                value="<?php echo $usuario->nombre; ?>" 
                placeholder="Tu Nombre"
            >
        </div>
        <div class="campo">
            <label for="nombre">Email:</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="<?php echo $usuario->email; ?>" 
                placeholder="Tu Email"
            >
        </div>

        <input type="submit" value="Guardar Cambios">
    </form>
</div>






<?php include_once __DIR__ . '/footer-dashboard.php'  ; ?>     