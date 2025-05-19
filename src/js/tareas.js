(function () {

  obtenerTareas();

  let tareas = [];
  // boton para mostrar el modal de agregar tarea 
  const nuevaTarea = document.querySelector('#agregar-tarea');
  nuevaTarea.addEventListener('click', mostrarFormulario);

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
    if (tareas.length === 0) {
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
    tareas.forEach(tarea => {
      // console.log(tarea);
      const contenedorTarea = document.createElement('LI');
      contenedorTarea.dataset.tareaID = tarea.id;
      contenedorTarea.classList.add('tarea');
      const nombreTarea = document.createElement('P');
      nombreTarea.textContent = tarea.nombre;
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

      // Un solo clic para cambiar el estado
    contenedorTarea.addEventListener('click', function (event) {
      // Evitar que el clic en el botón de estado cambie el estado
      if (!event.target.classList.contains('estado-tarea')) {
        cambiarEstado(tarea);
      }
    });

      const botonEliminarTarea = document.createElement('BUTTON');
      botonEliminarTarea.classList.add('eliminar-tarea');
      botonEliminarTarea.dataset.idTarea = tarea.id;
      botonEliminarTarea.textContent = 'Eliminar';
      // console.log(botonEliminarTarea);

      opcionesDiv.appendChild(botonEstadotarea);
      opcionesDiv.appendChild(botonEliminarTarea);

      contenedorTarea.appendChild(nombreTarea);
      contenedorTarea.appendChild(opcionesDiv);

      const listadoTareas = document.querySelector('#listado-tareas');
      listadoTareas.appendChild(contenedorTarea);

      //console.log(contenedorTarea);
    });

  }

  function mostrarFormulario() {

    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = `
   <form class="formulario nueva-tarea">
    <legend> Añade una nueva Tarea</legend>
    <div class="campo">
    <label>Tarea</label>
    <input
    type="text"
    name="nombre"
    placeholder="Añadir Tarea al Proyecto Actual"
    id="tarea"
    />
    </div>
     
    <div class="opciones">
    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea"/>
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
        submitFormularioTarea();
        // console.log('le diste click');
      }

    });
    document.body.appendChild(modal);
  }


  function submitFormularioTarea() {

    const tarea = document.querySelector('#tarea').value.trim();
    // console.log(tarea);

    if (tarea === '') {
      mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));
      return;

    }
    agregartarea(tarea);
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
        mostrarAlerta(resultado.respuesta.mensaje,
          resultado.respuesta.tipo,
          document.querySelector('.contenedor-nueva-tarea'));

        tareas = tareas.map(tareaMemoria => {
if (tareaMemoria.id === id) {
tareaMemoria.estado = estado;
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

})();

