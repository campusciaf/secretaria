 
var map, geocoder;

 function inicio() {
    var latlng = new google.maps.LatLng(4.8160841, -75.7008604);
    var mapOptions = {
      zoom: 12,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('mapa'), mapOptions);
    geocoder = new google.maps.Geocoder();
  }

function codeAddress(id_estudiante,latitudlongitud) {
    var address = latitudlongitud;
    geocoder.geocode({
      'address': address
        // 'latLng': latlng si lo que queremos ejecutar en geocodificación inversa
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        document.getElementById('x').innerHTML = results[0].geometry.location.lat().toFixed(6);
        document.getElementById('y').innerHTML = results[0].geometry.location.lng().toFixed(6);
        map.setCenter(results[0].geometry.location);
        document.getElementById('direccion').innerHTML = results[0].formatted_address;
        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
            for(var j=0;j < results[0].address_components.length; j++){
                for(var k=0; k < results[0].address_components[j].types.length; k++){
                    if(results[0].address_components[j].types[k] == "postal_code"){
                        zipcode = results[0].address_components[j].short_name;
                       // document.getElementById('CP').innerHTML = zipcode;
						
						actualizar(id_estudiante,zipcode);
                    }
                }
            }
        infowindow = new google.maps.InfoWindow({
          content: results[0].formatted_address + '<br> Latitud: ' + results[0].geometry.location.lat().toFixed(6) + '<br> Longitud: ' + results[0].geometry.location.lng().toFixed(6)
        });
        infowindow.open(map, marker)
      }
      // Se detallan los diferentes tipos de error
      else {
        //alert('Geocode no tuvo éxito por la siguiente razón: ' + status)
      }
    })
  }
	 
  //google.maps.event.addDomListener(window, 'load', inicio);


function listar(){
	$.post("../controlador/convergeopostal.php?op=listar",{}, function(data){	
		data = JSON.parse(data);	
		var a=1;
		
		var latitudlongitud="";
		var id_estudiante="";
		
		while(a < data.length){
			latitudlongitud=data[a]['0'];
			id_estudiante=data[a]['1'];
			inicio();
			codeAddress(id_estudiante,latitudlongitud);
			a++;
		}
		
			$("#resultado").html(data.length);
			$("#precarga").hide();
		
		
	});

}

function actualizar(id_estudiante,cod_postal){

	$.post("../controlador/convergeopostal.php?op=actualizar",{id_estudiante:id_estudiante,cod_postal:cod_postal}, function(data){
		
	});
	
}

listar();



