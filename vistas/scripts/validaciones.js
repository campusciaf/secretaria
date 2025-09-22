var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	
	$("#formulario").on("submit",function(e)
	{
		noValidarMetaMensaje(e);	
	});

}


//function listar(){
//	
//	$.post("../controlador/validaciones.php?op=listar",{},function(data, status){
//	data = JSON.parse(data);
//		
//	$("#tllistado").html("");
//	$("#tllistado").append(data["0"]["0"]);
//
//	});
//}


//Función Listar
function listar()
{

var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },
			{
                extend: 'print',
			 	text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Validaciones',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/validaciones.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

		
		
	// funcion para cambiar el responsive del data table	

         'select': 'single',

         'drawCallback': function (settings) {
            api = this.api();
            var $table = $(api.table().node());
            
            if ($table.hasClass('cards')) {

               // Create an array of labels containing all table headers
               var labels = [];
               $('thead th', $table).each(function () {
                  labels.push($(this).text());
               });

               // Add data-label attribute to each cell
               $('tbody tr', $table).each(function () {
                  $(this).find('td').each(function (column) {
                     $(this).attr('data-label', labels[column]);
                  });
               });

               var max = 0;
               $('tbody tr', $table).each(function () {
                  max = Math.max($(this).height(), max);
               }).height(max);

            } else {
               // Remove data-label attribute from each cell
               $('tbody td', $table).each(function () {
                  $(this).removeAttr('data-label');
               });

               $('tbody tr', $table).each(function () {
                  $(this).height('auto');
               });
            }
         }
		
		
		
      });
	
	
		var width = $(window).width();
		if(width <= 750){
			$(api.table().node()).toggleClass('cards');
			api.draw('page');
		}
		window.onresize = function(){

			 anchoVentana = window.innerWidth;
				if(anchoVentana > 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else if(anchoVentana > 750 && anchoVentana < 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else{
				  $(api.table().node()).toggleClass('cards');
					api.draw('page');
				}
		}
		// ****************************** //
	
	
		
}
//Función para guardar o editar



//Función Listar
function listar2()
{

var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-copy fa-2x" style="color: blue"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },
			{
                extend: 'print',
			 	text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/validaciones.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


//Función para desactivar registros
function validarMeta(id_meta,fecha)
{

	alertify.confirm('Validar Meta', '¿Está Seguro(a) de validar la fuente de verificación?', function(){ 
	
	$.post("../controlador/validaciones.php?op=validarMeta",{id_meta : id_meta, fecha:fecha}, function(data, status)
			{

				data = JSON.parse(data);
				if(data==true){
				   alertify.success("Validado Correctamente");
					listar();
				   }

			});
	
	}
                , function(){ alertify.error('Cancelado')});
	

}



//Función para desactivar registros
function noValidarMetaForm(id_meta,email)
{
	$("#myModalNoValidarForm").modal("show");
	$("#id_meta").val(id_meta);
	$("#email").val(email);
}

// funcion para no valiar meta
function noValidarMetaMensaje(e)
{
	$("#precarga").show();
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulario")[0]);
	
	var id_meta=$("#id_meta").val();
	var correo=$("#email").val();
	var mensaje=$("#mensaje").val();
	
	$.ajax({
		url: "../controlador/validaciones.php?op=noValidarMeta",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			
			data = JSON.parse(datos);
			
			if(data == true){
				alertify.success("Acción correcta");          
				$("#myModalNoValidarForm").modal("hide");
				$("#id_meta").val();
				listar();
				enviarMensaje(id_meta,correo,mensaje);
			}else{
				alertify.error("error");   
			}
			
	    }

	});

}

function enviarMensaje(id_meta,correo,mensaje){
	
	$.post("../controlador/validaciones.php?op=enviarMensaje",{id_meta:id_meta, correo:correo , mensaje:mensaje},function(data, status){	
		if(data==1){
			$("#precarga").hide();
			alertify.success("Correo enviado"); 
		}else{
			alertify.error("Correo no enviado"); 
		}
	});
}


function info(){

	alertify.alert('Pendiente','Proceso sin fuente de verificación.', function(){  });
}
init();