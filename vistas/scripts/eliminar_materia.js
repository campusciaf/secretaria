var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	
	
	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
	
	$("#formularioverificar").on("submit",function(e1){
		verificardocumento(e1);	
	});
	
	$("#precarga").hide();

	
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
		url: "../controlador/eliminar_materia.php?op=verificardocumento",
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
					url: '../controlador/eliminar_materia.php?op=listar&id_credencial='+id_credencial,
					type : "get",
					dataType : "json",						
					error: function(e){
							
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
	$.post("../controlador/eliminar_materia.php?op=mostrardatos",{id_credencial : id_credencial}, function(data, status)
	{

		data = JSON.parse(data);
		$("#mostrardatos").html("");
		$("#mostrardatos").append(data["0"]["0"]);
			
	});
}

function mostrarmaterias(id_programa_ac,id_estudiante){
	$("#precarga").show();
	$.post("../controlador/eliminar_materia.php?op=mostrarmaterias",{id_programa_ac : id_programa_ac , id_estudiante : id_estudiante}, function(data, status)
	{
		data = JSON.parse(data);
		//$("#myModalAgregarPrograma").modal("show");
		$("#listadoregistros").hide();
		$("#listadomaterias").show();
		$("#listadomaterias").html("");
		$("#listadomaterias").append(data["0"]["0"]);
		$("#precarga").hide();
	});
	
}



function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar2").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	var credencial=$("#credencial_identificacion").val();
	
	$.ajax({
		url: "../controlador/eliminar_materia.php?op=guardaryeditar&credencial_identificacion="+credencial,
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			
		data = JSON.parse(datos);

		alertify.success(data["0"]["0"]);          
		mostrarform(false);
		listar(data["0"]["1"]);

			
	    }

	});
	limpiar();
}

function cancelarMateriasss(id_credencial,id_estudiante,id_programa_ac,id_materia,semestres_del_programa,id_materia_matriculada,promedio_materia_matriculada,periodo){
	$("#precarga").show();
	// alert(periodo);
	$.post("../controlador/eliminar_materia.php?op=cancelarMateria",{id_credencial:id_credencial,id_estudiante:id_estudiante ,id_programa_ac:id_programa_ac,id_materia:id_materia,semestres_del_programa:semestres_del_programa,id_materia_matriculada:id_materia_matriculada,promedio_materia_matriculada:promedio_materia_matriculada,periodo:periodo}, function(data, status)
	{
		// alert(data);
		data = JSON.parse(data);
		if(data==true){
			alertify.success("Materia Cancelada");
			mostrarmaterias(id_programa_ac,id_estudiante);
			
		}else{
			alertify.error("error");
		}
		
	});
	
}	

function cancelarMateria(id_credencial,id_estudiante,id_programa_ac,id_materia,semestres_del_programa,id_materia_matriculada,promedio_materia_matriculada,periodo){
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
		  confirmButton: "btn btn-success",
		  cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	  });
	  swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la materia?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	  }).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/eliminar_materia.php?op=cancelarMateria",{id_credencial:id_credencial,id_estudiante:id_estudiante ,id_programa_ac:id_programa_ac,id_materia:id_materia,semestres_del_programa:semestres_del_programa,id_materia_matriculada:id_materia_matriculada,promedio_materia_matriculada:promedio_materia_matriculada,periodo:periodo}, function(data, status){
				data = JSON.parse(data);
				if(data==true){
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Materia eliminada con éxito.",
						icon: "success"
					  });

					  mostrarmaterias(id_programa_ac,id_estudiante);
				   }
				else{
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Materia no se puede eliminar.",
						icon: "error"
					  });
				}
        	});

		} else if (
		  /* Read more about handling dismissals below */
		  result.dismiss === Swal.DismissReason.cancel
		) {
		  swalWithBootstrapButtons.fire({
			title: "Cancelado",
			text: "Tu proceso está a salvo :)",
			icon: "error"
		  });
		}
	  });
}

init();