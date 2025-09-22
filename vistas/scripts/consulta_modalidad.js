// JavaScript Document
$(document).ready(init);
//definimos la variable la tabla
var tabla;
var colaborador="";
//primera funcion que se ejecut cuando el documento esta listo 
function init(){
    $("#precarga").hide();
    cargarPeriodo();

    //listar_atrasados(); //listar todos los atrasados
}
//Cargamos los items de los selects
function cargarPeriodo() {
    $.post("../controlador/consulta_modalidad.php?op=selectPeriodo", function (r) {
        //console.log(r);
        $("#periodo").html(r);
        $('#periodo').selectpicker('refresh');
    });
}

$.post("../controlador/consulta_modalidad.php?op=periodo", function(data){
    data = JSON.parse(data);
    $("#precarga").show();
    listar_modalidad(data.periodo);

});	

//Función Listar
function listar_modalidad(periodo){
    $("#dato_periodo").html("Modalidad " + periodo);
    $.post("../controlador/consulta_modalidad.php?op=selectDatos", function (data) {
        data = JSON.parse(data);
        this.colaborador=data["0"]; 

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
                    messageTop: '<div style="width:50%;float:left"><b>Colaborador:</b>'+this.colaborador +'<b><br><b>Reporte:</b> Materias matriculadas <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
                    title: 'Modalidades',
                     titleAttr: 'Print'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/consulta_modalidad.php?op=listarModalidad',
                        type : "POST",
                        data: {"periodo": periodo},
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            
                "bDestroy": true,
                "iDisplayLength": 10,//Paginación
                "order": [[ 1, "asc" ]],
                'initComplete': function (settings, json) {
                    $("#precarga").hide();

                    
                   

                    
                },
    
            
            
    
    
          });
        
    
    });
      
        
}


