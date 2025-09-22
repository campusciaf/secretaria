$(document).ready(incio);
var seleccion_actual = 1;

var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
var f=new Date();
var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

function incio() {
    $("#precarga").hide();
    listarconversiones();
    listarconversionescomparacion();
    listardatos(1);
    
}
function listardatos(rango){
    seleccion_actual = rango;
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    var contador=1;
        while(contador <= 5){
            $("#opcion"+contador).removeClass("activo"); 
            contador++;
        }
            $("#opcion"+rango).addClass("activo");

        $.post("../controlador/panelcomercial.php?op=listardatos&rango="+rango+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
        // console.log(e);
        var r = JSON.parse(e);

        $("#datouno").html(r.totaluno);
        $("#datodos").html(r.totaldos);
        $("#datotres").html(r.totaltres);
        $("#datocuatro").html(r.totalcuatro);
        $("#datocinco").html(r.totalcinco);
        $("#datoseis").html(r.totalseis);

        $("#totalmarketing").html(r.totalmarketing);
        $("#totalweb").html(r.totalweb);
        $("#totalasesor").html(r.totalasesor);

        $("#dato_tarea").html(r.totaltarea);
        $("#dato_realizadas").html(r.totalrealizadas);
        $("#dato_seguimiento").html(r.totalseguimiento);
        $("#dato_llamada").html(r.totalllamada);
        $("#dato_cita").html(r.totalcita);
        $("#dato_sinexito").html(r.totalsinexito);
        $("#dato_contactanos").html(r.totalcontactanos);
    });
}

function listarrango(){
    $(".chart-loader").show();
    $("#exampleModal").modal("hide");
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    
    var rango=5;
    var contador=1;
    while(contador <= 5){
        $("#opcion"+contador).removeClass("activo"); 
        contador++;
    }
        $("#opcion"+rango).addClass("activo");
        $.post("../controlador/panelcomercial.php?op=listarrango&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final, function (e) {
            // console.log(e);
        var r = JSON.parse(e);
        $("#datouno").html(r.totaluno);
        $("#datodos").html(r.totaldos);
        $("#datotres").html(r.totaltres);
        $("#datocuatro").html(r.totalcuatro);
        $("#datocinco").html(r.totalcinco);
        $("#datoseis").html(r.totalseis);
        $("#totalmarketing").html(r.totalmarketing);
        $("#totalweb").html(r.totalweb);
        $("#totalasesor").html(r.totalasesor);

        $("#dato_tarea").html(r.totaltarea);
        $("#dato_realizadas").html(r.totalrealizadas);
        $("#dato_seguimiento").html(r.totalseguimiento);
        $("#dato_llamada").html(r.totalllamada);
        $("#dato_cita").html(r.totalcita);
        $("#dato_sinexito").html(r.totalsinexito);
        $("#dato_contactanos").html(r.totalcontactanos);
    });

}


// traemos los interesados 
function interesados(interesado){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());

    $.post("../controlador/panelcomercial.php?op=interesados&interesado="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#interesados").modal("show");
        $("#datosusuario").html(r);

        $('#mostrarinteresados').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Interesados',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}
// traemos las tareas pendientes y finalizadas 
function tareascreadas(tareas){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    $.post("../controlador/panelcomercial.php?op=tareascreadas&tareas="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#tareas").modal("show");
        $("#datostareas").html(r);
        $('#tareascreadas').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Tareas Creadas',
                     titleAttr: 'Print'
                },
                
            ],

        });
        
    });

}

// traemos las tareas finalizadas
function tareasrealizadas(tareasrealizadas){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();
   

    $.post("../controlador/panelcomercial.php?op=tareasrealizadas&tareasrealizadas="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#tareasrealizadas").modal("show");
        $("#datostareasrealizadas").html(r);

        $('#tareasfinalizadas').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Tareas Realizadas',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}


// traemos los seguimientos
function seguimientos(seguimientos){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=seguimientos&seguimientos="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#seguimientos").modal("show");
        $("#datosseguimientos").html(r);

        $('#seguimientostabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Seguimientos',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}

// traemos las llamadas
function llamadas(llamadas){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=llamadas&llamadas="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#llamadas").modal("show");
        $("#datosllamadas").html(r);

        $('#llamadastabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'LLamadas',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}

// traemos las llamadas
function citas(citas){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=citas&citas="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#citas").modal("show");
        $("#datoscitas").html(r);

        $('#citastabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Citas',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}


// traemos las preinscritos
function preinscritos(preinscritos){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=preinscritos&preinscritos="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#preinscritos").modal("show");
        $("#datospreinscritos").html(r);

        $('#preinscritostabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Preinscritos',
                     titleAttr: 'Print'
                },
            ],
    
        });
        
    });

}


// traemos las inscritos
function inscritos(inscritos){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=inscritos&inscritos="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#inscritos").modal("show");
        $("#datosinscritos").html(r);

        $('#inscritostabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Inscritos',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });




}


// traemos las seleccionados
function seleccionados(seleccionados){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=seleccionados&seleccionados="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#seleccionados").modal("show");
        $("#datosseleccionados").html(r);

        $('#seleccionadostabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Seleccionados',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}

// traemos las admitidos
function admitidos(admitidos){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=admitidos&admitidos="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#admitidos").modal("show");
        $("#datosadmitidos").html(r);

        $('#admitidostabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Admitidos',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}


// traemos las matriculados
function matriculados(matriculados){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=matriculados&matriculados="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#matriculados").modal("show");
        $("#datosmatriculados").html(r);

        $('#matriculadostabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Matriculados',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}


function Marketingdigital(marketingdigital){
    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=marketingdigital&marketingdigital="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#marketingdigital").modal("show");
        $("#datosmarketingdigital").html(r);

        $('#marketingdigitaltabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Marketing-digital',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}
// traemos las matriculados
function Asesor(asesor){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=asesor&asesor="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#asesordigital").modal("show");
        $("#datosasesor").html(r);

        $('#asesortabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Asesor',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}
// traemos las matriculados
function Web(web){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=web&web="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#web").modal("show");
        $("#datosweb").html(r);

        $('#webtabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Web',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}

// traemos las matriculados
function sinexito(sinexito){

    var fecha_inicial=$("#fecha-inicio").val();
    var fecha_final=$("#fecha-hasta").val();

    $.post("../controlador/panelcomercial.php?op=sinexito&sinexito="+seleccion_actual+"&fecha_inicial="+fecha_inicial+"&fecha_final="+fecha_final,  function (e) {
        // console.log(e);
        var r = JSON.parse(e);
        $("#sinexito").modal("show");
        $("#datossinexito").html(r);

        $('#sinexitotabla').dataTable( {
					
            dom: 'Bfrtip',
            
            buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'print',
                     text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                    messageTop: '<div style="width:50%;float:left"><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Sin Exito',
                     titleAttr: 'Print'
                },
                
            ],
    
        });
        
    });

}

function listarconversiones(){

    $.post("../controlador/panelcomercial.php?op=listarconversion", function (e) {
        var r = JSON.parse(e);
        $("#datos_conversion").html(r.dato1);
    });


}

function listarconversionescomparacion(){

    $.post("../controlador/panelcomercial.php?op=listarconversioncomparacion", function (e) {
        var r = JSON.parse(e);
        $("#datos_conversion_comparacion").html(r.dato1);
    });


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
				title: 'Panel Comercial',
				intro: "Bienvenido a nuestra gestión de panel comercial visualiza la información de una maenra general"
			},
		
		
			
		]
			
	},
	console.log()
	
	).start();

}
