
var id_estudiante = "[";
var direccioncliente="[";

function listar(){
	$("#precarga").hide();
	$.post("../controlador/convergeo.php?op=listar",{}, function(data){

		data = JSON.parse(data);
		$("#resultado").html(data);
		
		var a=1;
		while(a < data.length){
			if((a+1) >= data.length){
				id_estudiante += `"`+data[a]['0']+`"`;
				direccioncliente += `"`+data[a]['1']+`"`;
			}else{
				id_estudiante += `"`+data[a]['0']+`",`;
				direccioncliente += `"`+data[a]['1']+`",`;
				
			}
						
			a++;
			
			
		}
		id_estudiante += "]";
		direccioncliente +="]";
		
		
		id_estudiante =JSON.parse(id_estudiante);		
		direccioncliente =JSON.parse(direccioncliente);	

		console.log(direccioncliente);
		
		
		for(i=0; i<id_estudiante.length; i++){
			

			geocode(id_estudiante[i],direccioncliente[i]);
	
		}

	});

}

function demo(id_usuario,direccion){
	alert(direccion);
	$.post("../controlador/convergeo.php?op=actualizar",{id_usuario:id_usuario,direccion:direccion}, function(data){
		
	});
	
}
    
listar();


function geocode(id_estudiante,direccion){
      // Prevent actual submit
   

     var location = direccion;
	var lat="";
	var lng="";
      axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
        params:{
          address:location,
          key:'AIzaSyD-9GbQKtTGVtTsUJiUfMwFfbsB0hN8UGw'
        }
      })
      .then(function(response){
        // Log full response
        console.log(response);

        // Formatted Address
        var formattedAddress = response.data.results[0].formatted_address;
        var formattedAddressOutput = `
          <ul class="list-group">
            <li class="list-group-item">${formattedAddress}</li>
          </ul>
        `;

        // Address Components
        var addressComponents = response.data.results[0].address_components;
        var addressComponentsOutput = '<ul class="list-group">';
        for(var i = 0;i < addressComponents.length;i++){
          addressComponentsOutput += `
            <li class="list-group-item"><strong>${addressComponents[i].types[0]}</strong>: ${addressComponents[i].long_name}</li>
          `;
        }
        addressComponentsOutput += '</ul>';

        // Geometry
        lat = response.data.results[0].geometry.location.lat;
        lng = response.data.results[0].geometry.location.lng;
        var geometryOutput = `
          <ul class="list-group">
            <li class="list-group-item"><strong>Latitude</strong>: ${lat}</li>
            <li class="list-group-item"><strong>Longitude</strong>: ${lng}</li>
          </ul>
        `;
		  
		  
		 $.post("../controlador/convergeo.php?op=actualizar",{id_estudiante:id_estudiante,lat:lat,lng:lng}, function(data){
		console.log(data);
	}); 
		  

        // Output to app
        document.getElementById('formatted-address').innerHTML = formattedAddressOutput;
        document.getElementById('address-components').innerHTML = addressComponentsOutput;
        document.getElementById('geometry').innerHTML = geometryOutput;
      })
      .catch(function(error){
        console.log(error);
      });
	
	
	
	
    }

