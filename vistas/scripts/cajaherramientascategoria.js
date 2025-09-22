var tabla;

function init(){

	listarcategorias();

	// se carga el formulario de categoria 
	$("#formulariocategoria").on("submit",function(e){
		guardaryeditarcategoria(e);	
	})
	
}

//funcion para listar las categorias  
function listarcategorias(){
	$("#precarga").show();
	

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistacategorias').dataTable({
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
		
		"ajax":{ url: '../controlador/cajaherramientascategoria.php?op=listarcategorias', type : "get", dataType : "json",						
		error: function(e){
			console.log(e.responseText);	
		}
	},
	"bDestroy": true,
	"iDisplayLength": 20,//Paginación
	"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	'initComplete': function (settings, json) {
			
			$("#precarga").hide();
			
		},
		
		
	});

	
	
}

//se edita y se muestra la categoria
function mostrar_categoria(id_software_categoria){
	
	$("#ModalCrearCategoria").modal("show");
	$.post("../controlador/cajaherramientascategoria.php?op=mostrar_categoria",{"id_software_categoria" : id_software_categoria},function(data){
		console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
			$("#nombre_categoria").val(data.nombre_categoria);
			$("#id_software_categoria").val(data.id_software_categoria);
			
		}
	});
}

//Funcion para guardar y editar la categoria
function guardaryeditarcategoria(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarCategoria").prop("disabled",true);
	var formData = new FormData($("#formulariocategoria")[0]);
	$.ajax({
		"url": "../controlador/cajaherramientascategoria.php?op=guardaryeditarcategoria",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			console.log(datos);
			alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			window.location.reload();
			$("#ModalCrearCategoria").modal("hide");
			$("#btnGuardarCategoria").prop("disabled",false);
			
		}
	});
}

//Función para eliminar la categoria
function eliminar_categoria(id_software_categoria){
	alertify.confirm("¿Está Seguro de eliminar La categoría?", function(result){
		if(result){
			$.post("../controlador/cajaherramientascategoria.php?op=eliminar_categoria", {'id_software_categoria' : id_software_categoria}, function(e){
				console.log(e);
				
				if(e){
					alertify.success("Eliminado correctamente");
					window.location.reload();
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}

init();