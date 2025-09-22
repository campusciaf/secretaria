var tabla;

//Función que se ejecuta al inicio
function init(){
    $.post("../controlador/consultaidiomas.php?op=selectPeriodo", function(r){
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
    
    });

    $.post("../controlador/consultaidiomas.php?op=selectEscuelas",{}, function(r){
        $("#escuelas").html(r);
        $("#escuelas").selectpicker('refresh');
    });

    $("#precarga").hide();
}

function buscarp(periodo){
  
    id_escuela=$("#escuelas").val();
    listar(periodo,id_escuela);
}
   
function buscare(id_escuela){
  
    periodo=$("#periodo").val();
    listar(periodo,id_escuela);
}


//Función Listar
function listar(periodo,id_escuela){
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
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/consultaidiomas.php?op=listar',
					type : "post",
                    data: {periodo:periodo,id_escuela:id_escuela},
					dataType : "json",						
					error: function(e){
						// console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación

			'initComplete': function (settings, json) {
				$("#precarga").hide();
                
			},

      });
		
}


init();// inicializa la funcion init