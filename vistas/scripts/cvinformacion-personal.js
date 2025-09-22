let id_usuario_cv_global = null;
$(document).ready(function(){


    $.post("../controlador/cv_educacion_formacion.php?op=selectListarNivelFormacion", function (r) {
		$("#nivel_formacion").html(r);
		$('#nivel_formacion').selectpicker('refresh');
	});

    // para cuando estamos en celular
    window.addEventListener("load", ajustarBotones);
    window.addEventListener("resize", ajustarBotones);
    window.addEventListener("load", function() {
        let porcentaje = $("#porcentaje_avance").val();
        porcentaje = Number(porcentaje); 
        if (!isNaN(porcentaje)) {
            ajustarBotones(porcentaje); 
        } else {
        }
    });
    window.addEventListener("resize", function() {
        let porcentaje = $("#porcentaje_avance").val();
        porcentaje = Number(porcentaje); 
        if (!isNaN(porcentaje)) {
            ajustarBotones(porcentaje); 
        } else {
        }
    });
    // tomamos el valor actual del porcentaje para que se activen solo dependiendo del porcentaje
    let porcentaje = $("#porcentaje_avance").val();
    porcentaje = Number(porcentaje); 
    activarPasosPorPorcentaje(porcentaje); 
    ajustarBotones(porcentaje);  
    // mostramos pordefecto el formulario 1.
    mostrarform(1);


    $(".rango_del_color").css("color", "yellow");
    mostrarExperiencias();
    mostrarEducacion();
    mostrarHabilidades();
    mostrarAreas();
    mostrarPortafolio();
    mostrarReferenciasPersonales();
    mostrarReferenciasLaborales();
    mostrarDocumentosObligatorios();
    mostrarDocumentosAdicionales();
    $('#departamento').selectpicker();
    $('#departamento').on('change',function(){
        var id = $('#departamento').val();
        if(id){
            cargarCiudades(id);
        }
    });

    $("input[name='foto']").change(function (){
        var formData = new FormData($("#informacion_personal_form")[0]);
        $("#info_preloader").html('<div class="preloader-box"></div>');
        $.ajax({
            url: "../controlador/cv_informacion_personal.php?op=guardaryeditarImagen",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(datos){
                var data = JSON.parse(datos);
                if(data.estatus == 1){
                    $(".user-image").attr("src","../files/usuarios/"+data.imagen);
                    guardarEditarInformacionPersonal();
                        url = dividirCadena(location.href, "?", 0);
                        setTimeout(function(){
                            window.location = url + '?i=' + Math.floor((Math.random() * 99999) + 1);
                        }, 2000);
                }else{
                    alertify.error(data.valor);
                    $("#info_preloader").html('');
                }
            }
        });
    });
    $("input[name='nivel_habilidad']").change(function(){
        switch($("input[name='nivel_habilidad']").val()){
            case "1":
                $(".rango_del_color").css("color", "red");
            break;
            case "2":
                $(".rango_del_color").css("color", "orange");
            break;
            case "3":
                $(".rango_del_color").css("color", "yellow");
            break;
            case "4":
                $(".rango_del_color").css("color", "green");
            break;
            case "5":
                $(".rango_del_color").css("color", "#00ff00");
            break;
            default:
            alert("valor desconocido");
            break;
        }
    });
    $("#informacion_personal_form").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarEditarInformacionPersonal();
    });
    $("#form-experiencia_laboral").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarEditarExperienciaLaboral();
    });
    $('#modal-experiencia_laboral').on('hidden.bs.modal', function () {
        $('#form-experiencia_laboral')[0].reset();
    }); 
    $("#form-educacion_formacion").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarEditarEducacion();
    });
    $('#modal-educacion_formacion').on('hidden.bs.modal', function () {
        $('#form-educacion_formacion')[0].reset();
    }); 
    $("#form-habilidades_aptitudes").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarHabilidades();
    });
    $('#modal-habilidades_aptitudes').on('hidden.bs.modal', function () {
        $('#form-habilidades_aptitudes')[0].reset();
    });
    $("#form-referencias_personales").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarReferenciasPersonales();
    });
    $('#modal-referencias_personales').on('hidden.bs.modal', function () {
        $('#form-referencias_personales')[0].reset();
    });
    $("#form-referencias_laborales").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarReferenciaslaborales();
    });
    $('#modal-referencias_laborales').on('hidden.bs.modal', function () {
        $('#form-referencias_laborales')[0].reset();
    });
    $("#form-portafolio").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarPortafolio();
    });
    $('#modal-portafolio').on('hidden.bs.modal', function () {
        $('#form-portafolio')[0].reset();
    });
    $("#form-documentos_obligatorios").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarDocumentosObligatorios();
    });
    $('#modal-documentos_obligatorios').on('hidden.bs.modal', function () {
        $('#form-documentos_obligatorios')[0].reset();
    });

    $("#form-documentos_adicionales").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarDocumentosAdicionales();
    });
    $('#modal-documentos_adicionales').on('hidden.bs.modal', function () {
        $('#form-documentos_adicionales')[0].reset();
    });
    $("#form-areas_de_conocimiento").off("submit").on("submit",function(e){
        e.preventDefault();
        guardarArea();
    });
});


function verificarEstadoDocumentos() {
    var todosSubidos = $('#mostrar_documentos_obligatorios tr td').filter(function() {
        return $(this).text().trim() === 'Falta Subir';
    }).length === 0; // Verifica si no hay celdas con 'Falta Subir'
    $('#btnSiguiente').prop('disabled', !todosSubidos);
}


function dividirCadena(cadenaADividir, separador, index) {
    if (cadenaADividir == "" || cadenaADividir === null || cadenaADividir === undefined) {
        return []; // Devuelve un array vacío si cadenaADividir es una cadena vacía, null o undefined
    } else {
        var arrayDeCadenas = cadenaADividir.split(separador);
        return arrayDeCadenas[index];
    }
}
function guardarEditarInformacionPersonal(){
    scroll(0, 0);
    $("#pasos_hoja_vida").html("Paso 2 / 10 Educación y formación")
    var formData = new FormData($("#informacion_personal_form")[0]);
    $.ajax({
        url: "../controlador/cv_informacion_personal.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var data = JSON.parse(datos);
            if(data.estatus == 1){ 
                avanzarAlSiguientePaso();
                $("#porcentaje_avance").val(data.nuevo_porcentaje);
                activarPasosPorPorcentaje(data.nuevo_porcentaje);
                ajustarBotones(data.nuevo_porcentaje);

                $("#id_informacion_personal").val(data.id_informacion_personal);
                alertify.success(data.valor);
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function cargarCiudades(id){
    if(id){
        $(".ciudad").prop( "disabled", false );
        $.ajax({
            url: "../controlador/cv_ciudad.php?op=mostrar&id_departamento="+id,
            type: "POST",
            success: function(datos){
                var data = JSON.parse(datos);
                var cont = 0;
                var html = "";
                while(cont < data.length){
                    html += "<option value='"+data[cont]["0"]+"'>"+data[cont]["1"]+"</option>";
                    cont++;
                }
                $(".ciudad").html(html);
            }
        });
    }
}

//experiencia laboral
function guardarEditarExperienciaLaboral(){
    scroll(0, 0);
    var formData = new FormData($("#form-experiencia_laboral")[0]);
    $.ajax({
        url: "../controlador/cv_informacion_personal.php?op=guardaryeditarexperiencialaboral",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var data = JSON.parse(datos);
            if(data.estatus == 1){ 
                cerrarLaboral();
                alertify.success(data.valor);
                $('#form-experiencia_laboral')[0].reset();
                $('#modal-experiencia_laboral').modal('toggle');
                mostrarExperiencias();
                if (data.total_registros >= 2) {
                    avanzarAlSiguientePaso();
                    activarPasosPorPorcentaje(data.porcentaje);
                    ajustarBotones(data.porcentaje);
                }
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarExperiencias(){
    if ( $.fn.DataTable.isDataTable('#table-experiencias_laborales') ) {
        $('#table-experiencias_laborales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cv_informacion_personal.php?op=mostrarexperiencias",
        type: "POST",
        success: function(datos){
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{  
                    url = dividirCadena(datos[""+cont].certificado_laboral, "../", 1);
                    let hasta_cuando = datos[""+cont].hasta_cuando ? datos[""+cont].hasta_cuando : "Trabajo actual";  
                    tabla += `<tr>
                                <td>
                                <button class="btn btn-flat btn-primary btn-sm" onclick="editarExperiencia(`+datos[""+cont].id_experiencia+`)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i>  </button>
                                <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarExperiencia(`+datos[""+cont].id_experiencia+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                                <td>`+datos[""+cont].nombre_empresa+`</td>
                                <td>`+datos[""+cont].cargo_empresa+`</td>
                                <td>`+datos[""+cont].desde_cuando+`</td>
                                <td>`+hasta_cuando+`</td>
                                <td>`+datos[""+cont].mas_detalles+`</td>
                                <td><a href="../`+url+`" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Certificado Laboral en pesataña nueva"><i class="fas fa-link"></i></a></td>
                            </tr>`;
                }
                cont++;
            }
            $(".body-experiencias_laborales").html(tabla);
            $('#table-experiencias_laborales').DataTable({
                "dom": '',
                "paging": false,
                "destroy" : true,
            });
            if (cont >= 2) {
                $('#btnSiguiente_laboralydocente').show();
            } else {
                $('#btnSiguiente_laboralydocente').hide();
            }
        }
    });
}
function editarExperiencia(id_experiencia){
    $.ajax({
        url: "../controlador/cv_informacion_personal.php?op=verExperienciaEspecifica",
        type: "POST",
        data: {id_experiencia : id_experiencia},
        success: function (datos) {
            datos = JSON.parse(datos);
            const d = datos[0];
            // Llenar el formulario
            $("#id_experiencia").val(d.id_experiencia);
            $("#id_experiencia_editar_img").val(d.id_experiencia);
            $("#cargo_empresa").val(d.cargo_empresa);
            $("#desde_cuando").val(d.desde_cuando);
            $("#hasta_cuando").val(d.hasta_cuando);
            $("#nombre_empresa").val(d.nombre_empresa);
            $("#mas_detalles").val(d.mas_detalles);

            if (d.estado_trabajo_actual == "1") {
                $("#trabajo_actual_si").prop("checked", true);
                $("#ocultar_hasta_cuando").hide(); // Oculta el campo
                $("#hasta_cuando").val(""); // Limpia la fecha
            } else {
                $("#trabajo_actual_no").prop("checked", true);
                $("#ocultar_hasta_cuando").show(); // Muestra el campo
            }
            // Mostrar el popover manualmente
            const popover = document.querySelector("#popoverLaboral");
            const contenedor = document.querySelector("#form3");
            // Puedes usar el mismo botón o simularlo
            const boton = document.querySelector('[onclick*="CrearLaboralPopover"]');
            const contenedorRect = contenedor.getBoundingClientRect();
            const buttonRect = boton.getBoundingClientRect();
            const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
            const offsetLeft = buttonRect.left - contenedorRect.left;
            popover.style.top = `${offsetTop}px`;
            popover.style.left = `${offsetLeft}px`;
            popover.style.display = "block";
            popover.classList.remove("d-none");
            contenedor.appendChild(popover);
        }
    });
}
function eliminarExperiencia(id_experiencia){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar esta experiencia laboral?', 
        function(){ 
            $.ajax({
                url: "../controlador/cv_informacion_personal.php?op=eliminarExperiencia",
                type: "POST",
                data: {"id_experiencia": id_experiencia},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarExperiencias();
                }
            });
        }, 

        function(){ 
            alertify.error('Cancelado')
        }
    );   
}
//Educacion y formacion
function guardarEditarEducacion(){
    scroll(0, 0);
    var formData = new FormData($("#form-educacion_formacion")[0]);
    $.ajax({
        url: "../controlador/cv_educacion_formacion.php?op=guardaryeditareducacion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var data = JSON.parse(datos);
            if(data.estatus == 1){ 
                cerrarPopoverEducacionformacion();
                if (data.total_registros >= 2) {
                    avanzarAlSiguientePaso();
                    activarPasosPorPorcentaje(data.porcentaje);
                    ajustarBotones(data.porcentaje);
                }
                alertify.success(data.valor);
                $('#form-educacion_formacion')[0].reset();
                mostrarEducacion();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarEducacion(){
    if ( $.fn.DataTable.isDataTable('#table-educacion_formacion') ) {
        $('#table-educacion_formacion').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cv_educacion_formacion.php?op=mostrarEducacion",
        type: "POST",
        success: function(datos){
            datos = JSON.parse(datos);
            id_usuario_cv_global = datos[0].id_usuario;
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{  
                    url = dividirCadena(datos[""+cont].certificado_educacion, "../", 1);
                    tabla+=`<tr>
                            <td>
                            <button class="btn btn-flat btn-primary btn-sm" onclick="editarEducacion(`+datos[""+cont].id_formacion+`)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i> </button>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarEducacion(`+datos[""+cont].id_formacion+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                            <td>`+datos[""+cont].institucion_academica+`</td>
                            <td>`+datos[""+cont].titulo_obtenido+`</td>
                            <td>`+datos[""+cont].desde_cuando_f+`</td>
                            <td>`+datos[""+cont].hasta_cuando_f+`</td>
                            <td>`+datos[""+cont].mas_detalles_f+`</td>
                            <td><a href="../cv/`+url+`" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Certificado en pesataña nueva"><i class="fas fa-link"></i></a></td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-educacion_formacion").html(tabla);
            $('#table-educacion_formacion').DataTable({
                "dom": '',
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
            if (cont >= 2) {
                $('#btnSiguiente_educacion_formacion').show();
            } else {
                $('#btnSiguiente_educacion_formacion').hide();
            }
        }
    });
}
function editarEducacion(id_formacion){
    $.ajax({
        url: "../controlador/cv_educacion_formacion.php?op=verEducacionEspecifica",
        type: "POST",
        data: {id_formacion : id_formacion},
        success: function (datos) {
            datos = JSON.parse(datos);
            const d = datos[0];
            // Cerrar y limpiar antes de mostrar
            cerrarPopoverEducacionformacion();
            // Llenar campos
            $("#id_formacion").val(d.id_formacion);
            $("#titulo_obtenido").val(d.titulo_obtenido);
            $("#desde_cuando_f").val(d.desde_cuando_f);
            $("#hasta_cuando_f").val(d.hasta_cuando_f);
            $("#institucion_academica").val(d.institucion_academica);
            $("#mas_detalles_f").val(d.mas_detalles_f);
            $("#nivel_formacion").val(d.nivel_formacion);
            $('#nivel_formacion').selectpicker('refresh'); // importante
            // Mostrar el popover en la posición adecuada
            const popover = document.querySelector("#popoverFormularioEducacionyFormacion");
            const contenedor = document.querySelector("#form2");
            const boton = document.querySelector('[onclick*="CrearEducacionFormacionPopover"]');
            const contenedorRect = contenedor.getBoundingClientRect();
            const buttonRect = boton.getBoundingClientRect();
            const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
            const offsetLeft = buttonRect.left - contenedorRect.left;
            popover.style.top = `${offsetTop}px`;
            popover.style.left = `${offsetLeft}px`;
            popover.style.display = "block";
            popover.classList.remove("d-none");
            contenedor.appendChild(popover);
        }
    });
}
function eliminarEducacion(id_formacion){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cv_educacion_formacion.php?op=eliminarEducacion",
                type: "POST",
                data: {"id_formacion": id_formacion},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarEducacion();
                }
            });
        }, 
        function(){ 
            alertify.error('Cancelado')
        }
    );   
}
//Habilidades y aptitudes mostrarReferenciasPersonales
function guardarHabilidades(){
    scroll(0, 0);
    var formData = new FormData($("#form-habilidades_aptitudes")[0]);
    $.ajax({
        url: "../controlador/cvhabilidad_aptitud.php?op=guardaryeditarhabilidad",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var data = JSON.parse(datos);
            if(data.estatus == 1){
                cerrarHabilidadesyAptitudes(); 
                if (data.total_registros >= 5) {
                    avanzarAlSiguientePaso();
                    activarPasosPorPorcentaje(data.porcentaje);
                    ajustarBotones(data.porcentaje);
                } 
                alertify.success(data.valor);
                $('#form-habilidades_aptitudes')[0].reset();
                $('#modal-habilidades_aptitudes').modal('toggle');
                mostrarHabilidades();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarHabilidades() {
    if ($.fn.DataTable.isDataTable('#table-habilidades_aptitudes')) {
        $('#table-habilidades_aptitudes').DataTable().destroy();
    }

    $.ajax({
        url: "../controlador/cvhabilidad_aptitud.php?op=mostrarHabilidades",
        type: "POST",
        success: function(datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            var maxRows = 5; // Número máximo de filas a mostrar
            while (cont < datos.length && cont < maxRows) { // Limitar a 5 filas
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {
                    var color;
                    switch (datos["" + cont].nivel_habilidad) {
                        case "1":
                            color = "bg-red";
                            break;
                        case "2":
                            color = "bg-orange";
                            break;
                        case "3":
                            color = "bg-warning";
                            break;
                        case "4":
                            color = "bg-teal";
                            break;
                        case "5":
                            color = "bg-green";
                            break;
                        default:
                            color = "bg-gray";
                            break;
                    }

                    tabla += `<tr>
                            <td>
                            <button class="btn btn-flat btn-primary btn-sm" onclick="editarHabilidad(` + datos["" + cont].id_habilidad + `)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i> </button>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarHabilidad(` + datos["" + cont].id_habilidad + `)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                            <td>` + datos["" + cont].nombre_categoria + `</td>
                            <td>
                                <div class="progress-group">
                                    <span class="progress-number"><b>` + datos["" + cont].nivel_habilidad + `</b>/5</span>
                                    <br>
                                    <div class="progress progress-sm active">
                                    <div class="progress-bar ` + color + ` progress-bar-striped" role="progressbar" aria-valuenow="` + (parseInt(datos["" + cont].nivel_habilidad) * 2) + `0" aria-valuemin="0" aria-valuemax="100" style="width: ` + (parseInt(datos["" + cont].nivel_habilidad) * 2) + `0%">
                                      <span class="sr-only">` + (parseInt(datos["" + cont].nivel_habilidad) * 2) + `0% Complete</span>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-habilidades_aptitudes").html(tabla);
            $('#table-habilidades_aptitudes').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
                "destroy": true,
            });
            if (cont >= 5) {
                $('#btnSiguiente_habilidades').show();
            } else {
                $('#btnSiguiente_habilidades').hide();
            }
        }
    });
}

function editarHabilidad(id_habilidad){
    $.ajax({
        url: "../controlador/cvhabilidad_aptitud.php?op=verHabilidadEspecifica",
        type: "POST",
        data: {id_habilidad : id_habilidad},
       success: function (datos) {
            datos = JSON.parse(datos);
            const d = datos[0];
            // Llenar el formulario

            $("#id_habilidad").val(d.id_habilidad);
            $("#categoria_habilidad").val(d.nombre_categoria);
            $("#nivel_habilidad").val(d.nivel_habilidad).trigger("input");
            // Mostrar el popover manualmente
            const popover = document.querySelector("#popoverhabilidadesyaptitudes");
            const contenedor = document.querySelector("#form4");
            // Puedes usar el mismo botón o simularlo
            const boton = document.querySelector('[onclick*="CrearHabilidadesyAptitudesPopover"]');
            const contenedorRect = contenedor.getBoundingClientRect();
            const buttonRect = boton.getBoundingClientRect();
            const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
            const offsetLeft = buttonRect.left - contenedorRect.left;
            popover.style.top = `${offsetTop}px`;
            popover.style.left = `${offsetLeft}px`;
            popover.style.display = "block";
            popover.classList.remove("d-none");
            contenedor.appendChild(popover);
        }
    });
}
function eliminarHabilidad(id_habilidad){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cvhabilidad_aptitud.php?op=eliminarHabilidad",
                type: "POST",
                data: {"id_habilidad": id_habilidad},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarHabilidades();
                }
            });
        }, 

        function(){ 
            alertify.error('Cancelado')
        }
    );   
}
//Portafolio
function guardarPortafolio(){
    scroll(0, 0);
    var formData = new FormData($("#form-portafolio")[0]);
    $.ajax({
        url: "../controlador/cvportafolio.php?op=guardaryeditarportafolio",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            var data = JSON.parse(datos);
            var data = JSON.parse(datos);
            if(data.estatus == 1){
                cerrarPortafolio();
                activarPasosPorPorcentaje(data.porcentaje);
                avanzarAlSiguientePaso();
                ajustarBotones(data.porcentaje);
                alertify.success(data.valor);
                $('#form-portafolio')[0].reset();
                // $('#modal-portafolio').modal('toggle');
                mostrarPortafolio();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarPortafolio(){
    if ( $.fn.DataTable.isDataTable('#table-portafolio') ) {
        $('#table-portafolio').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cvportafolio.php?op=mostrarPortafolio",
        type: "POST",
        success: function(datos){
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{  
                    
                    url = dividirCadena(datos[""+cont].portafolio_archivo, "../", 1);
                    tabla+=`<tr>
                            <td>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarPortafolio(`+datos[""+cont].id_portafolio+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                            <td>`+datos[""+cont].titulo_portafolio+`</td>
                            <td>`+datos[""+cont].descripcion_portafolio+`</td>
                            <td>`+((datos[""+cont].video_portafolio == "")?"":`<a href="`+datos[cont].video_portafolio+`" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Ver video de youtube"><i class="fab fa-youtube"></i></a>`)+`</td>
                            <td>`+((datos[""+cont].portafolio_archivo == "")?"":`
                            <a href="../cv/`+url+`" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Certificado en pesataña nueva"><i class="fas fa-link"></i></a>`)+`</td>

                        </tr>`;
                }
                cont++;
            }
            $(".body-portafolio").html(tabla);
            $('#table-portafolio').DataTable({
                "dom": '',
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
             $('#btnSiguiente_portafolio').show();
        }
    });
}
function eliminarPortafolio(id_portafolio){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cvportafolio.php?op=eliminarPortafolio",
                type: "POST",
                data: {"id_portafolio": id_portafolio},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarPortafolio();
                }
            });
        }, 

        function(){ 
            alertify.error('Cancelado')
        }

    );   

}
//Referencias Personales
function guardarReferenciasPersonales(){
    scroll(0, 0);
    var formData = new FormData($("#form-referencias_personales")[0]);
    $.ajax({
        url: "../controlador/cv_referencias_personales.php?op=guardaryeditarreferencias_personales",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var data = JSON.parse(datos);
            if(data.estatus == 1){
                cerrarReferenciaPersonal();
                if (data.total_registros >= 2) {
                    activarPasosPorPorcentaje(data.porcentaje);
                    avanzarAlSiguientePaso();
                    ajustarBotones(data.porcentaje);
                }
                alertify.success(data.valor);
                $('#form-referencias_personales')[0].reset();
                // $('#modal-referencias_personales').modal('toggle');
                mostrarReferenciasPersonales();
            }else{
                alertify.error(data.valor);
            }
        }
    });

}
function mostrarReferenciasPersonales() {
    $("#pasos_hoja_vida").html("Paso 1 / 10 Referencias Personales")
    if ($.fn.DataTable.isDataTable('#table-referencias_personales')) {
        $('#table-referencias_personales').DataTable().destroy();
    }

    $.ajax({
        url: "../controlador/cv_referencias_personales.php?op=mostrarReferenciasPersonales",
        type: "POST",
        success: function(datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var maxRows = 2; // Número máximo de referencias a mostrar
            var tabla = "";

            while (cont < datos.length && cont < maxRows) { // Limitar a 2 filas
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {  
                    tabla += `<tr>
                            <td>
                                <button class="btn btn-flat btn-primary btn-sm" onclick="editarReferenciasPersonales(` + datos["" + cont].id_referencias + `)" data-toggle="tooltip" data-placement="bottom" title="Editar"> 
                                    <i class="fas fa-pen"></i> 
                                </button>
                                <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarReferenciaPersonal(` + datos["" + cont].id_referencias + `)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> 
                                    <i class="fas fa-trash"></i>  
                                </button>
                            </td>
                            <td>` + datos["" + cont].referencias_nombre + `</td>
                            <td>` + datos["" + cont].referencias_profesion + `</td>
                            <td>` + datos["" + cont].referencias_empresa + `</td>
                            <td>` + datos["" + cont].referencias_telefono + `</td>
                        </tr>`;
                }
                cont++;
            }

            $(".body-referencias_personales").html(tabla);
            $('#table-referencias_personales').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
            });
            if (cont >= 2) {
                $('#btnSiguiente_referencias_personales').show();
            } else {
                $('#btnSiguiente_referencias_personales').hide();
            }
        }
    });
}

function editarReferenciasPersonales(id_referencias){
    $.ajax({
        url: "../controlador/cv_referencias_personales.php?op=verReferenciaPersonalEspecifica",
        type: "POST",
        data: {id_referencias : id_referencias},
        success: function (datos) {
            datos = JSON.parse(datos);
            const d = datos[0];
            // Llenar el formulario
            $("#id_referencias").val(d.id_referencias);
            $("#referencias_nombre").val(d.referencias_nombre);
            $("#referencias_profesion").val(d.referencias_profesion);
            $("#referencias_empresa").val(d.referencias_empresa);
            $("#referencias_telefono").val(d.referencias_telefono);
            // Mostrar el popover manualmente
            const popover = document.querySelector("#popoverReferenciaPersonal");
            const contenedor = document.querySelector("#form6");
            // Puedes usar el mismo botón o simularlo
            const boton = document.querySelector('[onclick*="CrearReferenciaPersonalPopover"]');
            const contenedorRect = contenedor.getBoundingClientRect();
            const buttonRect = boton.getBoundingClientRect();
            const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
            const offsetLeft = buttonRect.left - contenedorRect.left;
            popover.style.top = `${offsetTop}px`;
            popover.style.left = `${offsetLeft}px`;
            popover.style.display = "block";
            popover.classList.remove("d-none");
            contenedor.appendChild(popover);
        }
    });

}
function eliminarReferenciaPersonal(id_referencias){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cv_referencias_personales.php?op=eliminarReferenciaPersonal",
                type: "POST",
                data: {"id_referencias": id_referencias},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarReferenciasPersonales();
                }
            });
        }, 

        function(){ 
            alertify.error('Cancelado')
        }
    );   
}
//Referencias Laborales
function guardarReferenciaslaborales(){
    scroll(0, 0);
    var formData = new FormData($("#form-referencias_laborales")[0]);
    $.ajax({
        url: "../controlador/cvreferencias_laborales.php?op=guardaryeditarreferencias_laborales",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            var data = JSON.parse(datos);
            if(data.estatus == 1){ 
                cerrarReferenciaLaboral();
                alertify.success(data.valor);
                $('#form-referencias_laborales')[0].reset();
                // $('#modal-referencias_laborales').modal('toggle');
                mostrarReferenciasLaborales();
                if (data.total_registros >= 2) {
                    activarPasosPorPorcentaje(data.porcentaje);
                    avanzarAlSiguientePaso();
                    ajustarBotones(data.porcentaje);
                }
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarReferenciasLaborales() {
    if ($.fn.DataTable.isDataTable('#table-referencias_laborales')) {
        $('#table-referencias_laborales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cvreferencias_laborales.php?op=mostrarReferenciasLaborales",
        type: "POST",
        success: function(datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var maxRows = 2; // Número máximo de filas a mostrar
            var tabla = "";
            while (cont < datos.length && cont < maxRows) { // Limitar a 2 filas
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {  
                    tabla += `<tr>
                            <td>
                            <button class="btn btn-flat btn-primary btn-sm" onclick="editarReferenciasLaborales(` + datos["" + cont].id_referenciasl + `)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i> </button>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarReferenciaLaborales(` + datos["" + cont].id_referenciasl + `)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i> </button></td>
                            <td>` + datos["" + cont].referencias_nombrel + `</td>
                            <td>` + datos["" + cont].referencias_profesionl + `</td>
                            <td>` + datos["" + cont].referencias_empresal + `</td>
                            <td>` + datos["" + cont].referencias_telefonol + `</td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-referencias_laborales").html(tabla);
            $('#table-referencias_laborales').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
                "destroy": true,
            });
            if (cont >= 2) {
                $('#btnSiguiente_Referencia_laboral').show();
            } else {
                $('#btnSiguiente_Referencia_laboral').hide();
            }
        }
    });
}

function editarReferenciasLaborales(id_referenciasl){
    $.ajax({
        url: "../controlador/cvreferencias_laborales.php?op=verReferencialaboralespecifica",
        type: "POST",
        data: {id_referenciasl : id_referenciasl},
        success: function (datos) {
            datos = JSON.parse(datos);
            const d = datos[0];
            // Llenar el formulario


            $("#id_referenciasl").val(d.id_referenciasl);
            $("#referencias_nombrel").val(d.referencias_nombrel);
            $("#referencias_profesionl").val(d.referencias_profesionl);
            $("#referencias_empresal").val(d.referencias_empresal);
            $("#referencias_telefonol").val(d.referencias_telefonol);

            
            // Mostrar el popover manualmente
            const popover = document.querySelector("#popoverReferenciaLaboral");
            const contenedor = document.querySelector("#form7");
            // Puedes usar el mismo botón o simularlo
            const boton = document.querySelector('[onclick*="CrearReferenciaLaboralPopover"]');
            const contenedorRect = contenedor.getBoundingClientRect();
            const buttonRect = boton.getBoundingClientRect();
            const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
            const offsetLeft = buttonRect.left - contenedorRect.left;
            popover.style.top = `${offsetTop}px`;
            popover.style.left = `${offsetLeft}px`;
            popover.style.display = "block";
            popover.classList.remove("d-none");
            contenedor.appendChild(popover);
        }
    });
}
function eliminarReferenciaLaborales(id_referenciasl){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cvreferencias_laborales.php?op=eliminarReferenciaLaborales",
                type: "POST",
                data: {"id_referenciasl": id_referenciasl},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarReferenciasLaborales();
                }
            });
        }, 
        function(){ 
            alertify.error('Cancelado')
        }
    );   
}
//Documentos Obligatorios


function guardarDocumentosObligatorios(){
    scroll(0, 0);
    var formData = new FormData($("#form-documentos_obligatorios")[0]);
    $.ajax({
        url: "../controlador/cvdocumentos_obligatorios.php?op=guardaryeditardocumentos_obligatorios",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-documentos_obligatorios')[0].reset();
                $('#modal-documentos_obligatorios').modal('hide');

                // $('#modal-documentos_obligatorios').modal('toggle');
                mostrarDocumentosObligatorios();
                // $("#mostrardocumentosobligatorios").DataTable().ajax.reload();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}



// function guardarDocumentosObligatorios(){
//     var formData = new FormData($("#form-documentos_obligatorios")[0]);
//     $.ajax({
//         url: "../controlador/cvdocumentos_obligatorios.php?op=guardaryeditardocumentos_obligatorios",
//         type: "POST",
//         data: formData,
//         contentType: false,
//         processData: false,
//         success: function(datos){	
//          
//             var data = JSON.parse(datos);
//             if(data.estatus == 1){  
//                 alertify.success(data.valor);
//                 $('#form-documentos_obligatorios')[0].reset();
//                 $('#modal-documentos_obligatorios').modal('toggle');
//                 mostrarDocumentosObligatorios();
//             }else{
//                 alertify.error(data.valor);
//             }
//         }
//     });
// }
// function mostrarDocumentosObligatorios(){
//     if ( $.fn.DataTable.isDataTable('#table-documentos_obligatorios') ) {
//         $('#table-documentos_obligatorios').DataTable().destroy();
//     }
//     $.ajax({
//         url: "../controlador/cvdocumentos_obligatorios.php?op=mostrarDocumentosObligatorios",
//         type: "POST",
//         success: function(datos){
//           
//             datos = JSON.parse(datos);
//             var cont = 0;
//             var tabla_obligatorios = "";
//             while(cont < datos.length){
//                 if(datos[""+cont].id_usuario_cv == 0){
//                     tabla_obligatorios += `<li class="list-group-item">
//                                 <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
//                             </li>`;
//                 }else{  
//                     url = dividirCadena(datos[""+cont].documento_archivo, "../", 1);
//                     tabla_obligatorios+=`<tr>
//                             <td>
//                             <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarDocumentoObligatorio(`+datos[""+cont].id_documento+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
//                             <td>`+datos[""+cont].documento_nombre+`</td>
//                             <td>`+((datos[""+cont].documento_archivo == "")?"":`<a href="../cv/`+url+` " class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Documento en pesataña nueva"><i class="fas fa-link"></i></a>`)+`</td>
//                         </tr>`;
//                 }
//                 cont++;
//             }
//             $(".body-documentos_obligatorios").html(tabla_obligatorios);
//             $('#table-documentos_obligatorios').DataTable({
//                 "dom": '',
//                 "destroy" : true,
//                 "paging": false,
//                 "destroy" : true,
//             });
//         }
//     });
// }
function mostrarDocumentosAdicionales() {
    if ($.fn.DataTable.isDataTable('#table-documentos_adicionales')) {
        $('#table-documentos_adicionales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cvdocumentos_adicionales.php?op=mostrarDocumentosAdicionales",
        type: "POST",
        success: function(datos) {
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while (cont < datos.length) {
                if (datos["" + cont].id_usuario_cv == 0) {
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                } else {  
                    url = dividirCadena(datos["" + cont].documento_archivoA, "../", 1);
                    tabla += `<tr>
                            <td>` + datos["" + cont].documento_nombreA + `</td>
                            <td>` + ((datos["" + cont].documento_archivoA == "") ? "" : `<a href="` + datos["" + cont].documento_archivoA + ` " class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Documento en pestaña nueva"><i class="fas fa-link"></i></a>`) + `</td>
                            <td class="text-center">
                                <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarDocumentoAdicional(` + datos["" + cont].id_documentoA + `)" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-documentos_adicionales").html(tabla);
            $('#table-documentos_adicionales').DataTable({
                "dom": '',
                "destroy": true,
                "paging": false,
                "destroy": true,
            });
            $('#btnSiguiente_documentos_adicionales').show();
        }
    });
}


function eliminarDocumentoObligatorio(id_usuario_cv, nombre_documentos) {
 

    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cvdocumentos_obligatorios.php?op=eliminarDocumentoObligatorio",
                type: "POST",
                data: {"id_usuario_cv": id_usuario_cv, "nombre_documentos": nombre_documentos},
                success: function(datos) {
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarDocumentosObligatorios();
                },
            });
        }, 
        function(){ 
            alertify.error('Cancelado');
        }
    );   
}



function eliminarDocumentoObligatoriootrosestudios(id_documentacion) {
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cvdocumentos_obligatorios.php?op=eliminarDocumentoObligatoriootrosestudios",
                type: "POST",
                data: {"id_documentacion": id_documentacion},
                success: function(datos) {
                    datos = JSON.parse(datos);
                    if (datos.estatus === 1) {
                        alertify.success(datos.valor);
                    } else {
                        alertify.error(datos.valor);
                    }
                    mostrarArchivo();
                },
            });
        }, 
        function(){ 
            alertify.error('Cancelado');
        }
    );   
}





// function eliminarDocumentoObligatorio(id_documento){
//     alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
//         function(){ 
//             $.ajax({
//                 url: "../controlador/cvdocumentos_obligatorios.php?op=eliminarDocumentoObligatorio",
//                 type: "POST",
//                 data: {"id_documento": id_documento},
//                 success: function(datos){
//                   
//                     datos = JSON.parse(datos);
//                     alertify.message(datos.valor);
//                     mostrarDocumentosObligatorios();
//                 }
//             });
//         }, 
//         function(){ 
//             alertify.error('Cancelado')
//         }
//     );   
// }
//Documentos adicionales
function guardarDocumentosAdicionales(){
    scroll(0, 0);
    var formData = new FormData($("#form-documentos_adicionales")[0]);
    $.ajax({
        url: "../controlador/cvdocumentos_adicionales.php?op=guardaryeditardocumentos_adicionales",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var data = JSON.parse(datos);
            if(data.estatus == 1){
                cerrarDocumentosAdicionales();
                activarPasosPorPorcentaje(data.porcentaje);
                avanzarAlSiguientePaso();
                ajustarBotones(data.porcentaje);
                alertify.success(data.valor);
                $('#form-documentos_adicionales')[0].reset();
                mostrarDocumentosAdicionales();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}

function eliminarDocumentoAdicional(id_documentoA){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cvdocumentos_adicionales.php?op=eliminarDocumentoAdicional",
                type: "POST",
                data: {"id_documentoA": id_documentoA},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarDocumentosAdicionales();
                }
            });
        }, 
        function(){ 
            alertify.error('Cancelado')
        }
    );   
}
//Areas de conocimiento
function guardarArea(){
    scroll(0, 0);
    var formData = new FormData($("#form-areas_de_conocimiento")[0]);
    $.ajax({
        url: "../controlador/cv_areas_de_conocimiento.php?op=guardaryeditararea",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            var data = JSON.parse(datos);
            if(data.estatus == 1){
                cerrarAreaConocimiento(); 
                activarPasosPorPorcentaje(data.porcentaje);
                avanzarAlSiguientePaso();
                ajustarBotones(data.porcentaje);
                alertify.success(data.valor);
                $('#form-areas_de_conocimiento')[0].reset();
                mostrarAreas();
                mostrarform(10);
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarAreas(){
    if ( $.fn.DataTable.isDataTable('#table-areas_de_conocimiento') ) {
        $('#table-areas_de_conocimiento').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cv_areas_de_conocimiento.php?op=mostrarAreas",
        type: "POST",
        success: function(datos){
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{  
                        tabla+=`<tr>
                            <td>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarArea(`+datos[""+cont].id_area+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i> </button></td>
                            <td>`+datos[""+cont].nombre_area+`</td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-areas_de_conocimiento").html(tabla);
            $('#table-areas_de_conocimiento').DataTable({
                "dom": '',
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
            if (cont >= 2) {
                $('#btnSiguiente_areas').show();
            } else {
                $('#btnSiguiente_areas').hide();
            }
        }
    });
}
function eliminarArea(id_area){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cv_areas_de_conocimiento.php?op=eliminarArea",
                type: "POST",
                data: {"id_area": id_area},
                success: function(datos){
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarAreas();
                }
            });
        }, 
        function(){ 
            alertify.error('Cancelado')
        }
    );   
}


function toggleSubir(index, valor, id_usuario_cv,nombre_documentos) {
    const labelEstado = document.getElementById("label_estado_" + index);
    const btnSubir = document.getElementById("btnSubir_" + index);
    // Actualiza el texto
    labelEstado.textContent = valor ? "Sí" : "No";
    // Muestra u oculta el botón
    if (valor) {
        btnSubir.classList.remove("d-none");
    } else {
        btnSubir.classList.add("d-none");
        ActualizarEstadoTarjetaProfesionalRut(valor, id_usuario_cv, nombre_documentos);
    }

    
   

}


// funcion para insertar y modificar el estado del rut y la tarjeta profesional.
function ActualizarEstadoTarjetaProfesionalRut(valor, id_usuario_cv, nombre_documentos) {
    const valorNumerico = valor ? 1 : 0;
    $.ajax({
        url: "../controlador/cvdocumentos_obligatorios.php?op=ActualizarEstadoRutTarjetaProfesional",
        type: "POST",
        data: {
            "valor": valorNumerico,
            "id_usuario_cv": id_usuario_cv,
            "nombre_documentos": nombre_documentos,
        },
        success: function (datos) {
            const respuesta = JSON.parse(datos);
            if (respuesta.estatus === 1) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: respuesta.valor || 'Se Inserto Correctamente.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta.valor || 'Ocurrió un error al guardar.',
                });
            }
        },
    });
}








function mostrarDocumentosObligatorios() {
    // $("#precarga").show();
    $.post("../controlador/cvdocumentos_obligatorios.php?op=mostrarDocumentosObligatorios", {}, function (e) {
            let datos = JSON.parse(e);
            $("#mostrar_documentos_obligatorios").html(datos[0]);
            // logica para mostrar y ocultar el boton de continuar
            var boton = true;
            // $("#precarga").hide();
            $('#mostrardocumentosobligatorios tbody tr').each(function () {
                var nombreDocumento = $(this).find('td').eq(1).text().trim(); // Nombre del documento
                var estadoDocumento = $(this).find('td').eq(2).text().trim(); // "Falta Subir" o enlace

                // Si falta el documento Y no es uno de los permitidos para omitir
                if (estadoDocumento === 'Falta Subir' &&
                    nombreDocumento !== 'Registro Único Tributario (RUT)' &&
                    nombreDocumento !== 'Tarjeta Profesional') {
                    boton = false;
                    return false; // detener loop
                }
            });
            if (boton) {
                $('#boton_continuar').show();
            } else {
                $('#boton_continuar').hide();
            }
            $("#mostrardocumentosobligatorios").dataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
                "iDisplayLength": 15,
            });
            verificarEstadoDocumentos();
        }
    );
}


// function mostrarDocumentosObligatorios() {
//     // $("#precarga").show();
//     $.post("../controlador/cvdocumentos_obligatorios.php?op=mostrarDocumentosObligatorios", {}, function (e) {
//             var r = JSON.parse(e);
//             $("#mostrar_documentos_obligatorios").html(r);
//             // $("#precarga").hide();
//             $("#mostrardocumentosobligatorios").dataTable({
//                 dom: "Bfrtip",

//                 buttons: [
//                     {
//                         extend: "excelHtml5",
//                         text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
//                         titleAttr: "Excel",
//                     },
//                 ],
//                 "iDisplayLength": 15,
//             });
//             verificarEstadoDocumentos();
//         }
//     );
// }




function mostrarArchivo() {
    // $("#precarga").show();
    $.post("../controlador/cvdocumentos_obligatorios.php?op=mostrarotrosestudios", {}, function (e) {
            var r = JSON.parse(e);
            $("#modal-mostrar-otros-estudios").modal("show");
            $("#mostrar_documentos_otros-estudios").html(r);
            // $("#precarga").hide();
            $("#mostrardocumentosootrosestudios").dataTable({
                dom: "Bfrtip",

                buttons: [
                    {
                        extend: "excelHtml5",
                        text: '<i class=" text-center fa fa-file-excel fa-2x" style="color: green"></i>',
                        titleAttr: "Excel",
                    },
                ],
                "iDisplayLength": 15,
            });
        }
    );
}


function CrearDocumentoObligatorio(id_usuario_cv, nombre_documentos) {
    $("#id_usuario_cv_documento_obligatorio").val(id_usuario_cv);
    $("#nombre_tipos_documentos").val(nombre_documentos);
    $("#modal-documentos_obligatorios").modal("show");
}




function mostrarform(num) {
    // Lógica de activación de formularios
    for (let i = 1; i <= 10; i++) {
        if (i === num) {
            $("#caract-" + i).addClass("inactivo").removeClass("activo");
            $("#form" + i).show();
        } else {
            $("#caract-" + i).addClass("activo").removeClass("inactivo");
            $("#form" + i).hide();
        }
    }
}


// avanza dependiendo del paso en el que este al siguiente formulario
// function avanzarAlSiguientePaso() {
//     for (let i = 1; i <= 10; i++) {
//         if ($("#form" + i).is(":visible")) {
//             if (i === 8) {
//                     activarPasosPorPorcentaje(80);  
//                     actualizar_porcentaje_paso8();
//             } else {
//                 mostrarform(i + 1);
//             }
//             break;
//         }
//     }
// }

function avanzarAlSiguientePaso() {
    //para saber en que paso vamos y el porcentaje del paso.
    const porcentajePorPaso = {
        1: 11,
        2: 22,
        3: 33,
        4: 44,
        5: 55,
        6: 66,
        7: 77,
        8: 88,
        9: 90,
        10: 100
    };
    // tomamos el porcentaje actual que esta en base de datos
    let porcentaje_actual_bd = Number($("#porcentaje_avance").val());
    for (let i = 1; i <= 10; i++) {
        if ($("#form" + i).is(":visible")) {
            // let porcentaje = porcentajePorPaso[i];
            let porcentaje;
            // en caso de que en la base de datos este el 100% cuando le dan en continuar carga todos los pasos activados
            if (porcentaje_actual_bd == 100) {
                porcentaje = porcentaje_actual_bd;
            } else {
                //determinamos el porcentaje dependiendo del paso en el que vamos
                porcentaje = porcentajePorPaso[i];
            }
            if (porcentaje) {
                actualizar_porcentaje_continuar(id_usuario_cv_global, porcentaje, i);
                activarPasosPorPorcentaje(porcentaje);
                // si estamos en el paso 8 documentos obligatorios actualiza el porcentaje de avance cuando le damos en continuar 
                if (i === 8) {
                    activarPasosPorPorcentaje(80);
                    actualizar_porcentaje_paso8();
                }
                // continuar al formulario siguiente.
                if (i < 10) {
                    mostrarform(i +1);
                }
                // cuando estamos en el ultimo formulario y le damos en el botond e finalizar nos lleva al primer formulario
                if (i === 10) {
                    mostrarform(1);
                }
            }
            break;
        }
    }
}

function actualizar_porcentaje_continuar(id_usuario_cv_global, porcentaje) {
    $.ajax({
        url: "../controlador/cv_educacion_formacion.php?op=actualizar_porcentaje_continuar",
        type: "POST",
        data: {
            "id_usuario_cv_global": id_usuario_cv_global,
            "porcentaje": porcentaje,
        },
        success: function (datos) {
            const respuesta = JSON.parse(datos);
            if (respuesta.estatus === 1) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: respuesta.valor || 'Se actualizó correctamente.',
                    timer: 1000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta.valor || 'Ocurrió un error al guardar.',
                });
            }
        }
    });
}



// actualizamos una vez se le da en continuar a 80% y mostramos el siguiente formulario
function actualizar_porcentaje_paso8(){
    $.ajax({
        url: "../controlador/cvdocumentos_obligatorios.php?op=actualizar_porcentaje_avance",
        type: "POST",
        data: {},
        success: function(datos){
            datos = JSON.parse(datos);
            mostrarform(9);
        }
    });
    
    
}
function activarPasosPorPorcentaje(porcentaje) {
    // calculamos cuantos pasos completos se deben activar se divide el porcentaje entre 10 ejemplo si es 70% 70/10 =7 estariamos en el paso 7.
    const pasos = Math.floor(porcentaje / 10);
    for (let i = 1; i <= 10; i++) {
        // buscamos el elemento del id 
        const $contenedor = $("#caract-" + i);
        // se busca la etiqueta <a> para acceder al paso
        const $botonpaso = $contenedor.find("a");
        $contenedor.show();
        if (i <= pasos) {
            $contenedor.removeClass("inactivo").addClass("activo");
            $botonpaso.removeClass("text-muted").css("pointer-events", "auto");
            // deshabilitamos para que le den click si no esta dentro del porcentaje
            $botonpaso.off("click").on("click", () => mostrarform(i));
        } else {
            $contenedor.removeClass("activo").addClass("inactivo");
            $botonpaso.addClass("text-muted").css("pointer-events", "none");
            $botonpaso.off("click");
        }
    }
}


// funcion para pasar el menu en dispositivos moviles por medio del boton mas.
function ajustarBotones(porcentaje) {
    // Asegúrate de que porcentaje sea un número, convirtiéndolo si es necesario
    porcentaje = Number(porcentaje);  // Convertir a número
    // si porcentaje no es un número o es nan, salimos de la función
    if (isNaN(porcentaje)) {
        return;
    }
    // Calcular cuantos pasos deben ser activados según el porcentaje
    const pasos_a_activar = Math.floor(porcentaje / 10); // devuelve el numero de botones a activar segun el porcentaje.
    // Obtener todos los botones
    const pasos = Array.from(document.querySelectorAll('#mostrar_categorias > .py-3.pl-3:not(#caract-dropdown)'));
    // Activar o desactivar botones según el porcentaje
    pasos.forEach((div, idx) => {
        const boton = div.querySelector("a");  // Suponiendo que los botones son enlaces dentro del div
        if (idx < pasos_a_activar) {
            $(div).removeClass("disabled")
                .css("pointer-events", "auto")  // Permitir clic
                .addClass("activo");
            boton.removeAttribute("disabled");  // Habilitar el botón
        } else {
            $(div).removeClass("activo")
                .addClass("disabled")
                .css("pointer-events", "none");  // Deshabilitar clic
            boton.setAttribute("disabled", "true");  // Deshabilitar el botón
        }
    });
    // Manejo del dropdown en pantallas pequeñas
    const contenedor = document.getElementById("mostrar_categorias");
    if (window.innerWidth >= 768) {
        // Para pantallas grandes, mostramos todos los botones
        contenedor.querySelectorAll('.py-3.pl-3').forEach(btn => btn.classList.remove('d-none'));
        document.getElementById("caract-dropdown").classList.add('d-none');
        return;
    }
    const botones = Array.from(contenedor.querySelectorAll('.py-3.pl-3:not(#caract-dropdown)'));
    const dropdown = document.getElementById("caract-dropdown");
    const dropdownMenu = dropdown.querySelector(".dropdown-menu");
    dropdownMenu.innerHTML = '';  // Limpiamos el contenido actual del dropdown
    dropdown.classList.add("d-none");  // Escondemos el dropdown si no es necesario
    botones.forEach(btn => btn.classList.remove("d-none"));  // Aseguramos que todos los botones esten visibles para el manejo del dropdown
    const maxVisible = 2;
    for (let i = 0; i < botones.length; i++) {
        if (i >= maxVisible) {
            const btn = botones[i];
            btn.classList.add("d-none");  // Ocultamos el boton si supera el número máximo visible
            const text = btn.innerText.trim();
            const item = document.createElement("a");
            item.href = "#";
            item.className = "dropdown-item";
            item.innerText = text;
            // Si el paso está activo, permitimos el click, si no, lo deshabilitamos
            if (i < pasos_a_activar) {
                item.onclick = () => {
                    mostrarform(i + 1);
                    document.querySelectorAll('#mostrar_categorias a').forEach(el => el.classList.remove('active'));
                    btn.querySelector('a').classList.add('active');
                    dropdown.querySelector('.label-text').textContent = text;
                };
            } else {
                // Deshabilitar: puedes agregar clase y/o estilos, y quitar el click
                item.classList.add('disabled'); // Bootstrap style
                item.style.pointerEvents = "none"; // Realmente impide el click
                item.style.opacity = 0.5; // Opcional: para darle un efecto visual
            }
            dropdownMenu.appendChild(item);  // Añadimos el item al dropdown
            dropdown.classList.remove("d-none");  // Mostramos el dropdown
        }
    }
}
// paso 
function cerrarPopoverEducacionformacion() {
    const popover = document.querySelector("#popoverFormularioEducacionyFormacion");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-educacion_formacion").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearEducacionFormacionPopover(event) {
    event.stopPropagation();
    cerrarPopoverEducacionformacion();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverFormularioEducacionyFormacion");
    const contenedor = document.querySelector("#form2");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
}

function cerrarLaboral() {
    const popover = document.querySelector("#popoverLaboral");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-experiencia_laboral").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearLaboralPopover(event) {
    event.stopPropagation();
    cerrarLaboral();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverLaboral");
    const contenedor = document.querySelector("#form3");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
    document.querySelector("#trabajo_actual_no").checked = true;
    document.querySelector("#ocultar_hasta_cuando").style.display = "block";
}
//paso 4 habilidades
function cerrarHabilidadesyAptitudes() {
    const popover = document.querySelector("#popoverhabilidadesyaptitudes");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-habilidades_aptitudes").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearHabilidadesyAptitudesPopover(event) {
    event.stopPropagation();
    cerrarHabilidadesyAptitudes();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverhabilidadesyaptitudes");
    const contenedor = document.querySelector("#form4");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
}


//paso 5 portafolio
function cerrarPortafolio() {
    const popover = document.querySelector("#popoverPortafolio");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-portafolio").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearPortafolioPopover(event) {
    event.stopPropagation();
    cerrarPortafolio();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverPortafolio");
    const contenedor = document.querySelector("#form5");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
}

//paso 6 referencia personales
function cerrarReferenciaPersonal() {
    const popover = document.querySelector("#popoverReferenciaPersonal");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-referencias_personales").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearReferenciaPersonalPopover(event) {
    event.stopPropagation();
    cerrarReferenciaPersonal();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverReferenciaPersonal");
    const contenedor = document.querySelector("#form6");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
}

//paso 7 referencia laborales
function cerrarReferenciaLaboral() {
    const popover = document.querySelector("#popoverReferenciaLaboral");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-referencias_personales").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearReferenciaLaboralPopover(event) {
    event.stopPropagation();
    cerrarReferenciaLaboral();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverReferenciaLaboral");
    const contenedor = document.querySelector("#form7");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
}


//paso 9 Documentos Adicionales
function cerrarDocumentosAdicionales() {
    const popover = document.querySelector("#popoverDocumentosAdicionales");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-documentos_adicionales").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearDocumentosAdicionalesPopover(event) {
    event.stopPropagation();
    cerrarDocumentosAdicionales();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverDocumentosAdicionales");
    const contenedor = document.querySelector("#form9");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
}


//paso 10 Areas de conocmiento.
function cerrarAreaConocimiento() {
    const popover = document.querySelector("#popoverAreaConocimiento");
    if (!popover) return;
    popover.style.display = "none";
    document.getElementById("form-areas_de_conocimiento").reset();
    $('.selectpicker').val('').selectpicker('refresh');
}
function CrearAreaConocimientoPopover(event) {
    event.stopPropagation();
    cerrarAreaConocimiento();
    const boton = event.currentTarget;
    const popover = document.querySelector("#popoverAreaConocimiento");
    const contenedor = document.querySelector("#form10");
    const contenedorRect = contenedor.getBoundingClientRect();
    const buttonRect = boton.getBoundingClientRect();
    const offsetTop = buttonRect.top - contenedorRect.top + boton.offsetHeight + 5;
    const offsetLeft = buttonRect.left - contenedorRect.left;
    popover.style.top = `${offsetTop}px`;
    popover.style.left = `${offsetLeft}px`;
    popover.style.display = "block";
    popover.classList.remove("d-none");
    contenedor.appendChild(popover);
}


// actualizamos el estado de la experiencia docente.
function ActualizarEstadoExperienciaDocente(valor, id_usuario_cv) {
    // const valorNumerico = valor ? 1 : 0;
    $.ajax({
        url: "../controlador/cv_informacion_personal.php?op=ActualizarEstadoExperienciaDocente",
        type: "POST",
        data: {
            "valor": valor,
            "id_usuario_cv": id_usuario_cv,
        },
        success: function (datos) {
            const respuesta = JSON.parse(datos);
            if (respuesta.estatus === 1) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: respuesta.valor || 'Se Inserto Correctamente.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta.valor || 'Ocurrió un error al guardar.',
                });
            }
        },
    });
}

// actualizamos el estado de la experiencia docente.
function ActualizarEstadoPoliticamenteExpuesto(valor, id_usuario_cv) {
    console.log(id_usuario_cv);
    // const valorNumerico = valor ? 1 : 0;
    $.ajax({
        url: "../controlador/cv_informacion_personal.php?op=ActualizarEstadoPoliticamenteExpuesto",
        type: "POST",
        data: {
            "valor": valor,
            "id_usuario_cv": id_usuario_cv,
        },
        success: function (datos) {
            const respuesta = JSON.parse(datos);
            if (respuesta.estatus === 1) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: respuesta.valor || 'Se Inserto Correctamente.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: respuesta.valor || 'Ocurrió un error al guardar.',
                });
            }
        },
    });
}


function ocultar_input_hasta_cuando(valor) {
    if (valor === "1") {
        $("#ocultar_hasta_cuando").hide();
        $("#hasta_cuando").removeAttr("required");
        $("#hasta_cuando").val("");
    } else {
        $("#ocultar_hasta_cuando").show();
        $("#hasta_cuando").show().attr("required", true);
    }
}


function cerrarPopoverPoliticamenteExpuesto() {
  const popover = document.querySelector("#popoverFormularioPoliticamenteExpuesto");
  if (!popover) return;

  popover.style.display = "none";

  const form = document.getElementById("form-PoliticamenteExpuesto");
  if (form) form.reset();

  // Solo si existe jQuery/Bootstrap-select
  if (window.jQuery && typeof $ === "function" && $('.selectpicker').length) {
    $('.selectpicker').val('').selectpicker('refresh');
  }
}

function CrearPoliticamenteExpuestoPopover(event) {
  event.stopPropagation();
  cerrarPopoverPoliticamenteExpuesto(); // ya es segura, no rompe

  const boton   = event.currentTarget;
  const popover = document.getElementById("popoverFormularioPoliticamenteExpuesto");
  if (!popover || !boton) return;

  // Asegura que el popover esté en <body>
  if (popover.parentElement !== document.body) {
    document.body.appendChild(popover);
  }

  // Muestra temporalmente para medir altura/ancho
  popover.style.display = "block";
  popover.style.visibility = "hidden";

  const r = boton.getBoundingClientRect();
  const popRect = popover.getBoundingClientRect();

  let top;
  if (r.top >= popRect.height + 10) {
    // Suficiente espacio arriba → colócalo arriba
    top = r.top - popRect.height - 5 + window.scrollY;
  } else {
    // No hay espacio arriba → colócalo abajo
    top = r.bottom + 5 + window.scrollY;
  }

  const left = r.left + window.scrollX;

  popover.style.position = "absolute";
  popover.style.top  = `${top}px`;
  popover.style.left = `${left}px`;
  popover.style.visibility = "visible"; // ahora sí visible
  popover.classList.remove("d-none");
}




