$(document).ready(inicio);
    function inicio() {
        listarClaves();
        $(".guardarDatos").on("submit", function (e) {
            agregarClave(e);
        });

        $("#formularioeditarplataforma").on("submit",function(e1){
            guardaryeditarplataforma(e1);	
            
        });
        
}

//Función Listar
function listarClaves(){

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
                        url: '../controlador/clavesgestion.php?op=listarClaves',
                        type : "POST",
                        data: {},
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



function agregarClave(e) {
    $("#precarga").removeClass('hide');
    e.preventDefault();
    var formData = new FormData($("#form2")[0]);
    $.ajax({
        type: "POST",
        url: "../controlador/clavesgestion.php?op=agregar",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var r = JSON.parse(datos);
            if (r.conte == "1") {
                alertify.success("Dato registrado con exito");
                listarClaves();
                $("#precarga").addClass('hide');
                $("#form2")[0].reset();
                $("#exampleModal").modal("hide");
            } else {
                $("#precarga").addClass('hide');
                alertify.error('plataforma no registrada');
            }
        }
    });

}

function eliminarPlataforma(id) {
    alertify.confirm('Eliminar plataforma', 'Desea eliminar el registro', function () {

        $.post("../controlador/clavesgestion.php?op=eliminar", { id: id }, function (data, status) {
            var r = JSON.parse(data);
            if (r.conte == "1") {
                alertify.success('Plataforma eliminada con exito. ');
                listarClaves();
            } else {
                alertify.error("Error");
            }
        });
    }, function () { alertify.error('Cancel'); $("#form2")[0].reset(); });
}

function estado(id,est) {

    var e = "";
    var a = "";

    if (est == "1") {
        e = "Activado";
        a = "Activar";
    } else {
        e = "Descativado";
        a = "Desactivar";
    }
    alertify.confirm('Cambio de estado', function () {
        $.post("../controlador/clavesgestion.php?op=estado", { id: id, est:est }, function (data) {
            console.log(data);
            var r = JSON.parse(data);
            if (r.conte == "1") {
                alertify.success('Cambio ok');
                listarClaves();
				 
            } else {
                alertify.error("error");
            }
        });
    }, function () { alertify.error('Cancel');});
}




function mostrarplataforma(id_clave){
	$.post("../controlador/clavesgestion.php?op=mostrarplataforma",{"id_clave" : id_clave},function(data){
		// console.log(data);
		data = JSON.parse(data);
			if(Object.keys(data).length > 0){
            $("#ModalEditarPlataforma").modal("show");
			$("#id_clave").val(data.id_clave);
			$("#clave_plataforma_m").val(data.clave_plataforma);
			$("#clave_url_m").val(data.clave_url);
			$("#clave_usuario_m").val(data.clave_usuario);
            $("#clave_contrasena_m").val(data.clave_contrasena);
            $("#clave_descripcion_m").val(data.clave_descripcion);
			
		}
	});
}




function guardaryeditarplataforma(e1){
	e1.preventDefault(); //No se activará la acción predeterminada del evento
	var formData = new FormData($("#formularioeditarplataforma")[0]);
	$.ajax({
		"url": "../controlador/clavesgestion.php?op=guardaryeditarplataforma",
		"type": "POST",
		"data": formData,
		"contentType": false,
		"processData": false,
		success: function(datos){ 
            var r = JSON.parse(datos);
            console.log(datos);
            if (r.conte == "1") {
                alertify.success("Dato actualizado con exito");
                listarClaves();
                $("#formularioeditarplataforma")[0].reset();
                $("#ModalEditarPlataforma").modal("hide");
            } else {
                $("#precarga").addClass('hide');
                alertify.error('error');
            }
			
		}
	});
}
