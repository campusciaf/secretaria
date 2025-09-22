$(document).ready(inicio);
function inicio() {
    listarSalones();
    $("#formguardaryeditarsalon").on("submit", function (e) {
        guardaryeditarsalon(e);
    });

    // $("#formularioeditarsalones").on("submit",function(e){
	// 	guardaryeditarsalon(e);	
	// });
    
}

//Función Listar
function listarSalones()
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
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/salones.php?op=listarSalones',
					type : "get",
					dataType : "json",						
					error: function(e){
						// console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación

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
	
$("#precarga").hide();		
		
}

function guardaryeditarsalon(e) {
    $("#precarga").removeClass('hide');
	e.preventDefault();
	var formData = new FormData($("#formguardaryeditarsalon")[0]);
	$.ajax({
		"url": "../controlador/salones.php?op=guardaryeditarsalon",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			Swal.fire({
				position: "top-end",
				icon: "success",
				title: "Salon Actualizado",
				showConfirmButton: false,
				timer: 1500
			});
                listarSalones();
                $("#formguardaryeditarsalon")[0].reset();
                $("#exampleModal").modal("hide");
		}
	});
}


function eliminarSalon(id) {
    alertify.confirm('Eliminar salón', 'Desea eliminar el salón '+id, function () {

        $.post("../controlador/salones.php?op=eliminar", { id: id }, function (data, status) {
            var r = JSON.parse(data);
            if (r.status) {
                alertify.success('Salón eliminado con exito. ');
                $("#formguardaryeditarsalon")[0].reset();
                listarSalones();
            } else {
                alertify.error(r.status);
            }
        });
    }, function () { alertify.error('Cancel'); $("#formguardaryeditarsalon")[0].reset(); });
}

function estado(id,est) {

    var e = "";
    var a = "";

    if (est == "1") {
        e = "Activado";
        a = "Activar";
    } else {
        e = "Descativado";
        a = "Desactivar";
    }
    alertify.confirm(a+' salón', 'Desea '+a+' el salón '+id, function () {
        $.post("../controlador/salones.php?op=estado", { id: id, est:est }, function (data) {
            var r = JSON.parse(data);
            if (r.status) {
                alertify.success('Salón '+id+' '+e+' con exito. ');
                listarSalones();
				 
            } else {
                alertify.error("Erro al "+e+" el salón "+id);
            }
        });
    }, function () { alertify.error('Cancel');});
}

function video(id,est) {
    var e = "";
    var a = "";

    if (est == "1") {
        e = "Video beam agregado";
        a = "Agregar video beam al";
    } else {
        e = "Video beam expropiado";
        a = "Expropiar video beam al";
    }
    alertify.confirm(a + ' salón', 'Desea ' + a + ' salón ' + id, function () {
        $.post("../controlador/salones.php?op=video", { id: id, est: est }, function (data) {
            //console.log(data);
            var r = JSON.parse(data);
            if (r.status) {
                alertify.success(e+" al salón "+id);
               
				listarSalones();
            } else {
                alertify.error("Erro al " + e + " salón " + id);
            }
        });
    }, function () { alertify.error('Cancel'); });
}

function televi(id, est) {
    var e = "";
    var a = "";

    if (est == "1") {
        e = "TV agregado";
        a = "Agregar TV al";
    } else {
        e = "TV expropiado";
        a = "Expropiar TV al";
    }
    alertify.confirm(a + ' salón', 'Desea ' + a + ' salón ' + id, function () {
        $.post("../controlador/salones.php?op=televi", { id: id, est: est }, function (data) {
            //console.log(data);
            var r = JSON.parse(data);
            if (r.status) {
                alertify.success(e + " al salón " + id);
                listarSalones();
            } else {
                alertify.error("Erro al " + e + " salón " + id);
            }
        });
    }, function () { alertify.error('Cancel'); });
}


function activar_formulario(id, est) {
    var mensaje = "";
    var accion = "";

    if (est == "1") {
        mensaje = "Formulario activado";
        accion = "Activar formulario del";
    } else {
        mensaje = "Formulario desactivado";
        accion = "Desactivar formulario del";
    }

    alertify.confirm(
        accion + " salón",
        "¿Desea " + accion.toLowerCase() + " salón " + id + "?",
        function () {
            $.post("../controlador/salones.php?op=formulario_activar", { id: id, est: est }, function (data) {
                var r = JSON.parse(data);
                if (r.status) {
                    alertify.success(mensaje + " salón " + id);
                    listarSalones();
                } else {
                    alertify.error("Error al intentar " + accion.toLowerCase() + " salón " + id);
                }
            });
        },
        function () {
            alertify.error("Acción cancelada");
        }
    );
}



function mostrar_salones(codigo_salones){
	$.post("../controlador/salones.php?op=mostrar_salones",{"codigo_salones" : codigo_salones},function(data){
		data = JSON.parse(data);

			if(Object.keys(data).length > 0){
            $("#exampleModal").modal("show");
            $("#codigo_s").val(data.codigo);   
            $("#id_oculto_salon").val(data.codigo);   
            $("#capacidad").val(data.capacidad);
            $("#piso").val(data.piso);
            $("#sede").val(data.sede);
            $("#sede_otro").val(data.sede);
            $("#tv").val(data.tv);
            $("#video_beam").val(data.video_beam);
            $("#estado_formulario").val(data.estado_formulario);

            $("#sede").off("change", ocultarAsistentes).on("change", ocultarAsistentes);
            if (data.sede !== "CIAF" && data.sede !== "CRAI") {
                $("#sede").val("otro").trigger("change");
                $("#sede_otro").val(data.sede || "");
            } else {
                $("#sede").trigger("change");
            }
			
		}
	});
}
function ocultarAsistentes() {
    if ($("#sede").val() === "otro") {
        $("#sede_otro_wrap").removeClass("d-none");
        $("#sede_otro").prop("required", true);
    } else {
        $("#sede_otro_wrap").addClass("d-none");
        $("#sede_otro").prop("required", false).val("");
    }
}

function nuevoSalon() {
    $("#formguardaryeditarsalon")[0].reset();
    $("#id_oculto_salon").val("");
}



