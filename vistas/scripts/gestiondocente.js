var tabla;
var maxCaracteres = 280;
//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
    mostrar_datos_hora_catedra("1");
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
    $("#formularioeditarfuncionario").on("submit", function (e) {
        guardaryeditarfuncionario(e);
    });
    $("#formulariocrearcontrato").on("submit", function (e) {
        guardaryeditarcontrato(e);
    });

    $("#comentario_docente").on("submit", function (e) {
		guardarcomentario(e);
	});

    $("#imagenmuestra").hide();
    //Cargamos los items de los selects
    $.post(
        "../controlador/gestiondocente.php?op=selectTipoDocumento",
        function (r) {
            $("#usuario_tipo_documento").html(r);
            $("#usuario_tipo_documento").selectpicker("refresh");
        }
    );
    //Cargamos los items de los selects
    $.post("../controlador/gestiondocente.php?op=selectTipoSangre", function (r) {
        $("#usuario_tipo_sangre").html(r);
        $("#usuario_tipo_sangre").selectpicker("refresh");
    });
    //Cargamos los items de los selects contrato
    $.post(
        "../controlador/gestiondocente.php?op=selectTipoContrato",
        function (r) {
            $("#usuario_tipo_contrato").html(r);
            $("#usuario_tipo_contrato").selectpicker("refresh");
        }
    );
    $.post(
        "../controlador/gestiondocente.php?op=selectTipoContrato",
        function (r) {
            $("#tipo_contrato").html(r);
            $("#tipo_contrato").selectpicker("refresh");
        }
    );
    //Cargamos los items al select ejes
    $.post(
        "../controlador/gestiondocente.php?op=selectDepartamento",
        function (r) {
            $("#usuario_departamento_nacimiento").html(r);
            $("#usuario_departamento_nacimiento").selectpicker("refresh");
        }
    );
    $.post("../controlador/gestiondocente.php?op=selectMunicipio", function (r) {
        $("#usuario_municipio_nacimiento").html(r);
        $("#usuario_municipio_nacimiento").selectpicker("refresh");
    });
    $.post(
        "../controlador/gestiondocente.php?op=selectListaEstadoCivil",
        function (r) {
            $("#usuario_estado_civil").html(r);
            $("#usuario_estado_civil").selectpicker("refresh");
        }
    );
    $.post(
        "../controlador/gestiondocente.php?op=selectListaGenero",
        function (r) {
            $("#usuario_genero").html(r);
            $("#usuario_genero").selectpicker("refresh");
        }
    );
    $.post("../controlador/gestiondocente.php?op=selectPeriodo", function (r) {
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
    });
    // restamos la cantidad total de 280 para el mensaje cada vez que escriban.
    $('#mensaje_docente').on('input', function () {
		let texto = $(this).val();
		let caracteresRestantes = maxCaracteres - texto.length;
		// En caso de que el usuario pegue más texto del permitido
		if (caracteresRestantes < 0) {
			$(this).val(texto.substring(0, maxCaracteres));
			caracteresRestantes = 0;
		}
		$('#contador_texto').text(caracteresRestantes);
	});
}
//Función limpiar
function limpiar() {
    $("#id_usuario").val("");
    $("#usuario_tipo_documento").val("");
    $("#usuario_tipo_documento").selectpicker("refresh");
    $("#usuario_identificacion").val("");
    $("#usuario_nombre").val("");
    $("#usuario_nombre_2").val("");
    $("#usuario_genero").val("");
    $("#usuario_apellido").val("");
    $("#usuario_apellido_2").val("");
    $("#usuario_fecha_nacimiento").val("");
    $("#usuario_departamento_nacimiento").val("");
    $("#usuario_departamento_nacimiento").selectpicker("refresh");
    $("#usuario_municipio_nacimiento").val("");
    $("#usuario_municipio_nacimiento").selectpicker("refresh");
    $("#usuario_direccion").val("");
    $("#usuario_tipo_contrato").val("");
    $("#usuario_tipo_contrato").selectpicker("refresh");
    $("#usuario_tipo_sangre").val("");
    $("#usuario_tipo_sangre").selectpicker("refresh");
    $("#usuario_telefono").val("");
    $("#usuario_celular").val("");
    $("#usuario_email_p").val("");
    $("#usuario_estado_civil").val("");
    $("#usuario_estado_civil").selectpicker("refresh");
    $("#usuario_email_ciaf").val("");
    $("#imagenmuestra").attr("src", " ");
    $("#imagenactual").val("");
}
//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}
//Función Listar
function listar() {
    $("#precarga").show();
    var meses = new Array(
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    );
    var diasSemana = new Array(
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado"
    );
    var f = new Date();
    var fecha_hoy =
        diasSemana[f.getDay()] +
        ", " +
        f.getDate() +
        " de " +
        meses[f.getMonth()] +
        " de " +
        f.getFullYear();
    tabla = $("#tbllistado")
        .dataTable({
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            dom: "Bfrtip", //Definimos los elementos del control de tabla
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: "Excel"
                },
                {
                    extend: "print",
                    text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop:
                        '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' +
                        fecha_hoy +
                        ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: "Docentes",
                    titleAttr: "Print"
                }
            ],
            ajax: {
                url: "../controlador/gestiondocente.php?op=listar",
                type: "get",
                dataType: "json",
                error: function (e) {
                    // console.log(e.responseText);
                }
            },
            initComplete: function () {
                $("#precarga").hide();
            },
            bDestroy: true,
            iDisplayLength: 10, //Paginación
            order: [[12, "asc"]] //Ordenar (columna,orden)
        })
        .DataTable();
}
//Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../controlador/gestiondocente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            // console.log(datos);
            alertify.success(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}
function mostrar(id_usuario) {
    $.post(
        "../controlador/gestiondocente.php?op=mostrar",
        { id_usuario: id_usuario },
        function (data, status) {
            // console.log(data);
            data = JSON.parse(data);
            mostrarform(true);
            $("#usuario_tipo_documento").val(data.usuario_tipo_documento);
            $("#usuario_tipo_documento").selectpicker("refresh");
            $("#usuario_identificacion").val(data.usuario_identificacion);
            $("#usuario_genero").val(data.usuario_genero);
            $("#usuario_genero").selectpicker("refresh");
            $("#usuario_nombre").val(data.usuario_nombre);
            $("#usuario_nombre_2").val(data.usuario_nombre_2);
            $("#usuario_apellido").val(data.usuario_apellido);
            $("#usuario_apellido_2").val(data.usuario_apellido_2);
            $("#usuario_fecha_nacimiento").val(data.usuario_fecha_nacimiento);
            $("#usuario_departamento_nacimiento").val(
                data.usuario_departamento_nacimiento
            );
            $("#usuario_departamento_nacimiento").selectpicker("refresh");
            $("#usuario_municipio_nacimiento").val(data.usuario_municipio_nacimiento);
            $("#usuario_municipio_nacimiento").selectpicker("refresh");
            $("#usuario_direccion_2").val(data.usuario_direccion);
            $("#usuario_telefono_2").val(data.usuario_telefono);
            $("#usuario_celular_2").val(data.usuario_celular);
            $("#usuario_email_p").val(data.usuario_email_p);
            $("#usuario_estado_civil").val(data.usuario_estado_civil);
            $("#usuario_estado_civil").selectpicker("refresh");
            $("#usuario_tipo_contrato").val(data.usuario_tipo_contrato);
            $("#usuario_tipo_contrato").selectpicker("refresh");
            $("#usuario_tipo_sangre").val(data.usuario_tipo_sangre);
            $("#usuario_tipo_sangre").selectpicker("refresh");
            $("#usuario_email_ciaf").val(data.usuario_email_ciaf);
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr(
                "src",
                "../files/usuarios/" + data.usuario_imagen
            );
            $("#imagenactual").val(data.usuario_imagen);
            $("#id_usuario").val(data.id_usuario);
        }
    );
}
//Función para desactivar registros
function desactivar(id_usuario) {
    alertify.confirm(
        "Desactivar Usuario",
        "¿Está Seguro de desactivar el usuario?",
        function () {
            $.post(
                "../controlador/gestiondocente.php?op=desactivar",
                { id_usuario: id_usuario },
                function (e) {
                    if (e == 1) {
                        alertify.success("Usuario Desactivado");
                        tabla.ajax.reload();
                    } else {
                        alertify.error("Usuario no se puede desactivar");
                    }
                }
            );
        },
        function () {
            alertify.error("Cancelado");
        }
    );
}
//Función para activar registros
function activar(id_usuario) {
    alertify.confirm(
        "Activar Usuario",
        "¿Está Seguro de activar el Usuario?",
        function () {
            $.post(
                "../controlador/gestiondocente.php?op=activar",
                { id_usuario: id_usuario },
                function (e) {
                    if (e == 1) {
                        alertify.success("Usuario Activado");
                        tabla.ajax.reload();
                    } else {
                        alertify.error("Usuario no se puede activar");
                    }
                }
            );
        },
        function () {
            alertify.error("Cancelado");
        }
    );
}
function guardaryeditarfuncionario(e) {
    e.preventDefault();
    alertify
        .confirm(
            "Confirmación",
            "¿Está seguro de guardar? Los cambios no se podrán deshacer.",
            function () {
                var formData = new FormData($("#formularioeditarfuncionario")[0]);
                $.ajax({
                    url: "../controlador/gestiondocente.php?op=guardaryeditarfuncionario",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (datos) {
                        // console.log(datos);
                        alertify.set("notifier", "position", "top-center");
                        alertify.success(datos);
                        $("#ModalEditarFuncionario").modal("hide");
                        // listar();
                    }
                });
            },
            function () {
                $("#ModalEditarFuncionario").modal("hide");
            }
        )
        .set("labels", { ok: "Aceptar", cancel: "Cancelar" });
}
// function guardaryeditarcontrato(e){
// 	e.preventDefault();
// 	var formData = new FormData($("#formulariocrearcontrato")[0]);
// 	$.ajax({
// 		"url": "../controlador/gestiondocente.php?op=guardaryeditarcontrato",
// 		"type": "POST",
// 		"data": formData,
// 		"contentType": false,
// 		"processData": false,
// 		success: function(datos){
// 			console.log(datos);
// 			$("#MymodalMostrarContrato").modal("hide");
// 			Swal.fire({
// 				position: "top-end",
// 				icon: "success",
// 				title: "Contrato Agregado",
// 				showConfirmButton: false,
// 				timer: 1500,
// 			});
// 			$("#tbllistado").DataTable().ajax.reload();
// 		}
// 	});
// }
function guardaryeditarcontrato(e) {
    e.preventDefault();
    var formData = new FormData($("#formulariocrearcontrato")[0]);
    $("#btnGuardarContrato").hide();
    $.ajax({
        url: "../controlador/gestiondocente.php?op=guardaryeditarcontrato",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.includes("Faltan documentos obligatorios")) {
                Swal.fire({
                    icon: "error",
                    title: response,
                    showConfirmButton: true
                });
                $("#btnGuardarContrato").show();
            } else if (response.includes("Contrato Agregado")) {
                Swal.fire({
                    icon: "success",
                    title: "Contrato Agregado",
                    timer: 1500,
                    showConfirmButton: false
                });
                $("#MymodalMostrarContrato").modal("hide");
                $("#tbllistado").DataTable().ajax.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error al procesar la solicitud.",
                    showConfirmButton: true
                });
            }
        }
    });
}
// function guardaryeditarcontrato(e) {
//     e.preventDefault();
//     alertify.confirm(
//         "Confirmación",
//         "¿Está seguro de guardar? Los cambios no se podrán deshacer.",
//         function() { // Función de callback cuando se pulsa "Aceptar"
//             var formData = new FormData($("#formulariocrearcontrato")[0]);
//             $.ajax({
//                 "url": "../controlador/gestiondocente.php?op=guardaryeditarcontrato",
//                 "type": "POST",
//                 "data": formData,
//                 "contentType": false,
//                 "processData": false,
//                 success: function(datos) {
//                     console.log(datos);
//                     alertify.set('notifier', 'position', 'top-center');
//                     alertify.success(datos);
// 					$("#MymodalMostrarContrato").modal('hide');
// 					// listar();
//                 }
//             });
//         },
//         function() { // Función de callback cuando se pulsa "Cancelar"
//             // Cierra el modal
//             $("#MymodalMostrarContrato").modal('hide');
//         }
//     ).set('labels', {ok:'Aceptar', cancel:'Cancelar'});
// }
function editar_tipo_contrato(documento_docente_editar) {
    $("#documento_docente_editar").val(documento_docente_editar);
    $("#ModalEditarFuncionario").modal("show");
}
function crearcontrato(
    usuario_identificacion,
    nombre_docente,
    apellido_docente,
    usuario_email_p
) {
    $("#documento_docente_contrato").val(usuario_identificacion);
    $("#nombre_docente_contrato").val(nombre_docente);
    $("#apellido_docente_contrato").val(apellido_docente);
    $("#usuario_email_p_contrato").val(usuario_email_p);
    $("#crear_contrato").html("Crear Contrato");
    $("#MymodalMostrarContrato").modal("show");
    $("#salario_docente").val("");
    $("#fecha_inicio_contrato").val("");
    $("#fecha_final_contrato").val("");
    $("#auxilio_transporte").val("");
}
function mostrar_datos_hora_catedra(valor) {
    if (valor == "2" || valor == "1") {
        //clase para ocultar los input
        $("#cargo_docente_ocultar").hide();
        $("#cargo_docente").removeAttr("required");
        $("#cantidad_horas_ocultar").hide();
        $("#cantidad_horas").removeAttr("required");
        $("#valor_horas_ocultar").hide();
        $("#valor_horas").hide().removeAttr("required");
        $("#materia_docente_ocultar").hide();
        $("#materia_docente").removeAttr("required");
    } else {
        $("#cargo_docente_ocultar").show();
        $("#cargo_docente").show().attr("required", true);
        $("#cantidad_horas_ocultar").show();
        $("#cantidad_horas").show().attr("required", true);
        $("#valor_horas_ocultar").show();
        $("#valor_horas").show().attr("required", true);
        $("#materia_docente_ocultar").show();
        $("#materia_docente").show().attr("required", true);
    }
}
function mostrarContratos(usuario_identificacion) {
    $("#modalListarContratos").modal("show");
    $.post(
        "../controlador/gestiondocente.php?op=buscarContratos",
        { usuario_identificacion: usuario_identificacion },
        function (data, status) {
            // console.log(data);
            var r = JSON.parse(data);
            // $("#datosusuario_contactanos").html(r);
            $("#datosusuario_contactanos").html(r[0]);
            $("#mostrarcontratos").dataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel"
                    }
                ]
            });
        }
    );
}
function eliminarContrato(id_docente_contrato) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: "¿Está Seguro de eliminar el contrato?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, continuar!",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controlador/gestiondocente.php?op=eliminarContrato", { id_docente_contrato: id_docente_contrato }, function (e) {
                if (e !== 'null') {
                    swalWithBootstrapButtons.fire({
                        title: "Ejecutado!",
                        text: "Contrato eliminada con éxito.",
                        icon: "success"
                    });
                }
                else {
                    swalWithBootstrapButtons.fire({
                        title: "Ejecutado!",
                        text: "Contrato no se puede eliminar.",
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
function mostrar_info_personal(usuario_identificacion) {
    $("#Modalhojadevida").modal("show");
    // Realiza una consulta para obtener el id_usuario_cv
    $.post(
        "../controlador/gestiondocente.php?op=obtener_id_usuario_cv",
        { usuario_identificacion: usuario_identificacion },
        function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                $(".nav-link").removeClass("btn-success btn-warning")
                if (data.info.referencias == 1) {
                    $("#paso6").addClass("btn-success");
                } else if (data.info.referencias == 0) {
                    $("#paso6").addClass("btn-warning");
                }
                if (data.info.obligatorios == 1) {
                    $("#paso8").addClass("btn-success");
                } else if (data.info.referencias == 0) {
                    $("#paso8").addClass("btn-warning");
                }
                if (data.info.paso1 == 1) {
                    $("#paso1").addClass("btn-success");
                } else if (data.info.paso1 == 0) {
                    $("#paso1").addClass("btn-warning");
                }
                if (data.info.paso2 == 1) {
                    $("#paso2").addClass("btn-success");
                } else if (data.info.paso1 == 0) {
                    $("#paso2").addClass("btn-warning");
                }
                if (data.info.experiencia == 1) {
                    $("#paso3").addClass("btn-success");
                } else if (data.info.experiencia == 0) {
                    $("#paso3").addClass("btn-warning");
                }
                if (data.info.habilidad == 1) {
                    $("#paso4").addClass("btn-success");
                } else if (data.info.habilidad == 0) {
                    $("#paso4").addClass("btn-warning");
                }
                if (data.info.portafolio == 1) {
                    $("#paso5").addClass("btn-success");
                } else if (data.info.portafolio == 0) {
                    $("#paso5").addClass("btn-warning");
                }
                if (data.info.referencias == 1) {
                    $("#paso7").addClass("btn-success");
                } else if (data.info.referencias == 0) {
                    $("#paso7").addClass("btn-warning");
                }
                if (data.info.adicionales == 1) {
                    $("#paso9").addClass("btn-success");
                } else if (data.info.adicionales == 0) {
                    $("#paso9").addClass("btn-warning");
                }
                if (data.info.area == 1) {
                    $("#paso10").addClass("btn-success");
                } else if (data.info.area == 0) {
                    $("#paso10").addClass("btn-warning");
                }
                var id_usuario_cv = data.id_usuario_cv;
                mostrarEducacion(id_usuario_cv);
                mostrarExperiencias(id_usuario_cv);
                mostrarHabilidades(id_usuario_cv);
                mostrarPortafolio(id_usuario_cv);
                mostrarReferenciasPersonales(id_usuario_cv);
                mostrarDocumentosObligatorios(id_usuario_cv);
                mostrarDocumentosAdicionales(id_usuario_cv);
                mostrarAreas(id_usuario_cv);
                mostrarReferenciasLaborales(id_usuario_cv)
                $.post(
                    "../controlador/gestiondocente.php?op=paso_1",
                    { usuario_identificacion: usuario_identificacion },
                    function (data) {
                        data = JSON.parse(data);
                        // console.log("ciudad"+data.info.departamento);
                        if (data.exito == 1) {
                            mostrar_departamento(data.info.departamento);
                            mostrar_ciudad(data.info.ciudad);
                            $("#nombres").val(data.info.usuario_nombre);
                            $("#apellidos").val(data.info.usuario_apellido);
                            $("#direccion").val(data.info.direccion);
                            $("#fecha_nacimiento").val(data.info.fecha_nacimiento);
                            $("#estado_civil").val(data.info.estado_civil);
                            $("#celular").val(data.info.telefono);
                            $("#nacionalidad").val(data.info.nacionalidad);
                            $("#pagina_web").val(data.info.pagina_web);
                            $("#titulo_profesional").val(data.info.titulo_profesional);
                            $("#categoria_profesion").val(data.info.categoria_profesion);
                            $("#situacion_laboral").val(data.info.situacion_laboral);
                            $("#resumen_perfil").val(data.info.perfil_descripcion);
                            $("#otro_ingresoff").val(data.info.experiencia_docente);
                            // $("#departamento").val();
                            // $("#ciudad").val(data.info.ciudad);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: data.info,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                );
            } else {
                Swal.fire({
                    icon: "error",
                    title: data.info,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    );
}
function mostrarEducacion(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-educacion_formacion')) {
        $('#table-educacion_formacion').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarEducacion",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv },
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while (cont < datos.length) {
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {
                    url = dividirCadena(datos["" + cont].certificado_educacion, "../", 1);
                    tabla += `<tr>
                            <td>`+ datos["" + cont].institucion_academica + `</td>
                            <td>`+ datos["" + cont].titulo_obtenido + `</td>
                            <td>`+ datos["" + cont].desde_cuando_f + `</td>
                            <td>`+ datos["" + cont].hasta_cuando_f + `</td>
                            <td>`+ datos["" + cont].mas_detalles_f + `</td>
                            <td><a href="../cv/`+ url + `" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Certificado en pesataña nueva"><i class="fas fa-link"></i></a></td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-educacion_formacion").html(tabla);
            $('#table-educacion_formacion').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
                "destroy": true,
            });
            if (cont >= 2) {
                $('#btnSiguiente_educacion_formacion').show();
            } else {
                $('#btnSiguiente_educacion_formacion').hide();
            }
        }
    });
}
function dividirCadena(cadenaADividir, separador, index) {
    if (cadenaADividir == "" || cadenaADividir === null || cadenaADividir === undefined) {
        return []; // Devuelve un array vacío si cadenaADividir es una cadena vacía, null o undefined
    } else {
        var arrayDeCadenas = cadenaADividir.split(separador);
        return arrayDeCadenas[index];
    }
}
function mostrarHabilidades(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-habilidades_aptitudes')) {
        $('#table-habilidades_aptitudes').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarHabilidades",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv },
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            var maxRows = 5; // Número máximo de filas a mostrar
            while (cont < datos.length && cont < maxRows) { // Limitar a 5 filas
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {
                    var color;
                    switch (datos["" + cont].nivel_habilidad) {
                        case "1":
                            color = "bg-red";
                            break;
                        case "2":
                            color = "bg-orange";
                            break;
                        case "3":
                            color = "bg-warning";
                            break;
                        case "4":
                            color = "bg-teal";
                            break;
                        case "5":
                            color = "bg-green";
                            break;
                        default:
                            color = "bg-gray";
                            break;
                    }
                    tabla += `<tr>
                            <td>` + datos["" + cont].nombre_categoria + `</td>
                            <td>
                                <div class="progress-group">
                                    <span class="progress-number"><b>` + datos["" + cont].nivel_habilidad + `</b>/5</span>
                                    <br>
                                    <div class="progress progress-sm active">
                                    <div class="progress-bar ` + color + ` progress-bar-striped" role="progressbar" aria-valuenow="` + (parseInt(datos["" + cont].nivel_habilidad) * 2) + `0" aria-valuemin="0" aria-valuemax="100" style="width: ` + (parseInt(datos["" + cont].nivel_habilidad) * 2) + `0%">
                                      <span class="sr-only">` + (parseInt(datos["" + cont].nivel_habilidad) * 2) + `0% Complete</span>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-habilidades_aptitudes").html(tabla);
            $('#table-habilidades_aptitudes').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
                "destroy": true,
            });
            if (cont >= 5) {
                $('#btnSiguiente_habilidadesyaptitudes').show();
            } else {
                $('#btnSiguiente_habilidadesyaptitudes').hide();
            }
        }
    });
}
function mostrarPortafolio(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-portafolio')) {
        $('#table-portafolio').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarPortafolio",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv },
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while (cont < datos.length) {
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {
                    url = dividirCadena(datos["" + cont].portafolio_archivo, "../", 1);
                    tabla += `<tr>
                            <td>` + datos["" + cont].titulo_portafolio + `</td>
                            <td>` + datos["" + cont].descripcion_portafolio + `</td>
                            <td>` + ((datos["" + cont].video_portafolio == "") ? "" : `<a href="` + datos[cont].video_portafolio + `" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Ver video de youtube"><i class="fab fa-youtube"></i></a>`) + `</td>
                            <td>` + ((datos["" + cont].portafolio_archivo == "") ? "" : `<a href="../cv/` + url + `" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Certificado en pestaña nueva"><i class="fas fa-link"></i></a>`) + `</td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-portafolio").html(tabla);
            $('#table-portafolio').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
                "destroy": true,
            });
        }
    });
}
function mostrarReferenciasPersonales(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-referencias_personales')) {
        $('#table-referencias_personales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarReferenciasPersonales",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv },
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var maxRows = 2; // Número máximo de referencias a mostrar
            var tabla = "";
            if (datos.length === 0 || (datos.length === 1 && datos[0].id_usuario === "0")) {
                tabla += `<li class="list-group-item">
                            <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                        </li>`;
            } else {
                while (cont < datos.length && cont < maxRows) { // Limitar a 2 filas
                    tabla += `<tr>
                            <td>${datos[cont].referencias_nombre}</td>
                            <td>${datos[cont].referencias_profesion}</td>
                            <td>${datos[cont].referencias_empresa}</td>
                            <td>${datos[cont].referencias_telefono}</td>
                        </tr>`;
                    cont++;
                }
            }
            $(".body-referencias_personales").html(tabla);
            $('#table-referencias_personales').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
            });
        }
    });
}
function mostrarArchivo() {
    // $("#precarga").show();
    $.post("../controlador/gestiondocente.php?op=mostrarotrosestudios", {}, function (e) {
        var r = JSON.parse(e);
        $("#modal-mostrar-otros-estudios").modal("show");
        $("#mostrar_documentos_otros-estudios").html(r);
        // $("#precarga").hide();
        $("#mostrardocumentosootrosestudios").dataTable({
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: "Excel",
                },
            ],
            "iDisplayLength": 15,
        });
    }
    );
}
function mostrarDocumentosAdicionales(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-documentos_adicionales')) {
        $('#table-documentos_adicionales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarDocumentosAdicionales",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv },
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while (cont < datos.length) {
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {
                    url = dividirCadena(datos["" + cont].documento_archivoA, "../", 1);
                    tabla += `<tr>
                            <td>` + datos["" + cont].documento_nombreA + `</td>
                            <td>` + ((datos["" + cont].documento_archivoA == "") ? "" : `<a href="` + datos["" + cont].documento_archivoA + ` " class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Documento en pestaña nueva"><i class="fas fa-link"></i></a>`) + `</td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-documentos_adicionales").html(tabla);
            $('#table-documentos_adicionales').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
                "destroy": true,
            });
        }
    });
}
function mostrarAreas(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-areas_de_conocimiento')) {
        $('#table-areas_de_conocimiento').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarAreas",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv },
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while (cont < datos.length) {
                if (!datos[cont].id_area) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                              </li>`;
                } else {
                    tabla += `<tr>
                                <td>${datos[cont].nombre_area}</td>
                              </tr>`;
                }
                cont++;
            }
            $(".body-areas_de_conocimiento").html(tabla);
            $('#table-areas_de_conocimiento').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false
            });
            if (cont >= 5) {
                $('#btnFinalizar').show();
            } else {
                $('#btnFinalizar').hide();
            }
        }
    });
}
function mostrarDocumentosObligatorios(id_usuario_cv) {
    // $("#precarga").show();
    $.post("../controlador/gestiondocente.php?op=mostrarDocumentosObligatorios", { "id_usuario_cv": id_usuario_cv }, function (e) {
        var r = JSON.parse(e);
        $("#mostrar_documentos_obligatorios").html(r);
        // $("#precarga").hide();
        $("#mostrardocumentosobligatorios").dataTable({
            dom: "Bfrtip",
            buttons: [
                {
                    extend: "excelHtml5",
                    text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: "Excel",
                },
            ],
            "iDisplayLength": 15,
        });
        verificarEstadoDocumentos();
    }
    );
}
function verificarEstadoDocumentos() {
    var todosSubidos = $('#mostrar_documentos_obligatorios tr td').filter(function () {
        return $(this).text().trim() === 'Falta Subir';
    }).length === 0; // Verifica si no hay celdas con 'Falta Subir'
    $('#btnSiguiente').prop('disabled', !todosSubidos);
}
function mostrarExperiencias(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-experiencias_laborales')) {
        $('#table-experiencias_laborales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarexperiencias",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv }, // Enviar el id_usuario_cv
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while (cont < datos.length) {
                if (datos[cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {
                    tabla += `<tr>
                                <td>${datos[cont].nombre_empresa}</td>
                                <td>${datos[cont].cargo_empresa}</td>
                                <td>${datos[cont].desde_cuando}</td>
                                <td>${datos[cont].hasta_cuando}</td>
                                <td>${datos[cont].mas_detalles}</td>
                            </tr>`;
                }
                cont++;
            }
            $(".body-experiencias_laborales").html(tabla);
            $('#table-experiencias_laborales').DataTable({
                "dom": '',
                "paging": false,
                "destroy": true,
            });
            if (cont >= 2) {
                $('#btnSiguiente_experiencias_laborales').show();
            } else {
                $('#btnSiguiente_experiencias_laborales').hide();
            }
        }
    });
}
// Función JS actualizada para enviar id_usuario_cv
function mostrarReferenciasLaborales(id_usuario_cv) {
    if ($.fn.DataTable.isDataTable('#table-referencias_laborales')) {
        $('#table-referencias_laborales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/gestiondocente.php?op=mostrarReferenciasLaborales",
        type: "POST",
        data: { id_usuario_cv: id_usuario_cv },
        success: function (datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var maxRows = 2; // Número máximo de filas a mostrar
            var tabla = "";
            while (cont < datos.length && cont < maxRows) { // Limitar a 2 filas
                if (datos[cont].id_usuario_cv == "0") {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                              </li>`;
                } else {
                    tabla += `<tr>
                                <td>${datos[cont].referencias_nombrel}</td>
                                <td>${datos[cont].referencias_profesionl}</td>
                                <td>${datos[cont].referencias_empresal}</td>
                                <td>${datos[cont].referencias_telefonol}</td>
                              </tr>`;
                }
                cont++;
            }
            $(".body-referencias_laborales").html(tabla);
            $('#table-referencias_laborales').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
            });
        },
        error: function (xhr, status, error) {
            console.error("Error AJAX:", error);
        }
    });
}
function mostrar_departamento(departamento) {
    $.post("../controlador/gestiondocente.php?op=traer_departamento", { "departamento": departamento }, function (data) {
        data = JSON.parse(data);
        $("#departamento").val(data.info.departamento);
    });
}
function mostrar_ciudad(ciudad) {
    $.post("../controlador/gestiondocente.php?op=traer_municipio", { "ciudad": ciudad }, function (data) {
        data = JSON.parse(data);
        $("#ciudad").val(data.info.municipio);
    });
}
//Función para activar registros
function influencer_mas(id_usuario, estado) {
    if (estado == 1) {
        estado = 0;
        texto_estado = "No";
        titulo = "Desactivar Influencer+"
        texto = "Desactivar Influencer+ para el docente?"
    }else{
        estado = 1;
        texto_estado = "Si";
        titulo = "Activar Influencer+"
        texto = "Activar Influencer+ para el docente?"
    }
    alertify.confirm(titulo, texto, function () {
        $.post("../controlador/gestiondocente.php?op=influencer_mas", { "id_usuario": id_usuario, "estado": estado }, function (e) {
            data = JSON.parse(e);
            if (data.exito == 1) {
                Swal.fire("", "Estado Actualizado", "success");
                $(".estado_influencer_mas_" + id_usuario).html(texto_estado);
            } else {
                Swal.fire("", "No Se Pudo Actualizar", "error")
            }
        });
    },
    function(){
    });
}
// guardamos el comentario.
function guardarcomentario(e) {
	e.preventDefault();
	var formData = new FormData($("#comentario_docente")[0]);
	$.ajax({
		"url": "../controlador/gestiondocente.php?op=comentario_docente",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function (datos) {
			datos = JSON.parse(datos);
			if (datos["0"] == "ok") {
				alertify.success("Comentario realizado");
				$("#modalComentariosDocentes").modal("hide");
				$("#comentario_docente")[0].reset();
			} else {
				alertify.error('No se pudo crear el comentario');
			}
		},
	});
}
// mostramos el modal y llenamos el id_usuario_cv
function comentarios_docentes(id_usuario_cv) {
	$("#modalComentariosDocentes").modal("show");
	$("#id_usuario_cv_comentario_docente").val(id_usuario_cv);
	$("#precarga").hide();
	ListarComentariosDocente(id_usuario_cv);
}
//listamos los comentarios para cada docente.
function ListarComentariosDocente(id_usuario_cv) {
	$.post("../controlador/gestiondocente.php?op=ListarComentariosDocente", { "id_usuario_cv": id_usuario_cv }, function (data) {
		data = JSON.parse(data);
		$("#tbllistado_comentarios").html(data.info);
	});
}
init();
