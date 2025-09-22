function guiabuscar(val) {
    $("#precarga").attr("hidden",false);
    $.post("../controlador/guiaremisiones.php?op=guiabuscar",{val:val}, function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $(".tbl_guia_remisiones").html(r.conte);
        $("#tbl_guia_remisiones").DataTable({
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
        $("#precarga").attr("hidden",true);
        
    });
}