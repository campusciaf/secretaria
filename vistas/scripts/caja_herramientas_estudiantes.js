function init(){
mostrarElementos();
mostrarcategorias();
// mostrarElementosAdmin();
$("#precarga").show();
}

var formData;
var boolean_data;
var opcion;
var accion;

function mostrarElementos(){
$.ajax({
	url:'../controlador/caja_herramientas_estudiantes.php?op=mostrar',
	success:function(msg){
		datos = JSON.parse(msg)
		$(".contenido_libre").html(datos);
		$("#precarga").hide();
		
	},
	error:function(){
		alert("Hay un error...");
	}
});
};

function LimpiarFormulario(){
	$("#form_sw")[0].reset();
	// $('#tituloModalSoftwareLibre').html('Agregar Software Libre');
	// $("#id_software_libre").val('');
	// $("#file_url").val('');
	// $("#txtNombre").val('');
	// $("#txtSitio").val('');
	// $("#txtUrl").val('');
	// $("#txtDescripcion").val('');
	// $("#txtValor").val('');
	// $("#txtCategoria").val('');
};

// $("#filtro_0").off("click").on("click",function(){
// 	mostrarElementos();
// 	});

// $("#filtro_1").off("click").on("click",function(){
// 	opcion = 1;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_2").off("click").on("click",function(){
// 	opcion = 2;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_3").off("click").on("click",function(){
// 	opcion = 3;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_4").off("click").on("click",function(){
// 	opcion = 4;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_5").off("click").on("click",function(){
// 	opcion = 5;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});
// $("#filtro_6").off("click").on("click",function(){
// 	opcion = 6;
// 	accion = "filtrar";
// 	filtrarSoftware(accion,opcion);
// 	});

	function filtrarSoftware(opcion){
	
		$.post("../controlador/caja_herramientas_estudiantes.php?op=filtrar",{"opcion" : opcion},function(data){
			console.log(data);
			data = JSON.parse(data);
				if(Object.keys(data).length > 0){

					$(".contenido_libre").html(data);
					$(".infoLibro").hide();//se esconde el boton por que nadie puede editarlo y aparace el boton de editar a los usuarios
				$("#mostrar_categorias").val(data);
				
			}
		});
	}

	function mostrarcategorias() {
		$.post("../controlador/caja_herramientas_estudiantes.php?op=mostrarcategorias", {}, function (data) {
		  console.log(data);
		  data = JSON.parse(data);
	  
		  if (Object.keys(data).length > 0) {
			// Insertar los botones en el contenedor
			$("#mostrar_categorias").html(data[0]);
	  
			const contenedor = document.getElementById('mostrar_categorias');
			const botones = Array.from(contenedor.querySelectorAll('.btn-group-toggle'));
	  
			// Crear dropdown para botones que no caben
			const dropdown = document.createElement('div');
			dropdown.className = 'btn-group btn-group-toggle p-1 d-none';
			dropdown.innerHTML = `
			  <label class="btn btn-primary dropdown-toggle text-white" data-toggle="dropdown">
				<input type="radio" name="options" autocomplete="off"> <span class="label-text">0 más</span>
			  </label>
			  <div class="dropdown-menu"></div>
			`;
			contenedor.appendChild(dropdown);
	  
			// Ajustar botones visibles y ocultos
			ajustarBotones(contenedor, botones, dropdown);
	  
			// Activar botón "Todos" al inicio
			$('#mostrar_categorias label.btn').removeClass('active');
			$('#mostrar_categorias label.btn').first().addClass('active');
	  
			// Activar el botón seleccionado cuando se hace clic

			$('#mostrar_categorias').on('click', 'label.btn, .dropdown-item', function () {
				$('#mostrar_categorias label.btn').removeClass('active');
			  
				if ($(this).hasClass('dropdown-item')) {
				  // Si es del dropdown, buscar el botón real y activarlo
				  const texto = $(this).text().trim();
			  
				  $('#mostrar_categorias label.btn').each(function () {
					if ($(this).text().trim() === texto) {
					  $(this).addClass('active');
					}
				  });
			  
				  // Cambiar texto del botón dropdown
				  $('.dropdown-toggle .label-text').text(texto);
				} else {
				  $(this).addClass('active');
			  
				  // Restaurar texto del dropdown si el clic fue en botón visible
				  const dropdownText = $('.dropdown-menu .dropdown-item').length;
				  if (dropdownText > 0) {
					$('.dropdown-toggle .label-text').text(`${dropdownText} más`);
				  }
				}
			  });
			  
  
		  }
		});
	  }
	  

	function ajustarBotones(contenedor, botones, dropdown) {
		let containerWidth = contenedor.offsetWidth;
		let currentWidth = 0;
		let ocultos = [];
	  
		botones.forEach(btn => {
		  btn.classList.remove('d-none');
		  btn.style.display = 'inline-block';
		});
	  
		for (let btn of botones) {
		  currentWidth += btn.offsetWidth + 8;
		  if (currentWidth > containerWidth) {
			btn.classList.add('d-none');
			ocultos.push(btn);
		  }
		}
	  
		if (ocultos.length > 0) {
		  const dropdownMenu = dropdown.querySelector('.dropdown-menu');
		  dropdownMenu.innerHTML = '';
	  
		  ocultos.forEach(btn => {
			const item = document.createElement('a');
			item.className = 'dropdown-item';
			item.textContent = btn.querySelector('span').textContent;
			item.onclick = btn.querySelector('label').onclick;

			dropdownMenu.appendChild(item);
		  });
	  
		  dropdown.classList.remove('d-none');
		  dropdown.querySelector('.label-text').innerText = `${ocultos.length} más`;
		} else {
		  dropdown.classList.add('d-none');
		}
	  }
	  
	  window.addEventListener('resize', () => {
		const contenedor = document.getElementById('mostrar_categorias');
		const botones = Array.from(contenedor.querySelectorAll('.btn-group-toggle')).filter(el => !el.classList.contains('d-none'));
		const dropdown = contenedor.querySelector('.dropdown-toggle')?.closest('.btn-group');
		if (dropdown) ajustarBotones(contenedor, botones, dropdown);
	  });
	  


init();