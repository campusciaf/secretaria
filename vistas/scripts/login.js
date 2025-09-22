function init2(){

	$("#precarga").hide();
	$("#formularioenviarlink").on("submit",function(e)
	{
		enviarlink(e);	
	});
	mostrar_imagen_banner();


	//formulario que envia el correo ayuda
	$("#formulariosolicitarayuda").on("submit",function(e){
		enviarcorreoayuda(e);	
	});

}
function direccion(usuario){
	if(usuario==1){
		$(location).attr("href","vistas/panel_admin.php");
	}
	if(usuario==2){
		$(location).attr("href","vistas/panel_docente.php");
	}
	if(usuario==3){
		$(location).attr("href","vistas/rematriculafinanciera.php");
	}
	if(usuario==4){// sigue siendo estudiante pero egresado para que lo lleve al perfil de egresado
		$(location).attr("href","vistas/egresadoperfil.php");
	}

}
$("#frmAcceso").on('submit',function(e)
{
	e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();
	roll=$("#roll").val();


    $.post("controlador/usuario.php?op=verificar",
        {"logina":logina,"clavea":clavea,"roll":roll},
        function(data){
			let respuesta = JSON.parse(data);
			if(roll=="Funcionario"){
					if (data.trim() != 1)			
					{  
						$("#precarga").show();
						ingreso(roll);
						
						setInterval("direccion(1)",1500);
						Swal.fire({
							position: "top-end",
							icon: "success",
							title: "Ingreso seguro",
							showConfirmButton: false,
							timer: 1500
						  });
						
					}
					else
					{
						Swal.fire({
							position: "top-center",
							icon: "warning",
							title: "Usuario y contraseña incorrectos",
							showConfirmButton: false,
							timer: 1500
						  });
					
					}
				
			}

			if(roll=="Docente"){
			
				if (data.trim() != 1)			
				{  
					$("#precarga").show();
					ingreso(roll);
					setInterval("direccion(2)",1500);
					Swal.fire({
						position: "top-end",
						icon: "success",
						title: "Ingreso seguro",
						showConfirmButton: false,
						timer: 1500
						});
					
				}
				else
				{
					Swal.fire({
						position: "top-center",
						icon: "warning",
						title: "Usuario y contraseña incorrectos",
						showConfirmButton: false,
						timer: 1500
						});
				}
			}

			if(roll=="Estudiante"){
				if (data.trim() != 1){ 
					egresado=respuesta.egresado 
					$("#precarga").show();
					ingreso(roll);
					if(egresado==0){// si no es egresado
						setInterval("direccion(3)",1500);
						Swal.fire({
							position: "top-end",
							icon: "success",
							title: "Ingreso seguro",
							showConfirmButton: false,
							timer: 1500
						});
					}else{ // si es egresado
						setInterval("direccion(4)",1500);
						Swal.fire({
							position: "top-end",
							icon: "success",
							title: "Ingreso seguro",
							showConfirmButton: false,
							timer: 1500
						});

					}
					
					
					
				}
				else
				{
					Swal.fire({
						position: "top-center",
						icon: "warning",
						title: "Usuario y contraseña incorrectos",
						showConfirmButton: false,
						timer: 1500
						});
				}
			}
		
		
		
    });
});

function ingreso(roll){
	$.post("controlador/usuario.php?op=ingreso",{"roll":roll},
        function(data){

		 });
		
}
//Función para enviarlink de la contraseña

function enviarlink(e)
{
	$("#precarga").show();
	e.preventDefault(); //No se activará la acción predeterminada del evento
	
	$("#myModal").modal("hide");
	var formData = new FormData($("#formularioenviarlink")[0]);

	$.ajax({
		url: "controlador/usuario.php?op=enviarlink",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(data)
	    {   
			data = JSON.parse(data);
			if(data["0"]["1"]==1){
				$("#precarga").hide();	
			}
			Swal.fire({
				position: "top-center",
				icon: "success",
				title: data["0"]["0"],
				showConfirmButton: false,
				timer: 1500
			  });

 
				$("#precarga").hide();        
				$("#email_link").val("");
			
	    }

	});
}




//Función lista los ejes estrategicos  
function mostrar_imagen_banner(){

	$.post("controlador/usuario.php?op=imagen_banner_campus",{},function(data){
		// console.log(data);
		data = JSON.parse(data);
		$(".lado-a-mostrar-banner").show();
		$(".lado-a-mostrar-banner").html(data);
	});
}



function mostrarmodalsolicitarayuda(e)
{
	
	$("#myModalSolicitarAyuda").modal("show");

	
}


//Función guardo y edito el nombre del proyecto
function enviarcorreoayuda(e){
	e.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formulariosolicitarayuda")[0]);
	$.ajax({
		"url": "controlador/usuario.php?op=enviarcorreoayuda",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
			console.log(datos);
			datos=JSON.parse(datos);
			if(datos.exito==1){
				
				Swal.fire({
					position: "top-end",
					icon: "success",
					title: datos.info,
					showConfirmButton: false,
					timer: 1500
				});

				$("#myModalSolicitarAyuda").modal("hide");
				$("#formulariosolicitarayuda")[0].reset();
			}else{	
				
				Swal.fire({
					position: "top-end",
					icon: "warning",
					title: datos.info,
					showConfirmButton: false,
					timer: 1500
				});
				
			}

		}
	});
}


  

init2();