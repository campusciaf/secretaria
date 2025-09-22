var image_ant = "", valor_defecto="";
$(document).ready(inicio);
function inicio() {
	$("#precarga").hide();
    listarDatos();
    updatedatos();
    mostrarform(1);
    mostrarpuntos();
    $("#ajuste").hide();
    $("#confirma").keyup(function () {
        dos = $("#nueva").val();
        uno = $("#confirma").val();
        if (uno == dos) {
        
            $(".confirmaCampo").removeClass("has-error");
            $(".confirmaCampodos").addClass("has-success");
            $(".confirmaCampo").addClass("has-success");
        } else {
            $(".confirmaCampo").addClass("has-error");
        }
    });
  $(".buttuno").on("submit", function (e) {
        e.preventDefault();
        valida();
    });

    $("#guardarDatosPersonales").on("submit", function (e0) {
        // e.preventDefault();
        editarDatos(e0);
    });

    $(".guardarDatos").on("submit", function (e2) {
        cambiarContra(e2);
    });

    $("#formulariodatos").on("submit", function (e1) {
        editarDatosPersona(e1);
       
    });

    $("#formulariodatos3").on("submit", function (e3) {
        editarDatosPersona3(e3);
       
    });

    $("#formulariodatos4").on("submit", function (e4) {
        editarDatosPersona4(e4);
       
    });

    $("#formulariodatos5").on("submit", function (e5) {
        editarDatosPersona5(e5);
       
    });

    $("#formulariodatos6").on("submit", function (e6) {
        editarDatosPersona6(e6);
       
    });
    
}
function mostrarpuntos(){
    $.post("../controlador/configurarcuentaestudiante.php?op=mostrarpuntos", function (datos) {
        var r = JSON.parse(datos);
        if(r[0].perfil == "si"){
            $("#coin-perfil").hide();
        }
        if(r[0].seres == "si"){
            $("#coin-seres").hide();
        }

        if(r[0].empleo == "si"){
            $("#coin-empleo").hide();
        }

        if(r[0].ingresos == "si"){
            $("#coin-ingresos").hide();
        }

        if(r[0].academica == "si"){
            $("#coin-academica").hide();
        }

        if(r[0].bienestar == "si"){
            $("#coin-bienestar").hide();
        }


    });
}


function tarjetacalendario() {
 
    $(".academico").slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            }
        ]
    });
}

window.onscroll = function() {fixDiv()};

function fixDiv() {
    var div = document.querySelector('#menuperfil');
    var offset = div.offsetTop;
    if (window.pageYOffset > offset) {
        div.classList.add('position-fixed');
        $("#ajuste").show();
    } else {
        div.classList.remove('position-fixed');
        $("#ajuste").hide();
    }
}



function mostrarform(num) {
    for (let i = 1; i <= 6; i++) {
        if (i === num) {
            $("#caract-" + i).addClass("activo").removeClass("inactivo");
            $("#form" + i).show();
        } else {
            $("#caract-" + i).addClass("inactivo").removeClass("activo");
            $("#form" + i).hide();
        }
    }
}


function comprimirImagen(file_input){
    const porcentajeCalidad = 20;
    var imagenComoArchivo = $("#" + file_input)[0];
    if (imagenComoArchivo.files.length <= 0) {
        return;
    }
    imagenComoArchivo = imagenComoArchivo.files[0];
    //crear un elemnto canvas para interpretar la imagen que llega
    elem_canvas = document.createElement("canvas");
    obj_imagen = new Image();
    //asignacion del fakepath al objeto de la imagen
    obj_imagen.src = URL.createObjectURL(imagenComoArchivo);
    //cuando la imagen este cargada hacemos una funcion callback
    obj_imagen.onload = () => {
        //al elemnto de canvas asignamos el width por defecto que tiene la imagen
        elem_canvas.width = obj_imagen.width;
        //al elemnto de canvas asignamos el height por defecto que tiene la imagen
        elem_canvas.height = obj_imagen.height;
        //con el canvas generado en 2 dimensiones, "dibujamos" la imagen sobre el lienzo
        elem_canvas.getContext("2d").drawImage(obj_imagen, 0, 0);
        //convertimos el canvas a un objeto tipo blob para modificar la calidad 
        elem_canvas.toBlob(function (blob) {
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function () {
                $("#b_" + file_input).val(reader.result);
                $("#preview_" + file_input).attr("src", reader.result);
                $(".btn_" + file_input).removeClass("d-none");
                $(".edit-" + file_input).toggleClass("d-none");
            }
        },
            'image/jpeg',
            porcentajeCalidad / 100);
    };
}
//cancela el input activo
function cancelar_input(campo) {
    //toma el valor que tenia antes del cambio y lo reemplaza
    $(".input-" + campo).val(valor_defecto);
    //funcion para activr o desactivar onputs
    activar_input(campo);
    $(".img_user").attr("src", image_ant);
}
//funcion para activr o desactivar onputs
function activar_input(campo) {
    //guarda el valor por defecto que tiene el input antes de ser editado
    valor_defecto = $(".input-" + campo).val();
    //si esta readonly lo pasa a false y si esta false lo pasa a true
    ($(".input-" + campo).prop('readonly')) ? $(".input-" + campo).prop('readonly', false) : $(".input-" + campo).prop('readonly', true);
    //activa el focus del campo a editar
    $(".input-" + campo).focus();
    //si el boton guardar tiene d-none elimina la clase y si no la tiene se la pone
    $(".guardar-" + campo).toggleClass("d-none");
    //si el boton cancelar tiene d-none elimina la clase y si no la tiene se la pone
    $(".cancel-" + campo).toggleClass("d-none");
    //si el boton editar tiene d-none elimina la clase y si no la tiene se la pone
    $(".edit-" + campo).toggleClass("d-none");
}
//Cambiar cualquier archivo, lo unico es colocar un digito cualquiera despues del nombre original de la carpeta
function cambiarImagen(campo) {
    input = $("#b_" + campo).val();
    if ((!input == "" || !input == null)) {
        $.ajax({
            "url": "../controlador/configurarcuentaestudiante.php?op=cambiarImagen", "type": "POST", "data": { 'campo': campo, 'valor': input }, "dataType": "JSON",
            success: function (datos) {
   
                if (datos.exito == 1) {
                    //si el boton guardar tiene d-none elimina la clase y si no la tiene se la pone
                    $(".guardar-" + campo).addClass("d-none");
                    $(".cancel-" + campo).addClass("d-none");
                    $(".edit-" + campo).toggleClass("d-none");
                    $("#b_" + campo).val("");
                    //si el boton cancelar tiene d-none elimina
                    alertify.success(datos.info);
                } else {
                    alertify.error(datos.info);
                }
            }, error: function (param) {
                $(".pop-up").addClass("d-none");
                alertify.error(param.responseText);
              
            }
        });
    } else {
        alertify.error("Debes subir la imagen de tu documento para continuar");
    }
}
function grupoEtnico(val) {
    $.post("../controlador/registrar2012.php?op=grupoEtnico", function (datos) {
     
        var opti = "";
        var r = JSON.parse(datos);
       
        if (val == "") {
            opti += '<option value="" selected disabled> - Grupo étnico - </option>';
        } else {
            opti += '<option value="" disabled> - Grupo étnico - </option>';
        }
        for (let i = 0; i < r.length; i++) {
            if (val == r[i].grupo_etnico) {
                opti += '<option selected value="' + r[i].grupo_etnico + '">' + r[i].grupo_etnico + '</option>';
            } else {
                opti += '<option value="' + r[i].grupo_etnico + '">' + r[i].grupo_etnico + '</option>';
            }

        }

        $(".grupo_etnico").append(opti);
    });
}

function tiposangre(val) {
    $.post("../controlador/configurarcuentaestudiante.php?op=tiposangre", function (datos) {

        var opti = "";
        var r = JSON.parse(datos);

        if (val == "") {
            opti += '<option value="" selected disabled> - Tipo de sangre - </option>';
        } else {
            opti += '<option value="" disabled> - Tipo de sangre - </option>';
        }
        for (let i = 0; i < r.length; i++) {
            if (val == r[i].nombre_sangre) {
                opti += '<option selected value="' + r[i].nombre_sangre + '">' + r[i].nombre_sangre + '</option>';
            } else {
                opti += '<option value="' + r[i].nombre_sangre + '">' + r[i].nombre_sangre + '</option>';
            }

        }

        $(".tipo_sangre").html(opti);
    });
}

function mostrar(id) {
    var nombre_et = $(".nom_et").val();
    if (id == "Comunidad negra" || id == "Pueblo indígena") {
        $.post("../controlador/registrar2012.php?op=nombreEtnico&id=" + id, function (datos) {
     
            var opti = "";
            var r = JSON.parse(datos);
         
            if (id == "") {
                opti += '<option value="" selected disabled> - Nombre étnico - </option>';
            } else {
                opti += '<option value="" disabled> - Nombre étnico - </option>';
            }
            for (let i = 0; i < r.length; i++) {
                if (nombre_et == r[i].nombre) {
                    opti += '<option selected value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
                } else {
                    opti += '<option value="' + r[i].nombre + '">' + r[i].nombre + '</option>';
                }
            }
            //$("#comunidad_negra").removeClass("hide");
            $(".nombre_etnico").html(opti);
        });
    } else {
        var opti = "";
        opti += '<option value="No pertenece" selected>No pertenece</option>';
        $(".nombre_etnico").html(opti);
    }
}

// lista en el selectpicker el departamento y municipio de nacimiento
function mostarDepar(val) {

    $.post("../controlador/configurarcuentaestudiante.php?op=mostarDepar", function (datos) {

        var opti = "";
        var r = JSON.parse(datos);
     
        
            

        if (val == "") {
            opti += '<option value="" selected disabled> - Departamentos - </option>';
        } else {
            opti += '<option value="" disabled> - Departamentos - </option>';
        }

        for (let i = 0; i < r.length; i++) {
            if (val == r[i].departamento) {
                opti += '<option selected value="' + r[i].departamento + '">' + r[i].departamento + '</option>';
            } else {
                opti += '<option value="' + r[i].departamento + '">' + r[i].departamento + '</option>';
            }

        }
        
        $(".depa_naci").html(opti);
        $('.depa_naci').selectpicker();
        $('.depa_naci').selectpicker('refresh');
    });
}

function mostrarmuni(depa,depa_se) {
    $.post("../controlador/configurarcuentaestudiante.php?op=mostarMuni",{depa:depa} ,function (datos) {
      
        var opti = "";
        var r = JSON.parse(datos);
    
        
            if (depa_se == "") {
                opti += '<option value="" selected disabled> - Municipios - </option>';
            } else {
                opti += '<option value="" disabled> - Municipios - </option>';
            }
            for (let i = 0; i < r.length; i++) {
                if (depa_se == r[i].municipio) {
                    opti += '<option selected value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
                } else {
                    opti += '<option value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
                }
            }
        

        $(".muni_naci").html(opti);
        /* $('.muni_naci').selectpicker();
        $('.muni_naci').selectpicker('refresh'); */
    });
}
//Fin

// lista en el selectpicker el departamento y municipio de residencia
function mostarDepar_residen(val) {

    $.post("../controlador/configurarcuentaestudiante.php?op=mostarDepar", function (datos) {
    
        var opti = "";
        var r = JSON.parse(datos);


        if (val == "") {
            opti += '<option value="" selected disabled> - Departamentos - </option>';
        } else {
            opti += '<option value="" disabled> - Departamentos - </option>';
        }
        for (let i = 0; i < r.length; i++) {
            if (val == r[i].departamento) {
                opti += '<option selected value="' + r[i].departamento + '">' + r[i].departamento + '</option>';
            } else {
                opti += '<option value="' + r[i].departamento + '">' + r[i].departamento + '</option>';
            }

        }


        $(".depa_reside").html(opti);
        $('.depa_reside').selectpicker();
        $('.depa_reside').selectpicker('refresh');
    });
}

function mostrarmuni_residen(depa, depa_se) {
    $.post("../controlador/configurarcuentaestudiante.php?op=mostarMuni", { depa: depa }, function (datos) {
    
        var opti = "";
        var r = JSON.parse(datos);
        

        if (depa_se == "") {
            opti += '<option value="" selected disabled> - Municipios - </option>';
        } else {
            opti += '<option value="" disabled> - Municipios - </option>';
        }
        for (let i = 0; i < r.length; i++) {
            if (depa_se == r[i].municipio) {
                opti += '<option selected value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
            } else {
                opti += '<option value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
            }
        }


        $(".muni_reside").html(opti);
        /* $('.muni_naci').selectpicker();
        $('.muni_naci').selectpicker('refresh'); */
    });
}
//Fin

function listarDatos() {
    $.post("../controlador/configurarcuentaestudiante.php?op=listarDatos", function (e) {
      
        var r = JSON.parse(e);
        $(".mostrar-uno").html(r.conte);
        image_ant = $(".img_user").attr("src");
        tarjetacalendario();
    });
}

function updatedatos() {
    $.post("../controlador/configurarcuentaestudiante.php?op=editarDatos", { }, function (e) {
     
        var r = JSON.parse(e);
        $("#guardarDatosPersonales").html(r.conte);
        $("#editarDatos").modal("show");
		$("#conte1").show();
		$("#conte2").hide();
		$("#buttuno").show();
    	$("#buttdos").hide();
        
        grupoEtnico(r.grupo);
        mostrar(r.grupo,r.nom);

        mostarDepar_residen(r.depar_residencia);
        mostrarmuni_residen(r.depar_residencia,r.muni_residencia);
        tiposangre(r.sangre);
        $(".gene").val(r.genero);
        $(".estra").val(r.estrato);

    });
}

function editarContrasena() {
    $("#restrablecer").modal("show"); 
}

function cambiarContra(e) {
    e.preventDefault();
    var formData = new FormData($("#form2")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/configurarcuentaestudiante.php?op=cambiarContra",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
        console.log(datos)
            var r = JSON.parse(datos);
            if (r.status == "ok") {
                alertify.success("Contraseña actualizada con Exito");
                $("#form2")[0].reset();
                $("#restrablecer").modal("hide");
            } else {
                alertify.error(r.status);
            }
        }
    });

}

function editarDatos(e0) {

    $("#precarga").show();
    e0.preventDefault();
    var formData = new FormData($("#guardarDatosPersonales")[0]);

        $.ajax({
            type: "POST",
            url: "../controlador/configurarcuentaestudiante.php?op=editarDatospersonales",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                
                var r = JSON.parse(datos);
                console.log(r[0].datos)
                if (r[0].datos == "si") {
                    alertify.success("Datos actualizada con Exito");
                    listarDatos();
                    $("#precarga").hide();
                } else {
                    alertify.error(r.status);
                }
                if(r[0].puntos=="si"){
                   
                    Swal.fire({
                        position: "top-end",
                        imageWidth: 150,
                        imageHeight: 150,
                        imageUrl: "../public/img/ganancia.gif",
                        title: "Te otorgamos " + r[0].puntosotorgados +" puntos, por actualizar los datos de contacto",
                        showConfirmButton: false,
                        timer: 4000
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 4000); // 3000 milisegundos = 3 segundos

                }
            }
        });
       

   
}

function listarPreguntas(){
    $("#precarga").show(); 
    $.post("../controlador/configurarcuentaestudiante.php?op=listarPreguntas", function(data){	
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

function editarDatosPersona(e1) {
    $("#precarga").show();
    e1.preventDefault();
    var formData = new FormData($("#formulariodatos")[0]);

            $.ajax({
                type: "POST",
                url: "../controlador/configurarcuentaestudiante.php?op=guardaryeditar",
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    var r = JSON.parse(datos);

                    if(r[0].estado == "si"){
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

                     if(r[0].puntos=="si"){
                   
                        Swal.fire({
                            position: "top-end",
                            imageWidth: 150,
                            imageHeight: 150,
                            imageUrl: "../public/img/ganancia.gif",
                            title: "Te otorgamos " + r[0].puntosotorgados +" puntos, por actualizar los datos personales",
                            showConfirmButton: false,
                            timer: 4000
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 4000); // 3000 milisegundos = 3 segundos

                    }
                   

                }
            });
        

}

function listarPreguntas3(){
    $("#precarga").show(); 
    $.post("../controlador/configurarcuentaestudiante.php?op=listarPreguntas3", function(data){	
        r = JSON.parse(data);
        $("#preguntas3").html(r.datos);
            cmostrarp1();// ¿Trabajas actualmente?
            cmostrarp3();// Tipo de sector de la empresa en la que trabajas
            cmostrarp6();// Jornada laboral 
            cmostrarp8();// Alguien de tu trabajo actual o anteriores, te inspiró a estudiar 
            cmostrarp11();// ¿Tienes una empresa legalmente constituida?    
            cmostrarp13();// Tienes una idea de negocio o emprendimiento
            cmostrarp15();// Sector de la empresa, emprendimiento o idea de negocio
            cmostrarp18();// Has realizado algún curso o capacitación relacionada con emprendimiento
        $("#precarga").hide();  
        
    });
}

function cmostrarp1(){
    var campop1=$("#cp1").find("option:selected").html();
    if(campop1=="No"){
        $("#cp2").prop('disabled', true);
        $("#cp3").prop('disabled', true);
        $("#cp4").prop('disabled', true);
        $("#cp5").prop('disabled', true);
        $("#cp6").prop('disabled', true);
        $("#cp7").prop('disabled', true);
        $("#cp2").val("");
        $("#cp3").val("");
        $("#cp4").val("");
        $("#cp5").val("");
        $("#cp6").val("");
        $("#cp7").val("");
    }else{
        $("#cp2").prop( "disabled", false );
        $("#cp3").prop( "disabled", false );
        $("#cp4").prop( "disabled", false );
        $("#cp5").prop( "disabled", false );
        $("#cp6").prop( "disabled", false );
        $("#cp7").prop( "disabled", false );
    }
}

function cmostrarp3(){
    var campop3_val=$("#cp3_val").val();

    let select = document.getElementById("cp3");
    select.value = campop3_val;
}

function cmostrarp6(){
    var campop6_val=$("#cp6_val").val();

    let select = document.getElementById("cp6");
    select.value = campop6_val;
}

function cmostrarp8(){
    var campop8=$("#cp8").find("option:selected").html();
    if(campop8=="No"){
        $("#cp9").prop('disabled', true);
        $("#cp10").prop('disabled', true);
        $("#cp9").val("");
        $("#cp10").val("");
    }else{
        $("#cp9").prop( "disabled", false );
        $("#cp10").prop( "disabled", false );
    }
}

function cmostrarp11(){
    var campop11=$("#cp11").find("option:selected").html();
    if(campop11=="No"){
        $("#cp12").prop('disabled', true);
        $("#cp12").val("");
    }else{
        $("#cp12").prop( "disabled", false );
    }
}

function cmostrarp13(){
    var campop13=$("#cp13").find("option:selected").html();
    if(campop13=="No"){
        $("#cp14").prop('disabled', true);
        $("#cp14").val("");
        $("#cp15").prop('disabled', true);
        $("#cp15").val("");
        $("#cp16").prop('disabled', true);
        $("#cp16").val("");
    }else{
        $("#cp14").prop( "disabled", false );
        $("#cp15").prop( "disabled", false );
        $("#cp16").prop( "disabled", false );
    }
}

function cmostrarp15(){
    var campop15_val=$("#cp15_val").val();

    let select = document.getElementById("cp15");
    select.value = campop15_val;
}

function cmostrarp18(){
    var campop18=$("#cp18").find("option:selected").html();
    if(campop18=="No"){
        $("#cp19").prop('disabled', true);
        $("#cp19").val("");

    }else{
        $("#cp19").prop( "disabled", false );

    }
}

function editarDatosPersona3(e3) {
    $("#precarga").show();
    e3.preventDefault();
    var formData = new FormData($("#formulariodatos3")[0]);

        $.ajax({
            type: "POST",
            url: "../controlador/configurarcuentaestudiante.php?op=guardaryeditar3",
            data: formData,
            contentType: false,
            processData: false,
            success: function (datos) {
                r = JSON.parse(datos);
                if(r[0].estado == "si"){
                    Swal.fire({
                        icon: "success",
                        title: "Datos actualizados",
                        showConfirmButton: false,
                        timer: 1500
                        });
                    
                    listarPreguntas3();
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

                if(r[0].puntos=="si"){
                
                    Swal.fire({
                        position: "top-end",
                        imageWidth: 150,
                        imageHeight: 150,
                        imageUrl: "../public/img/ganancia.gif",
                        title: "Te otorgamos " + r[0].puntosotorgados +" puntos, por actualizar los datos de empleabilidad",
                        showConfirmButton: false,
                        timer: 4000
                    });

                    setTimeout(function() {
                        location.reload();
                    }, 4000); // 3000 milisegundos = 3 segundos

                }

            }
        });
        
}

function listarPreguntas4(){
    $("#precarga").show(); 
    $.post("../controlador/configurarcuentaestudiante.php?op=listarPreguntas4", function(data){	
        r = JSON.parse(data);
        $("#preguntas4").html(r.datos);

            dmostrarp1();// ¿Estás embarazada?
            dmostrarp2();
            dmostrarp3();// 
            dmostrarp4();// 
            dmostrarp6();//


        $("#precarga").hide();  
        
    });
}

function dmostrarp1(){
    var campop1_val=$("#dp1_val").val();

    let select = document.getElementById("dp1");
    select.value = campop1_val;
}

function dmostrarp2(){
    var campop2_val=$("#dp2_val").val();

    let select = document.getElementById("dp2");
    select.value = campop2_val;
}

function dmostrarp3(){
    var campop3_val=$("#dp3_val").val();

    let select = document.getElementById("dp3");
    select.value = campop3_val;
}

function dmostrarp4(){
    var campop4_val=$("#dp4_val").val();

    let select = document.getElementById("dp4");
    select.value = campop4_val;
}


function dmostrarp6(){
    
    var campop5=$("#dp5").find("option:selected").html();
    var campop6_val=$("#dp6_val").val();


    let select = document.getElementById("dp6");
    select.value = campop6_val;
    
    if(campop5=="No"){
        $("#dp6").prop('disabled', true);
        let select2 = document.getElementById("dp6");
        select2.value = "";
    }else{
        $("#dp6").prop( "disabled", false );
       
    }
}

function editarDatosPersona4(e4) {
    $("#precarga").show();
    e4.preventDefault();
    var formData = new FormData($("#formulariodatos4")[0]);

            $.ajax({
                type: "POST",
                url: "../controlador/configurarcuentaestudiante.php?op=guardaryeditar4",
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    r = JSON.parse(datos);

                    if(r[0].estado == "si"){
                        Swal.fire({
                            icon: "success",
                            title: "Datos actualizados",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        
                        listarPreguntas4();
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

                    if(r[0].puntos=="si"){
                
                        Swal.fire({
                            position: "top-end",
                            imageWidth: 150,
                            imageHeight: 150,
                            imageUrl: "../public/img/ganancia.gif",
                            title: "Te otorgamos " + r[0].puntosotorgados +" puntos, por actualizar sus ingresos",
                            showConfirmButton: false,
                            timer: 4000
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 4000); // 3000 milisegundos = 3 segundos

                    }

                }
            });
        

}

function listarPreguntas5(){
    $("#precarga").show(); 
    $.post("../controlador/configurarcuentaestudiante.php?op=listarPreguntas5", function(data){	
        r = JSON.parse(data);
        $("#preguntas5").html(r.datos);

            emostrarp1();// 
            emostrarp2();// 
            emostrarp3();// 
            emostrarp4();// 
            emostrarp5();// 
            emostrarp7();//
            emostrarp8();//
            emostrarp9();//
            //mostrarp10();//



        $("#precarga").hide();  
        
    });
}

function emostrarp1(){
    var campop1_val=$("#ep1_val").val();

    let select = document.getElementById("ep1");
    select.value = campop1_val;
}

function emostrarp2(){
    var campop2_val=$("#ep2_val").val();

    let select = document.getElementById("ep2");
    select.value = campop2_val;
}

function emostrarp3(){
    var campop3_val=$("#ep3_val").val();

    let select = document.getElementById("ep3");
    select.value = campop3_val;
}

function emostrarp4(){
    var campop4_val=$("#ep4_val").val();

    let select = document.getElementById("ep4");
    select.value = campop4_val;
}

function emostrarp5(){

    var campop5=$("#ep5").find("option:selected").html();
    var campop6_val=$("#ep6_val").val();

    let select = document.getElementById("ep6");
    select.value = campop6_val;
    
    if(campop5=="No"){
        $("#ep6").prop('disabled', true);
        let select2 = document.getElementById("ep6");
        select2.value = "";
    }else{
        $("#ep6").prop( "disabled", false );
       
    }
}

function emostrarp7(){
    var campop7=$("#ep7").find("option:selected").html();
    if(campop7=="No"){
        $("#ep8").prop('disabled', true);
        $("#ep9").prop('disabled', true);
        $("#ep8").val("");
        $("#ep9").val("");
    }else{
        $("#ep8").prop( "disabled", false );
        $("#ep9").prop( "disabled", false );
    }
}

function emostrarp8(){
    var campop8_val=$("#ep8_val").val();

    let select = document.getElementById("ep8");
    select.value = campop8_val;
}

function emostrarp9(){
    var campop9_val=$("#ep9_val").val();

    let select = document.getElementById("ep9");
    select.value = campop9_val;
}

function editarDatosPersona5(e5) {
    $("#precarga").show();
    e5.preventDefault();
    var formData = new FormData($("#formulariodatos5")[0]);

            $.ajax({
                type: "POST",
                url: "../controlador/configurarcuentaestudiante.php?op=guardaryeditar5",
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {

                    r = JSON.parse(datos);

                    if(r[0].estado == "si"){
                        Swal.fire({
                            icon: "success",
                            title: "Datos actualizados",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        
                        listarPreguntas5();
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

                    if(r[0].puntos=="si"){
                
                        Swal.fire({
                            position: "top-end",
                            imageWidth: 150,
                            imageHeight: 150,
                            imageUrl: "../public/img/ganancia.gif",
                            title: "Te otorgamos " + r[0].puntosotorgados +" puntos, por actualizar su información académica",
                            showConfirmButton: false,
                            timer: 4000
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 4000); // 3000 milisegundos = 3 segundos

                    }

                }
            });
        

}

function listarPreguntas6(){
    $("#precarga").show(); 
    $.post("../controlador/configurarcuentaestudiante.php?op=listarPreguntas6", function(data){	
        r = JSON.parse(data);
        $("#preguntas6").html(r.datos);
            fmostrarp1();// 
            fmostrarp2();// 
            fmostrarp3();// 
            fmostrarp4();//
            fmostrarp5();//
            fmostrarp6();// 
            fmostrarp8();//
            fmostrarp9();//
            fmostrarp11();//    
            fmostrarp13();// 
            fmostrarp14();//
            fmostrarp16();//
            fmostrarp17();// 
            fmostrarp19();//
            fmostrarp20();//
            fmostrarp21();//
            fmostrarp23();//
        $("#precarga").hide();  
        
    });
}

function fmostrarp1(){
    var campop1=$("#fp1").find("option:selected").html();
    if(campop1=="No"){
        $("#fp2").prop('disabled', true);
        $("#fp3").prop('disabled', true);
        $("#fp2").val("");
        $("#fp3").val("");

    }else{
        $("#fp2").prop( "disabled", false );
        $("#fp3").prop( "disabled", false );

    }
}
function fmostrarp2(){
    var campop2_val=$("#fp2_val").val();

    let select = document.getElementById("fp2");
    select.value = campop2_val;
}

function fmostrarp3(){
    var campop3_val=$("#fp3_val").val();

    let select = document.getElementById("fp3");
    select.value = campop3_val;
}

function fmostrarp4(){
    var campop4=$("#fp4").find("option:selected").html();
    if(campop4=="No"){
        $("#fp5").prop('disabled', true);
        $("#fp6").prop('disabled', true);
        $("#fp5").val("");
        $("#fp6").val("");

    }else{
        $("#fp5").prop( "disabled", false );
        $("#fp6").prop( "disabled", false );

    }
}

function fmostrarp5(){
    var campop5_val=$("#fp5_val").val();

    let select = document.getElementById("fp5");
    select.value = campop5_val;
}

function fmostrarp6(){
    var campop6_val=$("#fp6_val").val();

    let select = document.getElementById("fp6");
    select.value = campop6_val;
}

function fmostrarp8(){
    var campop8_val=$("#fp8_val").val();

    let select = document.getElementById("fp8");
    select.value = campop8_val;
}

function fmostrarp9(){
    var campop9=$("#fp9").find("option:selected").html();
    if(campop9=="No"){
        $("#fp10").prop('disabled', true);
        $("#fp10").val("");
    }else{
        $("#fp10").prop( "disabled", false );
    }
}

function fmostrarp11(){
    var campop11=$("#fp11").find("option:selected").html();
    if(campop11=="No"){
        $("#fp12").prop('disabled', true);
        $("#fp12").val("");
    }else{
        $("#fp12").prop( "disabled", false );
    }
}

function fmostrarp13(){
    var campop13_val=$("#fp13_val").val();

    let select = document.getElementById("fp13");
    select.value = campop13_val;
}

function fmostrarp14(){
    var campop14_val=$("#fp14_val").val();

    let select = document.getElementById("fp14");
    select.value = campop14_val;
}

function fmostrarp16(){
    var campop16_val=$("#fp16_val").val();

    let select = document.getElementById("fp16");
    select.value = campop16_val;
}

function fmostrarp17(){
    var campop17=$("#fp17").find("option:selected").html();
    if(campop17=="No"){
        $("#fp18").prop('disabled', true);
        $("#fp18").val("");

    }else{
        $("#fp18").prop( "disabled", false );

    }
}

function fmostrarp19(){
    var campop19_val=$("#fp19_val").val();

    let select = document.getElementById("fp19");
    select.value = campop19_val;
}

function fmostrarp20(){
    var campop20_val=$("#fp20_val").val();

    let select = document.getElementById("fp20");
    select.value = campop20_val;
}

function fmostrarp21(){
    var campop21_val=$("#fp21_val").val();

    let select = document.getElementById("fp21");
    select.value = campop21_val;
}

function fmostrarp23(){
    var campop23_val=$("#fp23_val").val();

    let select = document.getElementById("fp23");
    select.value = campop23_val;
}


function editarDatosPersona6(e6) {
    $("#precarga").show();
    e6.preventDefault();
    var formData = new FormData($("#formulariodatos6")[0]);

            $.ajax({
                type: "POST",
                url: "../controlador/configurarcuentaestudiante.php?op=guardaryeditar6",
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    r = JSON.parse(datos);
                    if(r[0].estado == "si"){
                        Swal.fire({
                            icon: "success",
                            title: "Datos actualizados",
                            showConfirmButton: false,
                            timer: 1500
                          });
                        
                        listarPreguntas6();
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

                    if(r[0].puntos=="si"){
                
                        Swal.fire({
                            position: "top-end",
                            imageWidth: 150,
                            imageHeight: 150,
                            imageUrl: "../public/img/ganancia.gif",
                            title: "Te otorgamos " + r[0].puntosotorgados +" puntos, por actualizar su información institucional",
                            showConfirmButton: false,
                            timer: 4000
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 4000); // 3000 milisegundos = 3 segundos

                    }

                }
            });
        

}