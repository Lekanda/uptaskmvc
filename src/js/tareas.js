// Al tener varios archivos js en un HTML(scripts) se pueden pisar las variables unas con otras. Para eso creamos esta funcion IIFE que hace que esa variable solo este disponible en esta funcion y no pasen a otro .js unido a un script..
(function() {
    // Boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>Añade una nueva Tarea</legend>
                <div class="campo">
                    <label for="tarea">Tarea:</label>
                    <input type="text" placeholder="Añadir Tarea al proyecto actual" id="tarea" name="tarea" />
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />
                    <button type="button" class="cerrar-modal" value="Cancelar" id="cancelar">Cancelar</button>
                </div>
            </form>
        `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 3000);


        document.querySelector('body').appendChild(modal);
    }

})();
// El () final para que se ejecute automaticamente la funcion.
/****************************  Fin IIFE ******************************/
