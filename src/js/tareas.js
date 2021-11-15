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
        }, 0);


        // Añadir funcion al boton Cancelar del modal
        modal.addEventListener('click', (e) => {
            e.preventDefault(); // para que el valor por default no funcione. En este caso es el submit del boton Añadir tarea

            if(e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
            if(e.target.classList.contains('submit-nueva-tarea')) {
                submitFormularioNuevaTarea();
            }
        })

        document.querySelector('.dashboard').appendChild(modal);
    }



    function submitFormularioNuevaTarea(){
        const tarea = document.querySelector('#tarea').value.trim();
        if(tarea === ''){
            // Mostrar una alerta de error
            mostrarAlerta('La tarea no tiene nombre', 'error',document.querySelector('.formulario legend'));
            return;
        } 
        agregarTarea(tarea);
        
    }



    // Mostrar una alerta de error
    function mostrarAlerta(mensaje,tipo,referencia){

        // Previene la creacion de alerta de error si ya existe una alerta de error
        if(document.querySelector('.alerta')){
            return;
        }

        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta',tipo);
        alerta.textContent = mensaje;
        // Inserta la alerta antes del legend. Sí ponemos el .appendChild(alerta) no funciona , pone el elemento dentro del legend
        referencia.parentElement.insertBefore(alerta,referencia.nextElementSibling);// lo pone antes del legend
        // console.log(referencia);
        // console.log(referencia.parentElement);
        // console.log(referencia.nextElementSibling);// nextElementSibling: pone el elemento despues del elemento que le pasamos como referencia

        // Eliminar la lerta despues de 5sg
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }



    // Agregar tarea al proyecto y a la DB
    async function agregarTarea(tarea) {
        // Construir la peticion API a /api/tarea
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', obtenerProyecto());  


        // para la peticion a la API
        try {
            const url = 'http://localhost:3000/api/tarea';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));
        } catch (error) {
            console.log(error);
        }
    }




    function obtenerProyecto(){
        // Coge los parametros de la URL
        const proyectoParamsURL = new URLSearchParams(window.location.search);
        const proyecto = proyectoParamsURL.get('url');
        // console.log(typeof proyecto);
        return proyecto;
    }





})();
// El () final para que se ejecute automaticamente la funcion.
/****************************  Fin IIFE ******************************/