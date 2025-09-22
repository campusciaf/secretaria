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
                    url: "../controlador/carinspiradores.php?op=guardaryeditar",
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
        $.post("../controlador/carinspiradores.php?op=verificar", function(data){
 
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
            url: "../controlador/carinspiradores.php?op=guardardata",
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
        $.post("../controlador/carinspiradores.php?op=listarPreguntas", function(data){	
            r = JSON.parse(data);
            $("#preguntas").html(r.datos);

                mostrarp1();// ●	Estado civil
                mostrarp2();// ●	¿Tienes hijos? 
                mostrarp5();// ●	¿Tu padre se encuentra vivo?
                mostrarp7();// Nivel educativo de tu padre
                mostrarp8();// ●	¿Tu madre se encuentra vivo?
                mostrarp11();// Nivel educativo de tu madre
                mostrarp12();// Cuál es la situación laboral actual de tus padres 
                mostrarp13();// ●	¿En qué industria o sector trabajan tus padres 
                mostrarp14();// ●	¿Qué cursos o diplomados de interés de tus padres
                mostrarp15();// ●	¿Tiene pareja? 
                mostrarp18();// ●	¿Tienes hermanos? 
                mostrarp19();// ●	¿Cuántos hermanos tienes? 
                mostrarp20();// ●	¿En qué rango de edad se encuentran tus hermanos?
                mostrarp21();// ●	¿Con quién vive? 
                mostrarp22();//●	¿Tienes personas a tu cargo?
                mostrarp23();// ●	¿Cuántas personas tienes a cargo?
                mostrarp24();// ●	Quién es la persona que te inspiró a estudiar 
                mostrarp28();// ●	Nivel de formación de tu inspirador 
                mostrarp29();// Cuál es la situación laboral actual de tu inspirador
                mostrarp30();// En qué industria o sector trabaja tu inspirador
                mostrarp31();// Qué cursos o diplomados de interés para tu inspirador
               
            $("#precarga").hide();  
            
        });
    }
    
    function mostrarp1(){
        var campop1_val=$("#p1_val").val();
    
        let select = document.getElementById("p1");
        select.value = campop1_val;
    }

    function mostrarp2(){

        var campop2=$("#p2").find("option:selected").html();
        var campop3_val=$("#p3_val").val();
    
        let select = document.getElementById("p3");
        select.value = campop3_val;
        
        if(campop2=="No"){
            $("#p3").prop('disabled', true);
            let select3 = document.getElementById("p3");
            select3.value = "";
        }else{
            $("#p3").prop( "disabled", false );
           
        }
    }

    function mostrarp5(){
        var campop4=$("#p4").find("option:selected").html();
        if(campop4=="No"){
            $("#p5").prop('disabled', true);
            $("#p6").prop('disabled', true);
            $("#p7").prop('disabled', true);
            $("#p5").val("");
            $("#p6").val("");
            $("#p7").val("");
        }else{
            $("#p5").prop( "disabled", false );
            $("#p6").prop( "disabled", false );
            $("#p7").prop( "disabled", false );
        }
    }

    function mostrarp7(){
        var campop7_val=$("#p7_val").val();
    
        let select = document.getElementById("p7");
        select.value = campop7_val;
    }

    function mostrarp8(){
        var campop8=$("#p8").find("option:selected").html();
        if(campop8=="No"){
            $("#p9").prop('disabled', true);
            $("#p10").prop('disabled', true);
            $("#p11").prop('disabled', true);
            $("#p9").val("");
            $("#p10").val("");
            $("#p11").val("");
        }else{
            $("#p9").prop( "disabled", false );
            $("#p10").prop( "disabled", false );
            $("#p11").prop( "disabled", false );
        }
    }

    function mostrarp11(){
        var campop11_val=$("#p11_val").val();
    
        let select = document.getElementById("p11");
        select.value = campop11_val;
    }

    function mostrarp12(){
        var campop12_val=$("#p12_val").val();
    
        let select = document.getElementById("p12");
        select.value = campop12_val;
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
    
    function mostrarp15(){
        var campop15=$("#p15").find("option:selected").html();
        if(campop15=="No"){
            $("#p16").prop('disabled', true);
            $("#p17").prop('disabled', true);
            $("#p16").val("");
            $("#p17").val("");
        }else{
            $("#p16").prop( "disabled", false );
            $("#p17").prop( "disabled", false );
        }
    }

    function mostrarp18(){
        var campop18=$("#p18").find("option:selected").html();
        if(campop18=="No"){
            $("#p19").prop('disabled', true);
            $("#p20").prop('disabled', true);
            $("#p19").val("");
            $("#p20").val("");
        }else{
            $("#p19").prop( "disabled", false );
            $("#p20").prop( "disabled", false );
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

    function mostrarp22(){

        var campop22=$("#p22").find("option:selected").html();
        var campop23_val=$("#p23_val").val();
    
        let select = document.getElementById("p23");
        select.value = campop23_val;
        
        if(campop22=="No"){
            $("#p23").prop('disabled', true);
            let select3 = document.getElementById("p23");
            select3.value = "";
        }else{
            $("#p23").prop( "disabled", false );
           
        }
    }

    function mostrarp23(){
        var campop23_val=$("#p23_val").val();
    
        let select = document.getElementById("p23");
        select.value = campop23_val;
    }

    function mostrarp24(){
        var campop24_val=$("#p24_val").val();
    
        let select = document.getElementById("p24");
        select.value = campop24_val;
    }

    function mostrarp28(){
        var campop28_val=$("#p28_val").val();
    
        let select = document.getElementById("p28");
        select.value = campop28_val;
    }

    function mostrarp29(){
        var campop29_val=$("#p29_val").val();
    
        let select = document.getElementById("p29");
        select.value = campop29_val;
    }

    function mostrarp30(){
        var campop30_val=$("#p30_val").val();
    
        let select = document.getElementById("p30");
        select.value = campop30_val;
    }
    
    function mostrarp31(){
        var campop31_val=$("#p31_val").val();
    
        let select = document.getElementById("p31");
        select.value = campop31_val;
    }
    init();