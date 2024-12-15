let paso = 1; //definimos la variable en cual vamos a almacenar los taps 
const pasoInicial = 1; //definimos la variable minima de taps 
const pasoFinal = 3; //definimos la variable maxima de taps 

//Objeto con la infromacion de la cita
const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [

    ]
};

document.addEventListener('DOMContentLoaded', function() {  //Cuando todo el DOM este cargado, va a ejecutar esta funcion

    iniciarApp();
});


function iniciarApp() {
    
    mostrarSeccion(); //Muestra y oculta las secciones
    tabs(); //Cambia la sección cuando se de click en los tabs
    botonesPaginador(); //Agrega o quita los botones del paginador dependiendo la seccion en la que se encuentre
    paginaAnterior(); //Devuelve las paginas (secciones)
    paginaSiguiente(); //Avanza las paginas (secciones)
    consultarAPI(); //Consulta la API en el backend de PHP

    idCliente(); //Guardar el id del cliente en el objeto de cita
    nombreCliente();  //Guardar el nombre del cliente en el objeto de cita
    seleccionarFecha(); //Añade la fecha de la cita en el objeto de cita
    seleccionarHora(); //Añade la Hora de la cita en el objeto de cita
    mostrarResumen(); //Muestra el resumen de la cita

};

function mostrarSeccion() {
    //EN ESTA FUNCION PRIMERO ELIMINA LA CLASE DE 'MOSTRAR' A LA SECCION QUE LA TENGA, Y LUEGO SE LA AGREGA A LA QUE LE DE CLICK EN function tabs()

    //Ocultar la seccion que tenga la clase de 'mostrar'
    const seccionAnterior = document.querySelector('.mostrar'); //Seleccionamos la seccion que tenga la clase 'mostrar', lleva el . cuando esta dentro de un selector
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    //Seleccionar la sección con el paso.
    const pasoSeleccionado = `#paso-${paso}`;
    const seccionActual = document.querySelector(pasoSeleccionado); // Se usan `` porque lo vamos a mezclar con un selector de html
    seccionActual.classList.add('mostrar'); //Clase del cita.scss

    //Quita el blanco del tab anterior, quita la clase 'actual' del tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //Resalta en blanco el tab actual
    const tabActual = document.querySelector(`[data-paso="${paso}"]`); //ese selector es para los atributos personalizados
    tabActual.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button'); //No se le puedo agregar un addEventListener a una coleccion(ALL) por eso se hace con un forech
    
    botones.forEach( boton => {
        boton.addEventListener('click', function(e) {
            paso = parseInt(e.target.dataset.paso); //Para saber que paso es (data-paso="2"). parseInt Para volverlo numeros

            //Estas funciones se llaman para que cada ves que le de click a algun tab se cumpla lo de estas dos funciones 
            mostrarSeccion();
            botonesPaginador();

        });
    });
};

function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');
    
    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        
        mostrarResumen();
    }
    else {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}


function paginaAnterior () {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {
        
        if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador(); //Para que quite los botones cuando sea necesario
    });
}
function paginaSiguiente () {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {
        
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador(); //Para que quite los botones cuando sea necesario
    });
};


//Cuando es asincrona se va a ejecutar simultaneamente con otras funciones
async function consultarAPI() {

    //EL TRY-CATCH se intenta ejecutar lo que esta dentro del try, pero si no se puede muetra el error del catch, SIN QUE DEJE DE FUNCIONAR LA APLICACION
    try {
        const url = '/api/servicios'; //Va a ser la url que voy a consumir, la url que tiene la API
        //el AWAIT lo que hace es esperar a que se descarge todo, en este caso espera que se descargen todos los servicios
        const resultado = await fetch(url); //Funcion que nos va a permitir consumir el servicio de la url
        const servicios = await resultado.json();
    
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
};
//Consultar API para consultar las citas que ya estan ocupadas
async function consultarAPIcitasOcupadas() {
    try {
        const url = '/api/citas';
        const resultado = await fetch(url);
        const citasOcupadas = await resultado.json();
        return citasOcupadas; // Retorna las citas ocupadas como un arreglo

    } catch (error) {
        console.log(error);
    }
}


//Para ver los servicios en la interfaz
function mostrarServicios(servicios) {
    // Para recorrer cada uno de los servicios, pero es un arreglo
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;
        
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;
        
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id; //Atributo personalizado
        servicioDiv.onclick = function() { //Funcion que se va a ejecutar cuando de click en ese DIV
            seleccionarServicio(servicio);
        }  

        servicioDiv.appendChild(nombreServicio); //Le agregamos al div lo que esta nombreServicio
        servicioDiv.appendChild(precioServicio); //Le agregamos al div lo que esta precioServicio

        //Seleccionamos la parte donde queremos inyectar todo lo anterior (en esta caso de la vista del index del usuario en el paso de servicios)
        document.querySelector('#servicios').appendChild(servicioDiv);
    });

}


function seleccionarServicio(servicio) {
    const {id} = servicio;
    const {servicios} = cita; // Se extrae los servicios del obejeto cita

    //Identificamos el servicio al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    //Comprobar si un servicio ya fue agregado, para quitarlo en caso que asi se desee
    if(servicios.some(agregado => agregado.id === id)) { //.some devuelve true o falso si encuentra un elemento en el arreglo
        //Lo eliminamos
        cita.servicios = servicios.filter( agregado => agregado.id !== id );  //Filter nos permite sacar sierto elemento de un arreglo
        divServicio.classList.remove('seleccionado');

    }
    else {
        //Lo agregamos
        cita.servicios = [...servicios, servicio];  //(...servicios)->se toma una copia del arreglo servicios extraido previamente y se le va agregando el nuevo servicio
        divServicio.classList.add('seleccionado');
    }

    //console.log(cita);
}


function idCliente() {
    cita.id = document.querySelector('#id').value;
}
function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}


function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    
    inputFecha.addEventListener('input', function(e) {
        
        const dia = new Date(e.target.value).getUTCDay(); //getUTCDay para obtener el numero de dia de la semana (1-0)

        //Para saber si eligio sabado o domingo (Dias que no se pueden generar citas)
        if ( [0].includes(dia) ) {
            e.target.value = '';
            mostrarAlerta('Domingos No permitidos', 'error', '.formulario');
        } 
        else {
            cita.fecha = e.target.value;
            //console.log(cita);
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');

    inputHora.addEventListener('input', function(e) {

        const horaCita = e.target.value;
        const [hora, minutos] = horaCita.split(':').map(Number); // Extrae horas y minutos como números
        // const hora = horaCita.split(':')[0]; //splt permite separar una cadena de texto, toma como parametro el separador, el 0 es la posicion primera, osea la hora, no los minutos
        
        // Validar que la hora esté en intervalos de 30 minutos
        if (minutos !== 0 && minutos !== 30) {
            e.target.value = '';
            mostrarAlerta('Las citas solo se permiten cada 30 minutos', 'error', '.formulario');
        }
        // Verificamos si la hora está fuera del rango permitido
        if (hora < 8 || hora > 18) {
            e.target.value = '';
            mostrarAlerta('Hora selecciona no permitida', 'error', '.formulario');
        }
        else {
            cita.hora = e.target.value;
            //console.log(cita);
        }
    });
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar el contenido del resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan servicios, fecha u Hora', 'error', '.contenido-resumen', false);

        return;
    }

    //formatear el DIV de resumen
    const {nombre, fecha, hora, servicios} = cita;

    //HEADING para los servicios en el resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Servicios';
    resumen.appendChild(headingServicios);

    //Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const {id, precio, nombre} = servicio;  //Distrocios al objeto del servicio

        //Este va a tener toda la informacion del resumen en general
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(nombreServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    //HEADING para el usuario en el resumen
    const headingUsuario = document.createElement('H3');
    headingUsuario.textContent = 'Cita';
    resumen.appendChild(headingUsuario);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //Formatear la fecha en español
    const fechaObj = new Date(fecha); //el new DATE descuenta 1 dia 
    const mes = fechaObj.getMonth();  //Para obtener el mes (0 - 11)
    const dia = fechaObj.getDate() + 2; //Para obtener el dia del mes (0 - 30) y gatDay retorna el dia de la semana
    const year = fechaObj.getFullYear(); //Para obtener el año 

    const fechaUTC = new Date(Date.UTC(year, mes, dia)); //el new DATE descuenta 1 dia  UTC (Tiempo Universal Coordinado)

    const opciones = { weekday :'long',day:'numeric',month:'long',year:'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-CO', opciones);

    
    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    //Boton para crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}

async function reservarCita() {

    //PRIMERA OPCION
     const {nombre, fecha, hora, servicios, id} = cita;

     const idServicios = servicios.map(servicio => servicio.id); //el map itera y va  ir colocando las coincidencias en la variable
    // //console.log(idServicios);


    const datos = new FormData(); //Para enviar datos HTML mediante solicitudes HTTP, permite enviar datos al servidor sin recargar la página
    datos.append('fecha', fecha); //Append para agregar datos a un FORMDATA
    datos.append('hora', hora); //Append para agregar datos a un FORMDATA
    datos.append('usuarioId', id); //Append para agregar datos a un FORMDATA
    datos.append('servicios', idServicios); //Append para agregar datos a un FORMDATA
    //console.log([...datos]);
    
    try {
        
        //Petición hacia la API
        const url = '/api/citas';

       //fetch permite hacer solicitudes HTTP
        const respuesta = await fetch(url, {  //El await espera a que una funcion asincrona se complete y despues continua con la ejecucion del codigo
            method: 'POST', 
            body: datos
        }); 
        
        const resultado = await respuesta.json();
        console.log(resultado.resultado);
        //Notificacion de confirmacion de (sweetalert2.)
        if (resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: "Cita Confirmada",
                text: "Tu cita fue agendada correctamente",
                button: "OK"
                // footer: '<a href="#">Why do I have this issue?</a>' //Esto es como un enlace en caso de ayuda
            }).then( () => {         
                setTimeout(() => {
                    window.location.reload(); //Para que apenas le de OK al mensaje de la confirmacion se recargue la ventana
                }, 2000);
        
            })
        }

    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al agendar la cita",
        });
    }

        //console.log([...datos]); //toma una copia del formData y lo va a formatear dentro del arreglo
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {
    //Previene que se genere mas de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) { 
        alertaPrevia.remove();
    }  

    //Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    //Para que despues de 3 segundos, elimine el mensaje de alerta 
    if(desaparece) {
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}