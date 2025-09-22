$(document).ready(inicio);
function inicio() {
	$("#precarga").hide();
    programas();
    listarJornada();
}
function programas() {
    $.post("../controlador/calificaciondocente.php?op=listarProgra", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option value="" selected disabled>- Programas -</option>';
        for (let i = 0; i < r.length; i++) {
            if (r[i].id_programa == "1") {
                opti += '<option value="' + r[i].id_programa + '">Todos</option>';
            }else{
                opti += '<option value="' + r[i].id_programa + '">' + r[i].nombre + '</option>';
            }            
        }
        $("#programas").append(opti);
        $('#programas').selectpicker();
        $('#programas').selectpicker('refresh');
    });
}

function listarJornada() {
    $.post("../controlador/calificaciondocente.php?op=listarJornada", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option value="" selected disabled>- Jornada -</option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }
        $("#jornada").html(opti);
        $('#jornada').selectpicker();
        $('#jornada').selectpicker('refresh');
    });
}

function buscar() {
    
    var programa = $("#programas").val();
    var jornada = $("#jornada").val();

    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

    if (programa == null && jornada == null) {
        alertify.error("Por favor selecciona ambos campos.");
    } else {
        $("#precarga").attr("hidden",false);
        $.post("../controlador/calificaciondocente.php?op=buscar",{programa:programa,jornada:jornada}, function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $(".datos").html(r.conte);
            $("#tbl_datos").DataTable({
                "dom": 'Bfrtip',
                buttons: [{
                    extend:    'copyHtml5',
                    text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                    titleAttr: 'Copy'
                },
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend:    'csvHtml5',
                    text:      '<i class="fa fa-file-alt"></i>',
                    titleAttr: 'CSV'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><b>Estado calificación</b><b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Calificación Estado',
                    titleAttr: 'Print'
         
                }]
            });
            $("#precarga").attr("hidden",true);
        });
    }

}
function cambiarestado(id,val) {
    $.post("../controlador/calificaciondocente.php?op=cambiarestado",{id:id,val:val}, function (datos) {
        console.log(datos);
        var r = JSON.parse(datos);
        if (r.status == "ok") {
            alertify.success("Cambio de estado exitoso.");
            buscar();
        } else {
            alertify.error("Erro al cambiar el estado.");
        }
    });
}