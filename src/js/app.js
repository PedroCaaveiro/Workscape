const movilMenuBoton = document.querySelector('#mobile-menu');
const cerrarMenuBoton = document.querySelector('#cerrar-menu');
const sidebar = document.querySelector('.sidebar');


if (movilMenuBoton) {
    movilMenuBoton.addEventListener('click',function(){
sidebar.classList.add('mostrar');
    });
}

if (cerrarMenuBoton) {
    cerrarMenuBoton.addEventListener('click',function(){
sidebar.classList.remove('mostrar');
    });
}