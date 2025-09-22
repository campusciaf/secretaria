function buscar(val) {
    $("#precarga").show(); // Mostrar loader
    $("button").prop('disabled', true); // Desactivar botones durante la carga

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

    $.post("../controlador/quedatemiscasos.php?op=buscar", { val: val, ano: ano }, function (datos) {
        var r = JSON.parse(datos);
        if (val === 'casos') {
            $(".tbl_casos").html(r.conte);
            $(".tbl_remisiones").html('');
            if (r.conte.trim() === '') {
                $(".tbl_casos").html('<div class="alert alert-warning">No se encontraron casos para el año seleccionado.</div>');
            } else {
                $("#tbl_casos").DataTable({
                    "dom": 'Bfrtip',
                    "buttons": [
                        {
                            "extend": 'copyHtml5',
                            "text": '<i class="fa fa-copy" style="color: blue;"></i>',
                            "titleAttr": 'Copiar'
                        },
                        {
                            "extend": 'excelHtml5',
                            "text": '<i class="fa fa-file-excel" style="color: green;"></i>',
                            "titleAttr": 'Exportar a Excel'
                        },
                        {
                            "extend": 'csvHtml5',
                            "text": '<i class="fa fa-file-alt"></i>',
                            "titleAttr": 'Exportar a CSV'
                        },
                        {
                            "extend": 'pdfHtml5',
                            "text": '<i class="fa fa-file-pdf" style="color: red;"></i>',
                            "titleAttr": 'Exportar a PDF'
                        }
                    ]
                });
                $('.dt-button').addClass('btn btn-default btn-flat btn_tablas').removeClass('dt-button');
            }
        } else {
            $(".tbl_remisiones").html(r.conte);
            $(".tbl_casos").html('');

            if (r.conte.trim() === '') {
                $(".tbl_remisiones").html('<div class="alert alert-warning">No se encontraron remisiones para el año seleccionado.</div>');
            } else {
                $("#tbl_remisiones").DataTable({
                    "dom": 'Bfrtip',
                    "buttons": [
                        {
                            "extend": 'copyHtml5',
                            "text": '<i class="fa fa-copy" style="color: blue;"></i>',
                            "titleAttr": 'Copiar'
                        },
                        {
                            "extend": 'excelHtml5',
                            "text": '<i class="fa fa-file-excel" style="color: green;"></i>',
                            "titleAttr": 'Exportar a Excel'
                        },
                        {
                            "extend": 'csvHtml5',
                            "text": '<i class="fa fa-file-alt"></i>',
                            "titleAttr": 'Exportar a CSV'
                        },
                        {
                            "extend": 'pdfHtml5',
                            "text": '<i class="fa fa-file-pdf" style="color: red;"></i>',
                            "titleAttr": 'Exportar a PDF'
                        }
                    ]
                });
                $('.dt-button').addClass('btn btn-default btn-flat btn_tablas').removeClass('dt-button');
            }
        }

        $("#precarga").hide(); // Ocultar loader
        $("button").prop('disabled', false); // Reactivar botones
    });
}
