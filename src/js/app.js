const movilMenuBoton = document.querySelector('#mobile-menu');
const sidebar = document.querySelector('.sidebar');


if (movilMenuBoton) {
    movilMenuBoton.addEventListener('click',function(){
sidebar.classList.toggle('mostrar');
    });
}