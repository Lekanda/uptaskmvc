document.querySelector("#agregar-tarea").addEventListener("click",(function(){const a=document.createElement("DIV");a.classList.add("modal"),a.innerHTML='\n            <form class="formulario nueva-tarea">\n                <legend>Añade una nueva Tarea</legend>\n                <div class="campo">\n                    <label for="tarea">Tarea:</label>\n                    <input type="text" placeholder="Añadir Tarea al proyecto actual" id="tarea" name="tarea" />\n                </div>\n                <div class="opciones">\n                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />\n                    <button type="button" class="cerrar-modal" value="Cancelar" id="cancelar">Cancelar</button>\n                </div>\n            </form>\n        ',setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),document.querySelector("body").appendChild(a)}));