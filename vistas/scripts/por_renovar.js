function init(){
	listarescuelas();
	// listar(0);
	
}


function listarescuelas(){
    
	$.post("../controlador/por_renovar.php?op=listarescuelas",{}, function(r){
		var e = JSON.parse(r);
		$("#escuelas").html(e.mostrar);
		$("#precarga").hide();
		
	});
}




function listar(id_escuela){


    
  const COLS_MULTI = [3, 4, 6, 8];
  const multi = {};

	$("#precarga").show();
	// var id_programa = $("#selector_programa").val();
	// var semestre = $("#selector_semestres").val();
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
    var f = new Date();
    var fecha_hoy=(diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
    tabla = $('#tblrenovar').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "dom": 'Bfrtip',//Definimos los elementos del control de tabla
        "buttons": [{
                "extend":    'excelHtml5',
                "text":      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                "titleAttr": 'Excel'
            },{
                "extend": 'print',
                "text": '<i class="fas fa-print fa-2x" style="color: #ff9900"></i>',
                "messageTop": '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				"title" : 'Docentes',
                "titleAttr": 'Print'
            }],
		"ajax":{
            "url": '../controlador/por_renovar.php?op=listar&id_escuela='+id_escuela,
            "type" : "get",
            "dataType" : "json",						
            "error" : function(e){
                console.log(e.responseText);	
            }
        },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)
        'initComplete': function (settings, json) {
            const api = this.api();

            api.columns().every(function (idx) {
                if (!COLS_MULTI.includes(idx)) return;

                const col = this;
                const $th = $(col.header());

                // Guarda el título original antes de vaciar
                const title = $th.data('title') || $th.text().trim();
                $th.data('title', title); // por si DataTables re-renderiza

                // Estructura: título arriba, select abajo
                const $wrap = $(`
                <div class="th-filter">
                    <div class="th-title">${title}</div>
                    <select multiple class="dt-multi"></select>
                </div>
                `);

                $th.empty().append($wrap);

                const $select = $wrap.find('select');

                // poblar opciones únicas
                col.data().unique().sort().each(function (d) {
                $select.append(`<option value="${d}">${d}</option>`);
                });

                // inicializar Select2 (si lo usas)
                $select.select2({
                placeholder: "Filtrar...",
                width: 'resolve',
                closeOnSelect: false,
                allowClear: true,
                dropdownParent: $(document.body)
                });

                // evento change
                $select.on('change', function () {
                const vals = $(this).val() || [];
                multi[idx] = vals;
                const rx = vals.length ? '^(' + vals.map(v => $.fn.dataTable.util.escapeRegex(v)).join('|') + ')$' : '';
                col.search(rx, true, false).draw();
                });

            });

            $("#precarga").hide();
        },


	}).DataTable();
}

init();