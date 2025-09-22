function buscar(val) {
    $("#precarga").show();
    $.post("../controlador/guiacasosestado.php?op=buscar",{val : val},function(datos){
        console.table(datos);
        var r = JSON.parse(datos);
        $(".tbl_casos").html(r.conte);
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
                "titleAttr": 'Excel'
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
            }]
        });
        $('.dt-button').addClass('btn btn-default btn-flat');
        $('.dt-button').removeClass('dt-button');
        $("#precarga").hide();
    });
}