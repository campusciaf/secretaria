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
                    url: "../controlador/carseresoriginales.php?op=guardaryeditar",
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
        $.post("../controlador/carseresoriginales.php?op=verificar", function(data){
 
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
            url: "../controlador/carseresoriginales.php?op=guardardata",
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
        $.post("../controlador/carseresoriginales.php?op=listarPreguntas", function(data){	
            r = JSON.parse(data);
            $("#preguntas").html(r.datos);
            if(r.condi=="Femenino"){
                mostrarp1();// ¿Estás embarazada?
            }
                mostrarp3();// ¿Eres desplazado(a) por la violencia?
                mostrarp5();// ¿A qué grupo poblacional perteneces?
                mostrarp6();// ¿Perteneces a la comunidad LGBTIQ+? 
                mostrarp9();// ¿Cuál es tu relación o parentesco con esta persona?
                mostrarp13();// ¿Cuál es tu relación o parentesco con esta persona segundo contacto?
                mostrarp16();// ¿Tienes un computador o tablet?
                mostrarp17();// ¿Tienes conexión a internet en casa?
                mostrarp18();// ¿Tienes planes de datos en tu celular?

            $("#precarga").hide();  
            
        });
    }
    
    function mostrarp1(){

        var campop1=$("#p1").find("option:selected").html();
        var campop2_val=$("#p2_val").val();
    
        let select = document.getElementById("p2");
        select.value = campop2_val;
        
        if(campop1=="No"){
            $("#p2").prop('disabled', true);
            let select2 = document.getElementById("p2");
            select2.value = "";
        }else{
            $("#p2").prop( "disabled", false );
           
        }
    }

    function mostrarp3(){
        
        var campop3=$("#p3").find("option:selected").html();
        var campop4_val=$("#p4_val").val();

    
        let select = document.getElementById("p4");
        select.value = campop4_val;
        
        if(campop3=="No"){
            $("#p4").prop('disabled', true);
            let select2 = document.getElementById("p4");
            select2.value = "";
        }else{
            $("#p4").prop( "disabled", false );
           
        }
    }

    function mostrarp5(){
        var campop5_val=$("#p5_val").val();
    
        let select = document.getElementById("p5");
        select.value = campop5_val;
    }
    
    function mostrarp6(){

        var campop6=$("#p6").find("option:selected").html();
        var campop7_val=$("#p7_val").val();
    
        let select = document.getElementById("p7");
        select.value = campop7_val;
        
        if(campop6=="No"){
            $("#p7").prop('disabled', true);
            let select2 = document.getElementById("p7");
            select2.value = "";
        }else{
            $("#p7").prop( "disabled", false );
           
        }
    }

    function mostrarp9(){
        var campop9_val=$("#p9_val").val();
    
        let select = document.getElementById("p9");
        select.value = campop9_val;
    }
    function mostrarp13(){
        var campop13_val=$("#p13_val").val();
    
        let select = document.getElementById("p13");
        select.value = campop13_val;
    }

    function mostrarp16(){
        var campop16_val=$("#p16_val").val();
    
        let select = document.getElementById("p16");
        select.value = campop16_val;
    }

    function mostrarp17(){
        var campop17_val=$("#p17_val").val();
    
        let select = document.getElementById("p17");
        select.value = campop17_val;
    }
    function mostrarp18(){
        var campop18_val=$("#p18_val").val();
    
        let select = document.getElementById("p18");
        select.value = campop18_val;
    }

 
    
    init();