$(document).ready(incio);
function incio() {
    $("#precarga").hide();
    $("#muestreo1").hide();
    $("#muestreo2").hide();
    
    cargarperiodo();
    cargarprogramas();
    cargarjornadas();
    totalestudiantes();// contiene los estudiantes por programa
   
    // grafico3();
    grafico2();// cantidad de matriculas
    grafico4();


}
function configurar(){
    $("#configacademico").modal("show");
}
function buscar(){
   totalestudiantes();
}

//Cargamos los items de los selects
function  cargarperiodo(){
    $.post("../controlador/panelacademico.php?op=selectPeriodo", function(r){
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
    });

}

//Cargamos los items de los selects
function cargarprogramas(){
    $.post("../controlador/panelacademico.php?op=selectPrograma", function(r){
        $("#programa").html(r);
        $('#programa').selectpicker('refresh');
    });

}
//Cargamos los items de los selects contrato
function cargarjornadas(){
    $.post("../controlador/panelacademico.php?op=selectJornada", function(r){
        $("#jornada").html(r);
        $('#jornada').selectpicker('refresh');
    });
}


//Cargamos los items de los selects contrato
function totalestudiantes(){
    var periodo=$("#periodo").val();
    var nivel=$("#nivel").val();
    var escuela=$("#escuela").val();
    var programa=$("#programa").val();
    var jornada=$("#jornada").val();
    var semestre=$("#semestre").val();



    if(periodo==null){
        $.post("../controlador/panelacademico.php?op=traerPeriodo", function(r){
           periodo=r;
           
           grafico(periodo,nivel,escuela,programa,jornada,semestre);
           //grafico3();
       
           $.post("../controlador/panelacademico.php?op=totalestudiantes",{periodo:periodo, nivel:nivel , escuela:escuela , programa:programa , jornada:jornada , semestre:semestre}, function(r){
               var e = JSON.parse(r);
               $("#totalestudiantes").html(e.totalestudiantes);
         
           });

        });
    }else{
        grafico(periodo,nivel,escuela,programa,jornada,semestre);
        //grafico3();
    
        $.post("../controlador/panelacademico.php?op=totalestudiantes",{periodo : periodo, nivel:nivel, escuela:escuela, programa:programa , jornada:jornada , semestre:semestre}, function(r){
            var e = JSON.parse(r);
            $("#totalestudiantes").html(e.totalestudiantes);
        });
    }
    
    
    
   
}


function grafico(periodo,nivel,escuela,programa,jornada,semestre){

    $("#muestreo1").show();


    

    $.post("../controlador/panelacademico.php?op=grafico",{periodo : periodo , nivel : nivel , escuela : escuela , programa : programa ,jornada : jornada , semestre : semestre}, function(r){



        r = JSON.parse(r);
        console.log(r);
     
        var datos = new Array();
        datos.push(r.datosuno);
        datos=JSON.parse(datos);
 

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            title:{
                text: "Estudiantes por programa",
                horizontalAlign: "left",
                fontColor: "#fff",
                fontSize: 16,
                padding: 10,
                margin: 20,
                backgroundColor: "#015486",
                borderThickness: 1,
                cornerRadius: 5,
                fontWeight: "bold"
            },
            theme: "light2",
            axisX:{
                interval: 1,
                labelFontSize: 11,
            },
            axisY:{
                labelFontSize: 10,
                includeZero: false
            },
            axisY2:{
                labelFontSize: 10,
                interlacedColor: "rgba(1,77,101,.2)",
                gridColor: "rgba(1,77,101,.1)"
            },
            data: [{
                indexLabelTextAlign: "center",
                type: "bar",
                name: "Activos",
                axisYType: "secondary",
                color: "#7CAC3B",
                dataPoints: datos
            }]
        });
        chart.render();


    });


}

function grafico2(){

    $.post("../controlador/panelacademico.php?op=grafico2", function(r){

    r = JSON.parse(r);

    var datos = new Array();
    datos.push(r.datosuno);
    datos=JSON.parse(datos);
    


var chart = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
    exportEnabled: true,
    title:{
        text: "Cantidad de matriculas",
        horizontalAlign: "left",
        fontColor: "#fff",
        fontSize: 16,
        padding: 10,
        margin: 20,
        backgroundColor: "#015486",
        borderThickness: 1,
        cornerRadius: 5,
        fontWeight: "bold"
    },
	theme: "light2",
	axisY:{
        labelFontSize: 10,
		includeZero: false
	},
    axisX: {
        labelFontSize: 12,
        labelAngle: -30
    },
	data: [{        
        indexLabelFontSize: 10,
        type: "line",  
		dataPoints: datos
	}]
});

chart.render();
});	

}

function grafico3(){
    
    $("#muestreo2").show();
    var periodo=$("#periodo").val();

    
    $.post("../controlador/panelacademico.php?op=grafico3",{periodo : periodo}, function(r){



        r = JSON.parse(r);
     
        var datos = new Array();
        datos.push(r.datosuno);
        datos=JSON.parse(datos);
 


        var chart = new CanvasJS.Chart("chartContainer3", {
            animationEnabled: true,
            exportEnabled: true,
            title:{
                text: "Estudiantes por nivel",
                horizontalAlign: "left",
                fontColor: "#fff",
                fontSize: 16,
                padding: 10,
                margin: 20,
                backgroundColor: "#015486",
                borderThickness: 1,
                cornerRadius: 5,
                fontWeight: "bold"
            },
            theme: "light2",
            data: [{
                type: "doughnut",
                startAngle: 60,
                //innerRadius: 60,
                indexLabelFontSize: 17,
                indexLabel: "{label} - #percent%",
                toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                dataPoints: datos
            }]
        });
        chart.render();
            
    });

}

function grafico4(){
   

    $.post("../controlador/panelacademico.php?op=grafico4", function(r){

    r = JSON.parse(r);

    var datos = new Array();
    datos.push(r.datosuno);
    datos=JSON.parse(datos);
    


var chart = new CanvasJS.Chart("chartContainer4", {
	animationEnabled: true,
    exportEnabled: true,
    
    title:{
        text: "Estudiantes activos unicos",
        horizontalAlign: "left",
        fontColor: "#fff",
        fontSize: 16,
        padding: 10,
        margin: 20,
        backgroundColor: "#015486",
        borderThickness: 1,
        cornerRadius: 5,
        fontWeight: "bold"
    },
    theme: "light2",
	axisY:{
        labelFontSize: 10,
		includeZero: false
	},
    axisX: {
        labelFontSize: 12,
        labelAngle: -30
    },
	data: [{        
        indexLabelFontSize: 10,
        type: "line",  
		dataPoints: datos
	}]
});

chart.render();
});	

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
				title: 'Panel Académico',
				intro: "Bienvenido a nuestra gestión de panel académico visualiza la información de una maenra general"
			},
		
		
			
		]
			
	},
	console.log()
	
	).start();

}


