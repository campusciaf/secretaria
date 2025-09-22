var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	
	$("#archivomuestra").hide();
	//Mostramos los permisos

	
}

//Función limpiar
function limpiar()
{
	$("#id_formato").val("");
	$("#formato_nombre").val("");
	$("#formato_archivo").val("");

	
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
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

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
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },
			{
                extend: 'print',
			 	text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Formatos Institucionales',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/adminformatosinstitucionales.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		
      });
	

	
$("#precarga").hide();		
		
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/adminformatosinstitucionales.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			
	          alertify.success(datos);          
	          mostrarform(false);
	          tabla.ajax.reload();
			
	    }

	});
	limpiar();
}

//Función para eliminar un formato
function eliminarFormato(id_formato,formato_archivo)
{

	
	alertify.confirm('Eliminar Formato', '¿Está Seguro de eliminar el formato?', function(){ 

		$.post("../controlador/adminformatosinstitucionales.php?op=eliminarFormato",{id_formato:id_formato, formato_archivo:formato_archivo}, function(data, status)
			{
				console.log(data);
				data = JSON.parse(data);
				if(data==true){
				   alertify.success("Eliminado Correctamente");
					listar();
				   }

			});
	}
    , function(){ alertify.error('Cancelado')});
	
}

function mostrar(id_formato){
	$("#formularioregistros").show();
	$("#listadoregistros").hide();
	$("#btnagregar").hide();
	$.post("../controlador/adminformatosinstitucionales.php?op=mostrar",{id_formato:id_formato}, function(data, status){
		data = JSON.parse(data);
		$("#formato_nombre").val(data.formato_nombre);
	
	});
}



init();