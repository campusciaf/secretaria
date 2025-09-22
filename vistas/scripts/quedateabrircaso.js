$(document).ready(inicio);

function inicio(){
    $("#buscar_estudiante").off("submit").on("submit", function(e){
        e.preventDefault();
        buscar_estudiante();
    });
    
    $("#formabrircaso").off("submit").on("submit", function(e){
        e.preventDefault();
        Abrircaso();
    });
    
    listarCategorias();
    $("#precarga").hide();
    $("#btnabrircaso").prop('disabled', true);


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
				title: 'Quédate',
				intro: 'Bienvenido a nuestro módulo quédate donde para nosotros es muy importante la permanencia de nuestros seres originales, por eso les brindamos todo nuestro apoyo como una verdadera familia uniendo nuestros lazos a través de la comprensión'
			},
			{
				title: 'Busquedad',
				element: document.querySelector('#t-B'),
				intro: "Aquí podrás ingresar el número de identificación de el ser original que requiere nuestro apoyo"
			},
            {
				title: 'Nombre completo',
				element: document.querySelector('#t-NC'),
				intro: "Aquí podrás visualizar el nombre de nuestro ser original"
			},
            {
				title: 'Correo electrónico',
				element: document.querySelector('#t-C'),
				intro: "Aquí podrás encontrar su correo electrónico institucional donde podrás tener contacto con nuestro ser original"
			},
            {
				title: 'Número de celular',
				element: document.querySelector('#t-NT'),
				intro: "Da un vistazo a su número telefónico para mantener un contacto más directo"
			},
            {
				title: 'Cedula de ciudadanía',
				element: document.querySelector('#t-CD'),
				intro: "Aquí podrás visualizar el documento de nuestro ser original consultado por ti anteriormente"
			},
            {
				title: 'Dirección',
				element: document.querySelector('#t-D'),
				intro: "Visualiza el lugar de residencia de nuestro ser original"
			},
            {
				title: 'Casos',
				element: document.querySelector('#t-caso'),
				intro: "En este campo podrás verificar si nuestro ser original ya ha tenido algún caso quédate o de lo contrario seria su primer caso"
			},
            {
				title: 'Abrir caso',
				element: document.querySelector('#t-Acaso'),
				intro: "Con un click puedes abrir un nuevo caso a nuestro ser original especificando el asunto, la fecha de el caso y la categoría en la que nuestro ser original presenta inconveniente"
			},
            {
				title: 'Estado',
				element: document.querySelector('#t-E'),
				intro: "Aquí podrás ver si es un caso que permanece activo o por lo tanto ya se dio una solución y dieron por terminado seria un caso cerrado"
			},
            {
				title: 'Categoria',
				element: document.querySelector('#t-CA'),
				intro: "En este campo podrás evidenciar la categoría previamente elegida de acuerdo a la necesidad de nuestro ser original"
			},
            {
				title: 'Asunto',
				element: document.querySelector('#t-AS'),
				intro: "Aquí podrás encontrar una explicación corta de lo sucedido y el por que nuestro ser original requiere de nuestro apoyo"
			},
            {
				title: 'Fecha',
				element: document.querySelector('#t-FE'),
				intro: "visualiza la fecha en la que se creo este caso y decidimos brindarle nuestro apoyo incondcional "
			},
            {
				title: 'Fecha cerrado',
				element: document.querySelector('#t-FC'),
				intro: "visualiza la fecha en la que se dio por terminado,culminando asi con el apoyo especial que nuestra institución le ha brindado a ese ser original"
			},
            {
				title: 'Departamento de origen',
				element: document.querySelector('#t-DO'),
				intro: "Aquí podrás encontrar el área encargada de reportar este caso en nuestro módulo"
			},
            {
				title: 'Ver',
				element: document.querySelector('#t-V'),
				intro: "Visualiza más a fondo cada caso y descubre las diferentes soluciones y seguimiento que le hemos brindado a cada caso"
			},

		]
			
	},
	console.log()
	
    ).start();

}

//Guardar Caso
function Abrircaso(){
    var formData = new FormData($("#formabrircaso")[0]);
	$.ajax({
		url: "../controlador/quedateabrircaso.php?op=guardarcaso",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos){
			console.log(datos);
            datos = JSON.parse(datos);
            if(datos.exito == '0'){
                alertify.error(datos.info);
            }else{
                alertify.success(datos.info);
                $("#formabrircaso")[0].reset();
                $('#modal-nuevo-caso').modal("hide");
                buscar_casos();
            }
		}
	});
}

//mostrar datos personales del estudiante
function buscar_estudiante(){
    $.post("../controlador/quedateabrircaso.php?op=buscar_estudiante",{dato_busqueda: $("#input_estudiante").val()},function (datos) {//enlace al controlador para traer los datos del estudiante
        //console.table(datos);
        datos = JSON.parse(datos);
        if(datos.exito == '0'){
            alertify.error(datos.info);
            limpiar();
        }else{
            buscar_casos();
            $(".nombre_estudiante").text(datos.info.nombre_estudiante);
            $(".apellido_estudiante").text(datos.info.apellido_estudiante);
            $(".tipo_identificacion").text(datos.info.tipo_identificacion);
            $(".numero_documento").text(datos.info.numero_documento);
            $(".direccion").text(datos.info.direccion);
            $(".celular").text(datos.info.celular);
            $(".correo").text(datos.info.email);
            $(".img_estudiante").prop("src", datos.info.foto);
            $(".lista_programas").html(datos.programas);
            $("#btnabrircaso").parent().removeClass("hide");
            $("#cedula-estudiante").html(datos.info.numero_documento);
            $("#id-estudiante-nuevo-caso").val(datos.info.id_credencial);
            $("#btnabrircaso").prop('disabled', false);
        }
    });
}

//Listar categorias de casos
function listarCategorias(){
    $.post("../controlador/quedateabrircaso.php?op=listarCategorias",function (datos) {
        datos = JSON.parse(datos);
        if(datos.exito == '0'){
            alertify.error(datos.info);
            limpiar();
        }else{
            html = '<option disabled selected value="">-- Selecciona una opción --</option>';
            i = 0;
            while(i < datos.info.length){
                html += '<option value="'+datos.info[i] +'">'+datos.info[i]+'</option>';
                i++;
            }
            $("#categoria-caso").html(html);    
        }
    });
}

//listar en un datatable los casos
function buscar_casos(){
    $('#tabla_casos').dataTable({
		lengthChange: false,	
		"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": '<Bl<f>rtip>',//Definimos los elementos del control de tabla
		"columnDefs": [
			{ "width": "10%", "targets": 0 }],
        buttons: [{
           extend:    'copyHtml5',
           text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
           titleAttr: 'Copy'
       },
       {
           extend:    'excelHtml5',
           text:      '<i class="fa fa-file-excel" style="color: green"></i>',
           titleAttr: 'Excel'
       },
       {
           extend:    'csvHtml5',
           text:      '<i class="fa fa-file-alt"></i>',
           titleAttr: 'CSV'
       },
       {
           extend:    'pdfHtml5',
           text:      '<i class="fa fa-file-pdf" style="color: red"></i>',
           titleAttr: 'PDF',

       }],
		"ajax":{
			url: '../controlador/quedateabrircaso.php?op=buscar_casos',
			type : "post",
            data: {dato_busqueda: $("#input_estudiante").val()} ,
			dataType : "json",						
			error: function(e){
                console.log(e.responseText);	
			}
		},
		"bDestroy": true,
		"iDisplayLength": 12,//Paginación	
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat float-margin');
	$('.dt-button').removeClass('dt-button');
}

//esconder datos de los estudiantes
$('#datos_estudiante').on('hidden.bs.collapse', function () { 
    $(".col-datos_e").removeClass("col-md-3");
    $(".col-datos_e").addClass("col-md-12");
    $(".tabla_busquedas").removeClass("col-md-9 col-lg-9");
    $(".tabla_busquedas").addClass("col-md-12 col-lg-12");
    $(".plusandminus").html('<i class="fas fa-plus"></i>');
});

//mostrar datos de los estudiantes
$('#datos_estudiante').on('shown.bs.collapse', function () {
    $(".col-datos_e").addClass("col-md-12");
    $(".col-datos_e").removeClass("col-md-12");
    $(".tabla_busquedas").addClass("col-md-12 col-lg-12");
    $(".tabla_busquedas").removeClass("col-md-12 col-lg-12");
    $(".plusandminus").html('<i class="fas fa-minus"></i>');
});

//Limpiar campos donde aparece info del estudiante
function limpiar(){
    $(".nombre_estudiante").text("----------------");
    $(".apellido_estudiante").text("----------------");
    $(".tipo_identificacion").text("---------------");
    $(".numero_documento").text("----------------");
    $(".direccion").text("----------------");
    $(".celular").text("---------------- ");
    $(".correo").text("--------------");
    $("#btnabrircaso").parent().addClass("hide");
    $(".img_estudiante").prop("src", '../files/null.jpg');
    $("#cedula-estudiante").html("");
    $("#id-estudiante-nuevo-caso").val("");
    $(".lista_programas").html('<li class="list-group-item"><b>Programa:</b> <br> <a class=" box-profiledates profile-programa">----------------</a></li><li class="list-group-item"><b>Semestre:</b> <a class="pull-right box-profiledates profile-semestre">----------------</a></li>');
    
}