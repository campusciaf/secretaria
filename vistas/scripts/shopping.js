var myDropzone;
// Deshabilitar la autoinstalación de Dropzone
Dropzone.autoDiscover = false;

// Inicializar Dropzone
$(document).ready(function () {
	init();
	ejecutarDropzone();
	
});
function ejecutarDropzone() {
	myDropzone = $("#my-awesome-dropzone").dropzone({
		// El nombre usado para pasar el archivo
		"paramName": "file",
		//tamaño maxiomo en megas 
		"maxFilesize": 5,
		//mensaje por defecto
		"dictDefaultMessage": "Arrastra los archivos aquí para subirlos",
		// Limita a 1 el número de archivos
		"maxFiles": 1,
		init: function () {
			// Guardar referencia a la instancia de Dropzone
			var self = this; 
			///verificacion de imagenes existentes
			$.post("../controlador/shopping.php?op=ImagenExistente", function (datos) {
				datos = JSON.parse(datos);
				if (datos.exito == 1) {
					// Mostrar un archivo existente
					var mockFile = { "name": datos.info, "size": datos.size, "type": datos.type };
					// URL de la imagen existente
					var callMockFile = '../files/shopping/' + datos.info;
					// Llama a `displayExistingFile` para mostrar la imagen
					self.displayExistingFile(mockFile, callMockFile);
					mostrar();
				}
			});
			this.on("success", function (file, data) {
				data = JSON.parse(data);
				if (data.exito == 0) {
					Swal.fire({ "icon": "error", "html": data.info, "showConfirmButton": false, "timer": 1500, "allowOutsideClick": false });
					// Remover el archivo de Dropzone
					this.removeFile(file);
				} else {
					Swal.fire({ "icon": "success", "html": data.info, "showConfirmButton": false, "timer": 1500, "allowOutsideClick": false });
					mostrar();
				}
			});
			this.on("addedfile", function (file) {
				selfEliminar = this;
				// Crear un botón de eliminación
				var removeButton = Dropzone.createElement('<button class="btn btn-danger delete-btn btn-block btn-flat pointer">Eliminar</button>');
				// Añadir el botón al detalle del archivo
				file.previewElement.appendChild(removeButton);
				// Escuchar el evento de clic en el botón de eliminación
				removeButton.addEventListener("click", function (e) {
					// Prevenir acciones predeterminadas
					e.preventDefault();
					e.stopPropagation();
					//solo cuando el usuario esta registrado pregunta si quiere reenviar las claves
					Swal.fire({
						"text": "¿Deseas eliminar la imagen?",
						"icon": 'warning',
						"showCancelButton": true,
						"confirmButtonColor": '#3085d6',
						"cancelButtonColor": '#d33',
						"confirmButtonText": 'Si, por favor!'
					}).then((result) => {
						if (result.isConfirmed) {
							//envia al controlador la peticion de enviar las credenciales 
							$.post("../controlador/shopping.php?op=EliminarImagen", function (datos) {
								datos = JSON.parse(datos);
								if (datos.exito == 1) {
									selfEliminar.destroy();
									$("#my-awesome-dropzone").html("");
									Swal.fire({ position: 'top-end', icon: 'success', title: datos.info, showConfirmButton: false, timer: 1500 });
									mostrar();
									ejecutarDropzone();
								} else {
									Swal.fire({ position: 'top-end', icon: 'error', title: datos.info, showConfirmButton: false, timer: 1500 })
								}
							});
						};
					});
				}.bind(this));
			});
			this.on("maxfilesexceeded", function (file) {
				// Si se intenta subir más de un archivo, se elimina el excedente automáticamente
				this.removeAllFiles();
				this.addFile(file);
			});
		}
	});
}
function init() {
	$(".precarga").show();
	$(".precarga").hide();
	$("#proceso").hide();
	verificar();
}
function verificar() {
	$.post("../controlador/shopping.php?op=verificar", function (datos) {
		data = JSON.parse(datos);// convertir el mensaje a json
		if (data == 1) {
			mostrar();
			$("#proceso").show();
			$("#btn-iniciar").hide();
			$(".precarga").hide();
		} else {
			$("#proceso").hide();
			$("#btn-iniciar").show();
			$(".precarga").hide();
		}
	});
}
function mostrar() {
	$.post("../controlador/shopping.php?op=mostrar", {}, function (data, status) {
		data = JSON.parse(data);
		$("#shopping_nombre").val(data.shopping_nombre);
		$("#shopping_descripcion").val(data.shopping_descripcion);
		$(".shopping_nombre").html(data.shopping_nombre);
		$(".shopping_descripcion").html(data.shopping_descripcion);
		$("#shopping_facebook").val(data.shopping_facebook);
		$("#shopping_instagram").val(data.shopping_instagram);
		if (data.shopping_facebook === null || data.shopping_facebook == "") {
			$(".shopping_facebook").html("");
		} else {
			$(".shopping_facebook").html('<a href="https://web.facebook.com/' + data.shopping_facebook + '" target="_blank" class="m-2"><i class="fa-brands fa-facebook text-white fa-2x"></i></a>');
		}
		if(data.shopping_instagram === null || data.shopping_instagram == "") {
			$(".shopping_instagram").html("");
		} else {
			$(".shopping_instagram").html('<a href="https://www.instagram.com/' + data.shopping_instagram + '" target="_blank" class="m-2"><i class="fa-brands fa-instagram text-white fa-2x"></i></a>');
		}
		if (data.shopping_participar == "3") {
			$("#shopping_participar").html('<span class="badge bg-success rounded  fs-12"><i class="fa-regular fa-circle-check"></i>Active</span>');
		} else if (data.shopping_participar == "2") {
			$("#shopping_participar").html('<span class="badge bg-warning rounded  fs-12"><i class="fa-regular fa-circle-check"></i>en proceso</span>');
		} else {
			$("#shopping_participar").html('');
		}
		if (data.shopping_img === null || data.shopping_img == "") {
			$(".shopping_img").html('<figure class="avatar-ico rounded" style="background-image: url(../public/img/ico-feria.webp);"><img src="../public/img/ico-feria.webp" alt="" style="display: none;"></figure>');
		} else {
			$(".shopping_img").html('<figure class="avatar-ico rounded" style="background-image: url(../files/shopping/' + data.shopping_img + ');"><img src="../files/shopping/' + data.shopping_img + '" alt="" style="display: none;"></figure>');
		}

		if (data.shopping_participar == "2" || data.shopping_participar == "3") {
			$("#btn2_participar").hide();
			$("#formulario_emprendimiento").hide();
		} else {
			$("#btn2_participar").show();
			$("#formulario_emprendimiento").show();
		}
		if(data.shopping_autorizo==1){
			$("#publicarCIAF").html('<button class="btn btn-outline-light btn-xs" onclick="autorizo()"><i class="fa-solid fa-plus"></i> Autorizo </button>');
		}else{
			$("#publicarCIAF").html('<button class="btn btn-outline-success btn-xs"><i class="fa-solid fa-plus"></i> Autorizado </button>');
		}
	});
}
function participar() {
	$.post("../controlador/shopping.php?op=participar", function (datos) {
		data = JSON.parse(datos);// convertir el mensaje a json
		if (data == 1) {
			let timerInterval;
			Swal.fire({
				"title": "Creando un espacio",
				"html": "Personalizando <b></b> espacios.",
				"timer": 2000,
				"timerProgressBar": true,
				didOpen: () => {
					Swal.showLoading();
					const timer = Swal.getPopup().querySelector("b");
					timerInterval = setInterval(() => {
						timer.textContent = `${Swal.getTimerLeft()}`;
					}, 100);
				},
				willClose: () => {
					clearInterval(timerInterval);
					$("#proceso").show();
					$("#btn-iniciar").hide();
				}
			}).then((result) => {
				/* Read more about handling dismissals below */
				if (result.dismiss === Swal.DismissReason.timer) {
					console.log("I was closed by the timer");
				}
			});
		} else {
			Swal.fire({
				"position": "top-end",
				"icon": "warning",
				"title": "Your work has been saved",
				"showConfirmButton": false,
				"timer": 1500
			});
		}
	});
}
function listar() {
	$.post("../controlador/pagogeneral.php?op=listar", function (datos) {
		$(".precarga").hide();
	});
}
function iniciarTour() {
	introJs().setOptions({
		"nextLabel": 'Siguiente',
		"prevLabel": 'Anterior',
		"doneLabel": 'Terminar',
		"showBullets": false,
		"showProgress": true,
		"showStepNumbers": true,
		"steps": [
			{
				"title": 'Horarios',
				"intro": 'Módulo para consultar los horarios por salones creados en el periodo actual.'
			},
			{
				"title": 'Docente',
				"element": document.querySelector('#t-programa'),
				"intro": "Campo de opciones que contiene los nombres de los salones activos en plataforma para consultar."
			},
		]
	},
	).start();
}
function editar(campo) {
	if (campo == "1") {
		valor1 = $("#shopping_nombre").val();
		valor2 = $("#shopping_descripcion").val();
	}
	$("#animacion1").removeClass('wobble-hor-bottom');
	$.post("../controlador/shopping.php?op=editar", { campo: campo, valor1: valor1, valor2: valor2 }, function (datos, status) {
		data = JSON.parse(datos);// convertir el mensaje a json
		if (data == "0") {
			mostrar();
			Swal.fire({
				"position": "top-end",
				"icon": "success",
				"title": "Datos actualizados",
				"showConfirmButton": false,
				"timer": 1500
			});
			$("#animacion1").addClass('wobble-hor-bottom');			
		} else {
			Swal.fire({
				position: "top-end",
				icon: "warning",
				title: "Your work has been saved",
				showConfirmButton: false,
				timer: 1500
			});
		}

	});
}
function redes(campo) {
	valor = (campo == "1") ? $("#shopping_facebook").val() : $("#shopping_instagram").val();

	$("#animacion_facebook").removeClass('wobble-hor-bottom');
	$("#animacion_instagram").removeClass('wobble-hor-bottom');

	$.post("../controlador/shopping.php?op=editarredes", { campo: campo, valor: valor }, function (datos, status) {
		data = JSON.parse(datos);// convertir el mensaje a json
		if (data == "0") {
			mostrar();
			if(campo == "1"){
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": "Facebook agregado",
					"showConfirmButton": false,
					"timer": 1500
				});
				$("#animacion_facebook").addClass('wobble-hor-bottom');
			}else{
				Swal.fire({
					"position": "top-end",
					"icon": "success",
					"title": "Instagram agregada",
					"showConfirmButton": false,
					"timer": 1500
				});
				$("#animacion_instagram").addClass('wobble-hor-bottom');
			}
			
			
		} else {
			Swal.fire({
				"position": "top-end",
				"icon": "warning",
				"title": "Your work has been saved",
				"showConfirmButton": false,
				"timer": 1500
			});
		}
	});
}
function enviar() {
	Swal.fire({
		"title": "Estas segur@?",
		"text": "¡No podrás revertir esto!",
		"icon": "success",
		"showCancelButton": true,
		"confirmButtonColor": "#3085d6",
		"cancelButtonColor": "#d33",
		"confirmButtonText": "Si, enviar!",
		"cancelButtonText": "No enviar"
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/shopping.php?op=enviar", {}, function (datos, status) {
				// convertir el mensaje a json
				data = JSON.parse(datos);
				console.log(data);
				if (data == "1") {
					$("#btn2_participar").hide();
					mostrar();
					Swal.fire({
						"title": "Enviado!",
						"text": " ¡Es hora de destacar tu emprendimiento y que toda la comunidad lo descubra y disfrute de tus increíbles servicios!",
						"icon": "success"
					});
				} else {
					Swal.fire({
						"position": "top-end",
						"icon": "warning",
						"title": "Error al emnviar",
						"showConfirmButton": false,
						"timer": 1500
					});
				}
			});
		}
	});
}
function autorizo() {
	Swal.fire({

		"title": "Estas segur@?",
		"text": "¡Al dar si publicar, aceptas publicar tus emprendimientos en las redes sociales de CIAF!",
		"icon": "success",
		"showCancelButton": true,
		"confirmButtonColor": "#28a745",
		"cancelButtonColor": "#d33",
		"confirmButtonText": "Si, publicar!",
		"cancelButtonText": "No enviar"
	}).then((result) => {
		if (result.isConfirmed) {
			$.post("../controlador/shopping.php?op=autorizo", {}, function (datos, status) {
				// convertir el mensaje a json
				data = JSON.parse(datos);
				console.log(data);
				if (data == "1") {
					mostrar();
					Swal.fire({
						"title": "Enviado!",
						"text": " ¡Es hora de destacar tu emprendimiento y que toda la comunidad lo descubra y disfrute de tus increíbles servicios!",
						"icon": "success"
					});
				} else {
					Swal.fire({
						"position": "top-end",
						"icon": "warning",
						"title": "Error al emnviar",
						"showConfirmButton": false,
						"timer": 1500
					});
				}
			});
		}
	});
}