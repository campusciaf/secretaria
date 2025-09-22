$(document).ready(inicio);
function inicio() {
    listarProgramas();
    $("#resultados").hide();
	$("#precarga").hide();
}
function validar(){
    var programa=$("#programa").val();
    var corte=$("#corte").val();
    if(programa!= "" & corte != ""){
        consultar(programa,corte)
    }else{
        console.log(error);
    }
}

function listarProgramas() {
    $.post("../controlador/verificarcalificaciones.php?op=listarProgramas", function (datos) {
        //console.table(datos);
        var opti = "";
        var r = JSON.parse(datos);
        opti += '<option selected></option>';
        for (let i = 0; i < r.length; i++) {
            
            opti += '<option value="' + r[i].id_programa + '">' + r[i].nombre + '</option>';
        }
        $(".programa").append(opti);
        $('.programa').selectpicker();
        $('.programa').selectpicker('refresh');
    });
}

function consultar2() {
    var formData = new FormData($("#formulario")[0]);
    $("#precarga").show();
    $.ajax({
        url: "../controlador/verificarcalificaciones.php?op=consulta",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            //console.log(datos);
            var r = JSON.parse(datos);
            $(".conte").html(r.conte);
            $(".table").DataTable({
                'initComplete': function (settings, json) {
                    $("#precarga").hide();
                },
            });
        }

    });
}


//Función ver estudiantes
function consultar(programa,corte){
	$("#precarga").show();

	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
		
		
		tabla=$('#tbllistado').dataTable(
		{
			"aProcessing": true,//Activamos el procesamiento del datatables
			"aServerSide": true,//Paginación y filtrado realizados por el servidor
			dom: 'Bfrtip',//Definimos los elementos del control de tabla
				   buttons: [
				{
					extend:    'excelHtml5',
					text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
					titleAttr: 'Excel'
				},
				{
					extend: 'print',
					 text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Por renovar <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Calificaciones',
					 titleAttr: 'Print'
				},
	
			],
			"ajax":
					{
						url: '../controlador/verificarcalificaciones.php?op=consulta&programa='+programa+'&corte='+corte,
						type : "get",
						dataType : "json",						
						error: function(e){
							console.log(e.responseText);	
						}
					},
			
				"bDestroy": true,
				"iDisplayLength": 10,//Paginación
				"order": [[ 1, "asc" ]],
				'initComplete': function (settings, json) {
					$("#resultados").show();
					$("#precarga").hide();
				},
	
		  });
		
			
	}