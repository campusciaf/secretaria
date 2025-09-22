$(document).ready(inicio);
function inicio() {
    listarProgramas();
    $("#formulario").on("submit",function(e){
        e.preventDefault();
        consulta();
    });
    listarJornada();
    listarPeriodo();
    $("#precarga").hide();
    $(".dos").hide();
}
function listarJornada() {
    $.post("../controlador/listarcategoria.php?op=listarJornada", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option value="" selected disabled>- Jornada -</option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
        }
        $(".jornada").html(opti);
    });
}
function listarPeriodo() {
    $.post("../controlador/consultanotas.php?op=periodos", function (datos) {
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option value="" selected disabled>- Periodo -</option>';
        for (let i = 0; i < r.length; i++) {
            opti += '<option value="' + r[i].periodo + '">' + r[i].periodo + '</option>';
        }
        $(".periodo").html(opti);
    });
}
function listarProgramas() {
    $.post("../controlador/listarcategoria.php?op=listarProgra", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            if (r[i].id_programa == "1") {
                //opti += '<option selected value="' + r[i].id_programa + '">' + r[i].nombre + '</option>';
            }else{
                opti += '<option value="' + r[i].id_programa + '">' + r[i].nombre + '</option>';
            }            
        }
        $(".programa").append(opti);
        $('.programa').selectpicker();
        $('.programa').selectpicker('refresh');
    });
}
function progra(val) {
    var opti = "";
    var opti2 = ""; 
    $.post("../controlador/consultanotas.php?op=progra", {val:val} ,function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        opti += '<option value="" selected disabled>- Semestres -</option>';
        opti += '<option value="todos">Todos</option>';
        for (let i = 1; i <= r.semestres; i++) {
            opti += '<option value="'+i+'">'+i+'</option>';
        }
        opti2 += '<option value="" selected disabled>- Cortes -</option>';
        opti2 += '<option value="Todos">Todos</option>';
        opti2 += '<option value="promedio">Promedio</option>';
        for (let i = 1; i <= r.cortes; i++) {
            opti2 += '<option value="c'+i+'">Corte'+i+'</option>';
        }
        $(".semestre").html(opti);
        $(".corte").html(opti2);
        $(".dos").show();
        $(".c").val(r.ciclo);
        $(".canCor").val(r.cortes);
    });
}
function consulta() {
    $("#precarga").show();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/consultanotas.php?op=consulta",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $(".conte").html(r.conte);
            $('#dtl_notas').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                dom: 'Bfrtip',
                "buttons": [{
                    "extend": 'pdfHtml5',
                    "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    "orientation": 'landscape',
                    "pageSize": 'LEGAL'
                },{
                    "extend": 'excelHtml5',
                    "text": '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    "titleAttr": 'Excel'
                }],
                "columnDefs": [{
                    "className": 'control',
                    "orderable": false,
                    "targets": 0
                }],
                "order": [1, 'asc'],
                "initComplete": function () {
                    $("#precarga").hide();
                },
                "iDisplayLength": 20,//Paginación
            });
        }
    });
}