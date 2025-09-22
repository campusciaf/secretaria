//JavaScript Document
$(document).ready(init);

//inicializacion de variables 
var tabla, tabla_cuotas;

//primera funcion que se ejecut cuando el documento esta listo 
function init(){
    //esconde la tabla de informacion 
    $(".tabla_info").hide();
    //esconde la precarga0
    $("#precarga").hide();
    //esconde los formularios de tareas y seguimientos
    $("#forms_tareas_segs").hide();
    //guardar tarea
    $("#formularioTareas").on("submit", function(e){
        e.preventDefault();
        //envia a la funcion que guarda la info
        guardarTarea();
    });
    //guardar segumiento
    $("#formularioSeguimientos").on("submit", function(e){
        e.preventDefault();
        //envia a la funcion que guarda la info
        guardarSeguimientos();
    });
    //guardar categoria
    $("#formularioCategorizar").on("submit", function(e){
        e.preventDefault();
        //envia a la funcion que guarda la info
        categoria_credito();
    });
    //Insertar nueva cuota
    $("#formularioCrearCuota").on("submit", function(e){
        e.preventDefault();
        //envia a la funcion que guarda la info
        guardarCuota();
    });
    //busca un consulta especifica
    $("#busqueda_cuota").on("submit", function(e){
        e.preventDefault();
        if($("#tipo_busqueda").val() == 2){
            tabla  = "tabla_cuotas";
        }else{
            tabla = "tabla_info";
        }
        var tipo_busqueda = $("#tipo_busqueda").val();
        var dato_busqueda = $("#dato_busqueda").val();
        //envia a la funcion que lista la info
        listar_cuotas(tipo_busqueda, dato_busqueda, tabla);
    });
    //cambiar al formuilario
    $(".agregarSegumiento").off("click").on("click", function(){
        $("#forms_tareas_segs").show();
        $("#tablas_tareas_segs").hide();
    });
    //cambiar a las tablas
    $(".mostrarSeguimientos").off("click").on("click", function(){
        $("#forms_tareas_segs").hide();
        $("#tablas_tareas_segs").show();
    });
    //cuando cambie el tipo de busqueda que tambien lo haga la tabla
    $("#tipo_busqueda").on("change", function(){
        mostrar_tabla($("#tipo_busqueda").val());
    });
}

//selecciona una de las dos tablas a mostrar dependiendo del tipo de busqueda
function mostrar_tabla(valor){
    if( valor == 2){
        $(".tabla_cuotas").show();
        $(".tabla_info").hide();
    }else{
        $(".tabla_info").show();
        $(".tabla_cuotas").hide();
        limpiarInfoSolicitante();
    }
}

//listar cuotas
function listar_cuotas(tipo_busqueda, dato_busqueda, tabla){
    $(".btnBuscarCuota").prop("disabled",true);
    tabla_cuotas = $('#'+tabla).dataTable({
        "aProcessing": true,
		"aServerSide": true,
		"autoWidth": false,
		"dom": '',
		"ajax": {
			"url" : "../controlador/sofi_modificar_credito.php?op=listarCuotas",
			"type" : "POST",
            "data" : { "tipo_busqueda": tipo_busqueda, "dato_busqueda": dato_busqueda },
			"error" : function(e){ console.log(e.responseText) }
		},
        "bDestroy": true,
		"iDisplayLength": 30,
        "ordering": false
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
    $(".btnBuscarCuota").prop("disabled", false);
    if(tipo_busqueda == 2){
        verInfoSolicitante(dato_busqueda);
        saldo_debito(dato_busqueda);
    }
    mostrar_tabla(tipo_busqueda);
}

//funcion para limpiar informacion del aprobado
function limpiarInfoSolicitante(){
    $(".imagen_estudiante").attr("src", "../files/null.jpg");
    $(".profile-tipocc").html("---------------");
    $(".profile-documento").html("---------------");
    $(".nombre_completo").html("Nombre Financiado");
    $(".apellido_completo").html("---------------");
    $(".profile-direccion").html("---------------");
    $(".profile-celular").html("---------------");
    $(".profile-email").html("---------------");
    $(".info-periodo").html("---------------");
    $(".estado_financiacion").html("---------------");
    $(".estado_ciafi").html("---------------");
    $(".en_cobro").html("---------------");
    $(".seguimientos_btn").html("---------------");
    $(".categorizar_btn").html("---------------");
    $(".saldo_debito").html("---------------");
}

//funcion para ver informacion del aprobado
function verInfoSolicitante(consecutivo){
    //muestra datos personales
    $.post("../controlador/sofi_modificar_credito.php?op=verInfoSolicitante",{consecutivo : consecutivo}, function(data){
		//console.log(data);
        data = JSON.parse(data);
        if(data.exito == 1){
            var image = $('<img src="../files/estudiantes/'+data.numero_documento+'.jpg" />');
            if (image.attr('width') > 0){
              $(".imagen_estudiante").attr("src", "../files/estudiantes/"+data.numero_documento+".jpg");
            }else{
              $(".imagen_estudiante").attr("src", "../files/null.jpg");
            }
            $(".profile-tipocc").html(data.tipo_documento);
            $(".profile-documento").html(data.numero_documento);
            $(".nombre_completo").html(data.nombres);
            $(".apellido_completo").html(data.apellidos);
            $(".profile-direccion").html(data.direccion);
            $(".profile-celular").html(data.celular+" - "+data.telefono);
            $(".profile-email").html(data.email);
            $(".info-periodo").html(data.periodo);
            $(".estado_financiacion").html(data.estado_financiacion);
            $(".estado_ciafi").html(data.estado_ciafi);
            $(".en_cobro").html(data.en_cobro);
            $(".seguimientos_btn").html(data.seguimiento);
            $(".categorizar_btn").html(data.categorizar);
            $(".historial_pagos").html(data.historial_pagos);

            $(".profile-consecutivo").html("# "+data.id);
            $(".profile-programa").html(data.programa);
            $(".profile-jornada").html(data.jornada);
            $(".profile-semestre").html(data.semestre);
            $(".profile-valor_financiado").html(data.valor_financiacion);
            $(".profile-forma_pago").html(data.dia_pago);
            $(".profile-cantidad_tiempo").html(data.cantidad_tiempo + " Meses");
        }
	});
}

//funcion para ver el saldo debito
function saldo_debito(consecutivo){
    //muestra datos personales
    $.post("../controlador/sofi_modificar_credito.php?op=saldoDebito",{consecutivo : consecutivo}, function(data){
		//console.log(data);
        data = JSON.parse(data);
        if(data.exito == 1){
            $(".saldo_debito").html(data.saldo_debito);
        }
	});
}

//listar historial de pagos
function historial_pagos(consecutivo){
    $('#tabla_historial').dataTable({
        "aProcessing": true,
		"aServerSide": true,
		"autoWidth": false,
		"dom": 'rtip',
		"ajax": {
			"url" : "../controlador/sofi_modificar_credito.php?op=historialPagos",
			"type" : "POST",
            "data" : { "consecutivo": consecutivo },
			"error" : function(e){ console.log(e.responseText) }
		},
        "bDestroy": true,
		"iDisplayLength": 12,
        "ordering": false
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}

//cambia en estado de la financiacion
function cambiar_estado_financiacion(estado_financiacion, consecutivo, id_persona){
    alertify.confirm('Confirmar', '¿ Estas segur@ de cambiar el estado de financiación ?', function(){ 
        $.post("../controlador/sofi_modificar_credito.php?op=cambiarEstadoFinanciacion", { estado_financiacion: estado_financiacion, id_persona: id_persona}, function(data){
            data = JSON.parse(data);
            if(data.exito == 1){
                alertify.success('Cambio de estado correcto');
                verInfoSolicitante(consecutivo);
                tabla_cuotas.ajax.reload();
            }else{
                alertify.error('Error en el cambio de estado');
            }
        }); 
    }, function(){ 
        alertify.error('Has cancelado el cambio de estado')
    });
}

//cambia en estado en el ciafi
function cambiar_estado_ciafi(estado_ciafi, consecutivo){
    alertify.confirm('Confirmar', '¿ Estas segur@ de cambiar el estado de ciafi ?', function(){ 
        $.post("../controlador/sofi_modificar_credito.php?op=cambiarEstadoCiafi",{estado_ciafi : estado_ciafi, consecutivo : consecutivo}, function(data){
            data = JSON.parse(data);
            if(data.exito == 1){
                alertify.success('Cambio de estado correcto');
                verInfoSolicitante(consecutivo);
            }else{
                alertify.error('Error en el cambio de estado');
            }
        }); 
    }, function(){ 
        alertify.error('Has cancelado el cambio de estado')
    });
}

//cambia en estado en el cobro
function cambiar_estado_cobro(en_cobro, consecutivo){
    alertify.confirm('Confirmar', '¿ Estas segur@ de cambiar el estado de ciafi ?', function(){ 
        $.post("../controlador/sofi_modificar_credito.php?op=cambiarEstadoCobro",{en_cobro : en_cobro, consecutivo : consecutivo}, function(data){
            data = JSON.parse(data);
            if(data.exito == 1){
                alertify.success('Cambio de estado correcto');
                verInfoSolicitante(consecutivo);
            }else{
                alertify.error('Error en el cambio de estado');
            }
        }); 
    }, function(){ 
        alertify.error('Has cancelado el cambio de estado')
    });
}
//Funcion para ver la tareas agendadas 
function verTareas(id){
    $("#id_persona_seguimiento").val(id);
    $("#id_persona_tarea").val(id);
    //busca tambien los agendamientos
    verSeguimientos(id);
    tabla_tareas = $('#tabla_tareas').dataTable({
		"lengthChange": false,	
		"stateSave": true,
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "aProcessing": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
        "buttons": [{
               extend:    'copyHtml5',
               text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
               titleAttr: 'Copy'
           },{
               extend:    'excelHtml5',
               text:      '<i class="fa fa-file-excel" style="color: green"></i>',
               titleAttr: 'Excel'
           },{
               extend:    'csvHtml5',
               text:      '<i class="fa fa-file-alt"></i>',
               titleAttr: 'CSV'
           },{
               extend:    'pdfHtml5',
               text:      '<i class="fa fa-file-pdf" style="color: red"></i>',
               titleAttr: 'PDF',
           }],
		"ajax":{
			"url": "../controlador/sofi_atrasados.php?op=verTareas",
			"type" : "POST",
            "data": {"id_persona": id},
			"dataType" : "json",
			"error": function(e){
				console.log(e.responseText);	
			}
		},
        "bDestroy": true,
		"iDisplayLength": 12,	
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}
//Funcion para ver los seguimientos agendadas 
function verSeguimientos(id){
    tabla_seguimiento = $('#tabla_seguimiento').dataTable({
		"lengthChange": false,	
		"stateSave": true,
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "aProcessing": true,
		"autoWidth": false,
		"dom": 'Bfrtip',
        "buttons": [{
               extend:    'copyHtml5',
               text:      '<i class="fa fa-copy" style="color: blue;padding-top : 0px;"></i>',
               titleAttr: 'Copy'
           },{
               extend:    'excelHtml5',
               text:      '<i class="fa fa-file-excel" style="color: green"></i>',
               titleAttr: 'Excel'
           },{
               extend:    'csvHtml5',
               text:      '<i class="fa fa-file-alt"></i>',
               titleAttr: 'CSV'
           },{
               extend:    'pdfHtml5',
               text:      '<i class="fa fa-file-pdf" style="color: red"></i>',
               titleAttr: 'PDF',
           }],
		"ajax":{
			"url": "../controlador/sofi_atrasados.php?op=verSeguimientos",
			"type" : "POST",
            "data": {"id_persona": id},
			"dataType" : "json",
			"error": function(e){
				console.log(e.responseText);	
			}
		},
        "bDestroy": true,
		"iDisplayLength": 12,	
	}).DataTable();
    $('.dt-button').addClass('btn btn-default btn-flat btn_tablas');
	$('.dt-button').removeClass('dt-button');
}
//Funcion para agregar una nueva tarea al financiado
function guardarTarea(){
	$("#btnGuardarTarea").prop("disabled",true);
	var formData = new FormData($("#formularioTareas")[0]);
	$.ajax({
        url: "../controlador/sofi_modificar_credito.php?op=guardarTarea",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){ 
            $("#btnGuardarTarea").prop("disabled",true);
            datos = JSON.parse(datos);
            $("#btnGuardarSeguimiento").prop("disabled", false);
            if(datos.exito == 1){
                alertify.set('notifier','position', 'top-center');
                alertify.success(datos.info);
                $("#tab_seg_1").removeClass("active");
                $("#tab_seg_2").addClass("active");
                verTareas(datos.id_persona);
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error(datos.info);
            }
        }
	});
}
//Funcion para agregar un nuevo seguimiento al financiado
function guardarSeguimientos(){
	$("#btnGuardarSeguimiento").prop("disabled",true);
	var formData = new FormData($("#formularioSeguimientos")[0]);
	$.ajax({
        url: "../controlador/sofi_modificar_credito.php?op=guardarSeguimientos",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            datos = JSON.parse(datos);
            $("#btnGuardarSeguimiento").prop("disabled", false);
            if(datos.exito == 1){
                alertify.set('notifier','position', 'top-center');
                alertify.success(datos.info);
                $("#tab_seg_1").removeClass("active");
                $("#tab_seg_2").addClass("active");
                verSeguimientos(datos.id_persona);
            }else{
                alertify.set('notifier','position', 'top-center');
                alertify.error(datos.info);
            }
        }
	});
}
//traer cateoria si tiene aguna asignada
function modal_categoria(consecutivo){
    $("#consecutivo_categoria").val(consecutivo);
    $.post("../controlador/sofi_modificar_credito.php?op=traerCategoria",{"consecutivo" : consecutivo}, function(data){
        console.log(data);
        data = JSON.parse(data);
        if(data.exito == 1){
            $("#categoria_credito").val(data.info);
        }
    });
}
function categoria_credito(){
    $("#btnCategoria").prop("disabled",true);
	var formData = new FormData($("#formularioCategorizar")[0]);
	$.ajax({
        "url" : "../controlador/sofi_modificar_credito.php?op=guardarCategoria",
        "type" : "POST",
        "data" : formData,
        "contentType" : false,
        "processData" : false,
        success: function(datos){ 
            datos = JSON.parse(datos);
            $("#btnCategoria").prop("disabled", false);
            if(datos.exito == 1){
                alertify.set( 'notifier', 'position', 'top-center' );
                alertify.success(datos.info);
                verInfoSolicitante($("#dato_busqueda").val());
                $("#modal_categoria").modal("hide");
            }else{
                alertify.set( 'notifier','position', 'top-center' );
                alertify.error(datos.info);
            }
        }
	});
}
//editar campos especificos en una sola funcion
function modificarCampo(campo, valor, id_cuota, consecutivo){
    $.ajax({
        "url": "../controlador/sofi_modificar_credito.php?op=modificarCampo",
        "type": "POST",
        "data": {"campo" : campo, "valor": valor, "id_financiamiento": id_cuota},
        success: function (datos) {
            datos = JSON.parse(datos);
            if (datos.exito == '1') {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(datos.info);
                saldo_debito(consecutivo);
            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(datos.info);
            }
        }
    });
}
//elimina la cuota seleccionada
function eliminarCuota(id_financiamiento, consecutivo) {
    alertify.confirm('Confirmar', '¿ Estas segur@ de eliminar esta cuota ?', function () {
        $.post("../controlador/sofi_modificar_credito.php?op=eliminarCuota", {"id_financiamiento": id_financiamiento}, function (data) {
            data = JSON.parse(data);
            if (data.exito == 1) {
                alertify.success('Eliminada correctamente');
                listar_cuotas(2, consecutivo, "tabla_cuotas")
            } else {
                alertify.error('Error al eliminar la cuota');
            }
        });
    }, function(){});
}
//datos para insertar junto con la cuota
function datos_para_cuota(consecutivo, id_persona) {
    $("#consecutivo_cuota").val(consecutivo);
    $("#persona_cuota").val(id_persona);
}
//Funcion para agregar una nueva cuota al financiado
function guardarCuota() {
    $("#btnCrearCuota").prop("disabled", true);
    var formData = new FormData($("#formularioCrearCuota")[0]);
    $.ajax({
        "url": "../controlador/sofi_modificar_credito.php?op=guardarCuota",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        success: function (datos) {
            datos = JSON.parse(datos);
            $("#btnCrearCuota").prop("disabled", false);
            if (datos.exito == 1) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(datos.info);
                $("#modal_crear_cuota").modal("hide");
                listar_cuotas(2, $("#consecutivo_cuota").val(), 'tabla_cuotas');
            } else {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(datos.info);
            }
        }
    });
}