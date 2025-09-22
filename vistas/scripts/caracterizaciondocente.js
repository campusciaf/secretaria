function init() {
   $("#precarga").hide();
   aceptoData();
   $("#formulariodata").on("submit",function(e2)
   {
       guardardata(e2);	
   });

   $("#formulariodatos").on("submit", function (e) {
        editarDatosPersona(e);
       
    });
   
}
function editarDatosPersona(e) {
    $("#precarga").show();
    e.preventDefault();
    var formData = new FormData($("#formulariodatos")[0]);

            $.ajax({
                type: "POST",
                url: "../controlador/caracterizaciondocente.php?op=guardaryeditar",
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    data = JSON.parse(datos);
                    console.log(data.estado);
                    if(data.estado == "si"){
                        Swal.fire({
                            icon: "success",
                            title: "Datos actualizados",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        
                        listarPreguntas();
                        $("#precarga").hide();
                    }else{
                        Swal.fire({      
                            icon: "error",
                            title: "error",
                            text: "Proceso rechazado!",
                            showConfirmButton: false,
                            timer: 1500
                          });
                      
                    }

                }
            });
        

}


function iniciarTour(){
    introJs().setOptions({
        nextLabel: 'Siguiente',
        prevLabel: 'Anterior',
        doneLabel: 'Terminar',
        showBullets:false,
        showProgress:true,
        showStepNumbers:true,
        steps: [ 
            {
                title: 'Horarios',
                intro: 'Módulo para consultar los horarios por salones creados en el periodo actual.'
            },
            {
                title: 'Docente',
                element: document.querySelector('#t-programa'),
                intro: "Campo de opciones que contiene los nombres de los salones activos en plataforma para consultar."
            },

        ]
            
    },

    
    ).start();

}

function aceptoData(){
    $.post("../controlador/caracterizaciondocente.php?op=aceptoData", function(data){
        
        data = JSON.parse(data);
        if(data == false){
            $("#myModalAcepto").modal("show");
            
            }else{
                $("#myModalAcepto").modal("hide");
                listarPreguntas();
            }
    });
}

function guardardata(e2)
{
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnData").prop("disabled",true);
	var formData = new FormData($("#formulariodata")[0]);

	$.ajax({
		url: "../controlador/caracterizaciondocente.php?op=guardardata",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
		
            data = JSON.parse(datos);
            if (data == 1) {
                Swal.fire({      
                    icon: "success",
                    title: "Datos protegidos",
                    showConfirmButton: false,
                    timer: 1500
                  });
                  $("#myModalAcepto").modal("hide");
                  listarPreguntas();
            } else {
                
                Swal.fire({      
                    icon: "error",
                    title: "error",
                    text: r.status,
                    showConfirmButton: false,
                    timer: 1500
                  });
              
            }

			
	    }

	});
	limpiar();
}

//Función limpiar
function limpiar(){
	$("#id_categoria").val("");	
	$("#id_tipo_pregunta").val("");
	$("#variable").val("");
    $("#obligatorio_no").prop('checked', false);
    $("#obligatorio_si").prop('checked', true);

	
}

function listarPreguntas(){
    
    $.post("../controlador/caracterizaciondocente.php?op=listarPreguntas", function(data){	
        data = JSON.parse(data);
        $("#preguntas").html(data);

        mostrarp2();// parentesco en caso de emergencia
        mostrarp6();// pareja
        mostrarp9();//mascota
        mostrarp12();//idioma
        mostrarp14();// cuanas personas viven en tu casa
        mostrarp16();// personas a cargo
        mostrarp17();//hijos
        mostrarp18();//Cuantos hijos
        mostrarp20();//tipo de vivienda
        mostrarp21();//tipo de transporte
        mostrarp27();//eps
        mostrarp35();//colores
        mostrarp37();//que prefieres de detalle
        mostrarp39();//destacas tema diferente a tu profesión
        mostrarp41();//deporte que practica
        mostrarp42();//actividad fisica

        $("#precarga").hide();  
    });
}

function mostrarp2(){
    var campop2_val=$("#p2_val").val();

    let select = document.getElementById("p2");
    select.value = campop2_val;
}

function mostrarp6(){
    var campop6=$("#p6").find("option:selected").html();
    if(campop6=="No"){
        $("#p7").prop('disabled', true);
        $("#p8").prop('disabled', true);
        $("#p7").val("");
        $("#p8").val("");
    }else{
        $("#p7").prop( "disabled", false );
        $("#p8").prop( "disabled", false );
    }
}

function mostrarp9(){
    var campop9=$("#p9").find("option:selected").html();
    if(campop9=="No"){
        $("#p10").prop('disabled', true);
        $("#p11").prop('disabled', true);
        $("#p10").val("");
        $("#p11").val("");
    }else{
        $("#p10").prop( "disabled", false );
        $("#p11").prop( "disabled", false );
    }
}

function mostrarp12(){
   
    var campop12=$("#p12").find("option:selected").html();
    var campop13_val=$("#p13_val").val();

    let select = document.getElementById("p13");
    select.value = campop13_val;
    
    if(campop12=="No"){
        $("#p13").prop('disabled', true);
        let select2 = document.getElementById("p13");
        select2.value = "";
    }else{
        $("#p13").prop( "disabled", false );
       
    }
}

function mostrarp14(){
    var campop14_val=$("#p14_val").val();

    let select = document.getElementById("p14");
    select.value = campop14_val;
}

function mostrarp16(){
    var campop16_val=$("#p16_val").val();

    let select = document.getElementById("p16");
    select.value = campop16_val;
}

function mostrarp17(){
    var campop17=$("#p17").find("option:selected").html();
    if(campop17=="No"){
        $("#p18").prop('disabled', true);
        $("#p19").prop('disabled', true);
        $("#p18").val("");
        $("#p19").val("");
    }else{
        $("#p18").prop( "disabled", false );
        $("#p19").prop( "disabled", false );

    }
}

function mostrarp18(){
    var campop18_val=$("#p18_val").val();

    let select = document.getElementById("p18");
    select.value = campop18_val;
}

function mostrarp20(){
    var campop20_val=$("#p20_val").val();

    let select = document.getElementById("p20");
    select.value = campop20_val;
}

function mostrarp21(){
    var campop21_val=$("#p21_val").val();

    let select = document.getElementById("p21");
    select.value = campop21_val;
}

function mostrarp27(){
    var campop27_val=$("#p27_val").val();

    let select = document.getElementById("p27");
    select.value = campop27_val;
}

function mostrarp35(){
    var campop35_val=$("#p35_val").val();

    let select = document.getElementById("p35");
    select.value = campop35_val;
}

function mostrarp37(){
    var campop37_val=$("#p37_val").val();

    let select = document.getElementById("p37");
    select.value = campop37_val;
}

function mostrarp39(){
    var campop39=$("#p39").find("option:selected").html();
    if(campop39=="No"){
        $("#p40").prop('disabled', true);
        $("#p40").val("");
    }else{
        $("#p40").prop( "disabled", false ); 
    }
}

function mostrarp41(){
    var campop41_val=$("#p41_val").val();

    let select = document.getElementById("p41");
    select.value = campop41_val;
}

function mostrarp42(){
    var campop42_val=$("#p42_val").val();

    let select = document.getElementById("p42");
    select.value = campop42_val;
}

init();