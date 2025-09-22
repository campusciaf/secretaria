$(document).ready(incio);
var tabla="";
function incio() {

	$.post("../controlador/faltas.php?op=periodo", function(data){
		data = JSON.parse(data);
		$("#precarga").show();
		listar(data.periodo);

	});	

	$.post("../controlador/faltas.php?op=selectPeriodo", function(r){
		$("#periodo").html(r);
		$('#periodo').selectpicker('refresh');
	});
		
}
//Función Listar
function listar(periodo)
{
	$("#miperiodo").html(periodo);

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
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Faltas',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/faltas.php?op=listar&periodo='+periodo,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 5, "asc" ]],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

      });
	
	

	
		
}


//Función para activar registros
function eliminarfalta(id_falta,id_materia,ciclo)
{
	alertify.confirm("Eliminar falta", "¿Desea Eliminar esta falta?", function(){ 
	
		$.post("../controlador/faltas.php?op=eliminarfalta", {id_falta : id_falta, id_materia:id_materia, ciclo:ciclo}, function(datos){
				var r = JSON.parse(datos);
			console.log(r.status);
        		if(r.status == 1){
				   alertify.success("Falta eliminada");
					$('#tbllistado').DataTable().ajax.reload();
				   }
				else{
					alertify.error("Falta no se pudo  Eliminada");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}
