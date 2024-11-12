let paso=1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    nombre: '', 
    fecha: '', 
    hora: '', 
    servicios: [] 
}

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

    nombreCliente(); // Agregar el nombre del cliente al objeto de cita
    selccionarFecha(); // Agregar la fecha en el objeto cita
    selccionarHora(); // Agregar la hora en el objeto cita
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
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
        };

        //Agregar los elementos al contenedor div
        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        //Agregarlos a la vista
        document.querySelector('#servicios').appendChild(servicioDiv);

       // console.log(servicioDiv);      
    });
}

function seleccionarServicio(servicio) {

    const { id } = servicio;
    const { servicios } = cita;

    //Identificamos el elemento que se le dio click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);


    //Comprobar si un servicio ya se agrego
    if (servicios.some( agregado => agregado.id === id)) { //.some es para revisar si en un arreglo ya hay un objeto
        //Eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id); 
        divServicio.classList.remove('seleccionado');
    } else {
        //Agregarlo
        cita.servicios = [...servicios, servicio] //Tomamos una copia de servicios y agregamos un servicio en el objeto cita
        divServicio.classList.add('seleccionado');
    }
    console.log(cita);    
}

function nombreCliente() {
    const nombre = document.querySelector('#nombre').value;

    cita.nombre = nombre;    
}

function selccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e) {

        // Seleccionar fecha en solo en horario laboral
        const dia = new Date(e.target.value).getUTCDay(); //Traer el numero del dia
        /* Valores de los dias:
            domingo = 0
            lunes = 1
            martes = 2
            miercoles = 3
            jueves = 4
            viernes = 5
            sabado = 6
        */
       // console.log(dia);
        
            if ([0].includes(dia)) {
            //    console.log('el día domingo no hay servicio');
                e.target.value = '';  
                mostrarAlerta('Fecha inválida, los días domingos no hay servicio', 'error');           
            } else{
                cita.fecha = e.target.value;                    
            }
    });
}

function selccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {
        console.log();
        const horaCita = e.target.value;
        const hora = horaCita.split(":"); // para separar la hora de los min
        console.log(hora[0]);
        
    })   
}

function mostrarAlerta(mensaje, tipo) {

    //Para que no se creen multiples alertas
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) return;

    //Crear alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const formulario = document.querySelector('.formulario');
    formulario.appendChild(alerta);    

    //Eliminarla despues de 3s
    setTimeout(() => {
        alerta.remove();
    }, 3000);
}

