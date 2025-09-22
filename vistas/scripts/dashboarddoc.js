$(document).ready(inicio);
var seleccion_actual = 1;
function inicio() {
    mostrarcheckbox();
    listardatos(1);// quiere decir que es el dia de hoy
    listardatosfijos();
    siguienteclase();
    porcentaje_evaluacion();
    graficoingreso();

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
				title: 'campus docentes',
				intro: 'Bienvenido líder creativo para nosotros es muy importante que seas parte este parche creativo e innovador'
			},
			{
				title: 'clases asignadas',
				element: document.querySelector('#m-paso1'),
				intro: "Aquí podrás encontrar todas tus clases asignadas de las que serás el mejor líder creativo para nuestros seres originales"
			},
			
            {
				title: 'Horario',
				element: document.querySelector('#m-paso2'),
				intro: "visualiza de manera rápida tu horario, recuerda que como líder creativo debes ser muy puntual a la hora de comenzar con la experiencia creativa"
			},


            {
				title: 'Digital',
				element: document.querySelector('#m-paso3'),
				intro: "Encuentra algunos de nuestros recursos que te serviran de gran ayuda para hacer aún más interesante y personalizada cada una de esas experiencias"
			},
            

            {
				title: 'Reservas',
				element: document.querySelector('#m-paso4'),
				intro: "Recuerda que debes reservar tu salón para cumplir con la experiencia y no solo eso si no que también brindaremos un equipo previamente reservado y asistencia técnica por si lo necesitas"
			},

            {
				title: 'Menu hoja de vida',
				element: document.querySelector('#m-paso5'),
				intro: "Aquí podrás visualizar tu hoja de vida personal, teniendo encuenta toda la información que has llenado previamente "
			},

            {
				title: 'Carnet',
				element: document.querySelector('#m-paso6'),
				intro: "Como líder creativo conoce los diferentes beneficios que tenemos para ti,con el uso de tu carnet institucional"
			},
            {
				title: 'Caracterización',
				element: document.querySelector('#m-carac'),
				intro: "Podrás realizar tu caracterización para conocer un poco más de nuestro líder creativo y también para ti sea una experiencia única"
			},
            {
				title: 'Formatos institucionales',
				element: document.querySelector('#m-paso7'),
				intro: "Para que sea más facíl para ti contamos con diferentes formatos los cuales te ayudarán en las experiencias creativas brindadas"
			},

            {
				title: 'Configuracion de la cuenta',
				element: document.querySelector('#m-paso8'),
				intro: "Tendrás la oportunidad de personalizar tu campus virtual con tu información y nuestro nuevo modo oscuro"
			},

            {
				title: 'Salir',
				element: document.querySelector('#m-paso9'),
				intro: "Finaliza tu dia creativo cerrando tu sesión y descansando para empezar un nuevo dia lleno de innovación y creatividad para vivir la mejor experiencia creativa junto a nuestros seres originales"
			},

            {
				title: 'Faltas',
				element: document.querySelector('#t-paso1'),
				intro: "Aquí podras encontrar todas tus faltas reportadas con toda la información correspondiente"
			},
            {
				title: 'Actividades',
				element: document.querySelector('#t-paso2'),
				intro: "Aquí podrás crear tus diferentes actividades creativas para las experiencias de nuestros seres originales"
			},
            {
				title: 'Casos',
				element: document.querySelector('#t-paso3'),
				intro: "Aquí podrás encontrar diferentes casos quédate que te han asignado para asegurar la permanencia de nuestro ser original y buscar la mejor solución "
			},

            {
				title: 'Ingreso campus',
				element: document.querySelector('#t-paso4'),
				intro: "Visualiza tus entradas al campus y ten un control de las veces que has ingresado, además tendrás una calificación dependiendo de las veces de ingreso"
			},
            {
				title: 'Siguiente clase',
				element: document.querySelector('#t-paso5'),
				intro: "Da un vistazo a tu proxima experiencia creativa con tus seres originales"
			},
            {
				title: 'Mis perfiles',
				element: document.querySelector('#t-paso6'),
				intro: "Aquí podrás observar la ultima actualización que ha tenido tu perfil y fecha de caracterización"
			},
            {
				title: 'Estudiantes a cargo',
				element: document.querySelector('#t-paso7'),
				intro: "Da un vistazo a los seres originales que tienes a tu cargo con su nombre completo e identificación y la materia a la que pertenecen"
			},
            {
				title: 'Evaluación docente',
				element: document.querySelector('#t-paso8'),
				intro: "Da un vistazo a tu evaluación como líder creativo, teniendo en cuenta todas esas sugerencias y mejorando así la experiencia creativa para ti y tus seres originales a tu cargo"
			},
            {
				title: 'Hoja de vida',
				element: document.querySelector('#t-paso9'),
				intro: "podrás visualizar la última actualización que le has agregado a tu hoja de vida, teniendo así toda tu información al día"
			},
            {
				title: 'Calendario académico',
				element: document.querySelector('#t-paso10'),
				intro: "Entérate de todos nuestros eventos académicos programados para ti fomentando un espacio diferente donde podrás dejarte llevar por la creatividad e innovación de nuestras experiencias creativas"
			},
            {
				title: 'Vuelvete emprendedor',
				element: document.querySelector('#t-paso11'),
				intro: "Formate permanentemente con nuestros programas innovadores y basados en tecnologia que se amolda a los requerimientos de la empresa o comunidad para que sigas preparando e innovando en nuestro parche cretivo y educativo mas grande del eje cafetero"
			},
            {
				title: 'Calendario eventos',
				element: document.querySelector('#t-paso12'),
				intro: "Enterate de todas nuestras experiencias transformadoras que mejoran la calidad de vida de seres originales, docentes, colaboradores y sus familias incluyendo a sus inspiradores donde construirás un lazo de confianza,amor,amistad y respeto"
			},
            {
				title: 'QR',
				element: document.querySelector('#t-paso13'),
				intro: "¡Tu propio QR para escanear!"
			},
            {
				title: 'Salir',
				element: document.querySelector('#t-paso14'),
				intro: "Finaliza tu dia creativo cerrando tu sesión y descansando para empezar un nuevo día lleno de innovación y creatividad para vivir la mejor experiencia creativa junto a nuestros seres originales"
			},
		]
			
	},
	
	
	).start();



}


function listardatos(rango){
    seleccion_actual = rango;
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    var contador=1;
        while(contador <= 5){
            $("#opcion"+contador).removeClass("activo"); 
            contador++;
        }
            $("#opcion"+rango).addClass("activo");

        $.post("../controlador/dashboarddoc.php?op=listardatos&rango="+rango+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
          
            var r = JSON.parse(e);
            $("#dato_ingreso").html(r.totalingresos);
            $("#dato_faltas").html(r.totalfaltas);
            $("#dato_actividades").html(r.totalactividades);
            $("#dato_guia").html(r.totalguia);
            $("#totalestudiantesacargo").html(r.totalestudiantesacargo);
            $("#totalperfilactualizado").html(r.totalperfilactualizado);

            
        });
}

function mostrar_nombre_docente(rangodocente){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/dashboarddoc.php?op=mostrar_nombre_docente&rangodocente="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
       
        var r = JSON.parse(e);
        $("#myModalIngresosDocentes").modal("show");
        $("#datosusuario_docente").html(r);
        
        $('#mostrardocente').dataTable( {
					
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
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    $.post("../controlador/dashboarddoc.php?op=mostrar_faltas&rangofaltas="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
       
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

function estudiantesacargo(estudiantesacargo){
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    $.post("../controlador/dashboarddoc.php?op=estudiantesacargo&estudiantesacargo="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
       
        var r = JSON.parse(e);
        $("#myModalEstudiantesacargo").modal("show");
        $("#datosusuario_estudiantesacargo").html(r);

        $('#datosusuario_cargo').dataTable( {
					
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

function actividadesnuevas(actividadesnuevas){
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    $.post("../controlador/dashboarddoc.php?op=actividadesnuevas&actividadesnuevas="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
       
        var r = JSON.parse(e);
        $("#myModalActividades").modal("show");
		$("#datosusuario_actividades").html(r);
        $('#mostraractividades').dataTable( {
					
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

function siguienteclase(siguienteclase){
  
    $.post("../controlador/dashboarddoc.php?op=siguienteclase&siguienteclase="+seleccion_actual, function (e) {
      
        var r = JSON.parse(e);
   
        // alert('esta a punto de comenzar la clase');
        // $("#myModalClasesdelDia").modal("show");
		$("#datossiguienteclase").html(r);
        
        
    });
}

function casosquedate(casosquedate){
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    $.post("../controlador/dashboarddoc.php?op=casosquedate&casosquedate="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
      
        var r = JSON.parse(e);
        $("#myModalCasoQuedate").modal("show");
        $("#datosusuario_quedate").html(r);

        $('#mostrarcasoguia').dataTable( {
					
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

function perfilesactualizados(perfilactualizado){
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    $.post("../controlador/dashboarddoc.php?op=perfilesactualizados&perfilactualizado="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
      
        var r = JSON.parse(e);
        $("#myModalPerfilactualizado").modal("show");
        $("#datosusuario_perfilactualizado").html(r);

        $('#mostrarperfilactualizado').dataTable( {
					
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

function hojadevidanueva(hojasdevidanueva){
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    $.post("../controlador/dashboarddoc.php?op=hojadevidanueva&hojasdevidanueva="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
       
        var r = JSON.parse(e);
        $("#myModalHojadevidanueva").modal("show");
        $("#datosusuario_hoja_de_vida_nueva").html(r);
        

        $('#mostrarhojadevidanueva').dataTable( {
            		
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

function listarrango(){
    $(".chart-loader").show();
    $("#exampleModal").modal("hide");
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    rango=5;
    var contador=1;
    while(contador <= 5){
        $("#opcion"+contador).removeClass("activo"); 
        contador++;
    }
        $("#opcion"+rango).addClass("activo");

    $.post("../controlador/dashboarddoc.php?op=listarrango&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
    
        var r = JSON.parse(e);
            $("#dato_ingreso").html(r.totalingresos);
            $("#dato_faltas").html(r.totalfaltas);
            $("#dato_actividades").html(r.totalactividades);
            $("#dato_guia").html(r.totalguia); 
            // $("#totalperfilactualizado").html(r.totalperfilactualizado); 
            // $("#totalusuariohojadevida").html(r.totalusuariohojadevida); 
            
    });

}
/* para los datos del dashboard que son fijos */
function listardatosfijos(){

        $.post("../controlador/dashboarddoc.php?op=listardatosfijos", function (e) {
            var r = JSON.parse(e);
            $("#dato_perfil_actualizado").html(r.perfilactualizado);
            $("#actualizacion_hoja_de_vida").html(r.cvactualizado);


            
        });
}

/* para los datos del dashboard que son fijos */
function porcentaje_evaluacion() {
    $.post("../controlador/dashboarddoc.php?op=porcentaje_evaluacion", function (e) {
        var r = JSON.parse(e);
        if(r.exito == "1"){

            $("#porcentaje_evaluacion").html(r.promedio_final+"%");
            $(".icono_evaluacion").addClass(r.promedio_icono);
            $(".promedio_color").addClass(r.promedio_color);
        }
    });
}
/* ******************************** */
function volver(){
    $("#mycontenido").show();
    $("#mycalendario").hide();
}

function verComentariosHeteroevaluacion() {
    $.post("../controlador/dashboarddoc.php?op=comentarios_heteroevaluacion", function (r) {
        $(".box_comentarios").html(r);
        $("#tabla_comentarios").dataTable({
            "dom": "rtip",
            "pageLenght": 20
        });
    });
}

function mostrarcheckbox(){

	var formData = new FormData($("#check_list")[0]);
	
	$.ajax({

		"url": "../controlador/dashboarddoc.php?op=checkbox",
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

function graficoingreso() {
    $("#precarga1").show();
       
        $.post("../controlador/dashboarddoc.php?op=graficoingreso", {}, function (r) {
            $("#precarga1").hide();
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
            
        });


}


