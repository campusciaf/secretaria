var tabla;
//Función que se ejecuta al inicio
function init() {
    $("#listadoregistros").hide();
    $("#formularioverificar").on("submit", function (e1) {
        verificardocumento(e1);
    });
    $("#formularioticket").on("submit", function (e2) {
        guardarticket(e2);
    });
    $("#formulariofinanciacion").on("submit", function (e3) {
        guardarfinanciacion(e3);
    });
    $("#formAprobarMatricula").on("submit", function (e) {
        AprobarMatricula(e);
    });
    $(".calcularvalorapagar").on("change keyup", calcularValorFinal);
}
// carga los motivos en un select
function selectMotivo() {
    $.post("../controlador/sofi_pagosrematricula.php?op=selectMotivo",
        function (r) {
            //console.log(r);
            $("#motivo").html(r);
            $("#motivo").selectpicker("refresh");
        }
    );
}
//Función verificar documento, para saber si esa cédula exite en el campus
function verificardocumento(e1) {
    $("#listadomaterias").hide();
    e1.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularioverificar")[0]);
    $.ajax({
        "url": "../controlador/sofi_pagosrematricula.php?op=verificardocumento",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            data = JSON.parse(datos);
            var id_credencial = "";
            if (JSON.stringify(data["0"]["1"]) == "false") {
                // si llega vacio toca matricular
                alertify.error("Estudiante No Existe");
                $("#listadoregistros").hide();
                $("#mostrardatos").hide();
            } else {
                id_credencial = data["0"]["0"];
                $("#mostrardatos").show();
                alertify.success("Esta registrado");
                listar(id_credencial);
            }
        },
    });
}
//Función Listar
function listar(id_credencial) {
    $("#listadoregistros").show();
    var meses = new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
    tabla = $("#tbllistado").dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "Bfrtip",
        "buttons": [
            {
                "extend": "excelHtml5",
                "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": "Excel",
            },{
                "extend": "print",
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop": '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
                "title": "Programas Académicos",
                "titleAttr": "Print",
            }
        ],
        "ajax": {
            "url":"../controlador/sofi_pagosrematricula.php?op=listar&id_credencial=" +id_credencial,
            "type": "get",
            "dataType": "json",
            error: function (e) { },
        },
        "bDestroy": true,
        "scrollX": false,
        "iDisplayLength": 10, //Paginación
        "order": [[2, "asc"]], //Ordenar (columna,orden)
    }).DataTable();
    mostrardatos(id_credencial);
}
function mostrardatos(id_credencial) {
    $.post("../controlador/sofi_pagosrematricula.php?op=mostrardatos", { "id_credencial": id_credencial },
        function (data) {
            data = JSON.parse(data);
            $("#mostrardatos").html("");
            $("#mostrardatos").append(data["0"]["0"]);
        }
    );
}
// ver estado del credito con el id persona de la tabla sofi persona
function verestadocredito(id_persona) {
    $.post("../controlador/sofi_pagosrematricula.php?op=verestadocredito",{ "id_persona": id_persona },
        function (data) {
            data = JSON.parse(data);
            $("#estadocredito").html("");
            $("#estadocredito").append(data["0"]["0"]);
            $("#verestadocredito").modal("show");
        }
    );
}
function carrito(id_estudiante) {
    $.post("../controlador/sofi_pagosrematricula.php?op=carrito",{ "id_estudiante": id_estudiante },
        function (data) {
            data = JSON.parse(data);
            $("#listadoregistros").hide();
            $("#listadomaterias").show();
            $("#listadomaterias").html("");
            $("#listadomaterias").append(data["0"]["0"]);
            $("#precarga").hide();
        }
    );
}
function volver() {
    $("#listadoregistros").show();
    $("#listadomaterias").hide();
}
function nuevopago(opcion, id_estudiante) {
    $("#precarga").show();// abre la precarga
    $("#id_estudiante").val(id_estudiante);// contiene la variable id del estudiante
    selectMotivo();// carga el select motivos
    $.post("../controlador/sofi_pagosrematricula.php?op=nuevopago",{ "opcion": opcion, "id_estudiante": id_estudiante },
        function (data, status) {
            data = JSON.parse(data);
            $("#precarga").hide();// oculta la precarga
            $("#nuevopago").modal("show");// abre el modal del ticket
        }
    );
}
function financiacion(id_estudiante) {
    $("#precarga").show();// abre la precarga
    $("#id_estudiante_financiacion").val(id_estudiante);// contiene la variable id del estudiante
    //selectMotivo();// carga el select motivos
    $.post("../controlador/sofi_pagosrematricula.php?op=financiacion",{ "id_estudiante": id_estudiante },
        function (data) {
            data = JSON.parse(data);
            var identificacion = data[0].identificacion;
            var valor_total = data[0].valortotal;
            var valor_financiacion = data[0].financiacion;
            var valor_a_pagar = data[0].valorapagar;
            var estado = data[0].estado;
            if (estado == "Aprobado") {
                $("#nuevo_valor_financiacion").val(valor_a_pagar);// contiene el valor del pago
                $("#valor_total").val(valor_total);// contiene el valor del pago
                $("#valor_financiacion").val(valor_financiacion);// contiene el valor financiado en el sofi
                $("#financiacion").modal("show");// abre el modal del ticket
            } else {
                alertify.error("No tiene crédito aprobado");
            }
            $("#precarga").hide();// oculta la precarga
        }
    );
}
//Función Listar
function guardarticket(e2) {
    e2.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularioticket")[0]);
    $.ajax({
        "url": "../controlador/sofi_pagosrematricula.php?op=crearticket",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function (datos) {
            datos = JSON.parse(datos);
            if (datos["0"]["0"] == 1) {
                alertify.success("Ticket creado");
                $("#nuevopago").modal("hide");
                carrito(datos["0"]["1"]);
            } else if (datos["0"]["0"] == 2) {
                alertify.error("Ticket no creado");
                $("#nuevopago").modal("hide");
            } else {
                $("#nuevopago").modal("hide");
            }
        }
    });
}
//Función Listar
function guardarfinanciacion(e3) {
    e3.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formulariofinanciacion")[0]);
    $.ajax({
        "url": "../controlador/sofi_pagosrematricula.php?op=guardarfinanciacion",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            if (datos["0"]["0"] == 1) {
                alertify.success("Ticket creado");
                $("#financiacion").modal("hide");
                carrito(datos["0"]["1"]);
            }else if (datos["0"]["0"] == 2) {
                alertify.error("Ticket no creado");
                $("#financiacion").modal("hide");
            }else {
                $("#financiacion").modal("hide");
            }
        }
    });
}
//Función para eliminar ticket
function eliminarticket(id_ticket, id_estudiante) {
    alertify.confirm('Eliminar Ticket', '¿Está Seguro de eliminar el ticket?', function () {
        $.post("../controlador/sofi_pagosrematricula.php?op=eliminarticket", { "id_estudiante": id_estudiante, id_ticket: id_ticket }, function (datos) {
            datos = JSON.parse(datos);
            if (datos["0"]["0"] == 1) {
                alertify.success("Ticket Eliminado");
                carrito(id_estudiante);
            }else {
                alertify.error("Ticket no se puede eliminar");
            }
        });
    }, function () { alertify.error('Cancelado') });
}
function modalAprobarMatricula(id_estudiante) {
    $("#id_estudiante_matricula").val("");
    $("#total_pecuniario").val("");
    $("#porcentaje_descuento").val("");
    $("#centro_de_costos").val("");
    $("#codigo_yeminus").val("");
    //e.preventDefault();
    $("#id_estudiante_matricula").val(id_estudiante)
    $.ajax({
        "url": "../controlador/sofi_pagosrematricula.php?op=generarDatosMatricula",
        "type": "POST",
        "data": { "id_estudiante": id_estudiante },
        success: function (datos) {
            $("#modalAprobarMatricula").modal("show");
            //console.log(datos);
            datos = JSON.parse(datos);
            if (datos.exito == 1) {
                $("#total_pecuniario").val(datos.valor_pecuniario);
                $("#porcentaje_descuento").val(datos.aporte_social);
                $("#centro_de_costos").val(datos.centro_costo_yeminus);
                $("#codigo_yeminus").val(datos.codigo_producto);
                calcularValorFinal();
            } else {
                $(".no_datos_precios").text(datos.info);
            }
        }
    });
}
function calcularValorFinal(){
    total_pecuniario = Number($("#total_pecuniario").val());
    aporte_social = parseFloat($("#porcentaje_descuento").val());
    tiempo_pago = $(".tiempo_pago").val();
    porcentaje_extraordinaria = parseFloat($("#porcentaje_extraordinaria").val());
    aporte_socialtotal = total_pecuniario * (aporte_social / 100);
    valor_a_pagar = total_pecuniario - aporte_socialtotal; 
    console.log(total_pecuniario ,aporte_social ,tiempo_pago ,porcentaje_extraordinaria ,aporte_socialtotal ,valor_a_pagar);
    if (tiempo_pago == 1) {
        pronto_pago = valor_a_pagar * (10 / 100);
        valor_a_pagar = valor_a_pagar - pronto_pago;    
    } else if (tiempo_pago == 3){
        valor_extra = valor_a_pagar * (porcentaje_extraordinaria / 100);
        valor_a_pagar = valor_a_pagar + valor_extra;
    }
    let porcentaje_total_aplicado = ((total_pecuniario - valor_a_pagar) / total_pecuniario) * 100;
    porcentaje_total_aplicado = Math.round(porcentaje_total_aplicado * 100) / 100;
    $("#porcentaje_total_aplicado").val(porcentaje_total_aplicado);
    valor_a_pagar = Math.round(valor_a_pagar);
    $("#totaloferta").val(valor_a_pagar);
}
//Función para validar la rematricula
function AprobarMatricula(e) {
    e.preventDefault();
    var formData = new FormData($("#formAprobarMatricula")[0]);
    $.ajax({
        "url": "../controlador/sofi_pagosrematricula.php?op=AprobarMatricula",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            console.log(datos);
            datos = JSON.parse(datos);
            check = ["fa-times-circle text-danger", "fas fa-check-circle text-success"];
            if (datos.exito == 1) {
                $("#modalAprobarMatricula").modal("hide");
                $("#modalGestionYeminus").modal("show");
                alertify.success("Matricula realizada");
                html = '<tr>';
                html += '    <td> ' + datos.numeroFactura +'</td>';
                html += '    <td><i class="fas '+check[datos.crear_factura] +'"></i></td>';
                html += '    <td><i class="fas '+check[datos.cierre_venta] +'"></i></td>';
                html += '    <td><i class="fas '+check[datos.contabilizar] +'"></i></td>';
                html += '    <td><i class="fas '+check[datos.crear_recibo_caja] +'"></i></td>';
                html += '</tr>';
                $(".listado_gestion_yeminus").html(html);
                carrito($("#id_estudiante_matricula").val());
            }else {
                alertify.error("Matricula no se pudo realizar");
            }
        }
    });
}
function descargarrecibo(id_estudiante) {
    $.post("../controlador/sofi_pagosrematricula.php?op=descargarrecibo",{ "id_estudiante": id_estudiante },
        function (data) {
            data = JSON.parse(data);
            $("#verrecibo").modal("show");
            $("#datosrecibo").html("");
            $("#datosrecibo").append(data["0"]["0"]);
        }
    );
}
function imprSelec(historial) {
    var ficha = document.getElementById(historial);
    var ventimp = window.open(' ', 'popimpr');
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}

function nuevoNivel(nuevoid,est,pac,cic,id_credencial){
	Swal.fire({
		title: "Vamos a solicitar la nueva matrícula?",
		showCancelButton: true,
		confirmButtonText: "Continuar",
		showCancelText: "Cancelar",
	  }).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.isConfirmed) {

			$.post(
				"../controlador/sofi_pagosrematricula.php?op=nuevonivel", { nuevoid: nuevoid , est:est, pac:pac,cic:cic,id_credencial:id_credencial},
				function (data) {

					data = JSON.parse(data);

					if(data["0"]["0"]=="ok"){
						listar(id_credencial);
						Swal.fire("Creado!", "", "success");
						
					}
					else if(data["0"]["0"]=="perdio"){
						
						Swal.fire({
							position: "top-end",
							icon: "warning",
							title: "No puede renovar por el momento",
							showConfirmButton: false,
							timer: 1500
						  });
						
					}
					else{

						Swal.fire({
							position: "top-end",
							icon: "warning",
							title: "Your work has been saved",
							showConfirmButton: false,
							timer: 1500
						  });
						
					}
		
					
				}
			);


		 
		} else if (result.isDenied) {
		  Swal.fire("Changes are not saved", "", "info");
		}
	  });
}

init();