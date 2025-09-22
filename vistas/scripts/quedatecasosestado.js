function buscar(val) {
    var ano = $("#select-programa-ano").val();
    if (!ano) {
        Swal.fire({      
            icon: "warning",
            title: "Por favor selecciona un año.",
            showConfirmButton: false,
            timer: 2000
        });
        $("#precarga").hide();
        $("button").prop('disabled', false);
        return;
    }
    $("#precarga").show();
    $.post("../controlador/quedatecasosestado.php?op=buscar", {"val": val, ano: ano }, function (datos) {
        var r = JSON.parse(datos);
        $(".tbl_casos").html(r.conte);
        $("#tbl_casos").DataTable({
            "dom": 'Bfrtip',
            "buttons": [{
                "extend": 'copyHtml5',
                "text": '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
                "titleAttr": 'Copy'
            },{
                "extend": 'excelHtml5',
                "text": '<i class="fa fa-file-excel" style="color: green"></i>',
                "titleAttr": 'Excel'
            },{
                "extend": 'csvHtml5',
                "text": '<i class="fa fa-file-alt"></i>',
                "titleAttr": 'CSV'
            },{
                "extend": 'pdfHtml5',
                "text": '<i class="fa fa-file-pdf" style="color: red"></i>',
                "titleAttr": 'PDF',
            }]
        });
        $('.dt-button').addClass('btn btn-default btn-flat');
        $('.dt-button').removeClass('dt-button');
        $("#precarga").hide();
    });
}