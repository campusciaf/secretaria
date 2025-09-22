$(document).ready(incio);
function incio() {
    listar();
}
//solicitudesaprobadas.php

function listar() {
    $('#tbl_solicitudes_aprobadas').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            "stateSave": true,
            "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
            "ajax":
            {
                url: '../controlador/solicitudesaprobadas.php?op=listar_solicitudes_coordinacion',
                type: "get",
                dataType: "json",

                error: function (e) {
                    console.log(e.responseText);
                }
            },

			"bDestroy": true,
            "iDisplayLength": 5,//Paginación
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
//Función listar

function ver_pagos(id) {
    $('#modal_pagos_realizados').modal('show');
    $('#tbl_pagos').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            "stateSave": true,
            "columnDefs": [{ "className": "dt-center", "targets": "_all" }],
            "ajax":
            {
                url: '../controlador/solicitudesaprobadas.php?op=listar_pagos&id_solicitud=' + id,
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            //"order": [[ 4, "desc" ]]//Ordenar (columna,orden)
        }).DataTable();
}

function modificar_valor(id_pa, id_sol) {
    id_solicitud = id_sol;
    id_pago = id_pa;
    guia_pago = "2";
    $('#modal_pagar_viaticos').modal('show');
    $('#modal_pagos_realizados').modal('hide');
    $('#titulo_registro_pagos').html('<b>Editar información pago</b>');
    $.post("../controlador/solicitudesaprobadas.php?op=info_pago", { id: id_pa }, function (data, status) {
        //console.log(data);
        data = JSON.parse(data);
        $('#valor').val(data[0].valor_pago);
        $('#id_pago').val(data[0].id);
        $('#id_soli').val(data[0].id_solicitud);
        $('#observacion').val(data[0].observaciones_admin);
    });
}
function updatePago() {
    var data = {
        'id': $("#id_pago").val(),
        'id_soli': $("#id_soli").val(),
        'valor': $("#valor").val(),
        'obser': $("#observacion").val()
    };
    //console.log(data)

    $.post("../controlador/solicitudesaprobadas.php?op=updatePago", data, function (r) {
        //console.log(r);
        if ((r = "ok") || (r = "1")) {
            alertify.success("Registro de pago con exito");
            ver_pagos($("#id_soli").val());
            listar();
            limpiar();
            $("#modal_pagar_viaticos").modal("hide");
        } else {
            alertify.error("Error al registrar el pago");
        }
    });
}

function eliminar_pago(id_pa,id_sol) {
    var data = {
        'id_pa': id_pa,
        'id_sol': id_sol
    };

    alertify.confirm('Eliminar pago', 'Presione el botón aceptar para eliminar el registro', function () {
        $.post("../controlador/solicitudesaprobadas.php?op=deletePago", data, function (r) {
            //console.log(r);
            if (r = "ok") {
                alertify.success("Registro de pago con exito");
                ver_pagos(id_sol);
                listar();
                $("#modal_pagar_viaticos").modal("hide");
            } else {
                alertify.error("Error al registrar el pago");
            }
        });
    }, function () { }).set('labels', { ok: 'Aceptar', cancel: 'Cancelar' });
}

function abrir_pagar_viaticos(id) {
    $("#id_pago_re").val(id)
    $('#modal_regis_viaticos').modal('show');
    $('#titulo_registro_pagos2').html('<b>Registro pago</b>');
}

function aggPago() {
    var data = {
        'id': $("#id_pago_re").val(),
        'valor': $("#valor_re").val(),
        'obser': $("#observacion_re").val()
    };

    $.post("../controlador/solicitudesaprobadas.php?op=aggPago", data, function (r) {
        console.log(r);
        if ((r = "ok") || (r = "1")) {
            alertify.success("Registro de pago con exito");
            listar();
            limpiar();
            $("#modal_regis_viaticos").modal("hide");
        } else {
            alertify.error("Error al registrar el pago");
        }
    });

}

function ver_actividades(id, estado) {
    $('#modal_clases_registradas').modal('show');
    tbl_clases = $('#tbl_clases').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            responsive: true,
            "stateSave": true,
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" },
                {
                    "targets": [5],
                    "visible": false,
                    "searchable": false
                }
            ],
            "ajax":
            {
                url: '../controlador/solicitudesaprobadas.php?op=listar_clases_solicitud&id_solicitud=' + id,
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },

            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[4, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}

function limpiar() {
    $(".limpiar").val("");
}