
var seleccion_actual = 1;
function inicio() {
    listardatos(1);
    // pendientes();
    
    // mostrarcheckbox();
    // ejecutaeventos();
    // clasedeldia();
    // // graficoingreso();
    

    // $("#formularioencuesta").on("submit",function(e3){
	// 	guardarencuesta(e3);	
	// });

    // $("#btnMapas").hide();
    // $("#formulariomapas").on("submit",function(e4){
	// 	vermapas(e4);	
	// });

    // mostrartoast();

    
    // ejecuta si el perfil esta actualizado
    // verperfilactualizado();
    // // ejecuta losdatos fijos del dashboard
    // listardatosfijos();

    // $("#formularioperfil").on("submit",function(e2){
	// 	actualizarperfil(e2);	
	// });
    // 		//Cargamos los items al select ejes
	// $.post("../controlador/dashboardest.php?op=selectDepartamento", function(r){

    //     $("#departamento_res").html(r);

    // });
    
   

}
function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Panel estudiante',
				intro: '¡Bienvenido a tus experiencias creativas,para nosotros es de gran alegria poder darte el nombre de ser original,porque eso es lo que eres una persona llena de creatvidad e innovación entre otras cualidades que te hacen ser unico(a) y que tu paso por nuestra institución sea memorable!'
			},
			{
				title: 'programas',
				element: document.querySelector('#m-paso1'),
				intro: "Da un vistazo a tus respectivos programas de tu elección con el que decidiste convertirte en un profesional creativo e innovador de la mano de nuestros docentes y la institución en general te apoyaremos en cada uno de tus pasos"
			},
			
            {
				title: 'Recursos digitales',
				element: document.querySelector('#m-paso2'),
				intro: "Apoyate con estos increibles recursos que como ser orignal tienes acceso, herramientas que te pueden ayudar a lo largo de tu trayectoria recibiendo diferentes experiencias creativas e innovadoras "
			},


            {
				title: 'Caracterización',
				element: document.querySelector('#m-paso3'),
				intro: "Ayudanos a formar un lazo cada ves más familiar contigo realizando tu inscripción como ser original caracterizado, para desarrollar todas nuestras estrategias de bienestar, mercadeo y extensión"
			},
            

            {
				title: '¡Historial académico',
				element: document.querySelector('#m-paso4'),
				intro: "Aquí podrás encontrar toda tu historia en este laberinto del saber,revive tu trayectoria revisando un poco sobre tu historial académico"
			},

            {
				title: 'Mis certificados',
				element: document.querySelector('#m-paso5'),
				intro: "Lleva un control de los diferentes certificados que puedes solicitar en  el área de registro y control en nuestra institución"
			},

            {
				title: 'Renovación',
				element: document.querySelector('#m-paso6'),
				intro: "Como ser original debe ser muy importante para ti  realizar la renovación tanto financiera como académica, una ves culmines satisfactoriamente puedes hacer tu renovación para que sigas siendo parte de el parche creativo más grande del eje cafetero "
			},

            {
				title: 'Mi financiación',
				element: document.querySelector('#m-paso7'),
				intro: "Para nosotros la confianza que tenemos en ti es muy importante es por eso que tambien debes de llevar un control de tu financiación y nos ayudes a que sigas siendo parte de este parche creativo e innovador"
			},

            {
				title: 'Pagos generales',
				element: document.querySelector('#m-paso8'),
				intro: "Aquí podrás encontrar un control de todos los pagos que has realizado de diferentes requerimientos a lo largo de todo tu esfuerzo y empeño"
			},

            {
				title: 'Mi carnet',
				element: document.querySelector('#m-paso9'),
				intro: "Para nosotros es muy importante reconocerte como un ser original de nuestra institución, aqui podras encontrar tu carnet que te identifica como un ser original de nuestro centro de idiomas"
			},

            {
				title: 'Idiomas',
				element: document.querySelector('#m-paso10'),
				intro: "Da un vistazo a nuestro centro de idiomas donde podras observar el nivel de inglés que estas cursando y los que te faltan por cursar de nuestro módulo, recuerda que es un requisito de grado haber cursado el módulo de manera satisfactoria en tu respectivo semestre"
			},

            {
				title: 'PQRS',
				element: document.querySelector('#m-paso11'),
				intro: "Aquí podrás dejar todas tus preguntas,quejas,reclamos y sugerencias ayudándonos así a mejorar como institución y cada ves seguir siendo el mejor parche creativo e innovador de todo el eje cafetero "
			},

            {
				title: 'QR',
				element: document.querySelector('#t-paso12'),
				intro: "¡Tu propio QR para escanear!"
			},

            {
				title: 'Salir',
				element: document.querySelector('#t-paso13'),
				intro: "Culmina tus experiencias creativas del día cerrando sesión, para empezar un nuevo día con las espectativas de siempre aprender algo nuevo mediante las expeiencias que te brinda nuestra intución soñando que seas un ser original creativo(a) e innovador(a)"
			
			},
            {
				title: 'Faltas',
				element: document.querySelector('#t-paso14'),
				intro: "Aquí podrás observar tus faltas reportadas por tu respectivo docente"
			},
            {
				title: 'Notas',
				element: document.querySelector('#t-paso15'),
				intro: "Aquí podrás observar tus notas subidas por tu respectivo docente, anteriormente obtenidas por las respectivas experiencias creativas "
			},
            {
				title: 'Actividades',
				element: document.querySelector('#t-paso16'),
				intro: "Enterate de todas las actividades propuestas por tu docente que seguramente serán de todo tu agrado para así seguir viviendola creatividad al máximo "
			},
            {
				title: 'Clases del día',
				element: document.querySelector('#t-paso17'),
				intro: "Da un vistazo a tus clases y preparate para la experiencia creativa del día"
			},
            {
				title: 'Perfil',
				element: document.querySelector('#t-paso18'),
				intro: "Enterate de todos los seres originales que conforman nuestra institución y cada ves son más los que deciden sumarse a este parche creativo"
			},

            {
				title: 'Dirección residencia',
				element: document.querySelector('#t-paso19'),
				intro: "¡Valida aquí tu lugar de recidencia!"
			},

            {
				title: 'Estoy Caracterizado',
				element: document.querySelector('#t-paso20'),
				intro: "Aquí podrás encontrar la fecha desde que estas caracterizado y te convertiste en un completo ser original"
			},

            {
				title: 'Novedades',
				element: document.querySelector('#t-paso21'),
				intro: "Enterate de todas nuestras novedades e innovaciones que tenemos para ti"
			},

            {
				title: 'Ingresos campus',
				element: document.querySelector('#t-paso22'),
				intro: "Ten un control de todos tus ingresos a nuestro campus virtual "
			},
            {
				title: 'Calendario',
				element: document.querySelector('#t-paso23'),
				intro: "Entérate de todos nuestros eventos académicos programados para ti fomentando un espacio diferente donde podrás dejarte llevar por la creatividad e innovación de nuestras experiencias creativas"
			},

            {
				title: 'Vuelvete emprendedor',
				element: document.querySelector('#t-paso24'),
				intro: "Formate permanentemente con nuestros programas innovadores y basados en tecnologia que se amolda a los requerimientos de la empresa o comunidad para que sigas preparando e innovando en nuestro parche cretivo y educativo mas grande del eje cafetero"
			},

            {
				title: 'Calendario eventos',
				element: document.querySelector('#t-paso25'),
				intro: "Enterate de todas nuestras experiencias transformadoras que mejoran la calidad de vida de seres originales como tú, docentes, colaboradores y sus familias incluyendo a tus inspiradores donde construirás un lazo de confianza,amor,amistad y respeto"
			},

            {
				title: 'Ajustes',
				element: document.querySelector('#m-paso26'),
				intro: "Personaliza como tu quieras el campus virtual con tu perfil, donde te podrás apropiar realmente de tu espacio virtual y seguro de nuestra institución "
			},
            
            {
				title: 'salir',
				element: document.querySelector('#m-paso27'),
				intro: "Culmina tus experiencias creativas del día cerrando sesión, para empezar un nuevo día con las espectativas de siempre aprender algo nuevo mediante las expeiencias que te brinda nuestra intución soñando que seas un ser original creativo(a) e innovador(a)"
			},

        


        







		]
			
	},
	
	
	).start();



}



function jornada_PAT(){
    $.post("../controlador/dashboardest.php?op=jornada_PAT", function (data) {
        data = JSON.parse(data);
        if (Object.keys(data).length > 0 ) {
            img = '';
            for (let index = 0; index < Object.keys(data).length; index++) {
                img += '<img src="../public/img/jornadas_pat/'+data[index]+'" width="100%">';
             }
            $("#modelopat").html(img);
        }else{
            //init events y calendario
            init_events($('#external-events div.external-event'));
            
        }
    });
}




/* initialize the external events-----------------------------------------------------------------*/
function init_events(ele) {
    ele.each(function () {
    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
    // it doesn't need to have a start or end
    var eventObject = {
        title: $.trim($(this).text()) // use the element's text as the event title
    }
    // store the Event Object in the DOM element so we can get to it later
    $(this).data('eventObject', eventObject)
    })
}


/* Función para limpiar el formulario al momento de cancelar la acción*/
function LimpiarFormulario(){
    $('#modalCalendarioLabel').html('Agregar Evento');
    $('#idActividad').val('');
    $('#txtTitulo').val('');
    $('#txtFechaInicio').val('');
    $('#txtFechaFin').val('');
    $('#txtColor').val('');
}

function mostrartoast(){
    $.ajax({
        
        type:'POST',
		url:'../controlador/dashboardest.php?op=alertacalendario',
		success:function(alerttoast){
        
            var alertavacia = alerttoast;
            if(alertavacia == null || alertavacia == undefined || alertavacia == "" ){
                $('.toast').toast('hide')

            } else {

           // $('.toast').toast('show');
            $("#alerta_calendario_toast").html(alerttoast);

        }},
	});
}



function listardatos(rango){
    
    // seleccion_actual = rango;
    // var contador=1;
    //     while(contador <= 4){
    //         $("#opcion"+contador).removeClass("activo"); 
    //         contador++;
    //     }
    //         $("#opcion"+rango).addClass("activo");

    $.post("../controlador/dashboardest.php?op=listardatos",{rango:rango},function(datos){
        var r = JSON.parse(datos);
            console.log(r)
            $("#dato_ingresos").html(r.totalingresos);
            // $("#dato_actividades").html(r.totalactividades);
            $("#dato_faltas").html(r.totalfaltas);
            $("#dato_notas_reportadas").html(r.totalnotareportada);
            // $("#dato_clasedeldia").html(r.totalclasededia);
            $("#dato_perfil_actualizado").html(r.perfil);
            $("#clasedeldiaa").html(r.clase);
    });
    


            

     
}


function mostrar_nombre_estudiante(rangoestudiante){
    
    $.post("../controlador/dashboardest.php?op=mostrar_nombre_estudiante&rangoestudiante="+seleccion_actual, function (e) {
     
        var r = JSON.parse(e);
        $("#myModalIngresosEstudiantes").modal("show");
        $("#datosusuario_estudiante").html(r);
        $('#mostrarestudiantesnombre').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                
            ],
    
        });
        
        
    });

}


function mostrar_faltas(rangofaltas){
    
    $.post("../controlador/dashboardest.php?op=mostrar_faltas&rangofaltas="+seleccion_actual, function (e) {

        var r = JSON.parse(e);
        $("#myModalFaltas").modal("show");
        $("#datosusuario_faltas").html(r);

        $('#mostrarfaltas').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                
            ],
    
        });
        
    });
}


function mostraractividadesnuevas(mostraractividadesnuevas){
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    
    // var trae_id_docente_grupo=$("#mostrar_id_docente").val();


    $.post("../controlador/dashboardest.php?op=mostraractividadesnuevas&mostraractividadesnuevas="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {

        var r = JSON.parse(e);
        $("#myModalActividadesdocente").modal("show");
		$("#datosusuario_mostraractividades").html(r);
        $("#myModalActividades").modal("hide");
        $('#activdadespordocente').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                
            ],
    
        });
        
    });
}

//muestra las activades del estudiante por materia
function mostraractividades(trae_id_docente_grupo){
	$("#myModalActividadesdocente").modal("show");
	$("#trae_id_docente_grupo").val(trae_id_docente_grupo);	
	
}


function notasreportadas(rangonotasreportadas){
    
    $.post("../controlador/dashboardest.php?op=notasreportadas&rangonotasreportadas="+seleccion_actual, function (e) {
       
        var r = JSON.parse(e);
        $("#myModalNotasReportada").modal("show");
		$("#datosusuario_nota_reportada").html(r);

        $('#notasreportadas').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                
            ],
    
        });
        
    });
}


function clasedeldia(clasedeldia){
    
    $.post("../controlador/dashboardest.php?op=clasedeldia&clasedeldia="+seleccion_actual, function (e) {
        var r = JSON.parse(e);
		$("#clasedeldiaa").html(r);
        $('#clasedia').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                
            ],
    
        });
        mostrarclasesdeldia();
        
    });
}


/* para los datos del dashboard que son fijos */
function listardatosfijos(){
    $.post("../controlador/dashboardest.php?op=listardatosfijos", function (e) {
        var r = JSON.parse(e);
        $("#dato_perfil_actualizado").html(r.perfilactualizado);
        $("#dato_caracterizados").html(r.caracterizado);
        
    });
}

function verperfilactualizado() {
    $.post("../controlador/dashboardest.php?op=verperfilactualizado", function (datos) {     
        var r = JSON.parse(datos);
        if(r.estado==2){// paso el tiempo es hora de actualizar
            mostrar();
        }else{
            $("#perfil").modal("hide");// perfil esta actaulziado detro del rango
        }
    });
}

function mostrar(){
	$.post("../controlador/dashboardest.php?op=mostrar",{}, function(data, status){
		data = JSON.parse(data);
        $("#email").val(data.email);
        $("#estrato").val(data.estrato);
		$("#telefono").val(data.telefono);
		$("#celular").val(data.celular);
        $("#barrio").val(data.barrio);
        $("#direccion").val(data.direccion);

        $("#perfil").modal({backdrop: 'static', keyboard: false});
        $("#perfil").modal("show");
   
    });
}

function actualizarperfil(e2)
{
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioperfil")[0]);

	$.ajax({
		url: "../controlador/dashboardest.php?op=actualizarperfil",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
            data = JSON.parse(datos);
            if(data.estado="si"){
                alertify.success("Datos actualizados");
                verperfilactualizado();
                listardatosfijos();	 
            }else{
                alertify.error("Datos no actualizados");
            }	
            
	    }
	});
	
}


/* *****  para la encuesta ****** */
function verificarencuesta(){
    $.post("../controlador/dashboardest.php?op=verificarencuesta", function(r){
        data = JSON.parse(r);
        if(data.estado!="1"){
            encuesta();
            listardocentesactivos();
        }else{
            $("#myModalEncuesta").modal("hide");
        }
    });
}

function encuesta(){
    $("#myModalEncuesta").modal({backdrop: 'static', keyboard: false});
    $("#myModalEncuesta").modal("show");
}

function listardocentesactivos(){

    $.post("../controlador/dashboardest.php?op=listardocentesactivos", function(r){
        $("#pre3").html(r);
        $('#pre3').selectpicker('refresh');
    });
}


function guardarencuesta(e3)
{
	e3.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioencuesta")[0]);

	$.ajax({
		url: "../controlador/dashboardest.php?op=guardarencuesta",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
            data = JSON.parse(datos);
            if(data.estado="1"){
                alertify.success("Encuesta enviada");
                verificarencuesta(); 
            }else{
                alertify.error("Encuesta errada");
            }	
            
	    }
	});
	
}

function ejecutaeventos(){
    // -------------------------------------------------------------
        //   Centered Navigation
        // -------------------------------------------------------------
        (function () {
            var $frame = $('#forcecentered1');
            var $wrap  = $frame.parent();
    
            // Call Sly on frame
            $frame.sly({
                horizontal: 1,
                itemNav: 'centered',
                smart: 1,
                activateOn: 'click',
                mouseDragging: 1,
                touchDragging: 1,
                releaseSwing: 1,
                startAt: 3,
                scrollBar: $wrap.find('.scrollbar'),
                scrollBy: 1,
                speed: 300,
                elasticBounds: 1,
                easing: 'easeOutExpo',
                dragHandle: 1,
                dynamicHandle: 1,
                clickBar: 1,
    
                // Buttons
                // se mueve el slider con los botones 
                prev: $wrap.find('.prev'),
                next: $wrap.find('.nextbtn'),

                // Cycling
                cycleBy: 'items',
                cycleInterval: 3000,
                pauseOnHover: 1,
            });
        }());
}


/* ******************************** */
function volver(){
    $("#mycontenido").show();
    $("#mycalendario").hide();
}

function mostrarcheckbox(){

	var formData = new FormData($("#check_list")[0]);
	
	$.ajax({

		"url": "../controlador/dashboardest.php?op=checkbox",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(e){
            e = JSON.parse(e);

			$(".info-mes").html(e[0]);			
		}
	});
}

function cambiarEstilo(button){
    $(".button-calendario").removeClass("button-active");
    $(button).addClass("button-active");
}

function mostrarmunicipio(id_departamento) {
	
    $.post("../controlador/dashboardest.php?op=selectMunicipio",{id_departamento:id_departamento} ,function (datos) {
        $("#municipio_res").html(datos);
        $("#municipio_res").selectpicker('refresh');
    });
}

function mostrarbarrio(id_municipio) {

    $.post("../controlador/dashboardest.php?op=selectBarrio",{id_municipio:id_municipio} ,function (datos) {
        $("#barrio_res").html(datos);
        $("#barrio_res").selectpicker('refresh');
    });
}


function loadGoogleMapsScript() {
    var script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyD-9GbQKtTGVtTsUJiUfMwFfbsB0hN8UGw&callback=initialize&v=weekly';
    script.async = true;
    script.defer = true;
    document.body.appendChild(script);
}

// Asignar el evento al botón para cargar el script y luego inicializar el mapa
document.getElementById("iniciarMapa").addEventListener("click", function() {
    loadGoogleMapsScript();  // Carga el script y ejecuta la función `initialize`
});

function initialize() {
   
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: new google.maps.LatLng(4.816142, -75.698787),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // creates a draggable marker to the given coords
    var vMarker = new google.maps.Marker({
        position: new google.maps.LatLng(4.816142, -75.698787),
        draggable: true
    });

    // adds a listener to the marker
    // gets the coords when drag event ends
    // then updates the input with the new coords
    google.maps.event.addListener(vMarker, 'dragend', function (evt) {
        $("#latitud").val(evt.latLng.lat().toFixed(6));
        $("#longitud").val(evt.latLng.lng().toFixed(6));

        map.panTo(evt.latLng);
        botonMapas();
    });

    // centers the map on markers coords
    map.setCenter(vMarker.position);

    // adds the marker on the map
    vMarker.setMap(map);
}

function botonMapas(){
 // Creating map object
    if($("#latitud").val()!="" && $("#longitud").val()!=""){
        $("#btnMapas").show();

    }
}

function pendientes(){
    
    $.post("../controlador/dashboardest.php?op=pendientes", function(data){
        var r = JSON.parse(data);
        $("#pendientes").html(r[0]);
    });
 }

function vermapas(e4)
{
	e4.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariomapas")[0]);

	$.ajax({
		url: "../controlador/dashboardest.php?op=guardarmapa",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
            data = JSON.parse(datos);
            if(data.estado="1"){
                alertify.success("Ubiación validada");
                $("#myModalDireccion").modal("hide");
                pendientes();
            }else{
                alertify.error("Error de validación");
            }	
            
	    }
	});
}	


function mostrarclasesdeldia() {


    $(".mostrarclasesdeldia").slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                infinite: true,
                dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
                },
                {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
                }
        ]
    });
}

function graficoingreso() {
    $.post("../controlador/dashboardest.php?op=graficoingreso", {}, function (r) {
        r = JSON.parse(r);
        var datos = r.datosuno.map(function (point) {
            return {
                x: new Date(point.x),
                y: point.y
            };
        });
        var chart = new CanvasJS.Chart("chartContainer", {
            "animationEnabled": true,
            
            "backgroundColor": null,
            "theme": "light1", // "light1", "light2", "dark1", "dark2"
            
            "axisX": {
                "valueFormatString": "DD-MM",
                "labelFontColor": "#4F81BC",
            },
            "axisY": {
                "valueFormatString": "#,###",
                "gridThickness": 0,
                "tickLength": 0,
                "lineThickness": 0,
                labelFormatter: function () {
                    return " ";
                }
            },
            
            "data": [{
                //change type to bar, line, area, pie, etc
                "type": "column", 
                //indexLabel: "{y}", //Shows y value on all Data Points
                "indexLabelFontColor": "#5A5757",
                "indexLabelFontSize": 16,
                "indexLabelPlacement": "outside",
                "dataPoints": datos    
            }]
        });
        chart.render();
        $("#precarga").hide(); 
    });

    
}


inicio();