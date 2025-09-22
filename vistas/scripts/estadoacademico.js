var tabla;

//Función que se ejecuta al inicio
function init(){
	
	$("#precarga").hide();
	
	$("#listadoregistros").hide();
	
	$("#formulario").on("submit",function(e)
	{
		consultar(e);	
	});
	
	$.post("../controlador/estadoacademico.php?op=selectPrograma", function(r){
	            $("#programa_ac").html(r);
	            $('#programa_ac').selectpicker('refresh');
	});
	
	$.post("../controlador/estadoacademico.php?op=selectPeriodo", function(r){
	            $("#periodo_activo").html(r);
	            $('#periodo_activo').selectpicker('refresh');
	});

    $.post("../controlador/estadoacademico.php?op=selectEstado", function(r){
        $("#estado").html(r);
        $('#estado').selectpicker('refresh');
});

	

	
}


//Función Listar
function listar(programa,estado,periodo_activo)
{
	$("#precarga").show();
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
					url: '../controlador/estadoacademico.php?op=listar&programa='+programa+'&estado='+estado+'&periodo_activo='+periodo_activo,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 20,//Paginación
			'initComplete': function (settings, json) {
                    $("#precarga").hide();
                },
			"order": [[ 1, "desc" ]],//Ordenar (columna,orden)
		
		
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
	
	
		
}


function consultar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/estadoacademico.php?op=consultar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
		  var r = JSON.parse(datos);
			var programa=r.programa;
			var estado=r.estado;
            var periodo_activo=r.periodo_activo;
			listar(programa,estado,periodo_activo);
		 
	    }

	});

}


//Función para desactivar registros
function desactivar(id_programa)
{


	alertify.confirm('Desactivar Programa',"¿Está Seguro de desactivar el programa?", function(){

        	$.post("../controlador/estadoacademico.php?op=desactivar", {id_programa : id_programa}, function(e){
			
				if(e == 1){
				   alertify.success("Programa Desactivado");
					tabla.ajax.reload();
				   }
				else{
					alertify.error("Programa no se puede desactivar");
				}
        		
	            
        	});	
		}
					, function(){ alertify.error('Cancelado')});

}	
	
//Función para activar registros
function activar(id_programa)
{
	alertify.confirm('Activar Programa', '¿Está Seguro de activar el Programa?', function(){ 
	
		$.post("../controlador/estadoacademico.php?op=activar", {id_programa : id_programa}, function(e){
				
        		if(e == 1){
				   alertify.success("Programa Activado");
					tabla.ajax.reload();
				   }
				else{
					alertify.error("Programa no se puede activar");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}	
	
//Función para activar registros
function convertiregresado(id_estudiante)
{
	alertify.confirm('Cambio de estado', '¿Está Seguro de cambiar el estado a egresado?', function(){ 
	
		$.post("../controlador/estadoacademico.php?op=convertiregresado", {id_estudiante : id_estudiante}, function(e){
				
        		if(e == 1){
				   alertify.success("Cambio realizado");
					
				   }
				else{
					alertify.error("cambio no se pudo realizar");
				}
        	});
	
	}
                , function(){ alertify.error('Cancelado')});


}	
		

init();