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
}

//Guardar Caso
function Abrircaso(){
    var formData = new FormData($("#formabrircaso")[0]);
	$.ajax({
		url: "../controlador/abrircaso.php?op=guardarcaso",
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
                $('#datos_estudiante').modal("hide");
                buscar_casos();
            }
		}
	});
}

//mostrar datos personales del estudiante
function buscar_estudiante(){
    $.post("../controlador/abrircaso.php?op=buscar_estudiante",{dato_busqueda: $("#input_estudiante").val()},function (datos) {//enlace al controlador para traer los datos del estudiante
        /*console.table(datos);*/
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
        }
    });
}

//Listar categorias de casos
function listarCategorias(){
    $.post("../controlador/abrircaso.php?op=listarCategorias",function (datos) {
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
			url: '../controlador/abrircaso.php?op=buscar_casos',
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