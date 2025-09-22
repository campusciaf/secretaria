var tabla;
var indice=0;
//Función que se ejecuta al inicio
function init(){
    
	mostrarform(false);		
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	$("#formulariodata").on("submit",function(e2)
	{
		guardardata(e2);	
	});

	aceptoData();



    
//	$.post("../controlador/caracterizacion.php?op=selectTipoPregunta", function(r){
//	            $("#tipo_pregunta").html(r);
//	            $('#tipo_pregunta').selectpicker('refresh');
//	});	

	
}

function iniciarTour(){
	introJs().setOptions({
		nextLabel: 'Siguiente',
		prevLabel: 'Anterior',
		doneLabel: 'Terminar',
		showBullets:false,
		showProgress:true,
		showStepNumbers:true,
		steps: [ 
			{
				title: 'Caracterización',
				intro: 'Bienvenido a nuestra caracterización donde podrás tener la oportunidad de contarnos con mayor profundidad quién eres y asi conocer por completo a nuestro ser original que dio el gran paso de formar parte de el parche más creativo'
			},
			{
				title: 'Categoria',
				element: document.querySelector('#t-pasoC'),
				intro: "Aquí podrás encontrar diferentes categorías que tenemos para ti"
			},
			{
				title: 'Estado',
				element: document.querySelector('#t-pasoE'),
				intro: "Para verificar que ya hayas hecho tu caracterización puedes observar en esta casilla si estas o no caracterizado en tus respectivas categorías"
			},

	       {
				title: 'Seres originales',
				element: document.querySelector('#t-paso0'),
				intro: "Como ya haces parte de nosotros,solo te falta un pequeño paso que seas todo un ser original y podrás estar rodeado de todos los beneficios que como institución tenemos para ti "
			},
			{
				title: 'Empezar',
				element: document.querySelector('#t-pasoB'),
				intro: "En un solo click puedes contarnos acerca de ti, para hacer que tu paso por nuestra institución sea cada ves más mágico,único y personalizado"
			},

			{
				title: 'Inspiradores',
				element: document.querySelector('#t-paso1'),
				intro: "No solo tu eres parte importante de nosotros, las personas que amas y que consideras como tu hogar también pueden sumarce a nuestro parche mejor llamados inspiradores, aquellas personas que te impulsan a culminar esta gran etapa y te apoyan en cada paso de tu vida por eso queremos reforzar aquellos lazos con diferentes actividades que los involucren a ellos y a ti"
			},
			{
				title: 'Empresas amigas y spin-off',
				element: document.querySelector('#t-paso2'),
				intro: "Contamos con diferentes aliados que nos ayudan a formar una experiencia diferente para ti, conoce todos los beneficios que tenemos para ti"
			},
			{
				title: 'Confiamos',
				element: document.querySelector('#t-paso3'),
				intro: "Como ya haces parte de nuestra increíble familia tenemos depositada una enorme confianza en ti,ayudanos a cuidar este lazo que nos une"
			},
			{
				title: 'Experiencia académica',
				element: document.querySelector('#t-paso4'),
				intro: "¡Vive el magico momento de cada una de tus experiencias creativas!"
			},

		    {
				title: 'Modelo de bienestar',
				element: document.querySelector('#t-paso5'),
				intro: "Tendrás la oportunidad de entretenimiento no solo en tus experiencias craetivas, si no también fuera de ellas "
			},

			{
				title: 'Emprendimiento',
				element: document.querySelector('#t-paso7'),
				intro: "Si cuentas con un emprendimiento para nosotros es de suma importancia apoyarte en todos los aspectos por eso nos encantaría conocer más sobre ello y entablar un entorno de apoyo y confianza"
			},
			
		]
			
	},
	console.log()
	
	).start();

}

//Función limpiar
function limpiar(){
	$("#id_categoria").val("");	
	$("#id_tipo_pregunta").val("");
	$("#variable").val("");
    $("#obligatorio_no").prop('checked', false);
    $("#obligatorio_si").prop('checked', true);

	
}

//Función mostrar formulario
function mostrarform(flag){
	//limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#botones").hide();
        
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
        $("#botones").show();

       
     
	
	}
}

//Función cancelarform
function cancelarform(){
	limpiar();
	mostrarform(false);
}


function aceptoData()
{
    	$.post("../controlador/caracterizacion.php?op=aceptoData", function(data){
			
                data = JSON.parse(data);
				if(data == false){
					$("#myModalAcepto").modal("show");
				   
				   }else{
					   $("#myModalAcepto").modal("hide");
					   listarBotones();
				   }
			
	    
        
	});
}


function listarBotones()
{
    	$.post("../controlador/caracterizacion.php?op=listarbotones", function(data){	
                data = JSON.parse(data);
	            $("#botones").html("");
                $("#botones").append(data["0"]["0"]);
				$("#precarga").hide();
        
	});
}
    
    
function listar(id_categoria){
	$("#precarga").show();
   
        $.post("../controlador/caracterizacion.php?op=listar",{id_categoria : id_categoria, indice:indice}, function(data, status)
        {

            data = JSON.parse(data);
            
            if(data["0"]["1"]==1){
                indice=0;
                mostrarform(false);
                
				insertardatosfinales(id_categoria);
				listarBotones();
				
                
            }else{
                mostrarform(true);
                $("#preguntas").html("");
                $("#preguntas").append(data["0"]["0"]);
                indice++;
				$("#precarga").hide();
            }

        });

}



function mostrar(id_programa)
{
	$.post("../controlador/caracterizacion.php?op=mostrar",{id_programa : id_programa}, function(data, status)
	{
		
		data = JSON.parse(data);	
		mostrarform(true);
		
		$("#nombre").val(data.nombre);		
		$("#cod_programa_pea").val(data.cod_programa_pea);		
		$("#ciclo").val(data.ciclo);
		$("#cod_snies").val(data.cod_snies);
		$("#cant_asignaturas").val(data.cant_asignaturas);
		$("#semestres").val(data.semestres);
		$("#cortes").val(data.cortes);
		$("#inicio_semestre").val(data.inicio_semestre);		
		$("#escuela").val(data.escuela);
		$("#escuela").selectpicker('refresh');
		$("#original").val(data.original);
		$("#estado").val(data.estado);
		$("#estado").selectpicker('estado');
		$("#id_programa").val(data.id_programa);


 	});
	
}

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/caracterizacion.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
		
			 datos = JSON.parse(datos);
	          alertify.success(datos["0"]["0"]);  
              listar(datos["0"]["1"]);
			
//	          mostrarform(false);
//	          tabla.ajax.reload();
			
	    }

	});
	limpiar();
}


function guardardata(e2)
{
	e2.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnData").prop("disabled",true);
	var formData = new FormData($("#formulariodata")[0]);

	$.ajax({
		url: "../controlador/caracterizacion.php?op=guardardata",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
		
	          alertify.success(datos);
				$("#myModalAcepto").modal("hide");
			listarBotones();
//	          mostrarform(false);
//	          tabla.ajax.reload();
			
	    }

	});
	limpiar();
}


    
function insertardatosfinales(id_categoria)
{

		$("#precarga").show();
        $.post("../controlador/caracterizacion.php?op=insertardatosfinales",{id_categoria : id_categoria}, function(data, status)
        {

            data = JSON.parse(data);
			$("#precarga").hide();

        });

}
	

init();