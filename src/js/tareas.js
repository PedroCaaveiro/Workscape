(function () {

obtenerTareas();

  // boton para mostrar el modal de agregar tarea 
  const nuevaTarea = document.querySelector('#agregar-tarea');
  nuevaTarea.addEventListener('click', mostrarFormulario);

async  function obtenerTareas(){

  try {
    const id = obtenerProyecto();
    const url = baseUrl + `api/tarea?id=${id}`;
    //console.log(url);
    const respuesta = await fetch(url);
    //console.log(respuesta);
    const resultado = await respuesta.json();
    //console.log(resultado.tareas);
    const{tareas} = resultado;
    mostrarTareas(tareas);



  } catch (error) {
    console.log(error);
  }


  }
  function mostrarTareas(tareas){
//console.log(tareas);
if (tareas.length === 0) {
  const contenedorTareas = document.querySelector('#listado-tareas');
  const textotareas = document.createElement('LI');
  textotareas.textContent = 'No hay Tareas';
  textotareas.classList.add('no-tareas');
  contenedorTareas.appendChild(textotareas);
  return;

}
tareas.forEach(tarea =>{
 // console.log(tarea);
 const contenedorTarea = document.createElement('LI');
 contenedorTarea.dataset.tareaID = tarea.id;
 contenedorTarea.classList.add('tarea');
 const nombreTarea = document.createElement('P');
 nombreTarea.textContent = tarea.nombre;
 console.log(nombreTarea);
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
      mostrarAlerta('El nombre de la tarea es obligatorio','error',document.querySelector('.formulario legend'));
      return;

    }
    agregartarea(tarea);
  }

  function mostrarAlerta(mensaje,tipo,referencia) {

const alertaPrevia = document.querySelector('.alertas');
if (alertaPrevia) {
  alertaPrevia.remove();
}

const alerta = document.createElement('DIV');
alerta.classList.add('alertas',tipo);


alerta.textContent = mensaje;

referencia.parentElement.insertBefore(alerta,referencia.nextElementSibling);

setTimeout(() =>{

alerta.remove();
},5000);

  }
  async function agregartarea(nombreTarea) {
    const datos = new FormData();
    datos.append('nombre', nombreTarea);
    datos.append('proyectoId',obtenerProyecto());
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
        

       }
        
       // console.log('Respuesta JSON:', resultado); 
        

    mostrarAlerta(resultado.mensaje,resultado.tipo,document.querySelector('.formulario legend'));
    } catch (error) {
        console.error('Error al enviar la tarea:', error);
        
       
    }
}

function obtenerProyecto(){

  const proyectoParametro = new URLSearchParams(window.location.search);
    const proyecto = Object.fromEntries(proyectoParametro.entries());
    return proyecto.id;
}

})();

