$(document).ready(function(){
    $("#precarga_modal").hide();
    $.post("../controlador/panel_admin.php?op=listarCursosEC", function (e) {
        //  console.log(e);
        var r = JSON.parse(e);
        if(r.exito == "1"){
            $("#slides-continuada").html(r.info);
            continuada();
        }else{
            $("#slides-continuada").html(r.plantilla);
        }
    });
});

function continuada() {
    $(".continuada").slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        dots: false,
    });
   
}

function listarDetallesCursoEc(id_curso){
    $.post("../controlador/panel_admin.php?op=listarDetallesCursoEc", {"id_curso": id_curso},function (e) {
  
        e = JSON.parse(e);
        if (e.exito == "1") {
            $(".nombre_curso").html(e.nombre_curso);
            $(".categoria_curso").html(e.categoria);
            $(".descripcion_curso").html(e.descripcion_curso);
            $(".valor_curso").html(e.precio_curso);
            $(".nivel_curso").html(e.nivel_educacion);
            $(".modalidad_curso").html(e.modalidad_curso);
            $(".duracion_curso").html(e.duracion_educacion+" Horas");
            $(".fecha_inicio").html(e.fecha_inicio);
            $(".img_curso").attr("src", "../public/img_educacion/"+e.imagen_curso);
            $(".boton_epayco").html(e.boton_epayco);
            $(".boton_inscripcion").html(e.boton_inscripcion);
        }
        $("#modalEducacionContinuada").modal("show");
    })
}
function inscripcionEducacioncontinua(id_curso){
    alertify.confirm('Realizar inscripción', 'Recuerda que ademas de hacer la inscripción, debes realizar el pago oportuno para iniciar', function () { 
        $.post("../controlador/panel_admin.php?op=inscripcionEducacioncontinua", {"id_curso": id_curso},function (e) {
            e = JSON.parse(e);
            if (e.exito == "1") {
                alertify.success(e.info);
                listarDetallesCursoEc(id_curso);
            }else{
                alertify.error(e.info);
            }
        })
    }, function () { 
        alertify.message('Acción realizada'); 
    });
}