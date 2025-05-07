(function() {

    // boton para mostrar el modal de agregar tarea 
const nuevaTarea = document.querySelector('#agregar-tarea');
nuevaTarea.addEventListener('click',mostrarFormulario);


function mostrarFormulario(){

   const modal = document.createElement('DIV');
   modal.classList.add('modal');
   modal.innerHTML= `
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
  },0);



  modal.addEventListener('click',function(e){
      //  e.preventDefault();
        if (e.target.classList.contains('cerrar-modal')) {
            //console.log('si');
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('cerrar');
            setTimeout(() => {
                modal.remove();
              },1500); 
           

        }else{
           // console.log('no');
        }
       // console.log(e.target);
  });
  document.body.appendChild(modal);
}

})();

