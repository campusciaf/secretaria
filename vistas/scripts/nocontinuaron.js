var tabla;
//Función que se ejecuta al inicio
function init() {
	listarescuelas();
	$("#listadoregistros").hide();
}
//Cargamos los items de los selects
function cargarperiodo() {
	$.post("../controlador/nocontinuaron.php?op=selectPeriodo", function (r) {
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});

}
function listarescuelas() {
	$("#precarga").show();
	$.post("../controlador/nocontinuaron.php?op=listarescuelas", {}, function (r) {
		var e = JSON.parse(r);
		$("#escuelas").html(e.mostrar);
		$("#precarga").hide();
	});
}

function listar(id_escuela){
    $("#precarga").show();
	$.post("../controlador/nocontinuaron.php?op=listar",{id_escuela:id_escuela}, function(r){
		var e = JSON.parse(r);
		$("#resultado").html(e.mostrar);
		$("#precarga").hide();
		$("#listadoregistros").show();

	});
}



init();// inicializa la funcion init