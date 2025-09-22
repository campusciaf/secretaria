function init(){
$("#precarga").hide();
}

function generar_reporte(){
    limpiarPantalla();
    var opcion = $("#snies").val();
    if (opcion == "Inscritos - Relación de Inscritos") {
        $("#datos_inscritos_relacion").removeAttr("hidden");
        $('#inscritos_relacion').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			  "scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
				
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    } else if (opcion == "Inscrito Programa") {
        $("#datos_inscritos_programa").removeAttr("hidden");
        $('#inscritos_programa').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			"scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
                
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    } else if (opcion == "Admitidos") {
        $("#datos_admitidos").removeAttr("hidden");
        $('#admitidos').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			"scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
                
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    } else if (opcion == "Participante") {
        $("#datos_participante").removeAttr("hidden");
        $('#participante').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			"scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
              
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    } else if (opcion == "Estudiantes de primer curso") {
        $("#datos_primer_curso").removeAttr("hidden");
        $('#primer_curso').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			"scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
               
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    } else if (opcion == "Matriculados") {
        $("#datos_matriculados").removeAttr("hidden");
        $('#matriculados').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			"scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
               
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    } else if (opcion == "Materias Matriculado") {
        $("#datos_materias_matriculado").removeAttr("hidden");
        $('#materias_matriculado').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			"scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
               
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    } else if (opcion == "Graduados") {
        $("#datos_graduados").removeAttr("hidden");
        $('#graduados').DataTable({
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
			"scrollX": true,
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
               
			
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    targets: 0
                }],
                buttons: [
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fa fa-file-excel fa-2x" style="color: green"></i>',
                    titleAttr: 'Excel'
                },
    
            ],
            "ajax":
                    {
                        url: '../controlador/reporte_snies.php?op=generarReporte&opcion='+opcion,
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
    }
}

function limpiarPantalla(){
    $("#datos_inscritos_relacion").attr("hidden",true);
    $("#datos_inscritos_programa").attr("hidden",true);
    $("#datos_admitidos").attr("hidden",true);
    $("#datos_participante").attr("hidden",true);
    $("#datos_primer_curso").attr("hidden",true);
    $("#datos_matriculados").attr("hidden",true);
    $("datos_materias_matriculado").attr("hidden",true);
    $("datos_graduados").attr("hidden",true);
}

init();