$(document).ready(inicio);
function inicio() {
   $("#precarga").hide(); 
}
function consulta(estado) {
    $("#precarga").show();
    $.post('../controlador/datosactualizados.php?op=consulta',{estado:estado}, function (data) {

        var r = JSON.parse(data);
        $('#resultado').html(r.conte);

        var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
        var f=new Date();
        var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());


        $("#dtl_consulta").DataTable({
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
					messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> Estudiantes <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
					title: 'Datos Actualizados',
					 titleAttr: 'Print'
				},
	
			],
            'initComplete': function (settings,json) {
                $("#precarga").hide();
            },
        });
    });
}