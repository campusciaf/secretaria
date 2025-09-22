function init(){
	$("#precarga").hide();
	$("#generador_certificados").hide();
	$("#listadoregistros").hide();
}

/* Función para limpiar los campos al momento de realizar una nueva búsqueda */
function limpiarInfo(){
	$("#user-photograph").attr("src","../files/null.jpg");
	$("#nombre_completo_estudiante").html("");
	$("#correo_estudiante").html("");

	$("#info_jornada_matriculado").html("");
	$("#id_credencial").val('');
	$("#id_estudiante").val('');
	$("#consulta").val('a');
	$("#contenido_vista_previa").html("");
	$("#calificaciones_actual").attr("hidden",true);
	$("#generador_certificados").hide();
	$("#selector_semestre").empty();
}
/* Código para buscar en la base de datos al estudiante y 
cargar la informaciòn del perfil al cual se le generará el certificado */
$("#buscar_estudiante").off("click").on("click",function(e){
	limpiarInfo();
	var cedula = $("#input_cedula").val();
	/* Condicional para verificar que si se haya ingresado un número de documento válido */
	if (cedula == "") {
		
		alertify.error("Digite por favor un documento a buscar");
	}else{
		/* Ajax para validar en tiempo real el documento del estudiante y revisar que si esté en la base de datos */
		$.ajax({
		type:'POST',
		url:'../controlador/certificadosporsemestre.php?op=verificar',
		data:{cedula:cedula},
		success:function(msg){
			if (msg==1) {
				
				alertify.error("Documento no existe en la base de datos.");
			}else{
				datos = JSON.parse(msg);
				var id_credencial = datos[0]['id_credencial'];
				listar(id_credencial);
				datos = JSON.parse(msg);
				$("#id_credencial").val(datos[0]['id_credencial']);
				nombre_completo = datos[0]['credencial_nombre'] + " " + datos[0]['credencial_nombre_2'] ;
				apellido_completo = datos[0]['credencial_apellido'] + " " + datos[0]['credencial_apellido_2'];
				
				$("#nombre_completo_estudiante").html(nombre_completo);
				$("#apellido_completo_estudiante").html(apellido_completo);

				$("#correo_estudiante").html(datos[0]['credencial_login']);
				var ruta = "../files/estudiantes/"+datos[0]['credencial_identificacion']+".jpg";
				revisarFichero(ruta);
				// cargarInformacion();
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
	}
});

/* Función para generar el certificado y tener una vista previa */
$("#ver_certificado").on("submit",function(e1){
	e1.preventDefault();
	var semestre_seleccionado = $("#selector_semestre").val();
	var id_estudiante = $("#id_estudiante").val();
	var id_credencial = $("#id_credencial").val();
	var fechahoy = new Date();
	var fechahoyesp = getDatennow(1,fechahoy);
	/* Si el certificado es Calificaciones Semestre Actual */
	limpiarModalCertificados();
	$.ajax({
		type:'POST',
		url:'../controlador/certificadosporsemestre.php?op=cargarDatosEstudiante',
		data:{id_estudiante:id_estudiante,id_credencial:id_credencial},
		success:function(msg){
			/* Se trae el arreglo con los datos consultados */
			datos = JSON.parse(msg);
			romano = convertirSemestreRomano(1,semestre_seleccionado);
			/* Habilitar el modal, el encabezado de los certificados y 
			el texto predeterminado de las calificaciones del semestre actual */
			$("#vistaprevia_modal").modal({backdrop: 'static', keyboard: false});
			$('#encabezado_certificados').removeAttr("hidden");
			$("#calificaciones").removeAttr("hidden");
			$("#pie_certificado").removeAttr("hidden");
			$("#fecha_certificado").html(fechahoyesp);
			/* Para rellenar los datos del párrafo del certificado */
			$("#calificaciones_nombre_estudiante").html(datos[0][0]);
			$("#calificaciones_tipo_doc").html(datos[0][1]);
			$("#calificaciones_identificacion").html(datos[0][2]);
			$("#calificaciones_expedido_en").html(datos[0][3]);
			$("#calificaciones_romano").html(romano);
			$("#calificaciones_programa").html(datos[0][5]+datos[0][10]);
			/* Se asignan las variables que requiere la función 
			que carga las calificaciones en el certificado*/
			var ciclo = datos[0][6];
			cargarSemestre(id_estudiante,ciclo,semestre_seleccionado);
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
});

/* Botón para activar la función de impresión de los certificados */
$("#boton_imprimir").off("click").on("click",function(){
	alertify.confirm('Imprimir Certificado', 
		'¿Está seguro que quiere imprimir este certificado?', 
		function(){
			var id_contenedor_imprimir = "cuerpo_vista_previa";
			imprimirCertificado(id_contenedor_imprimir);
		}, function(){ 
			alertify.error('Operación Cancelada');
		});
});

/* Función para imprimir los certificados */
 function imprimirCertificado(nombre) {
 	var ficha = document.getElementById(nombre);
 	var ventimp = window.open(' ', 'popimpr');
 	ventimp.document.write(ficha.innerHTML);
 	ventimp.document.close();
 	ventimp.print( );
 	ventimp.close();
 }

/* Función para listar los programas en los que se encuentra matriculado el estudiante */ 
function listar(id_credencial){
	$("#listadoregistros").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor

	    dom: 'Bfrtip',
				buttons: [

					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},

					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'Programas Académicos',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/certificadosporsemestre.php?op=listar&id_credencial='+id_credencial,
					type : "get",
					dataType : "json",						
					error: function(e){
							
					}
				},
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 2, "asc" ]],//Ordenar (columna,orden)

	}).DataTable();
	// mostrardatos(id_credencial);

}



/* Función para mostrar la opción de impresión y ocultar la tabla */
function mostrar(id_credencial,id_estudiante){
	$("#id_credencial").val(id_credencial);
	$("#id_estudiante").val(id_estudiante);
	$("#listadoregistros").hide();
	$("#generador_certificados").show();
	generarSelectInput(id_estudiante);

	// for (var cant = 0; cant < cantidad_semestres; cant++) {
	// 	var form = innerHTML()
	// }
	
}

/* Función para determinar cuántas opciones saldrán en el formulario */
function generarSelectInput(id_estudiante){
	/* Ajax para validar en tiempo real cuántos semestres ha cursado el estudiante */
	$.ajax({
		type:'POST',
		url:'../controlador/certificadosporsemestre.php?op=cargarOpciones',
		data:{id_estudiante:id_estudiante},
		success:function(msg){
			var datos = JSON.parse(msg);
			var option = '';
			for (i = 1; i <= datos['semestre_estudiante']; i++) {
				option = '<option value="'+i+'"> Semestre '+i+'</option>'
				$("#selector_semestre").append(option);
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
}

/* Función para cargar los datos del programa del estudiante */
function cargarInformacion(){
	var id_credencial = $("#id_credencial").val();
	$.ajax({
		type:'POST',
		url:'../controlador/certificadosporsemestre.php?op=cargar',
		data:{id_credencial:id_credencial},
		success:function(msg){
			datos = JSON.parse(msg);
			/* Bucle para validar si el estudiante está matriculado en más de un programa
			para imprimirlo en la vista */ 
			for (var contador = 0; contador < datos.length; contador++) {
				$("#info_programa_matriculado").append(datos[contador]['fo_programa']+"<br>");
				$("#info_jornada_matriculado").append(datos[contador]['jornada_e']+"<br>");
				$("#id_estudiante").val(datos[contador]['id_estudiante']);
			}
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
}

/* Código para validar que el usuario tenga foto en la base de datos */
function revisarFichero(data){
	$.ajax({ 
	url:data,
	type:'HEAD', 
	error: function() 
	{ 
		alertify.success("Por favor agregar Fotografía"); 
	}, 
	success: function() 
	{ 
		$("#user-photograph").attr("src",data);
	} 
});

}

/* Función para cargar la información del certificado de calificaciones del semestre actual */
function cargarSemestre(id_estudiante,ciclo,semestre_seleccionado){
	$.ajax({
		type:'POST',
		url:'../controlador/certificadosporsemestre.php?op=cargarSemestre',
		data:{id_estudiante:id_estudiante,ciclo:ciclo,semestre_seleccionado:semestre_seleccionado},
		success:function(msg){
			$("#contenido_vista_previa").html(msg);
		},
		error:function(){
			alertify.error("Hay un error...");
		}
	});
}

/* Función para imprimir la fecha en el pie de página del certificado */
function cargarFechaPie(flag,date){
	if (flag==1) {
		$.ajax({
			type:'POST',
			url:'../controlador/certificadosporsemestre.php?op=fecha_pie',
			data:{date:date},
			success:function(msg){
				console.log(msg);
				$('#pie_certificado').append(msg);
			},
			error:function(){
				alertiify.error("Hay un error");
			}
		});
	}
}

/* Función para convertir el número de semestre en número romano */
function convertirSemestreRomano(flag,semestre){
	if (flag) {
		var romano;
		if (semestre == 1) {
			romano = "I";
		} else if (semestre == 2) {
			romano = "II";
		} else if (semestre == 3) {
			romano = "III";
		} else if (semestre == 4) {
			romano = "IV";
		} else if (semestre == 5) {
			romano = "V";
		} else if (semestre == 6) {
			romano = "VI";
		} else if (semestre == 7) {
			romano = "VII";
		} else if (semestre == 8) {
			romano = "VIII";
		} else if (semestre == 9) {
			romano = "IX";
		} else if (semestre == 10) {
			romano = "X";
		}
	}

	return romano;
}

/* Función para pasar la fecha a formato español */
function getDatennow(flag, fecha){
    var today = new Date(fecha);
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var mi = today.getMinutes();
    var ss = today.getSeconds();
    if (dd < 10) {
	     dd = '0' + dd;
	    } 
	    if (mm < 10) {
	     mm = '0' + mm;
	    }
	    if (mi < 10) {
	     mi = '0' + mi;
	    } 
	    if (hh < 10) {
	     hh = '0' + hh;
	    } 
	    if (ss < 10) {
	     ss = '0' + ss;
	    }
    
    if(flag){
    var days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
    const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
         "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
         var date = days[today.getDay()]+' ('+ dd +') de ' + monthNames[today.getMonth()]+' de ('+ yyyy+')';
    //today = dd + '/' + mm + '/' + yyyy+ " Hora:  " + hh + ":" + mi + ":" + ss;
    return date;
    }else{
        date = yyyy + '-' + mm + '-'+dd ;
        return date;
    }   
}

function limpiarModalCertificados(){
	$("#contenido_vista_previa").html("");
	$("#calificaciones_actual").attr("hidden",true);
	$("#pie_certificado").attr("hidden",true);
}

function volver(){

	$("#generador_certificados").hide();
	$("#listadoregistros").show();
}

init();