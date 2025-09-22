var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#id_ejes").val("");
	$("#nombre_ejes").val("");
	$("#periodo").val("");
	$("#objetivo").val("");

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
					url: '../controlador/ejes.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 0, "desc" ]],//Ordenar (columna,orden)
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



function guardaryeditar(e) {
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);

	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		"url": "../controlador/ejes.php?op=guardaryeditar",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Eje Actualizada",
				showConfirmButton: false,
				timer: 1500
			});
			mostrarform(false);
			// $("#tbllistado").DataTable().ajax.reload();

		}
	});
	limpiar();

}



// function guardaryeditar(e)
// {
// 	e.preventDefault(); //No se activará la acción predeterminada del evento
// 	$("#btnGuardar").prop("disabled",true);
// 	var formData = new FormData($("#formulario")[0]);

// 	$.ajax({
// 		url: "../controlador/ejes.php?op=guardaryeditar",
// 	    type: "POST",
// 	    data: formData,
// 	    contentType: false,
// 	    processData: false,

// 	    success: function(datos)
// 	    {   
// 			console.log(datos);

// 	          alertify.success(datos);	          
// 	          mostrarform(false);
// 	          tabla.ajax.reload();
// 	    }

// 	});
// 	limpiar();
// }

function mostrar(id_ejes)
{
	$.post("../controlador/ejes.php?op=mostrar",{id_ejes : id_ejes}, function(data, status)
	{
		
		data = JSON.parse(data);		
		mostrarform(true);
		$("#id_ejes").val(data.id_ejes);
		$("#nombre_ejes").val(data.nombre_ejes);
		$("#periodo").val(data.periodo);
		$("#objetivo").val(data.objetivo);
 	});
}

//Función para desactivar registross
// function eliminar(id_ejes)
// {
// 	alertify.confirm("¿Está Seguro de eliminar la ejes?", function(result){
// 		if(result)
//         {
//         	$.post("../controlador/ejes.php?op=eliminar", {id_ejes : id_ejes}, function(e){
				
// 				if(e=='null'){
// 					alertify.success("Eliminado correctamente");
// 					tabla.ajax.reload();
// 				}
// 				else{
// 					alertify.error("Error")
// 				}
//         	});	
//         }
// 	})
// }



function eliminar(id_ejes) {
	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger"
		},
		buttonsStyling: false
	});
	swalWithBootstrapButtons.fire({
		title: "¿Está Seguro de eliminar la meta?",
		text: "¡No podrás revertir esto!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, continuar!",
		cancelButtonText: "No, cancelar!",
		reverseButtons: true
	}).then((result) => {
		if (result.isConfirmed) {

			$.post("../controlador/ejes.php?op=eliminar", { id_ejes : id_ejes}, function (e) {

				if (e == 'null') {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Eje eliminado con éxito.",
						icon: "success"
					});

					$('#tbllistadometas').DataTable().ajax.reload();
				}
				else {
					swalWithBootstrapButtons.fire({
						title: "Ejecutado!",
						text: "Eje no se puede eliminar.",
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