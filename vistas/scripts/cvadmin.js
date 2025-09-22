var tabla;
var id_cvadministrativos_global;

//Función que se ejecuta al inicio
function init(){
    // listamos los usuarios que estan en la tabla cvadministrativos.
    listar_funcionarios();
    
    
	mostrarform(false);
	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
    $("#imagenmuestra").hide();
    $("#fecha_solicitud").off("change").on("change", function(){
        listarbusqueda("porFecha", $("#fecha_solicitud").val());
    }); 
    $("#form_entrevista").off("submit").on("submit", function(e){
        e.preventDefault();
        enviar_cita();
    }); 
    $.post("../controlador/usuario.php?op=selectDependencia", function(r){
        $("#cvadministrativos_cargo").html(r);
        $('#cvadministrativos_cargo').selectpicker('refresh');
    });
    
}

//listamos los funcionarios que estan registrados en la tabla cvadministrativos
function listar_funcionarios(){
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,
        "aServerSide": true,
        "dom": 'Bfrtip',
        "buttons": [{
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                titleAttr: 'Excel'
            },{
                extend: 'print',
                text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
                titleAttr: 'Print'
            }],
		"ajax":{
            url: '../controlador/cvadmin.php?op=listar_funcionarios',
            type : "get",
            dataType : "json",						
            error: function(e){
                // console.log(e.responseText);	
            }
		},
        "columnDefs": [
            { "width": "15%", "targets": 0 }
        ],
		"bDestroy": true,
		"autowidth": true,
		"iDisplayLength": 10,
        "order": [[ 0, "desc" ]],
        'initComplete': function (settings, json) {
            $("#precarga").hide();
        },
	}).DataTable();
}


//Función limpiar
function limpiar(){
	// $("#id_cvadministrativos").val("");
	// $("#cvadministrativos_identificacion").val("");
	// $("#cvadministrativos_nombre").val("");
	// $("#cvadministrativos_apellido").val("");
	// $("#cvadministrativos_celular").val("");
	// $("#cvadministrativos_correo").val("");
}
//Función mostrar formulario
function mostrarform(flag){
	limpiar();
	if (flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}
//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//Función para guardar o editar
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		"url": "../controlador/cvadmin.php?op=guardaryeditar",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){
            // console.log(datos);
            datos = JSON.parse(datos);
            if(datos.estatus == "0"){
                alertify.error(datos.valor);
                //$("#btnGuardar").prop("disabled",false);
            }else if(datos.estatus == "1"){
                alertify.success(datos.valor);
                tabla.ajax.reload();
                mostrarform(false);
            }  
        }
	});
}
function dividirCadena(cadenaADividir,separador) {
    if(cadenaADividir == "" || cadenaADividir === null){
        array = [];
        return array;
    }else{
        var arrayDeCadenas = cadenaADividir.split(separador);
        return arrayDeCadenas[0];    
    }
}
function mostrar(id_cvadministrativos){
	$.post("../controlador/cvadmin.php?op=mostrar",{id_cvadministrativos : id_cvadministrativos}, function(data, status){
        // console.log(data);
		data = JSON.parse(data);	
		mostrarform(true);
		$("#cvadministrativos_identificacion").val(data.cvadministrativos_identificacion);
		$("#cvadministrativos_nombre").val(data.cvadministrativos_nombre);
        $("#cvadministrativos_celular").val(data.cvadministrativos_celular);
		$("#cvadministrativos_correo").val(data.cvadministrativos_correo);
		$("#id_cvadministrativos").val(data.id_cvadministrativos);
        $("#cvadministrativos_cargo").val(data.cvadministrativos_cargo);
        $('#cvadministrativos_cargo').selectpicker('refresh');
    });
}

//Función para desactivar registros
function desactivar(id_cvadministrativos){
	alertify.confirm('Desactivar Usuario',"¿Está Seguro de desactivar el usuario?", 
    function(){
        $.post("../controlador/cvadmin.php?op=desactivar", {id_cvadministrativos : id_cvadministrativos}, 
            function(e){
                    if(e == 1){
                        alertify.success("Usuario Desactivado");
                        tabla.ajax.reload();
                    }else{
                        alertify.error("Usuario no se puede desactivar");
                    }
                }
            );	
		},
        function(){ 
            alertify.error('Cancelado')
        }
    );
}

//Función para activar registros
function activar(id_cvadministrativos){
    alertify.confirm('Activar Usuario', '¿Está Seguro de activar el Usuario?', 
        function(){
            $.post("../controlador/cvadmin.php?op=activar", {id_cvadministrativos : id_cvadministrativos}, 
            function(e){
                    if(e == 1){
                    alertify.success("Usuario Activado");
                        tabla.ajax.reload();
                    }else{
                        alertify.error("Usuario no se puede activar");
                    }
            });
    },function(){ 
        alertify.error('Cancelado')}
    );
}
//Función para activar registros
function contratar(id_cvadministrativos){
	alertify.confirm('Contratar Usuario', '¿Está Seguro de contratar el Usuario?', 
        function(){
            $.post("../controlador/cvadmin.php?op=contratar", {id_cvadministrativos : id_cvadministrativos}, 
            function(e){    
                //console.log(e);
                    if(e == 1){
                    alertify.success("Usuario contratado");
                        tabla.ajax.reload();
                    }else{
                        alertify.error("Usuario no se puede contratar");
                    }
            });
    }, 
    function(){ 
        alertify.error('Cancelado')}
    );
}

//Función para activar registros
function desvinculado(id_cvadministrativos){
	alertify.confirm('Desvincular Usuario', '¿Está Seguro de desvincular el Usuario?', 
        function(){
            $.post("../controlador/cvadmin.php?op=desvincular", {id_cvadministrativos : id_cvadministrativos}, 
                function(e){
                    // console.log(e);
                    if(e == 1){
                        alertify.success("Usuario desvinculado");
                        tabla.ajax.reload();
                    }
                    else{
                        alertify.error("Usuario no se puede desvincular");
                    }
                }
            );
        }, 

    function(){ 
        alertify.error('Cancelado')}
    );

}

//Función para citar
function citar(id_cvadministrativos, correo_destino){
    $("#id_cvadministrativos_cv").val(id_cvadministrativos);
    $("#usuario_login").val($(".correo_admin").text());
    $("#cvadministrativos_correo_cv").val(correo_destino);
}


//Función para enviar_cita
function enviar_cita(){
    var formData = new FormData($("#form_entrevista")[0]);
    $("#info_preloader").html('<div class="preloader-box"></div>');
    $.ajax({
        url: "../controlador/cv_citar_entrevista_admin.php?op=citar_entrevista",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            //console.log(datos);
            var data = JSON.parse(datos);
            if(data.estatus == 1){
                alertify.success(data.valor);
                $('#modal-default').modal('hide');
                $("#info_preloader").html('');
            }else{
                alertify.error(data.valor);
                $("#info_preloader").html('');
            }
        }
    });
}


//Función para eliminar la categoria
function eliminar_usuario_cv(id_cvadministrativos){
	alertify.confirm("¿Está Seguro de eliminar el usuario?", function(result){
		if(result){
			$.post("../controlador/cvadmin.php?op=eliminar_usuario_cv", {'id_cvadministrativos' : id_cvadministrativos}, function(e){
				// console.log(e);
				
				if(e){
					alertify.success("Eliminado correctamente");
					window.location.reload();
				}else{
					alertify.error("Error");
				}
			});	
        }
	})
}


init();