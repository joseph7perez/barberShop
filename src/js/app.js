let paso=1;
const pasoInicial = 1;
const pasoFinal = 3;

document.addEventListener("DOMContentLoaded", function () {
    iniciarApp();
})

function iniciarApp() {
    mostrarSeccion(); // Mostrar la primera seccion 
    tabs(); // Cambio de seccion al presionar tabs
    botonesPaginador(); // Agregar o quitar los botones del paginador
    paginaSiguiente();
    paginaAnterior();
    consultarAPI(); //Consulta la API en el backend de PHP
}

function mostrarSeccion() {

    // Ocualtar la seccion que tenga la clase mostrar
    const seccionAnterior = document.querySelector('.mostrar'); //Mostrar solo una seccion a la vez
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    // Seleccionar la seccion con el paso o boton seleccionado
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);

    seccion.classList.add('mostrar'); //clase en _cita.scss 

    // Eliminar clase actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //Resaltar el boton del tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');    
}

function tabs() {
    const botones = document.querySelectorAll(".tabs button")

  //  console.log(botones);

    botones.forEach( boton => {
        boton.addEventListener("click", function (e) {
            paso = parseInt( e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();

        });
    } )   
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');    
        paginaSiguiente.classList.remove('ocultar');    
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');    
     
    } else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    })
}

async function consultarAPI() {

    try {
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
        
    } catch (error) {
        console.log(error);
    } 
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio; //Aplicamos destructuring

        //Creamos los elemento del html
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = '$' + precio;

        //Contenedor que contenga los servicios
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        //Agregar los elementos al contenedor div
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        //Agregarlos a la vista
        document.querySelector('#servicios').appendChild(servicioDiv);

        console.log(servicioDiv);      
    });
}