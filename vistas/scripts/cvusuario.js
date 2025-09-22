var tabla;



//Función que se ejecuta al inicio

function init(){
	mostrarform(false);
	listar();
	$("#formulario").on("submit",function(e){
		guardaryeditar(e);	
	});
    $("#imagenmuestra").hide();

    $.post("../controlador/cvusuario.php?op=selectDepartamento", function(r){
        $("#usuario_departamento").html(r);
        $('#usuario_departamento').selectpicker('refresh');
	});
	$.post("../controlador/cvusuario.php?op=selectMunicipio", function(r){
        $("#usuario_municipio").html(r);
        $('#usuario_municipio').selectpicker('refresh');
	});
    $("#estado_info").off("change").on("change", function(){
        listarbusqueda("porEstado", $("#estado_info").val());
    });
    $("#categoria_profesional").off("change").on("change", function(){
        listarbusqueda("porCategoria", $("#categoria_profesional").val());
    });
    $("#area_conocimiento").off("change").on("change", function(){
        listarbusqueda("porArea", $("#area_conocimiento").val());
    }); 
    $("#fecha_solicitud").off("change").on("change", function(){
        listarbusqueda("porFecha", $("#fecha_solicitud").val());
    }); 
    $("#form_entrevista").off("submit").on("submit", function(e){
        e.preventDefault();
        enviar_cita();
    }); 
    
}

//Función limpiar
function limpiar(){
	$("#id_usuario_cv").val("");
	$("#usuario_identificacion").val("");
	$("#usuario_nombre").val("");
	$("#usuario_apellido").val("");
	$("#usuario_fecha_nacimiento").val("");
	$("#usuario_direccion").val("");
	$("#usuario_telefono").val("");
	$("#usuario_email").val("");
	$("#usuario_login").val("");
	$("#imagenmuestra").attr("src"," ");
	$("#imagenactual").val("");
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

//Función Listar
function listar(){
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
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
            url: '../controlador/cvusuario.php?op=listar',
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
		"iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
        'initComplete': function (settings, json) {
            $("#precarga").hide();
        },
	}).DataTable();
}

//Función para guardar o editar
function guardaryeditar(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		"url": "../controlador/cvusuario.php?op=guardaryeditar",
        "type": "POST",
        "data": formData,
        "contentType": false,
        "processData": false,
        "success": function(datos){
            // console.log(datos);
            datos = JSON.parse(datos);
            if(datos.estatus == "0"){
                alertify.error(datos.valor);
                $("#btnGuardar").prop("disabled",false);
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

function mostrar(id_usuario_cv){
	$.post("../controlador/cvusuario.php?op=mostrar",{id_usuario_cv : id_usuario_cv}, function(data, status){
        // console.log(data);
		data = JSON.parse(data);	
		mostrarform(true);
		$("#usuario_identificacion").val(data.usuario_identificacion);
		$("#usuario_nombre").val(data.usuario_nombre);
		$("#usuario_apellido").val(data.usuario_apellido);
		$("#usuario_fecha_nacimiento").val(data.fecha_nacimiento);
		$("#usuario_departamento").val(data.departamento);
		$("#usuario_departamento").selectpicker('refresh');
		$("#usuario_municipio").val(data.ciudad);
		$("#usuario_municipio").selectpicker('refresh');
		$("#usuario_direccion_cv").val(data.direccion);
		$("#usuario_celular_cv").val(data.telefono);
		$("#usuario_email_cv").val(data.usuario_email);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.usuario_imagen);
		$("#imagenactual").val(data.usuario_imagen);
		$("#id_usuario_cv").val(data.id_usuario_cv);
    });
    // $.post("../controlador/usuario.php?op=permisos&id="+id_usuario,function(r){
    //     $("#permisos").html(r);
	// });
}

//Función para desactivar registros
function desactivar(id_usuario_cv){
	alertify.confirm('Desactivar Usuario',"¿Está Seguro de desactivar el usuario?", 
    function(){
        $.post("../controlador/cvusuario.php?op=desactivar", {id_usuario_cv : id_usuario_cv}, 
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
function activar(id_usuario_cv){
    alertify.confirm('Activar Usuario', '¿Está Seguro de activar el Usuario?', 
        function(){
            $.post("../controlador/cvusuario.php?op=activar", {id_usuario_cv : id_usuario_cv}, 
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
function contratar(id_usuario_cv){
	alertify.confirm('Contratar Usuario', '¿Está Seguro de contratar el Usuario?', 
        function(){
            $.post("../controlador/cvusuario.php?op=contratar", {id_usuario_cv : id_usuario_cv}, 
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
function desvinculado(id_usuario_cv){
	alertify.confirm('Desvincular Usuario', '¿Está Seguro de desvincular el Usuario?', 
        function(){
            $.post("../controlador/cvusuario.php?op=desvincular", {id_usuario_cv : id_usuario_cv}, 
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
function citar(id_usuario_cv, correo_destino){
    $("#form_entrevista")[0].reset();
    $("#nombre_usuario").val($(".nombre_admin").text());
    $("#mi_correo_electronico").val($(".correo_admin").text());
    $("#correo_electronico").val(correo_destino);
}

//Función para enviar_cita
function enviar_cita(){
    var formData = new FormData($("#form_entrevista")[0]);
    $("#info_preloader").html('<div class="preloader-box"></div>');
    $.ajax({
        url: "../controlador/cv_citar_entrevista.php?op=citar_entrevista",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            //console.log(datos);
            var data = JSON.parse(datos);
            if(data.estatus == 1){
                alertify.success(data.valor);
                $("#info_preloader").html('');
            }else{
                alertify.error(data.valor);
                $("#info_preloader").html('');
            }
        }
    });
}

//Función Listar
function listarbusqueda(tipobusqueda, valorbusqueda){
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [

        {
            extend:    'excelHtml5',
            text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
            titleAttr: 'Excel'
        },

        {
            extend: 'print',
            text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
            messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
            title: 'Ejes',
            titleAttr: 'Print'
        }],

		"ajax":
            {
                url: '../controlador/cvusuario.php?op=listarbusqueda&tipobusqueda='+tipobusqueda+"&valorbusqueda="+valorbusqueda,
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
		"iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();

}

//Función para eliminar la categoria
function eliminar_usuario_cv(id_usuario_cv){
	alertify.confirm("¿Está Seguro de eliminar el usuario?", function(result){
		if(result){
			$.post("../controlador/cvusuario.php?op=eliminar_usuario_cv", {'id_usuario_cv' : id_usuario_cv}, function(e){
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