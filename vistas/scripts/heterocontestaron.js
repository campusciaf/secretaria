var tabla;
function init(){
	
	$.post("../controlador/heterocontestaron.php?op=periodo", function(data){
		data = JSON.parse(data);
		listar(data.periodo);

       
	});	
    $.post("../controlador/heterocontestaron.php?op=selectPeriodo", function(r){
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
    });
    


}


   


// funcion para listar los estudaintes por suma de programa y jornada
function listar(periodo)
{
	
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
                messageTop: '<div style="width:50%;float:left">Asesor: <b>primer campo</b><br>Reporte: <b> </b><br>Fecha Reporte: <b> '+fecha_hoy+'</b> </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/heterocontestaron.php?op=listar&periodo='+periodo,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
        'initComplete': function (settings, json) {
				$("#precarga").hide();
			},
	}).DataTable();


}
init();