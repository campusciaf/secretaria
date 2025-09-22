$(document).ready(incio);

function incio() {
    $("#precarga").hide();
    cargarperiodo();
    cargarjornadas();
    cargarprograma(0,0);
    buscar();
}

function  cargarperiodo(){

  $.post("../controlador/poblacionestudiantil.php?op=selectPeriodo", function(r){
    $("#periodo").html(r);
    $('#periodo').selectpicker('refresh');
    
  });

}

//Cargamos los items de los selects contrato
function cargarjornadas(){
  $.post("../controlador/poblacionestudiantil.php?op=selectJornada", function(r){
      $("#jornada").html(r);
      $('#jornada').selectpicker('refresh');
  });

}

//Cargamos los items de los selects contrato
function cargarprograma(escuela,nivel){
  $.post("../controlador/poblacionestudiantil.php?op=selectPrograma",{escuela:escuela, nivel:nivel},function(r){
      $("#programa_ac").html(r);
      $('#programa_ac').selectpicker('refresh');
  });

}

function buscar(){

  let periodo=$("#periodo").val();
  let nivel = new Array();
  let escuela = new Array();
  let jornada = new Array();
  let semestre = new Array();
  let programa = new Array();



    select = document.getElementById('escuela');
    for (var i = 0; i < select.options.length; i++) {
      o = select.options[i];
      if (o.selected == true) {
        escuela.push(o.value);
      }
    }

    if(escuela.length == 0){
      escuela=0;
    }else{
      escuela;
    }

    select1 = document.getElementById('nivel');
    for (var i = 0; i < select1.options.length; i++) {
      o = select1.options[i];
      if (o.selected == true) {
        nivel.push(o.value);
      }
    }


    if(nivel.length == 0){
      nivel=0;
    }else{
      nivel;
    }

    select2 = document.getElementById('jornada');
    for (var i = 0; i < select2.options.length; i++) {
      o = select2.options[i];
      if (o.selected == true) {
        jornada.push(o.value);
      }
    }

    if(jornada.length == 0){
      jornada=0;
    }else{
      jornada;
    }

    
    select3 = document.getElementById('semestre');
    for (var i = 0; i < select3.options.length; i++) {
      o = select3.options[i];
      if (o.selected == true) {
        semestre.push(o.value);
      }
    }

    if(semestre.length == 0){
      semestre=0;
    }else{
      semestre;
    }

    select4 = document.getElementById('programa_ac');
    for (var i = 0; i < select4.options.length; i++) {
      o = select4.options[i];
      if (o.selected == true) {
        programa.push(o.value);
      }
    }

    if(programa.length == 0){
      programa=0;
    }else{
      programa;
    }
 
    if(programa==0){// solo carga el select mientras no seleccionemos el select programa
      cargarprograma(escuela,nivel);
    }
    

    $.post("../controlador/poblacionestudiantil.php?op=general",{periodo:periodo, escuela:escuela, nivel:nivel, jornada:jornada, semestre:semestre, programa:programa}, function(r){
      var datos = JSON.parse(r);
      $("#activos").html(datos.dtotal);
      var datosgrafico = new Array();
      datosgrafico.push(datos.datosuno);
      datosgrafico=JSON.parse(datosgrafico);
      

      var chart = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
          exportEnabled: false,
          backgroundColor: null,
          theme: "light2", // "light1", "light2", "dark1", "dark2"

        axisY:{
            labelFontSize: 10,
            includeZero: false,
            gridThickness: 0,
            tickLength: 0,
            lineThickness: 0,
        },
          axisX: {
            labelFontSize: 12,
            labelAngle: -30
          },
        data: [{        
            indexLabelFontSize: 10,
            type: "line",  
            dataPoints: datosgrafico
        }]
      });
  
      chart.render();



    });





  
}





