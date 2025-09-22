var map;
var marker;
var lugares = "[";
var titulo = "[";

function init(){
	$("#precarga").hide();
	$("#resultado").hide();
	$("#mapa").hide();
	
	$("#formulario").on("submit",function(e)
	{
		buscarfiltrar(e);	
	});
	
	$.post("../controlador/geolocalizacion.php?op=selectPrograma", function(r){
	            $("#programa").html(r);
	            $('#programa').selectpicker('refresh');
	});
		//Cargamos los items de los selects contrato
	$.post("../controlador/geolocalizacion.php?op=selectJornada", function(r){
	            $("#jornada").html(r);
	            $('#jornada').selectpicker('refresh');
	});
	
//		//Cargamos los items de los selects contrato
//	$.post("../controlador/geolocalizacion.php?op=selectPeriodo", function(r){
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
		url: "../controlador/geolocalizacion.php?op=listar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
		$("#resultado").show();
		$("#mapa").show();
			
		data = JSON.parse(datos);
	

			if(data.length==0){
				alertify.error('No se encuentran datos');
				deleteMarkers();
			}else{
				var latitud= data["0"]["0"];
				var longitud=data["0"]["1"];
				var registros=data["0"]["3"];


				$("#cantidad").html("");
				$("#cantidad").html("Registros encontrados: " + data.length);

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
					console.log(lugares);


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


init();