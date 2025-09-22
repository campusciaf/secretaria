var tabla, api;
function init(){
    listar();
    datospanel();
    mostrarEstadoEvalaucion();
	$("#boton_regresar").hide();
        $("#boton_regresar").off("click").on("click",function(){
        $("#listadoregistros").show();
        $("#información_grupos").attr("hidden",true);
        $("#boton_regresar").hide();
        $("#listado_grupos").attr("hidden",true);
        $("#selector_grupo").empty();
        $("#tblgrupos").html('');
        $("#tblpea").html('');
        $("#boton_pea").attr("hidden",true);
    });
    //Cargamos los items de los selects
	$.post("../controlador/resultadosautoevaluacion.php?op=selectPeriodo", function(r){
        var data = JSON.parse(r);
        if(Object.keys(data).length > 0){
            var html = '';
           for(var i = 0; i < Object.keys(data).length;i++ ){
               html += '<option value="'+data[i].periodo+'">'+data[i].periodo+'</option>';
           }
        }
        $("#input_periodo").html(html);
	});
    //activa o desactiva la autoevalaucion
    $('#switch_autoevaluacion').change(function () {
        estado = ($(this).prop('checked')) ? 1 : 0;
        $.post("../controlador/resultadosautoevaluacion.php?op=cambiarEstadoEvalaucion", { "tipo": "autoevaluacion", "estado": estado }, function (r) {
            
            r = JSON.parse(r);
            if (r.exito == 1) {
                alertify.success("Cambio exitoso");
                mostrarEstadoEvalaucion();
            } else {
                alertify.error("Error al cambiar de estado la autoevaluación");
            }
        });
    });
}

function mostrarEstadoEvalaucion() {
    $.post("../controlador/resultadosautoevaluacion.php?op=mostrarEstadoEvalaucion", { "tipo": "autoevaluacion" }, function (r) {
      
        var data = JSON.parse(r);
        if (data.estado == 0) {
            $('#switch_autoevaluacion').prop("checked", false);
            $('.estado_autoevaluacion').text("Inactiva");
        } else {
            $('#switch_autoevaluacion').prop("checked", true);
            $('.estado_autoevaluacion').text("Activa");
        }
    });
}

function datospanel() {
    var periodobuscar=$("#input_periodo").val();
    $.post("../controlador/resultadosautoevaluacion.php?op=datospanel",{periodobuscar:periodobuscar}, function(r){
        var data = JSON.parse(r);
        $("#datos").html(data);
        
    });
}

function resultados2(id_docente) {
    var periodobuscar=$("#input_periodo").val();

    $.post("../controlador/resultadosautoevaluacion.php?op=resultados",{id_docente:id_docente , periodobuscar:periodobuscar}, function(r){
        var data = JSON.parse(r);
        $("#modal-resultados").modal("show");
        $("#resultados-autoevaluacion").html(data);
        console.log(data);
    });
}

function resultados(id_docente){
    var periodobuscar=$("#input_periodo").val();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy=( diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#preguntas_respuestas').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons": [{
                "extend" : 'excelHtml5',
                "text" : '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr" : 'Excel'
            },{
                "extend" : 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop" : '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                "title": 'Autoevaluación',
                "titleAttr": 'Print'
            }],
		"ajax":{
            "url": '../controlador/resultadosautoevaluacion.php?op=resultados',
            "type" : "POST",
            "data" : {id_docente:id_docente , periodobuscar:periodobuscar},
            "dataType" : "json",						
            "error" : function(e){
                console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength" : 11,//Paginación
       
        "initComplete" : function(){
            $("#modal-resultados").modal("show");
            $("#precarga").hide();
        },

    });



}



/* Función para listar los docentes que se encuentran activos */
function listar(){
    $("#precarga").show();
    var periodobuscar=$("#input_periodo").val();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy=( diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tbllistado').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons": [{
                "extend" : 'excelHtml5',
                "text" : '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr" : 'Excel'
            },{
                "extend" : 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop" : '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                "title": 'Docentes',
                "titleAttr": 'Print'
            }],
		"ajax":{
            "url": '../controlador/resultadosautoevaluacion.php?op=listar',
            "type" : "POST",
            "data" : {"periodobuscar" : periodobuscar},
            "dataType" : "json",						
            "error" : function(e){
                console.log(e.responseText);	
            }
        },
        "bDestroy": true,
        "iDisplayLength" : 10,//Paginación
        "initComplete" : function(){
            datospanel();
            $("#precarga").hide();
        },

    });

}
init();