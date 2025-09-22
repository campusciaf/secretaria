
function inicio() {

    $("#form_preguntas").on("submit",function(e)
	{
		guardar(e);	
	});
    
    $("#precarga").show();
    $.post("../controlador/evaluaciondocente.php?op=listar",function(data){
        
        var r= JSON.parse(data);
        $("#listar").html(r.conte);
        $("#precarga").hide();
       
    });


    // $.post("../controlador/evaluaciondocente.php?op=listar",function(data){
    //     //console.log(data);
    //     var r= JSON.parse(data);
    //     $("#listar").html(r.conte);
    //     $("#modal_encuesta_docente").modal("hide");
    //     if (r.cantidad == 0) {
    //         alertify.success("Ya completaste la evaluación docente.");
    //         setInterval("redirec()",4000);
    //     } else {
    //         for (let index = 0; index < r.cantidad; index++) {
    //             $(".form_preguntas_"+(index+1)).on("submit", function (e) {
    //                 e.preventDefault();
    //                 registro(index+1);
    //             })
    //         }
    //     } 
    // });
}
// function registro( val ){
//     var formData = new FormData($("#form_preguntas"));
//     $.ajax({
//         type: "POST",
//         url : "../controlador/evaluaciondocente.php?op=registro",
//         data : formData,
//         contentType : false,
//         processData : false,
//         success : function (datos) {
//             console.log(datos);
//             var r = JSON.parse(datos);
//             if (r.status == "ok") {
//                 alertify.success("Registro exitoso.");
//                 $("#form_preguntas")[0].reset();
//                 $("#modalpreguntas").modal("hide");
//                 inicio();           
//             } else {
//                 alertify.error("Error al hacer el registro.");
//             }
//         }
//     });
// }


function guardar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#form_preguntas")[0]);

	
	$.ajax({
		url: "../controlador/evaluaciondocente.php?op=registro",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
		
	    success: function(datos)
	    {   
			data = JSON.parse(datos);
			if(data.status == "ok"){
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: "Docente calificado",
					showConfirmButton: false,
					timer: 1500
				});   

				$("#form_preguntas")[0].reset();
                $("#modalpreguntas").modal("hide");
                // inicio();  
                setTimeout(function() {
                    location.reload();
                  }, 2000); // recarga después de 2 segundos     
			}
	    }
	});
}

function redirec() {
    $(location).attr("href","panel_estudiante.php");
}

function preguntas(id,id2,id3){
    $.post("../controlador/evaluaciondocente.php?op=preguntas",{id:id,id2:id2,id3:id3},function(data){
        var r= JSON.parse(data);
        $("#modalpreguntas").modal("show");
        $("#preguntas").html(r.conte);
       
    });
}

function terminar(){
    
    $.post("../controlador/evaluaciondocente.php?op=terminar",{},function(data){
        
        var r= JSON.parse(data);
        
       
        if(r[0].puntos=="si"){
        
            Swal.fire({
                position: "top-end",
                imageWidth: 150,
                imageHeight: 150,
                imageUrl: "../public/img/ganancia.gif",
                title: "Te otorgamos " + r[0].puntosotorgados +" puntos, por realizar la evaluación",
                showConfirmButton: false,
                timer: 4000
            });

            setTimeout(function() {
               redirec(); 
            }, 4000); // 3000 milisegundos = 3 segundos

        }
console.log(r)

       
    });
}

inicio();