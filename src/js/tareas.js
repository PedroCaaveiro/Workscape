(function () {

  // boton para mostrar el modal de agregar tarea 
  const nuevaTarea = document.querySelector('#agregar-tarea');
  nuevaTarea.addEventListener('click', mostrarFormulario);


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
    name="tarea"
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
    agregartarea();
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

  //  console.log('URL de la API:', baseUrl + 'api/tarea'); // Para verificar la URL

    try {
        const url = baseUrl + 'api/tarea';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        console.log('Respuesta del servidor:', respuesta); 
       // const respuestaJson = await respuesta.json(); 
      //  console.log('Respuesta JSON:', respuestaJson); 

      

    } catch (error) {
        console.error('Error al enviar la tarea:', error);
       
    }
}


})();

