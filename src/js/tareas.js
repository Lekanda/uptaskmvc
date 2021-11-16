// Al tener varios archivos js en un HTML(scripts) se pueden pisar las variables unas con otras. Para eso creamos esta funcion IIFE que hace que esa variable solo este disponible en esta funcion y no pasen a otro .js unido a un script..
(function() {

    obtenerTareas();


    // Boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    async function obtenerTareas(){
        try {
            const idproyecto = obtenerProyecto();
            const url = `http://localhost:3000/api/tareas?url=${idproyecto} `;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            const {tareas} = resultado;
            mostrarTareas(tareas);
            // console.log(tareas);
        } catch (error) {
            console.log(error);
        }
    }

    function mostrarTareas(tareas){
        if (tareas.length === 0){
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'No hay tareas';
            textoNoTareas.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTareas);
            return;
        }
        const estados ={
            0: 'Pendiente',
            1: 'Completada'
        }
        tareas.forEach(tarea => {
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            // Botones
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`)
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;

            console.log(btnEstadoTarea);

        })

    }




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

        // Eliminar la alerta despues de 5sg
        setTimeout(() => {
            alerta.remove();
        }, 2000);
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
            console.log(resultado);
            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));
            if(resultado.tipo === 'exito'){
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 3000);
            }
        } catch (error) {
            console.log(error);
        }
    }




    function obtenerProyecto(){
        // Coge los parametros de la URL
        const proyectoParamsURL = new URLSearchParams(window.location.search);
        const proyecto = proyectoParamsURL.get('url');
        return proyecto;
    }





})();
// El () final para que se ejecute automaticamente la funcion.
/****************************  Fin IIFE ******************************/