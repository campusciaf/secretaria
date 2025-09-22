$(document).ready(panel());

//Función que se ejecuta al inicio

function panel(){
    $('#foto').change(function(e) {
        addImage(e); 
    });

    $('#cv_hoja_personal').off("click").on("click",function(e) {
        e.preventDefault();
        window.open("cv_hoja_personal.php?uid="+$(this).data("toogle"));

    });


}
function addImage(e){
    if(!$('#foto').val().trim() == ''){
        var file = e.target.files[0],
        imageType = /image.*/;
        if (!file.type.match(imageType))return;
            var reader = new FileReader();
            reader.onload = fileOnload;
            reader.readAsDataURL(file);

    }

}

function fileOnload(e) {
    var result=e.target.result;
    $('#img_foto_hoja_vida').attr("src",result);

}
var tabla;
//Función que se ejecuta al inicio
function init(){
	// listar();
    // verificarAutoevaluacion();
	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
}
function mostrarmunicipio(departamento) {
    $.post(
        "../controlador/panel.php?op=mostrarMunicipios",
        { "id_departamento": departamento },
        function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            var option = '<option value="" selected disabled>-- Selecciona Municipio --</option>';
            for (let i = 0; i < r.length; i++) {
                option += '<option value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
            }
            $("#ciudad").html(option);
            $("#ciudad").selectpicker("refresh");
        }
    );
}
function listar(){
	$.post("../controlador/panel.php?op=listar",{},function(data){
        // console.log(data);
        data = JSON.parse(data);
        $("#tllistado").html("");
        $("#tllistado").append(data["0"]["0"]);
	});
}
//funcion para abrir el modal de estudiante automaticamente
function verificarAutoevaluacion(){
	$.post("../controlador/panel.php?op=verificarAutoevaluacion",{},function(data){
    // console.log(data);
	data = JSON.parse(data);
		if(data=="1"){
			$('#myModalEncuesta').modal({backdrop: 'static', keyboard: false});// linea para desahbilitar el click de cerrar			
			$("#myModalEncuesta").modal("show");		
		}else{
			$("#myModalEncuesta").modal("hide");
		}
	});
}
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		"url": "../controlador/panel.php?op=guardaryeditar",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(){
            alertify.success("Gracias por superar las barreras"); 
            $("#myModalEncuesta").modal("hide");
        }
	});

}
function mostrarPregunta(valor,pregunta){
	switch(pregunta){
		case 1:
			if(valor=="otro"){
                $("#pr1-1").show();
            }else{
                $("#pr1-1").hide();
            }
		break;
		case 2:
			if(valor=="otro"){
                $("#pr2-1").show();
            }else{
                $("#pr2-1").hide();  
            }
		break;
		case 3:
			if(valor=="otro"){
                $("#pr3-1").show();
            }else{
                $("#pr3-1").hide();  
            }
		break;
		case 4:
			if(valor=="otro"){
                $("#pr4-1").show();
            }else{
                $("#pr4-1").hide();
            }
		break;	
		case 5:
			if(valor=="otro"){
                $("#pr5-1").show();
            }else{
                $("#pr5-1").hide();
            }
		break;	
    }
}
init();