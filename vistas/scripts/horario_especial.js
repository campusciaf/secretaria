var tabla;

var id_programa_ac_ = "";
var id_estudiante_ = "";
var ciclo_materia = "";
var id_docente = "";

var id_docente_grupo_ = "";


//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	$("#listadoregistros").hide();
	
	$("#formularioverificar").on("submit",function(e1)
	{
		verificardocumento(e1);	
	});
	
}


function asignar_docente(id_docente_grupo,dia,hora,hasta,diferencia,salon,nombre_materia,periodo) {

	$.post("../controlador/horario_especial.php?op=asignar_docente", {"id_docente_grupo" : id_docente_grupo, "dia" : dia,"hora" : hora,"hasta" : hasta,"diferencia" : diferencia, "salon" : salon, "nombre_materia": nombre_materia, "periodo": periodo }, function (data) {
		//console.log(data);	
		alertify.success(data);
		$("#myModalDocente").modal("hide");
		// $("#btn_docente").hide();
	});

	mostrarmaterias(id_programa_ac_,id_estudiante_,ciclo_materia)
}


function asignar_cualquier_docente(id_docente_grupo,dia,hora,hasta,diferencia,salon,materia,periodo) {

	$.post("../controlador/horario_especial.php?op=asignar_cualquier_docente", {"id_docente_grupo" : id_docente_grupo, "dia" : dia,"hora" : hora,"hasta" : hasta,"diferencia" : diferencia, "salon" : salon, "materia": materia, "periodo": periodo }, function (data) {
		//console.log(data);	
		alertify.success(data);
		$("#myModalDocenteCualquiera").modal("hide");
		// $("#btn_docente").hide();
	});

	mostrarmaterias(id_programa_ac_,id_estudiante_,ciclo_materia)
}

//Función limpiar
function limpiar()
{
	$("#id_credencial").val("");
	$("#credencial_nombre").val("");
	$("#credencial_nombre_2").val("");
	$("#credencial_apellido").val("");
	$("#credencial_apellido_2").val("");
	//$("#credencial_identificacion").val("");
	$("#credencial_login").val("");

}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#seleccionprograma").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#seleccionprograma").show();
		
	
	}
}



//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function verificardocumento(e1)
{
	$("#listadomaterias").hide();
	
		e1.preventDefault();
		//$("#btnVerificar").prop("disabled",true);
		var formData = new FormData($("#formularioverificar")[0]);


		$.ajax({
		url: "../controlador/horario_especial.php?op=verificardocumento",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function(datos)
		{   	
			data = JSON.parse(datos);
			var id_credencial="";
			if(JSON.stringify(data["0"]["1"])=="false"){// si llega vacio toca matricular
				alertify.error("Estudiante No Existe");
				$("#listadoregistros").hide();
				$("#mostrardatos").hide();
			}
			else{
				id_credencial=data["0"]["0"];
				$("#mostrardatos").show();
				alertify.success("Esta registrado");
				listar(id_credencial);
				
			}
			
		}

	});
	

	
}
		
//Función Listar
function listar(id_credencial)
{

	$("#listadoregistros").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
		"aServerSide": true,//Paginación y filtrado realizados por el servidor

		dom: 'Bfrtip',
				buttons: [

					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},

					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'Programas Académicos',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/horario_especial.php?op=listar&id_credencial='+id_credencial,
					type : "get",
					dataType : "json",						
					error: function(e){
					//console.log(e);
							
					}
				},
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
		"order": [[ 2, "asc" ]],//Ordenar (columna,orden)

	}).DataTable();
	mostrardatos(id_credencial);

}

function mostrardatos(id_credencial){
	$.post("../controlador/horario_especial.php?op=mostrardatos",{id_credencial : id_credencial}, function(data, status)
	{

		data = JSON.parse(data);
		
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
			
	});
}

function mostrarmaterias(id_programa_ac,id_estudiante,ciclo,id_docente_grupo){
	//variables globales para recargar las materias
	id_programa_ac_ = id_programa_ac;
	id_estudiante_ = id_estudiante;
	ciclo_ = ciclo;
	id_docente_grupo_ = id_docente_grupo;

	$("#precarga").show();
	$.post("../controlador/horario_especial.php?op=mostrarmaterias",{id_programa_ac : id_programa_ac , id_estudiante : id_estudiante, ciclo:ciclo, id_docente_grupo:id_docente_grupo}, function(data, status)
	{
		//console.log(data);
		data = JSON.parse(data);
		//$("#myModalAgregarPrograma").modal("show");
		$("#listadoregistros").hide();
		$("#listadomaterias").show();
		$("#listadomaterias").html("");
		$("#listadomaterias").append(data["0"]["0"]);
		$("#precarga").hide();
	});
	
}

function seleccionar_docente(id_docente_grupo,periodo,ciclo_materia,nombre_materia){
	$.post("../controlador/horario_especial.php?op=selecionar_docente",{ciclo_materia : ciclo_materia,periodo: periodo,nombre_materia: nombre_materia},function(data){
		// //console.log(data);
		data = JSON.parse(data);
	$("#periodo_actual").val(periodo);
	$("#nombre_materia").val(nombre_materia);
	$("#selecionar_docente").show();
	$("#myModalDocente").modal("show");
	$("#selecionar_docente").html(data);
	$('#mostrardocentes').dataTable({

		dom: 'Bfrtip',

		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},

		],

	});
	});


	

	
}



function seleccionar_cualquier_docente(id_docente_grupo,periodo,ciclo_materia,materia){
	$.post("../controlador/horario_especial.php?op=seleccionar_cualquier_docente",{ciclo_materia : ciclo_materia,periodo: periodo,materia: materia },function(data){

		//console.log(data);
		data = JSON.parse(data);
	$("#periodo_actual").val(periodo);
	// $("#nombre_materia").val(nombre_materia);
	$("#selecionar_docente_cualquiera").show();
	$("#myModalDocenteCualquiera").modal("show");
	$("#selecionar_docente_cualquiera").html(data);
	$('#mostrardocentes_todos').dataTable({

		dom: 'Bfrtip',

		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},

		],

	});
	});
	
}

function mostrar(id)
{
	$.post("../controlador/horario_especial.php?op=mostrar",{id : id}, function(data, status)
	{
		
		data = JSON.parse(data);	
		mostrarform(true);

	
		$("#programa").val(data.programa);
		$("#programa").selectpicker('refresh');
		$("#nombre").val(data.nombre);		
		$("#semestre").val(data.semestre);		
		$("#area").val(data.area);
		$("#area").selectpicker('refresh');
		$("#creditos").val(data.creditos);
		$("#codigo").val(data.codigo);
		$("#presenciales").val(data.presenciales);
		$("#independiente").val(data.independiente);
		$("#escuela").val(data.escuela);		
		$("#escuela").selectpicker('refresh');
		$("#id").val(data.id);

	});
	
}


function guardaryeditarcalidad(e1){
	// e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioagregarimageneditar")[0]);
	$.ajax({
		"url": "../controlador/web_calidad_crecimiento.php?op=guardaryeditarcalidad",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			//console.log(datos);
			$("#ModalEditarDocente").modal("hide");
			// alertify.set('notifier','position', 'top-center');
			alertify.success(datos);
			
		}
	});
}


function eliminar_docente(id_horas_grupos){

	alertify.confirm("¿Está Seguro de eliminar", function(result){
		if(result){
			$.post("../controlador/horario_especial.php?op=eliminar_docente", {'id_horas_grupos' : id_horas_grupos}, function(e){
				//console.log(e);
				if(e){
					alertify.success("Eliminado correctamente");
					mostrarmaterias(id_programa_ac_,id_estudiante_,ciclo_materia)
					
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}


function mostrar_editar_docente(periodo,ciclo_materia,materia,id_horas_grupos){
	$.post("../controlador/horario_especial.php?op=mostrar_editar_docente",{ciclo_materia : ciclo_materia,periodo: periodo,materia: materia ,id_horas_grupos: id_horas_grupos },function(data){

		//console.log(data);
		data = JSON.parse(data);
	$("#periodo_actual").val(periodo);
	// $("#nombre_materia").val(nombre_materia);
	$("#editar_docente_cualquiera").show();
	$("#ModalEditarDocente").modal("show");
	$("#editar_docente_cualquiera").html(data);
	$('#editar_docentes_todos').dataTable({
		
		dom: 'Bfrtip',
		
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			
		],
		
	});
});

}

function editar_asignar_cualquier_docente(dia,hora,hasta,salon,id_horas_grupos_input,id_docente_grupo) {
	
	$.post("../controlador/horario_especial.php?op=editar_asignar_cualquier_docente", {"dia" : dia,"hora" : hora,"hasta" : hasta, "salon" : salon , "id_horas_grupos_input" : id_horas_grupos_input, "id_docente_grupo" : id_docente_grupo}, function (data) {
		//console.log(data);	
		alertify.success(data);
		$("#id_horas_grupos").val(data.id_horas_grupos);
		$("#ModalEditarDocente").modal("hide");

	});

	mostrarmaterias(id_programa_ac_,id_estudiante_,ciclo_materia)
}


init();