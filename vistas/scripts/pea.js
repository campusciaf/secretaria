var tabla;
var tablados;
//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	$("#precarga").hide();
	$("#listadoregistros").hide();
	$("#gestion_pea").hide();
	$("#btnvolver").hide();
	$("#btnagregar").hide();
	
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	$("#formulariocrearpea").on("submit",function(e2)
	{
		guardarpea(e2);	
	});
	
	$("#formularioreferencia").on("submit",function(e)
	{
		guardaryeditarreferencia(e);	
	});
	
	$.post("../controlador/pea.php?op=selectPrograma", function(r){
	            $("#programa_ac").html(r);
	            $('#programa_ac').selectpicker('refresh');
	});
	$.post("../controlador/pea.php?op=selectPrograma", function(r){
	            $("#programa").html(r);
	            $('#programa').selectpicker('refresh');
	});
	

	

	
}



//Función limpiar
function limpiar()
{
	$("#id").val("");
	$("#id_tema").val("");
	$("#conceptuales").val("");
	$("#procedimentales").val("");
	$("#actitudinales").val("");
	$("#criterios").val("");



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
		$("#gestion_pea").hide();
		$("#btnvolver").hide();
	}
	else
	{
		$("#gestion_pea").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
		$("#seleccionprograma").show();
		$("#btnvolver").show();
		
		
	
	}
}

function volver()
{
		$("#gestion_pea").hide();
		$("#listadoregistros").show();
		$("#seleccionprograma").show();
		$("#btnagregar").hide();
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
	$("#seleccionprograma").hide();
}

//Función Listar
function listar(programa)
{
	$("#precarga").show();
	$("#listadoregistros").show();
	$("#btnagregar").hide();
	$("#gestion_pea").hide();
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

	if ($.fn.DataTable.isDataTable("#tbllistado")) {
		$("#tbllistado").DataTable().destroy();
	}

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
						messageTop: '<div style="width:50%;float:left">Plan Educativo de Aula<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'PEA',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/pea.php?op=listar&programa='+programa,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
				'initComplete': function (settings, json) {
					
					$("#precarga").hide();
				},


		
      });

	
$("#precarga").hide();		
		
}

//Función Listar
function ver_pea(id_pea)
{
	$("#gestion_pea").show();
	$("#myModalPea").modal("hide");
	$("#listadoregistros").hide();
	$("#seleccionprograma").hide();
	$("#btnagregar").show();
	$("#btnvolver").show();
	$("#id_pea").val(id_pea);

	$.post("../controlador/pea.php?op=verPea",{id_pea : id_pea,}, function(data)
	{
		data = JSON.parse(data);
		$("#tbllistadopea").html("");
		$("#tbllistadopea").append(data["0"]["0"]);
		
	});


}


//Función Listar
function ver_pea2(id_pea)
{
		$("#gestion_pea").show();
		$("#myModalPea").modal("hide");
		$("#listadoregistros").hide();
		$("#seleccionprograma").hide();
		$("#btnagregar").show();
		$("#btnvolver").show();
		$("#id_pea").val(id_pea);
		
		
	
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

	if ($.fn.DataTable.isDataTable("#tbllistadopea")) {
		$("#tbllistadopea").DataTable().destroy();
	}
	
	tablados=$('#tbllistadopea').dataTable(
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
					url: '../controlador/pea.php?op=verPea&id_pea='+id_pea,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},



		
		
      });

	
$("#precarga").hide();		
		
}	
	
		

function versionPea(id_programa_ac,id_materia)
{
	$.post("../controlador/pea.php?op=listarVersiones",{id_programa_ac : id_programa_ac, id_materia:id_materia}, function(data, status)
	{
		data = JSON.parse(data);
		$("#resultado").html("");
		$("#resultado").append(data["0"]["0"]);
		
		$("#myModalPea").modal("show");
	});
}

function crearpea(id_programa_ac,id_materia)
{
	$.post("../controlador/pea.php?op=crearPea",{id_programa_ac : id_programa_ac, id_materia:id_materia}, function(data, status)
	{
		data = JSON.parse(data);
		$("#resultadocrearpea").html("");
		$("#resultadocrearpea").append(data["0"]["0"]);
		$("#myModalCrearPea").modal("show");
		$("#version").val(data["0"]["1"]);
		$("#id_materia").val(id_materia);
		
		//ojo falta realizar la prueba para insertar el pea recuerde que solo mando tres campos, version, id_tema y fecha de aprobacion, falta el resto pero esto es solo una prueba felices pascuas si lees este mansaje es porque ya es 13 de enero del 2020.
		
	});
}
function agregartema(id_pea)
{
		$("#id_pea").val(id_pea);
		$("#myModalTema").modal("show");
		$("#btnGuardar").prop("disabled",false);
	
}

function agregarreferencia(id_pea)
{
		$("#id_pea_2").val(id_pea);
		$("#id_pea_referencia").val("");
		$("#myModalReferencia").modal("show");
		$("#btnGuardarReferencia").prop("disabled",false);
	
}


function actualizardescripcion(valor,id_pea)
{
	var contenido="";
	if(valor==1){
		contenido=$("#competencias").val();
	}
	if(valor==2){
		contenido=$("#resultado_apre").val();
	}
	if(valor==3){
		contenido=$("#criterio").val();
	}
	if(valor==4){
		contenido=$("#metodologia").val();
	}

	$.post("../controlador/pea.php?op=actualizardescripcion",{contenido : contenido, id_pea:id_pea , valor:valor}, function(data)
	{
		data = JSON.parse(data);
		if(data["0"]["0"]==1){
			alertify.success("Actualizado"); 
		}
		else if(data["0"]["0"]==2){
			alertify.error("No se pudo actualizar"); 
		}

	});
		
	
}


function mostrareditartema(id_tema,id_pea)
{
	$.post("../controlador/pea.php?op=mostrareditartema",{id_tema : id_tema}, function(data)
	{
		
		data = JSON.parse(data);	
		$("#id_tema").val(id_tema);
		$("#myModalTema").modal("show");
		$("#conceptuales").val(data.conceptuales);
		$("#btnGuardar").prop("disabled",false);
		ver_pea(id_pea);

 	});
	
}

function mostrareditarreferencia(id_pea_referencia,id_pea)
{
	$.post("../controlador/pea.php?op=mostrareditarreferencia",{id_pea_referencia : id_pea_referencia}, function(data)
	{
		
		data = JSON.parse(data);	
		$("#id_pea_referencia").val(id_pea_referencia);
		$("#id_pea_2").val(id_pea);
		$("#myModalReferencia").modal("show");
		$("#referencia").val(data.referencia);
		$("#btnGuardarreferencia").prop("disabled",false);
		ver_pea(id_pea);

 	});
	
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var id_pea=$("#id_pea").val();
	
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/pea.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			
			data = JSON.parse(datos);
			if(data["0"]["0"]==1){
				alertify.success("Tema agregado"); 
			}
			else if(data["0"]["0"]==2){
				alertify.error("No se pudo agregar"); 
			}
			else if(data["0"]["0"]==3){
				alertify.success("Tema actualizado");  
			}else{
				alertify.error("Tema no actualizado");
			}
	         ver_pea(data["0"]["1"]);        
	          $("#myModalTema").modal("hide");

			
			
	    }

	});
	limpiar();
}


function guardaryeditarreferencia(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarReferencia").prop("disabled",true);
	var id_pea=$("#id_pea").val();
	
	var formData = new FormData($("#formularioreferencia")[0]);

	$.ajax({
		url: "../controlador/pea.php?op=guardaryeditarreferencia",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			
			data = JSON.parse(datos);
			if(data["0"]["0"]==1){
				alertify.success("Referencia agregada"); 
			}
			else if(data["0"]["0"]==2){
				alertify.error("No se pudo agregar"); 
			}
			else if(data["0"]["0"]==3){
				alertify.success("Referencia actualizada");  
			}else{
				alertify.error("Referencia no actualizado");
			}
	         ver_pea(data["0"]["1"]);        
	          $("#myModalReferencia").modal("hide");
			  $("#referencia").val("");
			  $("#id_pea_2").val("");
			  $("#btnGuardarReferencia").prop("disabled",false);

	    }

	});
	limpiar();
}


function guardarpea(e2)
{
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardarPea").prop("disabled",true);
	
	
	var formData = new FormData($("#formulariocrearpea")[0]);

	$.ajax({
		url: "../controlador/pea.php?op=guardarpea",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(data)
	    {   
			
			data = JSON.parse(data);
			
	        alertify.success(data["0"]["0"]);          
			$("#myModalCrearPea").modal("hide");
			$("#btnGuardarPea").prop("disabled",false);
			
			listar(data["0"]["1"]);
			
			
	    }

	});
	limpiar();
}

//Función para desactivar registros
function desactivar(id_pea)
{


	alertify.confirm('Desactivar Versión del Pea',"¿Está Seguro de desactivar la versión Pea?", function(){

        	$.post("../controlador/pea.php?op=desactivar", {id_pea : id_pea}, function(data){
			
				data = JSON.parse(data);
				if(data["0"]["0"]==1){
					
				   alertify.success("Programa Desactivado");
					
					versionPea(data["0"]["1"],data["0"]["2"]);
					
				   }
				else{
					alertify.error("Pea no se puede desactivar");
				}
        		
	            
        	});	
		}
					, function(){ alertify.error('Cancelado')});

}	
	
//Función para activar registros
function activar(id_pea)
{
	alertify.confirm('Activar Versión del Pea', '¿Está Seguro de activar la versión?', function(){ 
	
		$.post("../controlador/pea.php?op=activar", {id_pea : id_pea}, function(data){
				
        		data = JSON.parse(data);
				
				if(data["0"]["0"]==1){
				   alertify.success("Pea Activado");
					versionPea(data["0"]["1"],data["0"]["2"]);
				   }
				else{
					alertify.error("Pea no se puede activar");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}	
	
//Función para activar registros
function eliminartema(id_tema,id_pea)
{
	
	alertify.confirm("Eliminar tema", "¿Desea Eliminar esta tema?", function(){ 
	
		$.post("../controlador/pea.php?op=eliminartema", {id_tema:id_tema}, function(datos){
			var datos = JSON.parse(datos);
			
        		if(datos[0] == 1){
				   alertify.success("Temae liminado corerctamente");
				   
				   ver_pea(id_pea);

				   }
				else{
					alertify.error("Tema no se pudo  Eliminada");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}

//Función para activar registros
function eliminarreferencia(id_pea_referencia,id_pea)
{
	
	alertify.confirm("Eliminar referencia", "¿Desea Eliminar esta referencia?", function(){ 
	
		$.post("../controlador/pea.php?op=eliminarreferencia", {id_pea_referencia:id_pea_referencia}, function(datos){
			var datos = JSON.parse(datos);
			
        		if(datos[0] == 1){
				   alertify.success("Referencia eliminada");
				   
				   ver_pea(id_pea);

				   }
				else{
					alertify.error("Referencia no se pudo eliminadar");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}	

init();