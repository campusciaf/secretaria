<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: login");
}else{
$menu=3;
$submenu=304;
require 'header.php';
if ($_SESSION['calendarioeventos']==1){
?>
<link rel="stylesheet" href="../public/css/fullcalendar.min.css">
<link rel="stylesheet" href="../public/css/fullcalendar.print.min.css" media="print">
<!--Contenido-->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Calendario Eventos</span><br>
                        <span class="fs-16 f-montserrat-regular">Bienvenido a nuestro calendario de eventos</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'>
                        <i class="fa-solid fa-play"></i> Tour
                    </button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Calendario de eventos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content" style="padding-top: 0px;">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card card-primary" style="padding: 2% 1%">
                    <!-- THE CALENDAR -->
              		<div id="calendar" class="col-12"></div>
                </div>
            </div>
        </div>
    </section>                
</div>
<!-- Modal Para visualizar la información del calendario -->
<div class="modal fade" id="modalCalendario" tabindex="-1" role="dialog" aria-labelledby="modalCalendario" aria-hidden="true">
    <form method="POST">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <b>
                        <h3 class="modal-title" id="modalCalendarioLabel">Visualizar Evento</h3>
                    </b>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idActividad" name="idActividad"/><br>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Título: </label>
                            <input class="form-control" type="text" id="txtTitulo" name="txtTitulo" placeholder="Título del Evento" disabled/>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Fecha Inicio:</label>
                            <input class="form-control" type="date" id="txtFechaInicio" name="txtFechaInicio" disabled />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Fecha Fin:</label>
                            <input class="form-control" type="date" id="txtFechaFin" name="txtFechaFin" disabled />
                        </div>
                        <div class="form-group col-md-12">
                            <label>Descripción del Evento:</label>
                            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" cols="50" style="resize:none;" disabled> </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="LimpiarFormulario()" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
}else{
    require 'noacceso.php';
}		
require 'footer.php';
}
	ob_end_flush();
?>
<style>
.fc th{
      padding: 10px 0px;
      vertical-align: middle;
      background: #f2f2f2;
}
.fc-content{
    cursor: pointer;
}
.fc-day:hover{
    background-color: #b5d2da;
    cursor: pointer;
}
</style>
<script src="../bower_components/moment/moment.js"></script>
<script src="../bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="../bower_components/fullcalendar/dist/locale/es.js"></script>
<script>
$(function(){
    /* initialize the external events-----------------------------------------------------------------*/
    function init_events(ele){
        ele.each(function(){
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
              title: $.trim($(this).text()) // use the element's text as the event title
            }
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject)
        });
    }
    init_events($('#external-events div.external-event'));
    /* initialize the calendar-----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear();
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
        events:'../controlador/admin_calendario_eventos.php',
        /*Función para abrir el modal*/
        eventClick:function(calEvent,jsEvent,view){
            /*Visualizacion de eventos del CRUD*/
            $('#botonAgregar').hide();
            $('#botonModificar').show();
            $('#botonEliminar').show();
            /*Título del evento*/
            $('#modalCalendarioLabel').html(calEvent.title);
            /*Mostrar la información del evento*/
            $('#idActividad').val(calEvent.id);
            $('#txtTitulo').val(calEvent.title);
            FechaInicio= calEvent.start._i.split(" ");
            $('#txtFechaInicio').val(FechaInicio[0]);
            /*Si se quiere habilitar la hora se debe establecer la linea FechaInicio[1]*/
            FechaFin= calEvent.end._i.split(" ");
            $('#txtFechaFin').val(FechaFin[0]);
            /*Si se quiere habilitar la hora se debe establecer la linea FechaFin[1]*/
            $("#txtDescripcion").val(calEvent.descripcion);
            $('#txtColor').val(calEvent.color);
            /*Línea para abrir el modal*/
            $("#modalCalendario").modal({backdrop: 'static', keyboard: false});
        }
    })
});
  /* Función para limpiar el formulario al momento de cancelar la acción*/
function LimpiarFormulario(){
    $('#modalCalendarioLabel').html('Agregar Evento');
    $('#idActividad').val('');
    $('#txtTitulo').val('');
    $('#txtFechaInicio').val('');
    $('#txtFechaFin').val('');
    $("#txtDescripcion").val('');
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
				title: 'Calendario',
				intro: "Bienvenido a nuestro calendario de eventos donde podrás visualizar todos los eventos preparados para toda nuestra comunidad educativa"
			},
		
		
			
		]
			
	},
	console.log()
	
	).start();

}
</script>