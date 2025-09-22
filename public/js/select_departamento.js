document.addEventListener('DOMContentLoaded', function(){

    var selectDepartamentoB = document.querySelector('#select-departamento');

    selectDepartamentoB.addEventListener('change',function(){
        var id = selectDepartamentoB.value;
        if(id){
            cargarCiudades(id);
			
        }
    })
})

function cargarCiudades(id){
 
 if(id){
        $.post("../controlador/obtener_municipios.php",{departamento : id}, function(respuesta)
		{
			
				$('#select-ciudad').html(respuesta);
				$('#select-ciudad').selectpicker('refresh');
		
		})
    }

}