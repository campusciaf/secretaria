var tabla;
//Función que se ejecuta al inicio
function init(){
	mostrartoast();
	listar();
    verificarAutoevaluacion();
	
}
function listar(){
	$.post("../controlador/panel.php?op=listar",{},function(data){
        data = JSON.parse(data);
        $("#tllistado").html("");
        $("#tllistado").append(data["0"]["0"]);
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

