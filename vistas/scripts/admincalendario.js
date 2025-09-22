$(function(){
    /* initialize the external events -----------------------------------------------------------------*/
    function init_events(ele) {
        ele.each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            }
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
        });
        $(".precarga").hide();
    }
    init_events($('#external-events div.external-event'));
    /* initialize the calendar -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    $('#calendar').fullCalendar({
        header    : {
            left  : 'prev,next today',
            center: 'title',
            right : 'month,agendaWeek,agendaDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week : 'Semana',
            day  : 'Día'
        },
        /*Función para capturar la información del día seleccionado*/
        dayClick:function(date){
            LimpiarFormulario();
            /*Visualizacion de eventos del CRUD*/
            $('#botonAgregar').show();
            $('#botonModificar').hide();
            $('#botonEliminar').hide();
            $("#txtFechaInicio").val(date.format());
            var dateObj = new Date(date.format());
            dateObj.setDate(dateObj.getDate() + 1);
            var month = dateObj.getUTCMonth() + 1; //months from 1-12
            var day = dateObj.getUTCDate();
            if (month < 10) {
                month = "0"+month;
            }
            if (day< 10) {
                day = "0"+day;
            }
            var year = dateObj.getUTCFullYear();
            var newdate = year + "-" + month + "-" + day;
            $("#txtFechaFin").attr({"min" : newdate});
            $("#modalCalendario").modal({backdrop: 'static', keyboard: false});
        },
        /*Enlace para cargar los eventos de la base de datos*/
        events:'../controlador/admin_calendario.php',
        /*Función para abrir el modal*/
            eventClick:function(calEvent){
                /*Visualizacion de eventos del CRUD*/
                $('#botonAgregar').hide();
                $('#botonModificar').show();
                $('#botonEliminar').show();
                /*Título del evento*/
                $('#modalCalendarioLabel').html(calEvent.title);
                /*Mostrar la información del evento*/
                $('#idActividad').val(calEvent.id);
                $('#txtTitulo').val(calEvent.title);
                var FechaInicio= calEvent.start._i.split(" ");
                $('#txtFechaInicio').val(FechaInicio[0]);
                /*Si se quiere habilitar la hora se debe establecer la linea FechaInicio[1]*/
                var FechaFin= calEvent.end._i.split(" ");
                $('#txtFechaFin').val(FechaFin[0]);
                /*Si se quiere habilitar la hora
                se debe establecer la linea
                FechaFin[1]*/
                $('#txtColor').val(calEvent.color);
                /*Línea para abrir el modal*/
                $("#modalCalendario").modal({backdrop: 'static', keyboard: false});
            },
            editable:false,
            eventDrop:function(calEvent){
                /*Capturar la información del evento que se va a arrastrar*/
                $('#idActividad').val(calEvent.id);
                $('#txtTitulo').val(calEvent.title);
                var fechaInicio= calEvent.start.format().split("T");
                $('#txtFechaInicio').val(fechaInicio[0]);
                /*Si se quiere habilitar la hora se debe establecer la linea fechaInicio[1]*/
                var fechaFin= calEvent.end.format().split("T");
                $('#txtFechaFin').val(fechaFin[0]);
                /*Si se quiere habilitar la hora se debe establecer la linea fechaFin[1]*/
                $('#txtColor').val(calEvent.color);
                /* Enviar información para modificar el evento*/
                RecolectarDatosGUI();
                EnviarInformacion('modificar',NuevoEvento,true);
            },
        });
        /*Función para agregar eventos al calendario*/
    var NuevoEvento;
    $('#botonAgregar').click(function(){
        var boolean_data =  RecolectarDatosGUI();
        verificar(boolean_data, "agregar" );
    });
    /*Función para eliminar eventos del calendario*/
    $('#botonEliminar').click(function(){
        var boolean_data =  RecolectarDatosGUI();
        verificar(boolean_data, "eliminar" );
    });
    /*Función para modificar eventos del calendario*/
    $('#botonModificar').click(function(){
        var boolean_data =  RecolectarDatosGUI();
        verificar(boolean_data, "modificar" );
    });
    /*Función para recolectar los datos de la interfaz de usuario*/
    function RecolectarDatosGUI(){
      /*Validar que los campos no estén vacíos*/
        if($('#txtTitulo').val().trim() == ''){
            return false;
        }else if($('#txtFechaInicio').val().trim()==''){
            return false;
        }else if($('#txtFechaFin').val().trim()==''){
            return false;
        }else if($('#txtColor').val()==''){
            return false;
        }
        /* Validar que la fecha final sea mayor a la fecha
        inicio para que deje crear el evento sin problemas */
        if ($('#txtFechaFin').val() <= $('#txtFechaInicio').val()) {
            return 1;
        }
        NuevoEvento= {
            id:$('#idActividad').val(),
            title:$('#txtTitulo').val(),
            start:$('#txtFechaInicio').val(),
            end:$('#txtFechaFin').val(),
            color:$('#txtColor').val()
        };
    }
    /*Función para recolectar los datos de la interfaz de usuario*/
    function verificar(boolean_data, accion){
        if(boolean_data == false) {
            alert("No es posible agregar el evento si no están todos los campos diligenciados.");
        }else if(boolean_data == 1){
            alert("No se puede generar el evento con una fecha menor o igual a la Fecha de Inicio");
        }else{
            EnviarInformacion(accion,NuevoEvento);
        }
    }
    /*función para enviar los datos al controlador para ser procesados*/
    function EnviarInformacion(accion,objEvento,modal){
        $.ajax({
            type:'POST',
            url:'../controlador/admin_calendario.php?accion='+accion,
            data:objEvento,
            success:function(msg){
                if(msg){
                    $('#calendar').fullCalendar('refetchEvents');
                    if (!modal) {
                        $("#modalCalendario").modal('toggle');
                    }
                }
            },
            error:function(){
                alert("Hay un error...");
            }
        });
    }
});
/* Función para limpiar el formulario al momento de cancelar la acción*/
function LimpiarFormulario(){
    $('#modalCalendarioLabel').html('Agregar Evento');
    $('#idActividad').val('');
    $('#txtTitulo').val('');
    $('#txtFechaInicio').val('');
    $('#txtFechaFin').val('');
    $('#txtColor').val('');
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
				title: 'Panel administrativo',
				intro: 'Módulo para consultar los horarios por salones creados en el periodo actual.'
			},
			{
				title: 'Estudiantes',
				element: document.querySelector('#t-paso1'),
				intro: ""
			},

		]
			
	},
	
	
	).start();

    console.log("holaaa");

}