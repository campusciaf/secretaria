$(document).ready(incio);
function incio(){
    $("#precarga").hide();
    listar_colaboradores();

    const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Meses de 0 a 11, por eso se suma 1
        const dd = String(today.getDate()).padStart(2, '0');

        // Formato YYYY-MM-DD para los campos tipo date
        const formattedDate = `${yyyy}-${mm}-${dd}`;


    fecha = $("#fecha_ingreso").val(formattedDate);
}


//lista los periodos existen en el sistema
function listar_colaboradores() {
    $.post("../controlador/ingreso_campus_colaborador.php?op=listarColaboradores", function (data, status) {
        $("#colaboradores").html(data);
	    $('#colaboradores').selectpicker('refresh');

    });
}

//Función Listar
function listar(){
    $("#precarga").show();
	id_usuario = $("#colaboradores").val();
    fecha = $("#fecha_ingreso").val();

    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f=new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	
	
	tabla=$('#tbllistado').dataTable({
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
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Faltas',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/ingreso_campus_colaborador.php?op=listar',
                    type: "POST", // Cambia el método a POST
                    data: {
                        id_usuario: id_usuario, // Envía fechaini
                        fecha: fecha  // Envía fechafin
                    },
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
		
}

function sinIngresos(){
    $("#precarga").show();
    fecha= $("#fecha_ingreso").val();
    $.post("../controlador/ingreso_campus_colaborador.php?op=sinIngresos",{fecha:fecha}, function (data, status) {
        r = JSON.parse(data);            
        $("#exampleModal").modal("show");
        $("#resutados").html(r.datos);
        $("#precarga").hide();
    });

    
    
}

