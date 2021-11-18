// Al tener varios archivos js en un HTML(scripts) se pueden pisar las variables unas con otras. Para eso creamos esta funcion IIFE que hace que esa variable solo este disponible en esta funcion y no pasen a otro .js unido a un script..
(function() {

    obtenerTareas();
    let  tareas = [];


    // Boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', function() {
        mostrarFormulario();
    });

    async function obtenerTareas(){
        try {
            const idproyecto = obtenerProyecto();
            const url = `http://localhost:3000/api/tareas?url=${idproyecto} `;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            // console.log('Resultado');
            // console.log(resultado);

            tareas = resultado.tareas;
            mostrarTareas();
            // console.log(tareas);
        } catch (error) {
            console.log(error);
        }
    }




    function mostrarTareas(){
        limpiarTareas();
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
            1: 'Completa'
        }
        tareas.forEach(tarea => {
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function(){
                mostrarFormulario(editar=true,{...tarea});
            };

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            // Botones
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`)
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;
            btnEstadoTarea.ondblclick = function () { 
                cambiarEstadoTarea({...tarea});
            };

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idTarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';
            btnEliminarTarea.ondblclick = function () { 
                confirmarEliminarTarea({...tarea});
            };

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);
            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTarea);

            // console.log(contenedorTarea);
            // console.log(btnEstadoTarea);

        })

    }




    function mostrarFormulario(editar = false,tarea = {}) {
        console.log(tarea);
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar tarea' : 'Añade una nueva Tarea'}</legend>
                <div class="campo">
                    <label for="tarea">Tarea:</label>
                    <input 
                        type="text" 
                        placeholder="${tarea.nombre ? 'Edita tu Tarea' : 'Nombre de tu Tarea'}" 
                        id="tarea" 
                        name="tarea" 
                        value="${tarea.nombre ? tarea.nombre : ''}"
                    />
                </div>
                
                <div class="opciones">

                    <input 
                        type="submit" 
                        class="submit-nueva-tarea" 
                        value="${tarea.nombre ? 'Editar' : 'Crear'}" 
                    />
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
                const nombreTarea = document.querySelector('#tarea').value.trim();
                if(nombreTarea === ''){
                    // Mostrar una alerta de error
                    mostrarAlerta('La tarea no tiene nombre', 'error',document.querySelector('.formulario legend'));
                    return;
                } 

                if(editar) {
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                }else{
                    agregarTarea(nombreTarea);
                }
        
            }
        });

        document.querySelector('.dashboard').appendChild(modal);
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

                }, 2000);

                // Agregar el objeto de tarea al global de tarea
                const tareaObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: "0",
                    proyectoId: resultado.proyectoId
                }
                tareas = [...tareas, tareaObj];
                mostrarTareas();
                // console.log(tareaObj);
            }
        } catch (error) {
            console.log(error);
        }
    }



    function cambiarEstadoTarea(tarea) { 
        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;
        actualizarTarea(tarea);
        // console.log(tarea);
        // console.log(tareas);
    }




    async function actualizarTarea(tarea) { 
        // Tarea del formulario cambiada
        const {estado,nombre,id,proyectoId} = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());

        // Para leer 'datos'
        // for(let valor of datos.values()){
        //     console.log(valor);
        // }

        try {
            const url = 'http://localhost:3000/api/tarea/actualizar';

            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            if(resultado.respuesta.tipo === 'exito'){
                Swal.fire(
                    resultado.respuesta.mensaje,
                    resultado.respuesta.mensaje,
                    'success',
                );
                console.log(resultado);
                const modal = document.querySelector('.modal');
                if(modal) {
                    modal.remove();
                }
                    


                tareas = tareas.map(tareaMemoria => {
                    if(tareaMemoria.id === id){
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    }
                    // este return asigna a tareas los datos cambiados de 'tareaMemoria'
                    return tareaMemoria;
                });
                mostrarTareas();
            }
        } catch (error) {
            console.log(error);
        }
    }


    function confirmarEliminarTarea(tarea) { 
        Swal.fire({
            title: 'Eliminar tarea?',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            } 
        })
    }

    async function eliminarTarea(tarea) {
        const {estado,nombre,id} = tarea;
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());
        try {
            const url = 'http://localhost:3000/api/tarea/eliminar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            if(resultado.resultado){
                // Mensaje con SweetAlert2
                Swal.fire('Eliminado!',resultado.mensaje,'success');

                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== id);
                mostrarTareas();
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



    function limpiarTareas() {
        const listadoTareas = document.querySelector('#listado-tareas');
        while (listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
            
    }



})();
// El () final para que se ejecute automaticamente la funcion.
/****************************  Fin IIFE ******************************/