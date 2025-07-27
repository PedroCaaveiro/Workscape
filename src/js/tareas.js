(function () {

  obtenerTareas();

  let tareas = [];
  let filtradas = [];
  // boton para mostrar el modal de agregar tarea 
  const nuevaTarea = document.querySelector('#agregar-tarea');
  nuevaTarea.addEventListener('click', function(){
    mostrarFormulario();
  });

const filtros = document.querySelectorAll('#filtros input[type="radio"]');

//console.log(filtros);

filtros.forEach(radio =>{
  radio.addEventListener('input',filtrarTareas);
})
function filtrarTareas(e){
  const filtro = e.target.value;

  if (filtro !== '') {
    filtradas = tareas.filter(tareas => tareas.estado === filtro)
  }else{
    filtradas = [];
  }
 // console.log(filtradas);
 mostrarTareas();
}

  async function obtenerTareas() {

    try {
      const id = obtenerProyecto();
      const url = baseUrl + `api/tarea?id=${id}`;
      //console.log(url);
      const respuesta = await fetch(url);
      //console.log(respuesta);
      const resultado = await respuesta.json();
      //console.log(resultado.tareas);
      tareas = resultado.tareas;

      mostrarTareas();



    } catch (error) {
      console.log(error);
    }


  }
  function mostrarTareas() {
    //console.log(tareas);
    limpiarTareas();
    totalPendientes();
    totalCompletas();

    const arrayTareas =  filtradas.length ? filtradas : tareas;

    if (arrayTareas.length === 0) {
      const contenedorTareas = document.querySelector('#listado-tareas');
      contenedorTareas.innerHTML = '';
      const textotareas = document.createElement('LI');
      textotareas.textContent = 'No hay Tareas';
      textotareas.classList.add('no-tareas');
      contenedorTareas.appendChild(textotareas);
      return;

    }

    const estados = {
      0: 'Pendiente',
      1: 'Completa'
    };
    arrayTareas.forEach(tarea => {
      // console.log(tarea);
      const contenedorTarea = document.createElement('LI');
      contenedorTarea.dataset.tareaID = tarea.id;
      contenedorTarea.classList.add('tarea');
      const nombreTarea = document.createElement('P');
      nombreTarea.textContent = tarea.nombre;
      nombreTarea.ondblclick = function (){
        mostrarFormulario(editar = true, {...tarea});
      }

      const opcionesDiv = document.createElement('DIV');
      opcionesDiv.classList.add('opciones');

      const botonEstadotarea = document.createElement('BUTTON');
      botonEstadotarea.classList.add('estado-tarea');
      botonEstadotarea.classList.add(`${estados[tarea.estado]}`.toLowerCase());
      botonEstadotarea.textContent = estados[tarea.estado];
      botonEstadotarea.dataset.estadotarea = tarea.estado;
      botonEstadotarea.ondblclick = function () {
        cambiarEstado(tarea);
      };

     
   

      const botonEliminarTarea = document.createElement('BUTTON');
      botonEliminarTarea.classList.add('eliminar-tarea');
      botonEliminarTarea.dataset.idTarea = tarea.id;
      botonEliminarTarea.textContent = 'Eliminar';
      // console.log(botonEliminarTarea);
      botonEliminarTarea.ondblclick = function (){
        confirmarEliminarTarea({...tarea});
      }

      opcionesDiv.appendChild(botonEstadotarea);
      opcionesDiv.appendChild(botonEliminarTarea);

      contenedorTarea.appendChild(nombreTarea);
      contenedorTarea.appendChild(opcionesDiv);

      const listadoTareas = document.querySelector('#listado-tareas');
      listadoTareas.appendChild(contenedorTarea);

      //console.log(contenedorTarea);
    });

  }

  function mostrarFormulario(editar = false,tarea = {}) {
//console.log(editar);
//console.log(tarea);
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
   <form class="formulario nueva-tarea">
    <legend>${editar ? 'Editar Tarea' : 'Añade una nueva Tarea'} </legend>
    <div class="campo">
    <label>Tarea</label>
    <input
    type="text"
    name="nombre"
    placeholder="${tarea.nombre ? 'Editar la tarea ' : 'Añadir tarea al proyecto actual'}"
    id="tarea"
    value= "${tarea.nombre ? tarea.nombre : ''}"
    />
    </div>
     
    <div class="opciones">
    <input type="submit" class="submit-nueva-tarea" value="${tarea.nombre ? 'Editar la tarea ' : 'Añadir tarea'}"/>
    <button type="button" class="cerrar-modal">Cancelar</button>
    </form>
   
   `;
    // console.log(modal);
    setTimeout(() => {
      const formulario = document.querySelector('.formulario');
      formulario.classList.add('animar');
    }, 0);



    modal.addEventListener('click', function (e) {
      e.preventDefault();
      if (e.target.classList.contains('cerrar-modal')) {
        //console.log('si');
        const formulario = document.querySelector('.formulario');
        formulario.classList.add('cerrar');
        setTimeout(() => {
          modal.remove();
        }, 1500);


      } else {
        // console.log('no');
      }
      // console.log(e.target);
      if (e.target.classList.contains('submit-nueva-tarea')) {
          const nombreTarea = document.querySelector('#tarea').value.trim();
    // console.log(tarea);

    if (nombreTarea === '') {
      mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));
      return;

    }
        if (editar) {
          tarea.nombre = nombreTarea;
          actualizarTarea(tarea)
        }else{
        agregartarea(nombreTarea);
        }
      }

    });
    document.body.appendChild(modal);
  }


 

  function mostrarAlerta(mensaje, tipo, referencia) {

    const alertaPrevia = document.querySelector('.alertas');
    if (alertaPrevia) {
      alertaPrevia.remove();
    }

    const alerta = document.createElement('DIV');
    alerta.classList.add('alertas', tipo);


    alerta.textContent = mensaje;

    referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

    setTimeout(() => {

      alerta.remove();
    }, 5000);


  }
  async function agregartarea(nombreTarea) {
    const datos = new FormData();
    datos.append('nombre', nombreTarea);
    datos.append('proyectoId', obtenerProyecto());
    datos.append('estado', 0);




    //  console.log('URL de la API:', baseUrl + 'api/tarea'); 

    try {
      const url = baseUrl + 'api/tarea';
      const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
      });
      // console.log('ProyectoId enviado:', obtenerProyecto());
      // console.log('Respuesta del servidor:', respuesta); 

      const resultado = await respuesta.json();

      if (resultado.tipo === 'exito') {
        const modal = document.querySelector('.modal');
        setTimeout(() => {
          modal.remove();
        }, 3000);
        const tareaObj = {
          id: String(resultado.id),
          nombre: nombreTarea,
          estado: "0",
          proyectoId: resultado.proyectoId
        };

        tareas = [...tareas, tareaObj];
        mostrarTareas();
        //  console.log(tareaObj);


      }

      // console.log('Respuesta JSON:', resultado); 


      mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));
    } catch (error) {
      console.error('Error al enviar la tarea:', error);


    }
  }

  function cambiarEstado(tarea) {
    //console.log(tarea);

    const nuevoEstado = tarea.estado === '1' ? "0" : "1";
    tarea.estado = nuevoEstado;
    actualizarTarea(tarea);
    //console.log(tarea);
  }

  async function actualizarTarea(tarea) {
    //console.log(tarea);
   // return;
    const { estado, id, nombre } = tarea;
    const datos = new FormData();
    datos.append('id', id);
    datos.append('nombre', nombre);
    datos.append('estado', estado);
    datos.append('proyectoId', obtenerProyecto());
    /*for (let valor of datos.values()) {
      
      console.log(valor);
    }*/

    try {
      const url = baseUrl + 'api/tarea/actualizar';
      const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
      });
      //console.log(respuesta);
      const resultado = await respuesta.json();
      if (resultado.respuesta.tipo === 'exito') {
       Swal.fire(
        resultado.respuesta.mensaje,
        resultado.respuesta.mensaje,
        'success'
       )

       const modal = document.querySelector('.modal');
       if (modal) {
       modal.remove(); 
       }
       

        tareas = tareas.map(tareaMemoria => {
if (tareaMemoria.id === id) {
tareaMemoria.estado = estado;
tareaMemoria.nombre = nombre;
}
return tareaMemoria;
        });
        mostrarTareas();
      };


    } catch (error) {
      console.log(error);
    }

  }

  function obtenerProyecto() {

    const proyectoParametro = new URLSearchParams(window.location.search);
    const proyecto = Object.fromEntries(proyectoParametro.entries());
    return proyecto.id;
  }


  function limpiarTareas() {

    const listadoTareas = document.querySelector('#listado-tareas');
    while (listadoTareas.firstChild) {
      listadoTareas.removeChild(listadoTareas.firstChild);
    }
  }

function confirmarEliminarTarea(tarea){
Swal.fire({
  title: "Esta Usted Seguro?",
  text: "Luego ya no hay vuelta atras...",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "SI, Borrar!"
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: "Borrado!",
      text: "Tu archivo ha sido Eliminado",
      icon: "success"
    });
   // console.log('eliminando');
   eliminarTarea(tarea);
  }
});

}

async function eliminarTarea(tarea){

  
   const { estado, id, nombre } = tarea;
    const datos = new FormData();
    datos.append('id', id);
    datos.append('nombre', nombre);
    datos.append('estado', estado);
    datos.append('proyectoId', obtenerProyecto());
    try {
       const url = baseUrl + 'api/tarea/eliminar';
       const respuesta = await fetch(url,{
        method: 'POST',
        body: datos
       });
      // console.log(respuesta);
       const resultado = await respuesta.json();
       //console.log(resultado);
       if (resultado.resultado) {
       
        tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tarea.id);
        mostrarTareas();
       }
    } catch (error) {
      
    }

}

function totalPendientes(){
  const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
 
  const pendientesRadio = document.querySelector('#pendientes');

  if (totalPendientes.length === 0) {
    pendientesRadio.disabled = true;
  }else{
    pendientesRadio.disabled = false;
  }
   //console.log(totalPendientes);
}
function totalCompletas(){
const totalCompletas = tareas.filter(tarea => tarea.estado === "1");
 
  const completaRadio = document.querySelector('#completadas');

  if (totalPendientes.length === 1) {
    completaRadio.disabled = true;
  }else{
    completaRadio.disabled = false;
  }
  // console.log(totalPendientes);

}
})();

