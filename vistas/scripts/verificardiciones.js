$(document).ready(inicio);
function inicio() {
    mostrarJornada();
}
function consulta() {
    

    $.post("../controlador/registrar2012.php?op=consultaCedula", { cedula: $("#verificar_estudiante").val(), titulo: $("#titulo").val() }, function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        if (r.result == false) {
            alertify.error("Número de identificación no se encuentra registrado.");
        } else {
            var data = ({
                'cc': $("#verificar_estudiante").val(),
                'titulo': $("#titulo").val()
            });
            $("#periodo").val(r.result.periodo);

            $.post("../controlador/verificardiciones.php?op=consultaCedula", data, function (e) {
                //console.log(e);
                var a = JSON.parse(e);
                if (a.result == false) {
                    $(".uno").addClass("hide");
                    $(".dos").removeClass("hide");
                } else {
                    //alertify.error("Error al consultar el estudiante, ponte en contacto con el administrador del sistema.");
                    $(".tres").html(a.conte);
                    $(".uno").addClass("hide");
                }
            });
            
        }
    });
    
}

function estado(id) {
    if (id == "graduado") {
        $(".datos_graduado").removeClass("hide");
    }else{
        $(".datos_graduado").addClass("hide");
    }
}

function guardarEstado() {
    var data = ({
        'titulo': $("#titulo").val(),
        'verificar_estudiante': $("#verificar_estudiante").val(),
        'estado_est': $("#estado_est").val(),
        'numero_acta': $("#numero_acta").val(),
        'folio': $("#folio").val(),
        'ano_graduacion': $("#ano_graduacion").val(),
        'periodo': $("#periodo").val()
    });

    $.post("../controlador/verificardiciones.php?op=guardarEstado", data, function (e) {
        //console.log(e);
        var a = JSON.parse(e);
        if (a.status == "ok") {
            $(".uno").addClass("hide");
            $(".dos").addClass("hide");
            $(".tres").html(a.conte);
        } else {
            alertify.error("Error al consultar el estudiante, ponte en contacto con el administrador del sistema.");
        }
    });

}

function listarMaterias(cc,tipo) {
    $.post("../controlador/verificardiciones.php?op=listarMaterias", {cc:cc, tipo:tipo } , function (e) {
        //console.log(e);
        var r = JSON.parse(e);
        $(".cuatro").html(r.conte);
    });
}
function guardarMateria(cc, tipo, escuela) {

    var data = ({
        'cc':cc,
        'tipo':tipo,
        'escuela':escuela,
        'programa': $("#programa").val(),
        'materia': $("#nombre_asig").val(),
        'creditos': $("#creditos_asig").val(),
        'semestre': $("#semestre_asig").val(),
        'nota': $("#nota_asig").val(),
        'periodo': $(".periodo_asig").val(),
        'jornada': $(".jornada_asig").val()
    });

    $.post("../controlador/verificardiciones.php?op=aggMaterias", data, function (e) {
        //console.log(e);
        var r = JSON.parse(e);
        if (r.status == "ok") {
            consulta();
        }else{
            alertify.error("Error al agregar la materia, ponte en contacto con el administrador del sistema.");
        }
    });
}

function eliminarMateria(id) {

    alertify.confirm('Eliminar materia', 'Desea eliminar la materia', function () {

        $.post("../controlador/verificardiciones.php?op=eliminarMateria", { id: id }, function (e) {
            //console.log(e);
            var r = JSON.parse(e);
            if (r.status == "ok") {
                consulta();
            } else {
                alertify.error("Error al eliminar la materia, ponte en contacto con el administrador del sistema.");
            }
        });
        
    }, function () { alertify.error('Cancel') });
}

function consultaMateria(id) {


    $.post("../controlador/verificardiciones.php?op=consultaMateria", { id: id }, function (e) {
        //console.log(e);
        
        var r = JSON.parse(e);

        $("#id").val(r.id_materia);
        $("#nombre_asig_e").val(r.nombre_materia);
        $("#creditos_asig_e").val(r.creditos);
        $("#semestre_asig_e").val(r.semestre);
        $("#nota_asig_e").val(r.nota);
        $("#periodo_asig_e").val(r.periodo);
        $(".jornada_asig_e").val(r.jornada);
        $("#editarMateria").modal("show");
        
    });
    
}

function editarMateria() {

    var data = {
        'id': $("#id").val(),
        'asignatura': $("#nombre_asig_e").val(),
        'creditos': $("#creditos_asig_e").val(),
        'semestre': $("#semestre_asig_e").val(),
        'nota': $("#nota_asig_e").val(),
        'periodo': $(".periodo_asig_e").val(),
        'jornada': $(".jornada_asig_e").val()
    }
    //console.log(data);

    $.post("../controlador/verificardiciones.php?op=editarMateria", data, function (e) {
        //console.log(e);

        var r = JSON.parse(e);
        if (r.status == "ok") {
            alertify.success("Materia editada con exito.");
            $("#editarMateria").modal("hide");
            consulta();
        } else {
            alertify.error("Error al editar la materia, ponte en contacto con el administrador del sistema.");
        }


    });
    
}

function mostrarJornada() {

    $.post("../controlador/verificardiciones.php?op=mostrarJornada", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        //console.log(r);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }
        $('.jornada_asig').html(opti);
        $(".jornada_asig_e").html(opti);
    });

}