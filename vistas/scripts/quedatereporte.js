$(document).ready(inicio);
function inicio(){
    buscar();
}
function buscar(){
    $("#precarga").show();
    var mes_llega = $("#mes").val();
    var mes = 0;
    var f = new Date();
    if(mes_llega == undefined){
        mes = f.getMonth()+1;
    }else{
        mes = mes_llega;
    }
    $.post("../controlador/quedatereporte.php?op=buscar",{mes : mes}, function(datos){
        var r = JSON.parse(datos);
        // console.log(datos);
        $(".select").html(r.select);
        $(".tbl_casos").html(r.conte);
        $(".tbl_casos_cerrados").html(r.conte2);
        $("#tbl_casos").DataTable({
            "dom": 'Bfrtip',
            "buttons": [{
                "extend":    'copyHtml5',
                "text":      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                "titleAttr": 'Copy'
            },
            {
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel" style="color: green"></i>',
                "titleAttr": 'Excel',
                "title": 'Reporte Septiembre',
            },
            {
                "extend":    'csvHtml5',
                "text":      '<i class="fa fa-file-alt"></i>',
                "titleAttr": 'CSV'
            },
            {
                "extend":    'pdfHtml5',
                "text":      '<i class="fa fa-file-pdf" style="color: red"></i>',
                "titleAttr": 'PDF',
    
            }],
            "pageLength": 50,
            "order": false
        });
        $("#tbl_casos_cerrados").DataTable({
            "dom": 'Bfrtip',
            "buttons": [{
                "extend":    'copyHtml5',
                "text":      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                "titleAttr": 'Copy'
            },
            {
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel" style="color: green"></i>',
                "titleAttr": 'Excel',
                "title": 'Reporte Septiembre',
            },
            {
                "extend":    'csvHtml5',
                "text":      '<i class="fa fa-file-alt"></i>',
                "titleAttr": 'CSV'
            },
            {
                "extend":    'pdfHtml5',
                "text":      '<i class="fa fa-file-pdf" style="color: red"></i>',
                "titleAttr": 'PDF',
    
            }],
            "pageLength": 50,
            "order": false
        });
        $('.dt-button').addClass('btn btn-default btn-flat');
        $('.dt-button').removeClass('dt-button');
        $("#precarga").hide();
    });
}