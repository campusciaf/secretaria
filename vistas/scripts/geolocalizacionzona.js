var map;
var marker;
var lugares = "[";
var titulo = "[";

function init(){

	$("#precarga").hide();
	$("#formulario").on("submit",function(e)
	{
		buscarfiltrar(e);	
	});
	
	$.post("../controlador/geolocalizacionzona.php?op=selectPrograma", function(r){
	            $("#programa").html(r);
	            $('#programa').selectpicker('refresh');
	});
		//Cargamos los items de los selects contrato
	$.post("../controlador/geolocalizacionzona.php?op=selectJornada", function(r){
	            $("#jornada").html(r);
	            $('#jornada').selectpicker('refresh');
	});
	
		//Cargamos los items al select ejes
	$.post("../controlador/geolocalizacionzona.php?op=selectDepartamento", function(r){
	            $("#departamento").html(r);
	           	$('#departamento').selectpicker('refresh');
	
	});
	
	
//		//Cargamos los items de los selects contrato
//	$.post("../controlador/$geolocalizacionzona.php?op=selectPeriodo", function(r){
//	            $("#periodo").html(r);
//	            $('#periodo').selectpicker('refresh');
//	});

}
	


function buscarfiltrar(e)
{
	deleteMarkers();
	e.preventDefault(); //No se activará la acción predeterminada del evento

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/geolocalizacionzona.php?op=listar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
		
			
		data = JSON.parse(datos);

			if(data.length==0){
				alertify.error('No se encuentran datos');
				deleteMarkers();
			}else{
				
				
				var latitud= data["0"]["0"];
				var longitud=data["0"]["1"];
				var registros=data["0"]["3"];
				var programa=data["0"]["4"];
				var jornada=data["0"]["5"];
				var semestre=data["0"]["6"];
				var cod_postal=data["0"]["7"];
				
				
				
				
				listarTabla(programa,jornada,semestre,cod_postal);
							
				$("#datos").show();
				$("#cantidad").html(registros);
				
				a=0;
				while(a < data.length){

					if((a+1) >= data.length){
					   lugares += `{"lat": `+data[a]['0']+`, "lng": `+data[a]['1']+`}`;
						titulo += `"`+data[a]['2']+`"`;
					 }else{
						lugares += `{"lat": `+data[a]['0']+`, "lng": `+data[a]['1']+`},`; 
						titulo += `"`+data[a]['2']+`",`;
					 }
					a++;
				}
				lugares += "]";
				titulo += "]";

				var center= {lat: 4.8161224, lng: -75.7009495};

					lugares =JSON.parse(lugares);		
					titulo =JSON.parse(titulo);	


				map = new google.maps.Map(document.getElementById('map'), {
					zoom: 12,
					center:center,

					});


				for(i=0; i<lugares.length; i++){
		
					
						marker = new google.maps.Marker({
						position:lugares[i] ,
						map: map,
						title:titulo[i],
					

					});		
				}
				
			}
	    }

	});
	//limpiar();
}
	
function deleteMarkers() {
   marker=[];
lugares = "[";
titulo = "[";
	
  }

function mostrarmunicipio(id_departamento) {
	
    $.post("../controlador/geolocalizacionzona.php?op=selectMunicipio",{id_departamento:id_departamento} ,function (datos) {
        $("#municipio").html(datos);
        $("#municipio").selectpicker('refresh');
    });
}
function mostrarcodpostal(id_municipio) {

    $.post("../controlador/geolocalizacionzona.php?op=selectPostal",{id_municipio:id_municipio} ,function (datos) {
		
        $("#cod_postal").html(datos);
        $("#cod_postal").selectpicker('refresh');
    });
}


//Función Listar
function listarTabla(programa,jornada,semestre,cod_postal)
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
                messageTop: '<div style="width:50%;float:left">Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'GEolocalización',
			 	titleAttr: 'Imprimir'
            },

        ],
		"ajax":
				{
					url: '../controlador/geolocalizacionzona.php?op=listarTabla&programa='+programa+'&jornada='+jornada+'&semestre='+semestre+'&cod_postal='+cod_postal,
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}



init();