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
                    url: "../controlador/carbienestar.php?op=guardaryeditar",
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
        $.post("../controlador/carbienestar.php?op=verificar", function(data){
 
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
            url: "../controlador/carbienestar.php?op=guardardata",
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
        $.post("../controlador/carbienestar.php?op=listarPreguntas", function(data){	
            r = JSON.parse(data);
            $("#preguntas").html(r.datos);
                mostrarp1();// 
                mostrarp2();// 
                mostrarp3();// 
                mostrarp4();//
                mostrarp5();//
                mostrarp6();// 
                mostrarp8();//
                mostrarp9();//
                mostrarp11();//    
                mostrarp13();// 
                mostrarp14();//
                mostrarp16();//
                mostrarp17();// 
                mostrarp19();//
                mostrarp20();//
                mostrarp21();//
                mostrarp23();//
            $("#precarga").hide();  
            
        });
    }
    
    function mostrarp1(){
        var campop1=$("#p1").find("option:selected").html();
        if(campop1=="No"){
            $("#p2").prop('disabled', true);
            $("#p3").prop('disabled', true);
            $("#p2").val("");
            $("#p3").val("");

        }else{
            $("#p2").prop( "disabled", false );
            $("#p3").prop( "disabled", false );

        }
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
        var campop4=$("#p4").find("option:selected").html();
        if(campop4=="No"){
            $("#p5").prop('disabled', true);
            $("#p6").prop('disabled', true);
            $("#p5").val("");
            $("#p6").val("");

        }else{
            $("#p5").prop( "disabled", false );
            $("#p6").prop( "disabled", false );

        }
    }

    function mostrarp5(){
        var campop5_val=$("#p5_val").val();
    
        let select = document.getElementById("p5");
        select.value = campop5_val;
    }

    function mostrarp6(){
        var campop6_val=$("#p6_val").val();
    
        let select = document.getElementById("p6");
        select.value = campop6_val;
    }

    function mostrarp8(){
        var campop8_val=$("#p8_val").val();
    
        let select = document.getElementById("p8");
        select.value = campop8_val;
    }

    function mostrarp9(){
        var campop9=$("#p9").find("option:selected").html();
        if(campop9=="No"){
            $("#p10").prop('disabled', true);
            $("#p10").val("");
        }else{
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
        var campop13_val=$("#p13_val").val();
    
        let select = document.getElementById("p13");
        select.value = campop13_val;
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
            $("#p18").val("");

        }else{
            $("#p18").prop( "disabled", false );

        }
    }

    function mostrarp19(){
        var campop19_val=$("#p19_val").val();
    
        let select = document.getElementById("p19");
        select.value = campop19_val;
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

    function mostrarp23(){
        var campop23_val=$("#p23_val").val();
    
        let select = document.getElementById("p23");
        select.value = campop23_val;
    }
 



 
    
    init();