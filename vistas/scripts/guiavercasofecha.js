function buscar(val) {
    var ano = $("#select-programa-ano").val();
    if (ano != null) {
        $("#precarga").show();
        $.post("../controlador/guiavercasofecha.php?op=buscar", { mes: val, ano: ano }, function (datos) {
            //console.log(datos);
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
    }else{
        alertify.error("Selecciona un año.");
        $("#select-programa-mes").val("");
    }
}