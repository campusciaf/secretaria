var tabla, global_id_estudiante, global_id_programa_ac;
//Funcion para iniciar 
$(document).ready(init)
//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
    $("#formularioverificar").on("submit", function (e1) {
        verificardocumento(e1);
    });
    $("#formularionovedadjornada").on("submit", function (e2) {
        actualizarCambioJornada(e2);
    });
    $("#formularionovedadperiodo").on("submit", function (e3) {
        actualizarCambioPeriodo(e3);
    });
    $("#formularionovedadgrupo").on("submit", function (e4) {
        actualizarCambioGrupo(e4);
    });
    $.post("../controlador/matriculamaterias.php?op=selectPrograma", function (r) {
        $("#fo_programa").html(r);
        $("#fo_programa").selectpicker("refresh");
    });
    $.post("../controlador/matriculamaterias.php?op=selectJornada", function (r) {
        $("#jornada_e").html(r);
        $("#jornada_e").selectpicker("refresh");
    });
    $.post("../controlador/matriculamaterias.php?op=selectPeriodo", function (r) {
        $("#periodo").html(r);
        $("#periodo").selectpicker("refresh");
    });
    $.post("../controlador/matriculamaterias.php?op=selectGrupo", function (r) {
        $("#grupo").html(r);
        $("#grupo").selectpicker("refresh");
    });
    $("#precarga").hide();
}
//Función limpiar
function limpiar() {
    $("#id_credencial").val("");
    $("#credencial_nombre").val("");
    $("#credencial_nombre_2").val("");
    $("#credencial_apellido").val("");
    $("#credencial_apellido_2").val("");
    $("#credencial_login").val("");
}
//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
        $("#seleccionprograma").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#seleccionprograma").show();
    }
}
//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}
//Función Listar
function verificardocumento(e1) {
    $("#listadomaterias").hide();
    e1.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularioverificar")[0]);
    $.ajax({
        "url": "../controlador/matriculamaterias.php?op=verificardocumento",
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
    var meses = new Array( "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    var diasSemana = new Array( "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var f = new Date();
    var fecha = diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear();
    tabla = $("#tbllistado").dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        "dom": "Bfrtip",
        "buttons": [{
            "extend": "excelHtml5",
            "text": '<i class="fa fa-file-excel" style="color: green"></i>',
            "titleAttr": "Excel",
        },{
            "extend": "print",
            "text": '<i class="fas fa-print" style="color: #ff9900"></i>',
            "messageTop": '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: ' + fecha + '</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
            "title": "Programas Académicos",
            "titleAttr": "Print",
        }],
        "ajax": {
            "url":"../controlador/matriculamaterias.php?op=listar&id_credencial=" +id_credencial,
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
    $.post("../controlador/matriculamaterias.php?op=mostrardatos",{ "id_credencial": id_credencial },function (data) {    
        data = JSON.parse(data);
        $("#mostrardatos").html("");
        $("#mostrardatos").append(data["0"]["0"]);
    });
}
function mostrarmaterias(id_programa_ac, id_estudiante) {
    global_id_programa_ac = id_programa_ac;
    global_id_estudiante = id_estudiante;
    $("#precarga").show();
    $.post( "../controlador/matriculamaterias.php?op=mostrarmaterias", { "id_programa_ac": id_programa_ac, "id_estudiante": id_estudiante }, function (data, status) {

        data = JSON.parse(data);
        //$("#myModalAgregarPrograma").modal("show");
        $("#listadoregistros").hide();
        $("#listadomaterias").show();
        $("#listadomaterias").html("");
        $("#listadomaterias").append(data["0"]["0"]);
        $("#precarga").hide();
        $('[data-toggle="tooltip"]').tooltip();
    });
}
function matriculaprograma(id_credencial) {
    $.post( "../controlador/matriculamaterias.php?op=matriculaprograma", { "id_credencial": id_credencial }, function (data, status) {
        data = JSON.parse(data);
        $("#mostrardatos").html("");
        $("#mostrardatos").append(data["0"]["0"]);
    });
}
function mostrar(id) {
    $.post( "../controlador/matriculamaterias.php?op=mostrar", { "id": id }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#programa").val(data.programa);
        $("#programa").selectpicker("refresh");
        $("#nombre").val(data.nombre);
        $("#semestre").val(data.semestre);
        $("#area").val(data.area);
        $("#area").selectpicker("refresh");
        $("#creditos").val(data.creditos);
        $("#codigo").val(data.codigo);
        $("#presenciales").val(data.presenciales);
        $("#independiente").val(data.independiente);
        $("#escuela").val(data.escuela);
        $("#escuela").selectpicker("refresh");
        $("#id").val(data.id);
    });
}
function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar2").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);
    var credencial = $("#credencial_identificacion").val();
    $.ajax({
        "url": "../controlador/matriculamaterias.php?op=guardaryeditar&credencial_identificacion=" + credencial,
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            alertify.success(datos["0"]["0"]);
            mostrarform(false);
            listar(datos["0"]["1"]);
        },
    });
    limpiar();
}
function matriculaMateriaNormal( id_estudiante, id_programa_ac, id_materia, semestres_del_programa, fecha) {
    $("#precarga").show();
    $.post("../controlador/matriculamaterias.php?op=matriculaMateriaNormal",{"id_estudiante": id_estudiante, "id_materia": id_materia, "semestres_del_programa": semestres_del_programa, "fecha": fecha,},
        function (data, status) {
            data = JSON.parse(data);
            if (data == true) {
                alertify.success("Materia matriculada");
                mostrarmaterias(id_programa_ac, id_estudiante);
            } else {
                alertify.error("error");
            }
        }
    );
}
function eliminarMateria( id_estudiante, id_programa_ac, id_materia, semestres_del_programa, id_materia_matriculada, promedio_materia_matriculada) {
    $("#precarga").show();
    $.post("../controlador/matriculamaterias.php?op=eliminarMateria", { "id_estudiante": id_estudiante, "id_materia": id_materia, "semestres_del_programa": semestres_del_programa, "id_materia_matriculada": id_materia_matriculada, "promedio_materia_matriculada": promedio_materia_matriculada, }, function (data) {
        data = JSON.parse(data);
        if (data == true) {
            alertify.success("Materia eliminada");
            mostrarmaterias(id_programa_ac, id_estudiante);
        } else {
            alertify.error("error");
        }
    });
}
function cambioJornada( id_materia, jornada, ciclo, id_programa_ac, id_estudiante) {
    $("#myModalMatriculaNovedad").modal("show");
    $("#id_materia").val(id_materia);
    $("#ciclo").val(ciclo);
    $("#id_programa_ac").val(id_programa_ac);
    $("#id_estudiante").val(id_estudiante);
    $("#jornada_e").val(jornada);
    $("#jornada_e").selectpicker("refresh");
}
function cambioPeriodo( id_materia, periodo, ciclo, id_programa_ac, id_estudiante) {
    $("#myModalMatriculaNovedadPeriodo").modal("show");
    $("#id_materia_j").val(id_materia);
    $("#ciclo_j").val(ciclo);
    $("#id_programa_ac_j").val(id_programa_ac);
    $("#id_estudiante_j").val(id_estudiante);
    $("#periodo").val(periodo);
    $("#periodo").selectpicker("refresh");
}
function cambioGrupo( id_materia, periodo, ciclo, id_programa_ac, id_estudiante, grupo) {
    $("#myModalMatriculaNovedadGrupo").modal("show");
    $("#id_materia_g").val(id_materia);
    $("#ciclo_g").val(ciclo);
    $("#id_programa_ac_g").val(id_programa_ac);
    $("#id_estudiante_g").val(id_estudiante);
    $("#grupo").val(grupo);
    $("#grupo").selectpicker("refresh");
}
//Función Listar
function actualizarCambioJornada(e2) {
    e2.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularionovedadjornada")[0]);
    $.ajax({
        "url": "../controlador/matriculamaterias.php?op=actualizarJornada",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            $("#myModalMatriculaNovedad").modal("hide");
            var id_programa_ac = datos["0"]["0"];
            var id_estudiante = datos["0"]["1"];
            alertify.success("Cambio Correcto");
            mostrarmaterias(id_programa_ac, id_estudiante);
        },
    });
}
//Función Listar
function actualizarCambioPeriodo(e3) {
    e3.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularionovedadperiodo")[0]);
    $.ajax({
        "url": "../controlador/matriculamaterias.php?op=actualizarPeriodo",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            $("#myModalMatriculaNovedadPeriodo").modal("hide");
            var id_programa_ac = datos["0"]["0"];
            var id_estudiante = datos["0"]["1"];
            alertify.success("Cambio Correcto");
            mostrarmaterias(id_programa_ac, id_estudiante);
        }
    });
}
//Función Listar
function actualizarCambioGrupo(e4) {
    e4.preventDefault();
    //$("#btnVerificar").prop("disabled",true);
    var formData = new FormData($("#formularionovedadgrupo")[0]);
    $.ajax({
        "url": "../controlador/matriculamaterias.php?op=actualizarGrupo",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            $("#myModalMatriculaNovedadGrupo").modal("hide");
            var id_programa_ac = datos["0"]["0"];
            var id_estudiante = datos["0"]["1"];
            alertify.success("Cambio Correcto");
            mostrarmaterias(id_programa_ac, id_estudiante);
        }
    });
}
function mostrarTodasLasClases(id_materia_matriculada, ciclo_matriculado, id_estudiante_especial) {
    $("#HorariosDeClaseModal").modal("show");
    $("#id_materia_matriculada").val(id_materia_matriculada);
    $("#ciclo_matriculado").val(ciclo_matriculado);
    $("#id_estudiante_especial").val(id_estudiante_especial);
}
//listar todos los horarios de la escuela 
function ListarHorariosEscuela(escuela) {
    var calendarEl = document.getElementById("clasesDelDia");
    var calendar = new FullCalendar.Calendar(calendarEl, {
        "initialView": "dayGridWeek",
        "locales": "es",
        "slotMinTime": "06:00:00",
        "slotMaxTime": "23:00:00",
        "hiddenDays": [0],
        "headerToolbar": { "start": "", "center": "", "end": ""},
        "buttonText": { "month": "Mes", "week": "Semana", "day": "dia"},
        "contentHeight": "auto",
        "eventSources": [{
            "url": "../controlador/matriculamaterias.php?op=ListarClasesEscuela&escuela=" + escuela,
            "type": "POST",
            success: function(events){},
        }],
        eventClick: function (info) {
            swal({
                "title": "¿Esta seguro de incluir en la materia " + info.event._def.title + " al estudiante ?",
                "icon": "warning",
                "buttons": ["Cancelar", "Confirmar"],
                "dangerMode": false,
            }).then(willUpdate => {
                if (willUpdate) {
                    $.post("../controlador/matriculamaterias.php?op=asignarDocenteGrupo", { "id_docente_grupo": info.event._def.extendedProps.id_docente_grupo, "id_materia_matriculada": $("#id_materia_matriculada").val(), "ciclo_matriculado": $("#ciclo_matriculado").val(), "id_docente": info.event._def.extendedProps.id_docente, "id_estudiante_especial": $("#id_estudiante_especial").val() },
                    function (e) {
                        e = JSON.parse(e);
                        if (e.exito == 1) {
                            swal(e.info, "", "success");
                            $("#HorariosDeClaseModal").modal("hide");
                            mostrarmaterias(global_id_programa_ac, global_id_estudiante);
                        } else {
                            swal(e.info, "", "error");
                        }
                    });
                }
            });
        },
        eventDidMount: function (info) {
            info.el.setAttribute("data-toggle", "tooltip");
            info.el.setAttribute("data-placement", "top");
            info.el.setAttribute("title", info.event._def.extendedProps.nombre_docente);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
    calendar.render();
}
//Eliminar hoario especial
function EliminarHorarioEspecial(id_materia_matriculada, ciclo_matriculado, id_estudiante_especial, id_docente_grupo_esp) {
    swal({
        "title": "¿Esta seguro de eliminar el horario especial al estudiante ?",
        "icon": "warning",
        "buttons": ["Cancelar", "Confirmar"],
        "dangerMode": false,
    }).then(willUpdate => {
        if (willUpdate) {
            $.post("../controlador/matriculamaterias.php?op=eliminarHorarioEspecial", {
                "id_materia_matriculada": id_materia_matriculada, "ciclo_matriculado": ciclo_matriculado,"id_estudiante_especial" : id_estudiante_especial,"id_docente_grupo_esp" : id_docente_grupo_esp},
            function (e) {
                e = JSON.parse(e);
                if (e.exito == 1) {
                    swal(e.info, "", "success");
                    mostrarmaterias(global_id_programa_ac, global_id_estudiante);
                } else {
                    swal(e.info, "", "error");
                }
            });
        }
    });
}
//agregar modalidad
function addmodalidad( id_programa_ac, id_materia, id_estudiante, id_materias_ciafi_modalidad) {
    alertify.confirm( "Matricular modalidad", "¿Desea matricular esta materia, una vez matriculada no se puede devolver los cambios?", function () {
        $("#precarga").show();
        $.post(
            "../controlador/matriculamaterias.php?op=addmodalidad",{"id_programa_ac": id_programa_ac, "id_materia": id_materia, "id_estudiante": id_estudiante,"id_materias_ciafi_modalidad": id_materias_ciafi_modalidad},
            function (data, status) {
                data = JSON.parse(data);

                if (data["0"]["0"] == 1) {
                    // todo correcto
                    alertify.success("Modalidad matriculada");
                    mostrarmaterias(global_id_programa_ac, global_id_estudiante);
                    $("#precarga").hide();
                } else if (data["0"]["0"] == 2) {
                    // ya esta matriculada
                    alertify.error("error, no se puede matricular");
                    $("#precarga").hide();
                } else if (data["0"]["0"] == 4) {
                    alertify.error("Fraude, sus datos fueron reportados");
                    $("#precarga").hide();
                } else {
                    alertify.error("Fraude, sus datos fueron reportados");
                    $("#precarga").hide();
                }
            }
        );
    },function () {
        alertify.error("Cancelado");
    }
    );
}
//elimnar modalidad
function delmodalidad(id_materias_modalidad) {
    alertify.confirm( "Eliminar modalidad", "¿Desea eliminar esta materia?", function () {
            // $("#precarga").show();
            $.post( "../controlador/matriculamaterias.php?op=delmodalidad", { "id_materias_modalidad": id_materias_modalidad }, function (data, status) {
                data = JSON.parse(data);
                if (data == true) {
                    alertify.success("Modalidad eliminada");
                    mostrarmaterias(global_id_programa_ac, global_id_estudiante);
                    $("#precarga").hide();
                } else {
                    alertify.error("error");
                }
            });
        },
        function () {
            alertify.error("Cancelado");
        }
    );
}
//muestra los detalles del usuario que lo matriculo
function verdetalle(id_programa_ac, id_estudiante) {
    $.post( "../controlador/matriculamaterias.php?op=verdetalle", { "id_programa_ac": id_programa_ac, "id_estudiante": id_estudiante }, function (data) {
        // console.log(data);
        data = JSON.parse(data);
        $("#verdetalles").html(data[0]);
        $("#myModalverdetelles").modal("show");
        $("#tablaverdetalles").dataTable({
            "dom": "Bfrtip",
            "buttons": [{
                "extend": "excelHtml5",
                "text":'<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": "Excel",
            }],
        });
    });
}