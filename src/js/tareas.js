// Al tener varios archivos js en un HTML(scripts) se pueden pisar las variables unas con otras. Para eso creamos esta funcion IIFE que hace que esa variable solo este disponible en esta funcion y no pasen a otro .js unido a un script..
(function() {
    // Boton para mostrar el Modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        console.log('Mostrando Form');
    }

})();
// El () final para que se ejecute automaticamente la funcion.
/****************************  Fin IIFE ******************************/
