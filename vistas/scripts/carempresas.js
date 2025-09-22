function init() {

    verificar();
    
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
                    url: "../controlador/carempresas.php?op=guardaryeditar",
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
                    title: 'Estudiante',
                    element: document.querySelector('#t-programa'),
                    intro: "Campo de opciones que contiene los nombres de los salones activos en plataforma para consultar."
                },
    
            ]
                
        },
    
        
        ).start();
    
    }
    
    function verificar(){ ;
        $.post("../controlador/carempresas.php?op=verificar", function(data){
 
            r = JSON.parse(data);
            if(r == 0){
                $("#myModalAcepto").modal("show");
                $("#precarga").hide();
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
            url: "../controlador/carempresas.php?op=guardardata",
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
                      verificar();
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
        $("#precarga").show(); 
        $.post("../controlador/carempresas.php?op=listarPreguntas", function(data){	
            r = JSON.parse(data);
            $("#preguntas").html(r.datos);
                mostrarp1();// ¿Trabajas actualmente?
                mostrarp3();// Tipo de sector de la empresa en la que trabajas
                mostrarp6();// Jornada laboral 
                mostrarp8();// Alguien de tu trabajo actual o anteriores, te inspiró a estudiar 
                mostrarp11();// ¿Tienes una empresa legalmente constituida?    
                mostrarp13();// Tienes una idea de negocio o emprendimiento
                mostrarp15();// Sector de la empresa, emprendimiento o idea de negocio
                mostrarp18();// Has realizado algún curso o capacitación relacionada con emprendimiento
            $("#precarga").hide();  
            
        });
    }
    
    function mostrarp1(){
        var campop1=$("#p1").find("option:selected").html();
        if(campop1=="No"){
            $("#p2").prop('disabled', true);
            $("#p3").prop('disabled', true);
            $("#p4").prop('disabled', true);
            $("#p5").prop('disabled', true);
            $("#p6").prop('disabled', true);
            $("#p7").prop('disabled', true);
            $("#p2").val("");
            $("#p3").val("");
            $("#p4").val("");
            $("#p5").val("");
            $("#p6").val("");
            $("#p7").val("");
        }else{
            $("#p2").prop( "disabled", false );
            $("#p3").prop( "disabled", false );
            $("#p4").prop( "disabled", false );
            $("#p5").prop( "disabled", false );
            $("#p6").prop( "disabled", false );
            $("#p7").prop( "disabled", false );
        }
    }

    function mostrarp3(){
        var campop3_val=$("#p3_val").val();
    
        let select = document.getElementById("p3");
        select.value = campop3_val;
    }

    function mostrarp6(){
        var campop6_val=$("#p6_val").val();
    
        let select = document.getElementById("p6");
        select.value = campop6_val;
    }

    function mostrarp8(){
        var campop8=$("#p8").find("option:selected").html();
        if(campop8=="No"){
            $("#p9").prop('disabled', true);
            $("#p10").prop('disabled', true);
            $("#p9").val("");
            $("#p10").val("");
        }else{
            $("#p9").prop( "disabled", false );
            $("#p10").prop( "disabled", false );
        }
    }

    function mostrarp11(){
        var campop11=$("#p11").find("option:selected").html();
        if(campop11=="No"){
            $("#p12").prop('disabled', true);
            $("#p12").val("");
        }else{
            $("#p12").prop( "disabled", false );
        }
    }

    function mostrarp13(){
        var campop13=$("#p13").find("option:selected").html();
        if(campop13=="No"){
            $("#p14").prop('disabled', true);
            $("#p14").val("");
            $("#p15").prop('disabled', true);
            $("#p15").val("");
            $("#p16").prop('disabled', true);
            $("#p16").val("");
        }else{
            $("#p14").prop( "disabled", false );
            $("#p15").prop( "disabled", false );
            $("#p16").prop( "disabled", false );
        }
    }

    function mostrarp15(){
        var campop15_val=$("#p15_val").val();
    
        let select = document.getElementById("p15");
        select.value = campop15_val;
    }

    function mostrarp18(){
        var campop18=$("#p18").find("option:selected").html();
        if(campop18=="No"){
            $("#p19").prop('disabled', true);
            $("#p19").val("");

        }else{
            $("#p19").prop( "disabled", false );

        }
    }


 



 
    
    init();