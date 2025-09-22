function init(){
}

$("#form_induccion").off('submit').on('submit',function(e){
    e.preventDefault();
    var formData = new FormData($("#form_induccion")[0]);

    if (formData) {
        enviarFormulario(formData);
    }
});

function enviarFormulario(formData){
    $.ajax({
		type:'POST',
        url:'../controlador/induccion_estudiantes.php?op=verificar',
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        data:formData,
        success:function(data){
            console.log(data);
            if (data == 1) {
                window.location.replace('https://issuu.com/ciafcomunicacion/docs/revista_induccio_n_web');
            } else {
                alertify.error("Hay un error.");    
            }
        },error:function(){
            alertify.error("Hay un error.");
        }
    });
}


init();