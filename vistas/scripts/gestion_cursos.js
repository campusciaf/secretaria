var tabla;
var hoy = new Date();
hoy = formatDate(hoy);

//Función que se ejecuta al inicio
function init() {
    CKEDITOR.replace('descripcion_curso');
    $("#fecha_inicio").val(hoy);
    $("#fecha_fin").val(hoy);
    $("#fecha_inicio").prop('min', hoy);
    $("#fecha_fin").prop('min', hoy);
    $("#imagenmuestra").hide();
    listar();
    mostrar_form(false);
    //formulario de guardar
    $("#formulario_cursos").on("submit", function (e) {
        e.preventDefault();
        guardaryEditarCurso();
    });
    listarDocentesActivos();
}
function listarDocentesActivos() {
    $.post("../controlador/gestion_cursos.php?op=listarDocentesActivos", function(e) {
        //console.log(e);
        e = JSON.parse(e);
        if (e.exito == "1") {
           $(".listado_docentes").html(e.info);
           $(".listado_docentes").selectpicker();
        }
    });
}
//
function mostrar_form(flag) {
    $("#formulario_cursos")[0].reset();
    if (flag) {
        $("#div_formulario").show();
        $("#listadoregistros").hide();
    } else {
        $("#listadoregistros").show();
        $("#div_formulario").hide();
    }
}
//Dar formato especifico a una fecha
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();
    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;
    return [year, month, day].join('-');
}
//Función Listar

//Función Listar
function listar(){
	
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
                messageTop: '<div style="width:50%;float:left"><b>Asesor:</b>primer campo <b><br><b>Reporte:</b> segundo campo <b><br>Fecha Reporte:</b> '+fecha_hoy+' </div><div style="width:50%;float:left;text-align:right;margin-top:-30px; position:relative"><img src="../public/img/logo_ciaf_web.png" width="200px"><br><br></div>',
				title: 'Continuada',
			 	titleAttr: 'Print'
            },

        ],
		"ajax":
				{
					url: '../controlador/gestion_cursos.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						// console.log(e.responseText);	
					}
				},
		
			"bDestroy": true,
            "iDisplayLength": 10,//Paginación
			"order": [[ 9, "asc" ]],
			'initComplete': function (settings, json) {
				$("#precarga").hide();
			},

      });
		
}


//Convertir la fecha militar a normal
function military_time(time) {
    time = time.split(':'); // convert to array

    // fetch
    var hours = Number(time[0]);
    var minutes = Number(time[1]);
    var seconds = Number(time[2]);

    // calculate
    var timeValue;

    if (hours > 0 && hours <= 12) {
        timeValue = "" + hours;
    } else if (hours > 12) {
        timeValue = "" + (hours - 12);
    } else if (hours == 0) {
        timeValue = "12";
    }

    timeValue += (minutes < 10) ? ":0" + minutes : ":" + minutes;  // get minutes
    timeValue += (seconds < 10) ? ":0" + seconds : ":" + seconds;  // get seconds
    timeValue += (hours >= 12) ? " P.M." : " A.M.";  // get AM/PM

    // show
    return timeValue;
}
//listar funcionarios
function mostrarCurso(id_curso) {
    mostrar_form(true);
    $.ajax({
        "url": "../controlador/gestion_cursos.php?op=mostrarCurso",
        "data": { "id_curso": id_curso },
        "type": "POST",
        "dataType": "json",
        success: function (datos) {
            keys = Object.keys(datos);
            for (var i = 0; i < keys.length; i++) {
                console.log(keys[i]);

                if (keys[i] == "descripcion_curso") {
                    CKEDITOR.instances.descripcion_curso.setData(datos[keys[i]]);
                }
                if (keys[i] == "imagen_curso") {
                    $("#imagenmuestra").show();
                    $("#imagenmuestra").attr("src", "../public/img_educacion/" + datos[keys[i]]);
                    $("#imagenactual").val(datos[keys[i]]);
                }else{
                    $("#" + keys[i]).val(datos[keys[i]]);
                }
            }
            $("#docente_curso").selectpicker("refresh");
        },
        error: function (e) {
            console.log(e.responseText);
        }
    });
}
//Guardar Cursos
function guardaryEditarCurso() {
    var text = CKEDITOR.instances['descripcion_curso'].getData();// captura el valor del editor
    $(".guardar_curso").attr("disabled", true);
    var formData = new FormData($("#formulario_cursos")[0]);
    formData.append("descripcion_curso", text); // enviamos el contenido del editor
    $.ajax({
        "url": "../controlador/gestion_cursos.php?op=guardaryEditarCurso",
        "type": "POST",
        "data": formData,
        "dataType": "json",
        "contentType": false,
        "processData": false,
        success: function (datos) {
            //console.log(datos);
            if (datos.status == "1") {
                $(".guardar_curso").attr("disabled", false);
                swal("Correcto!", datos.valor, "success");
                mostrar_form(false);
            } else {
                swal("Error!", datos.valor, "error");
                $(".guardar_curso").attr("disabled", false);
            }
        }, error: function (e) {
            console.log(e.responseText);
        }
    });
}
//Función para eliminar registros
function eliminarCurso(id_curso) {
    swal({ "title": "¿Está Seguro de eliminar el curso?", "icon": "warning", "buttons": true, "dangerMode": true, })
        .then((willDelete) => {
            if (willDelete) {
                $.post("../controlador/gestion_cursos.php?op=eliminarCurso", { id_curso: id_curso }, function (e) {
                    //console.log(e);
                    e = JSON.parse(e);
                    if (e.status == 1) {
                        swal('Curso Eliminado!', '', 'success')
                        listar();
                    } else {
                        swal('Curso no se puede eliminar!', '', 'error')
                    }
                });
            } else {
                swal('Cancelado', '', 'info')
            }
        });
}
//Función para eliminar registros
function estadoCurso(id_curso, estado) {
    swal({ "title": "¿Está Seguro de cambiar el estado del curso?", "icon": "warning", "buttons": true, "dangerMode": true, })
    .then((willChange) => {
        if (willChange) {
            $.post("../controlador/gestion_cursos.php?op=estadoCurso", { "id_curso": id_curso, "estado_educacion": estado }, function (e) {
                    console.log(e);
                    e = JSON.parse(e);
                    if (e.status == 1) {
                        swal('Cambio Realizado!', '', 'success')
                        listar();
                    } else {
                        swal('Cambio no realizado!', '', 'error')
                    }
                });
            } else {}
        });
}
init();