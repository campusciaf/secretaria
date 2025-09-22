var tabla;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();
	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	})
}
//Función limpiar
function limpiar(){
	$("#id_eje").val("");
	$("#nombre_eje").val("");
	$("#anio_eje").val("");
	$("#objetivo_eje").val("");
}
//Función mostrar formulario
function mostrarform(flag){
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//Función cancelarform
function cancelarform(){
	mostrarform(false);
}

//Función Listar
function listar(){
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistado').dataTable({
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
		"ajax":{ url: '../controlador/sac_eje.php?op=listar', type : "get", dataType : "json",						
			error: function(e){
				console.log(e.responseText);	
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[ 0, "asc" ]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#precarga").hide();
		},
		
	});
	
}
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../controlador/sac_eje.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos){   
			console.log(datos);
			alertify.success(datos);	          
			mostrarform(false);
			listar();
		}
	});
}

//Función para mostrar nombre de la meta 
function nombre_ejes(id_eje){
	$.post("../controlador/sac_eje.php?op=nombre_ejes",{ id_eje : id_eje },function(data){
		data = JSON.parse(data);
		console.log(data);
		$("#myModalNombreMetaEje").modal("show");
		$(".id_eje").html(data);
		
	});
}

//Función para mostrar nombre de la meta 
function nombre_accion_ejes(id_eje){
	$.post("../controlador/sac_eje.php?op=nombre_accion_ejes",{ id_eje : id_eje },function(data){
		data = JSON.parse(data);
		console.log(data);
		$("#myModalNombreAccionEje").modal("show");
		$(".id_accion_label").html(data);
		
	});
}

function mostrar(id_eje){
	$.post("../controlador/sac_eje.php?op=mostrar",{id_eje : id_eje}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
		$("#id_eje").val(data.id_ejes);
		$("#nombre_eje").val(data.nombre_ejes);
		$("#anio_eje").val(data.anio_ejes);
		
	});
}

//Función para desactivar registross
function eliminar(id_eje){
	alertify.confirm("¿Está Seguro de eliminar la ejes?", function(result){
		if(result)
        {
			$.post("../controlador/sac_eje.php?op=eliminar", {id_eje : id_eje}, function(e){
				if(e=='null'){
					alertify.success("Eliminado correctamente");
				}
				else{
					alertify.error("Error");
				}
			});	
        }
	})
}



init();