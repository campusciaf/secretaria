$(document).ready(incio);
function incio() {
    $("#precarga").hide();
}
function opcion(valor) {
    $("#precarga").show();
    switch (valor) {
        case 1:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=opcion", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 2:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=opciondos", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 3:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=porrenovar", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 4:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=estudiantesactivos", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 5:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=marcaregresados", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 6:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=marcarniveltario", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 7:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=ajusteactivos", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 8:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=ajustedatospersonales", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 9:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=opcionsemestre", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 10:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=sexo", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 11:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=activoegresado", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 12 :
            mostrar();
            $.post("../controlador/ajustedatos.php?op=marcarmatricula", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 13:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=sofipersonacredencial", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 14:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=sofitareascredencial", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 15:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=sofiVerificarFinalizados", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
            break;
        case 16:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=sofiSeguiWhatsapp", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 17:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=marcarreonovacion", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 18:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=marcarreonovacionefectivo", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 19:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=marcarreonovacionweb", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 20:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=renovacioncontrol", {}, function (data) {
                data = JSON.parse(data);
                console.log(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 21:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=renovacionaca", {}, function (data) {
                data = JSON.parse(data);
                console.log(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 22:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=SegmentacionEstudiante", {}, function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 23:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=ajusteporcentajehojadevida", {}, function (data) {
                console.log(data);
                data = JSON.parse(data);
                console.log(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 24:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=tablamadre", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        case 25:
            mostrar();
            $.post("../controlador/ajustedatos.php?op=resultadodocente", {}, function (data) {
                data = JSON.parse(data);
                $("#opciones").html(data.datos);
                $("#precarga").hide();
            });
        break;
        default:

    }
}
//Cargamos los items de los selects
function activos(nivel) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=activos", { nivel: nivel }, function (data) {
        data = JSON.parse(data);
        $("#activos").html(data.datos);
        $("#precarga").hide();
    });
}
//Cargamos los items de los selects
function activosdos(nivel) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=activosdos", { nivel: nivel, }, function (data) {
        data = JSON.parse(data);
        $("#activos").html(data.datos);
        $("#precarga").hide();
    });
}
//Cargamos los items de los selects
function ajustarrenovacion(id_programa, ciclo, semestres) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=ajustarrenovacion", { id_progama: id_programa, ciclo: ciclo, semestres: semestres }, function (data) {
        data = JSON.parse(data);
        $("#renovaciones").modal("show");
        $("#resultado_renovaciones").html(data.datos);
        $("#precarga").hide();
    });
}
//Cargamos los items de los selects
function ajustaregresados(id_programa, ciclo, semestres) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=ajustaregresados", { id_progama: id_programa, ciclo: ciclo, semestres: semestres }, function (data) {
        data = JSON.parse(data);
        $("#renovaciones").modal("show");
        $("#resultado_renovaciones").html(data.datos);
        $("#precarga").hide();
    });
}
//Cargamos los items de los selects
function cambiaregresado(id_estudiante, id_programa, ciclo) {
    $.post("../controlador/ajustedatos.php?op=cambiaregresado", { id_estudiante: id_estudiante, id_progama: id_programa, ciclo: ciclo }, function (data) {
        data = JSON.parse(data);
        if (data.datos == 1) {
            alertify.success("Cambio exitoso");
        } else {
            alertify.error(data.datos);
        }
    });
}
//Cargamos los items de los selects
function ajustarnivelatorio(id_programa, ciclo, semestres) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=ajustarnivelatorio", { id_progama: id_programa, ciclo: ciclo, semestres: semestres }, function (data) {
        data = JSON.parse(data);
        $("#nivelatorio").modal("show");
        $("#resultado_nivelatorio").html(data.datos);
        $("#precarga").hide();
    });
}
//funcion para ajustar los semestres
function semestre(nivel) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=semestre", { nivel: nivel, }, function (data) {
        data = JSON.parse(data);
        $("#activos").html(data.datos);
        $("#precarga").hide();
    });
}
//Cargamos los items de los selects
function eliminarActivo(id_estudiante_activo) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=eliminarActivo", { id_estudiante_activo: id_estudiante_activo }, function (data) {
        data = JSON.parse(data);
        opcion(7);
    });
}
//Cargamos los items de los selects
function insertarDatosPersonales(id_credencial) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=insertarDatosPersonales", { id_credencial: id_credencial }, function (data) {
        data = JSON.parse(data);
        if (data['datos'] == "si") {
            alertify.success("Registro correcto");
            opcion(8);
        } else {
            alertify.error("Error");
            $("#precarga").hide();
        }
    });
}
//Cargamos los items de los selects
function cambiosexo(id_credencial, sexo) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=cambiosexo", { id_credencial: id_credencial, sexo: sexo }, function (data) {
        data = JSON.parse(data);
        opcion(10);
    });
}
//funcion para eliminar el registro en la tabla estudiantes datos personales
function eliminarRegistrodato(id_credencial) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=eliminarRegistrodato", { id_credencial: id_credencial }, function (data) {
        data = JSON.parse(data);
        opcion(10);
    });
}
//Cargamos los items de los selects
function buscaractivostotal(nivel, periodo) {
    $("#precarga").show();
    $.post("../controlador/ajustedatos.php?op=buscaractivostotal", { nivel: nivel, periodo: periodo }, function (data) {
        data = JSON.parse(data);
        $("#activos").html(data.datos);
        $("#precarga").hide();
    });
}
function mostrar() {
    $("#panelcontrol").hide();
    $("#resultados").show();
}
function volver() {
    $("#panelcontrol").show();
    $("#resultados").hide();
}

//Cargamos los items de los selects
function marcarpago(id_estudiante_activo) {
    $.post("../controlador/ajustedatos.php?op=marcarpago", { id_estudiante_activo: id_estudiante_activo }, function (data) {
        data = JSON.parse(data);
        if (data.datos == 1) {
            alertify.success("Cambio exitoso");
        } else {
            alertify.error(data.datos);
        }
    });
}

//Cargamos los items de los selects
function marcarpago(id_estudiante_activo) {
    $.post("../controlador/ajustedatos.php?op=marcarpago", { id_estudiante_activo: id_estudiante_activo }, function (data) {
        data = JSON.parse(data);
        if (data.datos == 1) {
            alertify.success("Cambio exitoso");
        } else {
            alertify.error(data.datos);
        }
    });
}


//Cargamos los items de los selects
function datamadre(periodo,opcion) {
        Swal.fire({
        title: "Estas seguro?",
        text: "Recuerde que esto es registra todos los activos del periodo",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, continuar!"
        }).then((result) => {
        if (result.isConfirmed) {

                $("#precarga").show();
                $.post("../controlador/ajustedatos.php?op=datamadre", { periodo:periodo, opcion:opcion }, function (data) {
                    data = JSON.parse(data);
                    console.log(data.datos);
                    $("#precarga").hide();
                });

        }

        });




}

