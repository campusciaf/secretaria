var tabla;
var img_imagenes;
var id_banner;

var id_banner_global;

function init(){

	// listarbanner(id_banner_global);

	mostrar_boton_banner();

	$("#formularioeditarbannercampus").on("submit",function(e){
		guardaryeditarbannercampus(e);	
	});

	$("#formularioagregarimagen").on("submit",function(e){
		agregarimagen(e);	
	});

	$.post("../controlador/banner_campus.php?op=Categoria_Programas", function(r){
		$("#categoria_imagenes_imagen").html(r);
		$('#categoria_imagenes_imagen').selectpicker('refresh');
	});

	$.post("../controlador/banner_campus.php?op=Categoria_Programas", function(r){
		$("#categoria_imagenes_imagen_editar").html(r);
		$('#categoria_imagenes_imagen_editar').selectpicker('refresh');
	});
	
}



//Función lista los ejes estrategicos  
function mostrar_boton_banner(){

	// alert(id_banner_global); 
	$.post("../controlador/banner_campus.php?op=boton_agregar",{},function(data){
		// console.log(data);
		listarbanner(id_banner_global);
		data = JSON.parse(data);
		$("#boton_agregar_banner").show();
		$("#boton_agregar_banner").html(data);
	});
}

function listarbanner(id_banner){
	$("#precarga").show();
	
	$("#id_banner").val(id_banner);

	id_banner_global = id_banner;

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistaimagenen').dataTable({
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
				title: 'Noticias',
				titleAttr: 'Print'
			},
		],
		
		"ajax":{ url: '../controlador/banner_campus.php?op=listarbanner&id_banner='+id_banner, type : "get", dataType : "json",						
		error: function(e){
			// console.log(e.responseText);	
		}
	},
	"bDestroy": true,
	"iDisplayLength": 30,//Paginación
	"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	'initComplete': function (settings, json) {
			
			$("#precarga").hide();
			
		},
	});
}

function mostrar_imagen(id_banner){

	id_banner_global = id_banner;
	
	$.post("../controlador/banner_campus.php?op=mostrar_imagen",{"id_banner" : id_banner},function(data){
		// console.log(data);
		
	data = JSON.parse(data);
	if(Object.keys(data).length > 0){

		$("#id_banner_editar").val(data.id_banner);
		$("#nombre_banner_editar").val(data.nombre_banner);

		$("#categoria_imagenes_imagen_editar").val(data.id_bienestar_programas);
		$("#categoria_imagenes_imagen_editar").selectpicker('refresh');
		
		$("#agregar_editar_imagen_editar").val(data.imagen_banner);
		$("#imageneditarguardar").val(data.imagen_banner);

		$("#ModalEditarNoticias").modal("show");

	}
});


}

function agregarimagen(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarimagen")[0]);
	$.ajax({
		"url": "../controlador/banner_campus.php?op=agregarimagen",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			// window.location.reload();
			// listarbanner(id_banner)
			window.location.reload();
			$("#ModalImagen").modal("hide");
			// alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			
		}
	});
}

function limpiar_imagen()
{
	$("#id_banner").val("");
	$("#nombre_banner").val("");
	$("#editarguardarimg").val("");
	
}

function mostraragregarimagen(flag)
{
	if (flag)
	{
		$("#ModalImagen").modal("show");
		limpiar_imagen();
	}
	
}


function guardaryeditarbannercampus(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarbannercampus")[0]);
	$.ajax({
		"url": "../controlador/banner_campus.php?op=guardaryeditarbannercampus",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			// console.log(datos);
			$("#ModalEditarNoticias").modal("hide");
			// alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			window.location.reload();
			
		}
	});
}

function eliminar_imagenes(id_banner,imagen_banner){

	alertify.confirm("¿Está Seguro de eliminar", function(result){
		if(result){
			$.post("../controlador/banner_campus.php?op=eliminar_imagenes", {'id_banner' : id_banner,'imagen_banner' : imagen_banner}, function(e){
				// console.log(e);
				if(e){
					alertify.success("Eliminado correctamente");
					// listarbanner(id_banner)
					window.location.reload();;
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}






init();