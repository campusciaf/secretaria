$(function () {
$("#precarga").hide();
    /* initialize the external events
     -----------------------------------------------------------------*/
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
    init_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
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
      /*Enlace para cargar los eventos de la base de datos*/
      events:'../controlador/calendario_poa.php?op=mostrar_individual',
     /*Función para abrir el modal*/
      eventClick:function(calEvent,jsEvent,view){
      	/*Título del evento*/
      	$('#calendariopoatitle').html(calEvent.title);
      	var fecha_meta = getDatennow(calEvent.start["_i"]);
      	$('#fecha_meta').html(fecha_meta);
      	$('#quien_verifica').html(calEvent.meta_valida);
      	var id_compromiso = calEvent.id_compromiso;
      	var nombreCompromiso = cargarCompromiso(id_compromiso);
        /*Línea para abrir el modal*/
        $("#modalcalendariopoa").modal({backdrop: 'static', keyboard: false});
      },
      editable:false,
    })
    /*Fin $(function)*/
    /*$.ajax({
		type:'POST',
		url:'../controlador/calendario_poa?op=mostrar_individual',
		success:function(msg){
			console.log(msg);
		},
		error:function(){
			alert("Hay un error...");
		}
	});*/
});

/*Funcion para cargar datos de compromiso*/
function cargarCompromiso(id_compromiso){
	$.ajax({
		type:'POST',
		url:'../controlador/calendario_poa.php?op=cargarCompromiso',
		data:{id_compromiso:id_compromiso},
		success:function(msg){
			datos = JSON.parse(msg);
			$('#nombre_compromiso').html(datos[0]['compromiso_nombre']);
		},
		error:function(){
			alert("Hay un error...");
		}
	});
}

/*Formato de la fecha*/
function getDatennow(flag){
var today = new Date(flag);
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
var hh = today.getHours();
var mi = today.getMinutes();
var ss = today.getSeconds();
if (dd < 10) {
 dd = '0' + dd;
} 
if (mm < 10) {
 mm = '0' + mm;
}
if (mi < 10) {
 mi = '0' + mi;
} 
if (hh < 10) {
 hh = '0' + hh;
} 
if (ss < 10) {
 ss = '0' + ss;
}

if(flag){
var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
 	"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
var date = days[today.getDay()]+' '+ dd +' de ' + monthNames[today.getMonth()]+' del '+ yyyy ;
//today = dd + '/' + mm + '/' + yyyy+ " Hora:  " + hh + ":" + mi + ":" + ss;
return date;
}else{
date = yyyy + '-' + mm + '-'+dd ;
return date;
}	
}