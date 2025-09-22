var tabla;
function init(){
    listar();
}

function listar()
{
	$("#listadoregistros").show();
	var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
	var f=new Date();
	var fecha=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor

	    dom: 'Bfrtip',
				buttons: [

					{
						extend:    'excelHtml5',
						text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
						titleAttr: 'Excel'
					},

					{
						extend: 'print',
						text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
						messageTop: '<div style="width:50%;float:left">Reporte Programas Académicos<br><b>Fecha de Impresión</b>: '+fecha+'</div><div style="width:50%;float:left;text-align:right"><img src="../public/img/logo_print.jpg" width="150px"></div><br><div style="float:none; width:100%; height:30px"><hr></div>',
						title: 'Programas Académicos',
						titleAttr: 'Print'
					},
				],
		"ajax":
				{
					url: '../controlador/ver_materias_canceladas.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
							
					}
				},
		"bDestroy": true,
		"scrollX": false,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 2, "asc" ]],//Ordenar (columna,orden)
		
	// funcion para cambiar el responsive del data table	

         'select': 'single',

         'drawCallback': function (settings) {
            api = this.api();
            var $table = $(api.table().node());
            
            if ($table.hasClass('cards')) {

               // Create an array of labels containing all table headers
               var labels = [];
               $('thead th', $table).each(function () {
                  labels.push($(this).text());
               });

               // Add data-label attribute to each cell
               $('tbody tr', $table).each(function () {
                  $(this).find('td').each(function (column) {
                     $(this).attr('data-label', labels[column]);
                  });
               });

               var max = 0;
               $('tbody tr', $table).each(function () {
                  max = Math.max($(this).height(), max);
               }).height(max);

            } else {
               // Remove data-label attribute from each cell
               $('tbody td', $table).each(function () {
                  $(this).removeAttr('data-label');
               });

               $('tbody tr', $table).each(function () {
                  $(this).height('auto');
               });
            }
         }
		
		
		
      });
	
	
		var width = $(window).width();
		if(width <= 750){
			$(api.table().node()).toggleClass('cards');
			api.draw('page');
		}
		window.onresize = function(){

			 anchoVentana = window.innerWidth;
				if(anchoVentana > 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else if(anchoVentana > 750 && anchoVentana < 1000){
					$(api.table().node()).removeClass('cards');
					api.draw('page');
				}else{
				  $(api.table().node()).toggleClass('cards');
					api.draw('page');
				}
		}
		// ****************************** //
	
$("#precarga").hide();		
		
}

init();