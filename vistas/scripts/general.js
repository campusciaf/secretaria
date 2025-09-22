var departamento_global;
var valor_global;
function init() {
	listardatos(1); // quiere decir que es el dia de hoy
	listarEscuelas();

	$("#clasesDelDiaModal").on("shown.bs.modal", function (e) {
        $("#clasesDelDia").fullCalendar({
            defaultView: 'agendaDay',
            slotLabelFormat: "h(:mm) a",
            slotDuration: '00:30:00',
            allDaySlot: false,
            locale: "es",
            minTime: "06:00:00",
            maxTime: "23:00:00",
            buttonText: {
                month: "Mes",
                week: "Semana",
                day: "Dia",
            },
            header: {
                left: '',
                center: '',
                right: ''
            },
            /*Enlace para cargar los eventos de la base de datos*/
            events: {
                url: "../controlador/general.php?op=clasesDelDia",
                type: "POST",
                success: function (events) {
                    
                },
            },
        });
        // Corregir el nombre del objeto a renderizar
        $("#clasesDelDia").fullCalendar("render");
    });
}
function listardatos(rango) {
    seleccion_actual = rango;
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();
    var contador = 1;
    while (contador <= 5) {
        $("#opcion" + contador).removeClass("activo");
        contador++;
    }
    $("#opcion" + rango).addClass("activo");

    $.post(
        "../controlador/general.php?op=listardatos&rango=" +
        rango +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
            var r = JSON.parse(e);
            $("#dato_funcionarios").html(r.totalfun);
            $("#dato_docentes").html(r.totaldoc);
            $("#dato_estudiantes").html(r.totalest);
            $("#dato_faltas").html(r.totalfaltas);
            $("#dato_quedate").html(r.totalquedate);
            $("#dato_contactanos").html(r.totalcontactanos);
            $("#dato_caracterizados").html(r.totalcaracterizados);
            $("#dato_actividades").html(r.totalactividades);
            $("#dato_cv").html(r.totalcv);
            $("#dato_perfil").html(r.totalperfil);
            $("#dato_perfildoc").html(r.totalperfildoc);
            $("#dato_perfilest").html(r.totalperfilest);

            $("#precarga").hide();
        }
    );
}

function caracterizados(caracterizados) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();
    $.post(
        "../controlador/general.php?op=caracterizados&caracterizados=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
		
            var r = JSON.parse(e);
            $("#myModalCaracterizados").modal("show");
            $("#datosusuario_caracterizados").html(r);
            $("#precarga").hide();
            $("#mostrarcaracterizados").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function listarrango() {
    $(".chart-loader").show();
    $("#exampleModal").modal("hide");
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    var rango = 5;
    var contador = 1;
    while (contador <= 5) {
        $("#opcion" + contador).removeClass("activo");
        contador++;
    }
    $("#opcion" + rango).addClass("activo");
    $.post(
        "../controlador/general.php?op=listarrango&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {            
            var r = JSON.parse(e);
            $("#dato_funcionarios").html(r.totalfun);
            $("#dato_docentes").html(r.totaldoc);
            $("#dato_estudiantes").html(r.totalest);
            $("#dato_faltas").html(r.totalfaltas);
            $("#dato_quedate").html(r.totalquedate);
            $("#dato_contactanos").html(r.totalcontactanos);
            $("#dato_caracterizados").html(r.totalcaracterizados);
            $("#dato_actividades").html(r.totalactividades);
            $("#dato_cv").html(r.totalcv);
            $("#dato_perfil").html(r.totalperfiladmin);
            $("#dato_perfildoc").html(r.totalperfildoc);
            $("#dato_perfilest").html(r.totalperfilest);
            $(".chart-loader").hide();
        }
    );
}

function actividadesnuevas(actividadesnuevas) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();
    $.post(
        "../controlador/general.php?op=actividadesnuevas&actividadesnuevas=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
   
            var r = JSON.parse(e);
            $("#myModalActividades").modal("show");
            $("#datosusuario_actividades").html(r);
            $("#precarga").hide();
            $("#mostraractividades").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function hojadevidanueva(hojasdevidanueva) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    $.post(
        "../controlador/general.php?op=hojadevidanueva&hojasdevidanueva=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
         
            var r = JSON.parse(e);
            $("#myModalHojadevidanueva").modal("show");
            $("#datosusuario_hoja_de_vida_nueva").html(r);
            $("#precarga").hide();
            $("#mostrarhojadevida").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function mostrar_nombre_funcionario(rangofuncionario) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    $.post(
        "../controlador/general.php?op=mostrar_nombre_funcionario&rangofuncionario=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
            var r = JSON.parse(e);
            $("#myModalIngresosFuncionarios").modal("show");
            $("#datosusuario").html(r);
            $("#precarga").hide();
            $("#mostrarfuncionario").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function mostrar_nombre_docente(rangodocente) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    $.post(
        "../controlador/general.php?op=mostrar_nombre_docente&rangodocente=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
  
            var r = JSON.parse(e);
            $("#myModalIngresosDocentes").modal("show");
            $("#datosusuario_docente").html(r);
            $("#precarga").hide();
            $("#mostrardocente").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function mostrar_nombre_estudiante(rangoestudiante) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();
    $.post(
        "../controlador/general.php?op=mostrar_nombre_estudiante&rangoestudiante=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
  
            var r = JSON.parse(e);
            $("#myModalIngresosEstudiantes").modal("show");
            $("#datosusuario_estudiante").html(r);
            $("#precarga").hide();
            $("#mostrarestudiante").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function perfilesactualizadosadministradores(perfilactualizadoadministrativo) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    $.post(
        "../controlador/general.php?op=perfilesactualizadosadministradores&perfilactualizadoadministrativo=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
       
            var r = JSON.parse(e);
            $("#myModalPerfilactualizadoadministradores").modal("show");
            $("#datosusuario_perfilactualizadoadministradores").html(r);
            $("#precarga").hide();
            $("#mostrarperfilesactualizadosadministradores").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function perfilesactualizadosdocente(perfilactualizadodocente) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    $.post(
        "../controlador/general.php?op=perfilesactualizadosdocente&perfilactualizadodocente=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
       
            var r = JSON.parse(e);
            $("#myModalPerfilactualizadodocente").modal("show");
            $("#datosusuario_perfilactualizadodocente").html(r);
            $("#precarga").hide();
            $("#mostrarperfilesactualizadosdocente").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function perfilesactualizadosestudiante(perfilactualizadoestudiante) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    $.post(
        "../controlador/general.php?op=perfilesactualizadosestudiante&perfilactualizadoestudiante=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
   
            var r = JSON.parse(e);
            $("#myModalPerfilactualizadoestudiante").modal("show");
            $("#datosusuario_perfilactualizadoestudiante").html(r);
            $("#precarga").hide();
            $("#mostrarperfilesactualizadosestudiante").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function mostrar_faltas(rangofaltas) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();

    $.post(
        "../controlador/general.php?op=mostrar_faltas&rangofaltas=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
        
            var r = JSON.parse(e);
            $("#myModalFaltas").modal("show");
            $("#datosusuario_faltas").html(r);
            $("#precarga").hide();
            $("#mostrarfaltasreportadas").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function casosquedate(casosquedate) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();
    $.post(
        "../controlador/general.php?op=casosquedate&casosquedate=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
     
            var r = JSON.parse(e);
            $("#myModalCasoQuedate").modal("show");
            $("#datosusuario_quedate").html(r);
            $("#precarga").hide();
            $("#mostrarcasoquedate").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function contactanos(contactanos) {
    $("#precarga").show();
    var fecha_inicial = $("#fecha-inicio").val();
    var fecha_final = $("#fecha-hasta").val();
    $.post(
        "../controlador/general.php?op=contactanos&contactanos=" +
        seleccion_actual +
        "&fecha_inicial=" +
        fecha_inicial +
        "&fecha_final=" +
        fecha_final,
        function (e) {
            var r = JSON.parse(e);
            $("#myModalCasoContactanos").modal("show");
            $("#datosusuario_contactanos").html(r);
            $("#precarga").hide();
            $("#mostrarcontactanos").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
            });
        }
    );
}

function ListarClasesEscuela(escuela) {
    $("#precarga").show();
    $("#clasesDelDia").fullCalendar("destroy");
    $("#clasesDelDia").fullCalendar({
        defaultView: "agendaDay",
        slotLabelFormat: "h(:mm) a",
        slotEventOverlap: true,
        locales: "es",
        minTime: "06:00:00",
        maxTime: "23:00:00",
        buttonText: {
            month: "Mes",
            week: "Semana",
            day: "dia",
        },
        allDaySlot: false,
        /*Enlace para cargar los eventos de la base de datos*/
        events: {
            url: "../controlador/general.php?op=ListarClasesEscuela&escuela="+escuela,
            type: "POST",
            success: function (events) {
                $("#precarga").hide();
            },
        },
    });
    // Corregir el nombre del objeto a renderizar
    $("#clasesDelDia").fullCalendar("render");
}

function listarEscuelas() {
    $.post("../controlador/general.php?op=listarEscuelas", function (datos) {
        datos = JSON.parse(datos);
        let options = ``;
        for (let i = 0; i < datos.length; i++) {
            options +=
                `<div class="col-xl-3 mb-3">
                            <a onclick="ListarClasesEscuela(` +
                datos[i].id_escuelas +
                `)" class="btn btn-block ` +
                datos[i].clase +
                ` btn-xs">` +
                datos[i].escuelas +
                `</a>
                        </div>`;
        }
        $(".divEscuelas").html(options);
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
				title: 'General',
				intro: 'Da un vistazo a nuestro modulo donde podrás observar todos nuestros horarios por salones activos'
			},
			{
				title: 'Salón',
				element: document.querySelector('#t-programa'),
				intro: "Aquí podrás encontrar todos nuestros nuestros salones disponibles para que puedas consultar "
			},
		]
			
	},
	).start();

}

init();