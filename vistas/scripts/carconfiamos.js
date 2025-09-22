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
                    url: "../controlador/carconfiamos.php?op=guardaryeditar",
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
        $.post("../controlador/carconfiamos.php?op=verificar", function(data){
 
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
            url: "../controlador/carconfiamos.php?op=guardardata",
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
        $.post("../controlador/carconfiamos.php?op=listarPreguntas", function(data){	
            r = JSON.parse(data);
            $("#preguntas").html(r.datos);

                mostrarp1();// ¿Estás embarazada?
                mostrarp2();
                mostrarp3();// 
                mostrarp4();// 
                mostrarp5();//
                mostrarp5();// 

            $("#precarga").hide();  
            
        });
    }
    
    function mostrarp1(){
        var campop1_val=$("#p1_val").val();
    
        let select = document.getElementById("p1");
        select.value = campop1_val;
    }

    function mostrarp2(){
        var campop2_val=$("#p2_val").val();
    
        let select = document.getElementById("p2");
        select.value = campop2_val;
    }

    function mostrarp3(){
        var campop3_val=$("#p3_val").val();
    
        let select = document.getElementById("p3");
        select.value = campop3_val;
    }

    function mostrarp4(){
        var campop4_val=$("#p4_val").val();
    
        let select = document.getElementById("p4");
        select.value = campop4_val;
    }


    function mostrarp5(){
        
        var campop5=$("#p5").find("option:selected").html();
        var campop6_val=$("#p6_val").val();

    
        let select = document.getElementById("p6");
        select.value = campop6_val;
        
        if(campop5=="No"){
            $("#p6").prop('disabled', true);
            let select2 = document.getElementById("p6");
            select2.value = "";
        }else{
            $("#p6").prop( "disabled", false );
           
        }
    }
    


 
    
init();