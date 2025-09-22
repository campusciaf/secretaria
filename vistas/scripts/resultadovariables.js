var tabla;
var indice=0;
//Función que se ejecuta al inicio
function init(){
    
	mostrarform(false);		
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	listarBotones();
    
 

    
//	$.post("../controlador/resultadovariables.php?op=selectTipoPregunta", function(r){
//	            $("#tipo_pregunta").html(r);
//	            $('#tipo_pregunta').selectpicker('refresh');
//	});	

	
}

//Función limpiar
function limpiar()
{
	$("#id_categoria").val("");	
	$("#id_tipo_pregunta").val("");
	$("#variable").val("");
    $("#obligatorio_no").prop('checked', false);
    $("#obligatorio_si").prop('checked', true);

	
}

//Función mostrar formulario
function mostrarform(flag)
{
	//limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#botones").hide();
        
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
        $("#botones").show();

       
     
	
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}


//Funcion para listar los resultados por categorias
function listarBotones()
{
	$.post("../controlador/resultadovariables.php?op=listarbotones", function(data){// metodo para traer la consulta listar botones
		data = JSON.parse(data);// convierte la consulta en un jason
		$("#botones").html("");// limpia el campo botones
		$("#botones").append(data["0"]["0"]);// agrega al campo botones el resultado de data
		$("#precarga").hide();
	});
}  
// ************************* //


//Funcion para listar los estudiantes que contestaron la categoria

function listarEstudiantes(id_categoria)
{
$("#precarga").show();

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
					url: '../controlador/resultadovariables.php?op=listarEstudiantes&id_categoria='+id_categoria,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			'initComplete': function (settings, json) {
				$("#myModalEstudiantes").modal("show");	
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


//Funcion para listar los estudiantes que contestaron la categoria

function verEstudiantes(id_categoria,id_variable,respuesta_id_variable)
{
$("#myModalEstudiantes").modal("show");	
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
					url: '../controlador/resultadovariables.php?op=verEstudiantes&id_categoria='+id_categoria+'&id_variable='+id_variable+'&respuesta_id_variable='+respuesta_id_variable,
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








function listar(id_categoria)
{
	$.post("../controlador/resultadovariables.php?op=listar",{id_categoria : id_categoria, indice:indice}, function(data, status)
	{
		data = JSON.parse(data);

		if(data["0"]["1"]==1){
			indice=0;
			mostrarform(false);
			listarBotones();
		}else{
			mostrarform(true);
			$("#preguntas").html("");
			$("#preguntas").append(data["0"]["0"]);
			indice++;
		}
	});
}



function mostrar(id_programa)
{
	$.post("../controlador/resultadovariables.php?op=mostrar",{id_programa : id_programa}, function(data, status)
	{
		
		data = JSON.parse(data);	
		mostrarform(true);
		
		$("#nombre").val(data.nombre);		
		$("#cod_programa_pea").val(data.cod_programa_pea);		
		$("#ciclo").val(data.ciclo);
		$("#cod_snies").val(data.cod_snies);
		$("#cant_asignaturas").val(data.cant_asignaturas);
		$("#semestres").val(data.semestres);
		$("#cortes").val(data.cortes);
		$("#inicio_semestre").val(data.inicio_semestre);		
		$("#escuela").val(data.escuela);
		$("#escuela").selectpicker('refresh');
		$("#original").val(data.original);
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_programa").val(data.id_programa);


 	});
	
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/resultadovariables.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
		
			 datos = JSON.parse(datos);
	          alertify.success(datos["0"]["0"]);  
              listar(datos["0"]["1"]);
//	          mostrarform(false);
//	          tabla.ajax.reload();
			
	    }

	});
	limpiar();
}

function listarVariable(id_categoria)
{
	$("#precarga").show();
	$.post("../controlador/resultadovariables.php?op=listarVariable",{id_categoria : id_categoria}, function(data, status)
	{
		data = JSON.parse(data);
        $("#botones").hide();
		$("#resultadolistarvariable").show();
		$("#resultadolistarvariable").html("");
		$("#resultadolistarvariable").append(data["0"]["0"]);
		$("#precarga").hide();
		
	});
}
function volver()
{
	$("#botones").show();
	$("#resultadolistarvariable").hide();
	$("#resultadolistarvariable").html("");

}

init();