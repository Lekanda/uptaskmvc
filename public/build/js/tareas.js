!function(){!async function(){try{const e=`http://localhost:3000/api/tareas?url=${t()} `,a=await fetch(e),n=await a.json(),{tareas:o}=n;!function(e){if(0===e.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No hay tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const t={0:"Pendiente",1:"Completa"};e.forEach(e=>{const a=document.createElement("LI");a.dataset.tareaId=e.id,a.classList.add("tarea");const n=document.createElement("P");n.textContent=e.nombre;const o=document.createElement("DIV");o.classList.add("opciones");const r=document.createElement("BUTTON");r.classList.add("estado-tarea"),r.classList.add(""+t[e.estado].toLowerCase()),r.textContent=t[e.estado],r.dataset.estadoTarea=e.estado;const c=document.createElement("BUTTON");c.classList.add("eliminar-tarea"),c.dataset.idTarea=e.id,c.textContent="Eliminar",o.appendChild(r),o.appendChild(c),a.appendChild(n),a.appendChild(o);document.querySelector("#listado-tareas").appendChild(a),console.log(a)})}(o)}catch(e){console.log(e)}}();function e(e,t,a){if(document.querySelector(".alerta"))return;const n=document.createElement("DIV");n.classList.add("alerta",t),n.textContent=e,a.parentElement.insertBefore(n,a.nextElementSibling),setTimeout(()=>{n.remove()},2e3)}function t(){return new URLSearchParams(window.location.search).get("url")}document.querySelector("#agregar-tarea").addEventListener("click",(function(){const a=document.createElement("DIV");a.classList.add("modal"),a.innerHTML='\n            <form class="formulario nueva-tarea">\n                <legend>Añade una nueva Tarea</legend>\n                <div class="campo">\n                    <label for="tarea">Tarea:</label>\n                    <input type="text" placeholder="Añadir Tarea al proyecto actual" id="tarea" name="tarea" />\n                </div>\n                <div class="opciones">\n                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />\n                    <button type="button" class="cerrar-modal" value="Cancelar" id="cancelar">Cancelar</button>\n                </div>\n            </form>\n        ',setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),a.addEventListener("click",n=>{if(n.preventDefault(),n.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{a.remove()},500)}n.target.classList.contains("submit-nueva-tarea")&&function(){const a=document.querySelector("#tarea").value.trim();if(""===a)return void e("La tarea no tiene nombre","error",document.querySelector(".formulario legend"));!async function(a){const n=new FormData;n.append("nombre",a),n.append("proyectoId",t());try{const t="http://localhost:3000/api/tarea",a=await fetch(t,{method:"POST",body:n}),o=await a.json();if(console.log(o),e(o.mensaje,o.tipo,document.querySelector(".formulario legend")),"exito"===o.tipo){const e=document.querySelector(".modal");setTimeout(()=>{e.remove()},3e3)}}catch(e){console.log(e)}}(a)}()}),document.querySelector(".dashboard").appendChild(a)}))}();