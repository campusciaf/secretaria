var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();
	
}
   
//Función Listar
function listar()
{
    
	$("#listadoregistros").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		"paging":   false,
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
		"autoWidth": false,
		
		buttons: [],

		"ajax":
			{
				url: '../controlador/micertificado.php?op=listar',
				type : "get",
				dataType : "json",						
				error: function(e){

				}
			},
		
		"bDestroy": true,
		"scrollX": false,
		'initComplete': function (settings, json) {
			$("#precarga").hide();
		},

		
      });

      $.post("../controlador/micertificado.php?op=listar", {}, function(e){
				
      console.log(e);
    });

}


init();