$(document).ready(inscribete);
function inscribete(){
	const prefijosUnicos = [
		"300", "301", "302", "303", "304", "305", "310", "311", "312", "313",
		"314", "315", "316", "317", "318", "319", "320", "321", "322", "323",
		"324", "350", "351", "333"
	];

	$(".representante_menor").hide();
	mostrarDepartamentos();
	$("#formulario").off("submit").on("submit", function(e){
		e.preventDefault();
		guardaryeditar();
	});
	$("#fecha_nacimiento").on("change", function () {
		// tomamos la fecha de nacimiento
		const fecha_nacimiento = new Date($("#fecha_nacimiento").val());
		// creamos una variable con la fecha actual
		const fecha_actual = new Date();
		// calculamos la edad en años
		let edad = fecha_actual.getFullYear() - fecha_nacimiento.getFullYear();
		// ajustamos en caso de que el mes o el día de la fecha aún no ha pasado este año
		if (fecha_actual.getMonth() < fecha_nacimiento.getMonth() || (fecha_actual.getMonth() === fecha_nacimiento.getMonth() && fecha_actual.getDate() < fecha_nacimiento.getDate())) {
			//le restamos 1 en caso de que la condicion se cumpla
			edad--;
		}
		//Si la edad es mayor o igual a 18 mostramos el tratamiento de datos para mayores
		if (edad >= 18){
			//modificacmos el atributo href para el enlace de tratamientos para mayores
			$(".politicas").attr("href", "https://ciaf.digital/public/web_tratamiento_datos/Tratamiento_de_datos_CIAF_2024.pdf");
			//Escondemos en caso de que este visible los campos del representante legal
			$(".representante_menor").hide(500);
			//removemos el atributo de required a los campos para evitar errores de envio
			$(".input-representante").prop("required", false);
		}else{
			//modificacmos el atributo href para el enlace de tratamientos para menore
			$(".politicas").attr("href", "https://ciaf.digital/public/web_tratamiento_datos/Tratamiento_de_datos_menores_CIAF_2024.pdf");
			//mostramos en caso de que este oculto los campos del representante legal
			$(".representante_menor").show(500);
			//Agregamor el atributo required a los campos para obligarlo a llenar
			$(".input-representante").prop("required", true);
		}
	});
	$("#labora_actualmente").on("click", function(){
		habilitar_otro_ingeso();
	});
	$('#numero_documento').on('input', function () {
		const valor = $(this).val();
		const esInvalido = prefijosUnicos.some(prefijo => valor.startsWith(prefijo));
		if (esInvalido && valor.length == 10) {
			$(this).addClass('is-invalid');
			$(".btn-final").prop("disabled", true);
		} else {
			$(this).removeClass('is-invalid');
			$(".btn-final").prop("disabled", false);
		}
	});
}
// lista en el selectpicker el departamento y municipio de nacimiento
function mostrarDepartamentos() {
	//console.log(val);
	$.post("../controlador/sofi_inscribete.php?op=mostrarDepartamento", function(datos){
		//console.log(datos);
		var option = '<option value="" selected disabled>-- Selecciona departamento --</option>';
		//console.log(r);
		var r = JSON.parse(datos);
		for (let i = 0; i < r.length; i++) {
			option += '<option value="' + r[i].id_departamento+'">' + r[i].departamento + '</option>';
		}
		$(".departamento").html(option);
	});
}
//listar municipios dependiendo del departamento
function mostrarMunicipios(departamento) {
	$.post("../controlador/sofi_inscribete.php?op=mostrarMunicipios",{"id_departamento": departamento }, function (datos) {
		//console.log(datos);
		var r = JSON.parse(datos);
		var option ='<option value="" selected disabled>-- Selecciona Municipio --</option>';
		for (let i = 0; i < r.length; i++) {
			option += '<option value="' + r[i].municipio + '">' + r[i].municipio + '</option>';
		}
		$(".ciudad").html(option);
	});
}
// Función para almacenar la información de la solicitud
function guardaryeditar(){
	const formData = new FormData($("#formulario")[0]);
    $(".btn-final").prop("disabled",true);
	$.ajax({
		"url": "../controlador/sofi_inscribete.php?op=guardaryeditar",
	    "type":"POST",
	    "data":formData,
	    "contentType":false,
	    "processData":false,
	    success: function(datos){
            datos = JSON.parse(datos);
            if(datos.estatus == 1){
				Swal.fire({ "title": '!Perfecto¡', "text": 'Has realizado la solicitud con éxito', "icon": 'success' });
                window.location.href = "complete.php";   
            }else{
				Swal.fire({ "title": 'Error', "text": datos.info, "icon": 'error' });
			}
		}
	});   
}
// Función para rellenar los datos de ingresos cuando no tienen
function habilitar_otro_ingeso(){
	if (!$("#labora_actualmente").is(":checked")){
		$(".input-ingresos_labora").prop("readonly", true);
		$("#tiempo_servicio").val("No Aplica");
		$("#sector_laboral").val("No Aplica");
        $("#salario").val("0");
	}else{
		$(".input-ingresos_labora").prop("readonly",false);
		$("#sector_laboral").val("");
		$("#tiempo_servicio").val("");
        $("#salario").val("");
	}
}