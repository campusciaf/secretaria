$(document).ready(inicio);
function inicio(){
    CKEDITOR.replace('editor1');
    $(".conte").hide();
    $("#precarga").hide();
}
function consulta() {
    var data = ({
        'jornada':$(".jornada").val()
    });
    $.post("../controlador/recordatoriodocente.php?op=consulta", data ,function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        $(".correos").val(r.conte);
        $(".conte").show();
    });
}
function enviar() {
    $(".but").attr('disabled', 'disabled');
    var text = CKEDITOR.instances['editor1'].getData();
    //var tex = CKEDITOR.instances.editor1.document.getBody().getText();
    var data = ({
        'correos': $(".correos").val(),
        'asunto': $(".asunto").val(),
        'text': text
    });
    //console.table(text);
    $.post("../controlador/recordatoriodocente.php?op=enviar", data, function (datos) {
        //console.log(datos);
        var r = JSON.parse(datos);
        if (r.status == "ok") {
            $(".correos").val("");
            $(".asunto").val("");
            CKEDITOR.instances['editor1'].setData('');
            $(".but").removeAttr('disabled');
        }
    });
}