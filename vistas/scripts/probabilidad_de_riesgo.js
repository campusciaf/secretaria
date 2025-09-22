$(document).ready(inicio);
function inicio() {
    $("#precarga").hide();
    // traemos los periodos
    // $.post("../controlador/probabilidad_de_riesgo.php?op=selectlistaranios", function (respuesta) {
    //     $("#periodo_probabilidad").html(respuesta);
    //     $('#periodo_probabilidad').selectpicker('refresh');
    // });
}
function MostrarResultado(dato_seleccionado) {
    $(".btn-nivel").removeClass("active");
    // activamos el boton seleccionado.
    $(dato_seleccionado).addClass("active");
    // obtener el valor del data-nivel
    var val_boton_seleccionado = $(dato_seleccionado).data('nivel'); 
    //  let periodoSeleccionado = $("#periodo_sac").val(); 
	var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	var diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
	var f = new Date();
	var fecha_hoy = (diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
	tabla = $('#tbllistaprobabilidad').dataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: [
			{
				extend: 'excelHtml5',
				text: '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
				titleAttr: 'Excel'
			},
			{
				extend: 'print',
				text: '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
				messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> ' + fecha_hoy + ' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Ejes',
				titleAttr: 'Print'
			},
		],
		"ajax": {
            url: '../controlador/probabilidad_de_riesgo.php?op=buscar_por_porcentaje',
            type: "POST",
            dataType: "json",
            data: { val_boton_seleccionado: val_boton_seleccionado },
            error: function (e) { 
                // console.log(e); 
            }
        },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
		"order": [[0, "asc"]],//Ordenar (columna,orden)
		'initComplete': function (settings, json) {
			$("#precarga").hide();
			scroll(0,0);
		},
	});

}
