$(document).ready(function(){

    $(".rango_del_color").css("color", "yellow");
    $('.nav-tabs a').on('shown.bs.tab', function(event){
        
        var y = $(event.relatedTarget).data("id");//previous tab
        // alert(y);
        switch(y){
            case 1:
                guardarEditarInformacionPersonal();
            break;
        }
    });
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
            url: "../controlador/cv_informacion_personal_docente.php?op=guardaryeditarImagen",
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
function dividirCadena(cadenaADividir,separador, index) {
    if(cadenaADividir == "" || cadenaADividir === null){
        array = [];
        return array;
    }else{
        var arrayDeCadenas = cadenaADividir.split(separador);
        return arrayDeCadenas[index];
    }
    
}
function guardarEditarInformacionPersonal(){
    var formData = new FormData($("#informacion_personal_form")[0]);
    $.ajax({
        url: "../controlador/cv_informacion_personal_docente.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
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
                //console.log(datos);
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
    var formData = new FormData($("#form-experiencia_laboral")[0]);
    $.ajax({
        url: "../controlador/cv_informacion_personal_docente.php?op=guardaryeditarexperiencialaboral",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            /*console.log(datos);*/
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-experiencia_laboral')[0].reset();
                $('#modal-experiencia_laboral').modal('toggle');
                mostrarExperiencias();
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
        url: "../controlador/cv_informacion_personal_docente.php?op=mostrarexperiencias",
        type: "POST",
        success: function(datos){
            datos = JSON.parse(datos);
            //console.log(datos);
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{  
                    tabla += `<tr>
                                <td>
                                <button class="btn btn-flat btn-primary btn-sm" onclick="editarExperiencia(`+datos[""+cont].id_experiencia+`)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i>  </button>
                                <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarExperiencia(`+datos[""+cont].id_experiencia+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                                <td>`+datos[""+cont].nombre_empresa+`</td>
                                <td>`+datos[""+cont].cargo_empresa+`</td>
                                <td>`+datos[""+cont].desde_cuando+`</td>
                                <td>`+datos[""+cont].hasta_cuando+`</td>
                                <td>`+datos[""+cont].mas_detalles+`</td>
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
        }
    });
}
function editarExperiencia(id_experiencia){
    $.ajax({
        url: "../controlador/cv_informacion_personal_docente.php?op=verExperienciaEspecifica",
        type: "POST",
        data: {id_experiencia : id_experiencia},
        success: function(datos){
            datos = JSON.parse(datos);
            /*console.log(datos);*/
            $("#id_experiencia").val(datos[0].id_experiencia);
            $("#cargo_empresa").val(datos[0].cargo_empresa);
            $("#desde_cuando").val(datos[0].desde_cuando);
            $("#hasta_cuando").val(datos[0].hasta_cuando);
            $("#nombre_empresa").val(datos[0].nombre_empresa);
            $("#mas_detalles").val(datos[0].mas_detalles);
            $("#modal-experiencia_laboral").modal("show");
        }
    });
}
function eliminarExperiencia(id_experiencia){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar esta experiencia laboral?', 
        function(){ 
            $.ajax({
                url: "../controlador/cv_informacion_personal_docente.php?op=eliminarExperiencia",
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
    var formData = new FormData($("#form-educacion_formacion")[0]);
    $.ajax({
        url: "../controlador/cv_educacion_formacion.php?op=guardaryeditareducacion",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            /*console.log(datos);*/
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-educacion_formacion')[0].reset();
                $('#modal-educacion_formacion').modal('toggle');
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
            //console.log(datos);
            datos = JSON.parse(datos);
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
        }
    });
}
function editarEducacion(id_formacion){
    $.ajax({
        url: "../controlador/cv_educacion_formacion.php?op=verEducacionEspecifica",
        type: "POST",
        data: {id_formacion : id_formacion},
        success: function(datos){
            /*console.log(datos);*/
            datos = JSON.parse(datos);
            $("#id_formacion").val(datos[0].id_formacion);
            $("#titulo_obtenido").val(datos[0].titulo_obtenido);
            $("#desde_cuando_f").val(datos[0].desde_cuando_f);
            $("#hasta_cuando_f").val(datos[0].hasta_cuando_f);
            $("#institucion_academica").val(datos[0].institucion_academica);
            $("#mas_detalles_f").val(datos[0].mas_detalles_f);
            $("#modal-educacion_formacion").modal("show");
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
                    /*console.log(datos);*/
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
    var formData = new FormData($("#form-habilidades_aptitudes")[0]);
    $.ajax({
        url: "../controlador/cvhabilidad_aptitud.php?op=guardaryeditarhabilidad",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            /*console.log(datos);*/
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
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
function mostrarHabilidades(){
    if ( $.fn.DataTable.isDataTable('#table-habilidades_aptitudes') ) {
        $('#table-habilidades_aptitudes').DataTable().destroy();
    }

    $.ajax({
        url: "../controlador/cvhabilidad_aptitud.php?op=mostrarHabilidades",
        type: "POST",
        success: function(datos){
            // console.log(datos);
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{ 
                    var color;
                    switch(datos[""+cont].nivel_habilidad){
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

                    tabla+=`<tr>
                            <td>
                            <button class="btn btn-flat btn-primary btn-sm" onclick="editarHabilidad(`+datos[""+cont].id_habilidad+`)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i> </button>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarHabilidad(`+datos[""+cont].id_habilidad+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                            <td>`+datos[""+cont].nombre_categoria+`</td>
                            <td>
                                <div class="progress-group">
                                    <span class="progress-number"><b>`+datos[""+cont].nivel_habilidad+`</b>/5</span>
                                    <br>
                                    <div class="progress progress-sm active">
                                    <div class="progress-bar `+color+` progress-bar-striped" role="progressbar" aria-valuenow="`+(parseInt(datos[""+cont].nivel_habilidad) * 2)+`0" aria-valuemin="0" aria-valuemax="100" style="width: `+(parseInt(datos[""+cont].nivel_habilidad) * 2)+`0%">
                                      <span class="sr-only">`+(parseInt(datos[""+cont].nivel_habilidad) * 2)+`0% Complete</span>
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
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
        }
    });
}
function editarHabilidad(id_habilidad){
    $.ajax({
        url: "../controlador/cvhabilidad_aptitud.php?op=verHabilidadEspecifica",
        type: "POST",
        data: {id_habilidad : id_habilidad},
        success: function(datos){
            /*onsole.log(datos);*/
            datos = JSON.parse(datos);
            $("#id_habilidad").val(datos[0].id_habilidad);
            $("#categoria_habilidad").val(datos[0].nombre_categoria);
            $("#nivel_habilidad").val(datos[0].nivel_habilidad);
            $("#modal-habilidades_aptitudes").modal("show");
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
                    /*console.log(datos);*/
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
    var formData = new FormData($("#form-portafolio")[0]);
    $.ajax({
        url: "../controlador/cvportafolio.php?op=guardaryeditarportafolio",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            console.log(datos);
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-portafolio')[0].reset();
                $('#modal-portafolio').modal('toggle');
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
            //console.log(datos);
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
                    /*console.log(datos);*/
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
    var formData = new FormData($("#form-referencias_personales")[0]);
    $.ajax({
        url: "../controlador/cv_referencias_personales.php?op=guardaryeditarreferencias_personales",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            /*console.log(datos);*/
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-referencias_personales')[0].reset();
                $('#modal-referencias_personales').modal('toggle');
                mostrarReferenciasPersonales();
            }else{
                alertify.error(data.valor);
            }
        }
    });

}
function mostrarReferenciasPersonales(){
    if($.fn.DataTable.isDataTable('#table-referencias_personales')){
        $('#table-referencias_personales').DataTable().destroy();
    }

    $.ajax({
        url: "../controlador/cv_referencias_personales.php?op=mostrarReferenciasPersonales",
        type: "POST",
        success: function(datos){
            /*console.log(datos);*/
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
                            <td><button class="btn btn-flat btn-primary btn-sm" onclick="editarReferenciasPersonales(`+datos[""+cont].id_referencias+`)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i> </button><button class="btn btn-flat btn-danger btn-sm" onclick="eliminarReferenciaPersonal(`+datos[""+cont].id_referencias+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                            <td>`+datos[""+cont].referencias_nombre+`</td>
                            <td>`+datos[""+cont].referencias_profesion+`</td>
                            <td>`+datos[""+cont].referencias_empresa+`</td>
                            <td>`+datos[""+cont].referencias_telefono+`</td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-referencias_personales").html(tabla);
            $('#table-referencias_personales').DataTable({
                "dom": '',
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
        }
    });
}
function editarReferenciasPersonales(id_referencias){
    $.ajax({
        url: "../controlador/cv_referencias_personales.php?op=verReferenciaPersonalEspecifica",
        type: "POST",
        data: {id_referencias : id_referencias},
        success: function(datos){
            /*console.log(datos);*/
            datos = JSON.parse(datos);
            $("#id_referencias").val(datos[0].id_referencias);
            $("#referencias_nombre").val(datos[0].referencias_nombre);
            $("#referencias_profesion").val(datos[0].referencias_profesion);
            $("#referencias_empresa").val(datos[0].referencias_empresa);
            $("#referencias_telefono").val(datos[0].referencias_telefono);
            $("#modal-referencias_personales").modal("show");
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
                    /*console.log(datos);*/
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
    var formData = new FormData($("#form-referencias_laborales")[0]);
    $.ajax({
        url: "../controlador/cvreferencias_laborales.php?op=guardaryeditarreferencias_laborales",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            /*console.log(datos);*/
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-referencias_laborales')[0].reset();
                $('#modal-referencias_laborales').modal('toggle');
                mostrarReferenciasLaborales();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarReferenciasLaborales(){
    if ( $.fn.DataTable.isDataTable('#table-referencias_laborales') ) {
        $('#table-referencias_laborales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cvreferencias_laborales.php?op=mostrarReferenciasLaborales",
        type: "POST",
        success: function(datos){
            /*console.log(datos);*/
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
                            <button class="btn btn-flat btn-primary btn-sm" onclick="editarReferenciasLaborales(`+datos[""+cont].id_referenciasl+`)" data-toggle="tooltip" data-placement="bottom" title="Editar"> <i class="fas fa-pen"></i> </button>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarReferenciaLaborales(`+datos[""+cont].id_referenciasl+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i> </button></td>
                            <td>`+datos[""+cont].referencias_nombrel+`</td>
                            <td>`+datos[""+cont].referencias_profesionl+`</td>
                            <td>`+datos[""+cont].referencias_empresal+`</td>
                            <td>`+datos[""+cont].referencias_telefonol+`</td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-referencias_laborales").html(tabla);
            $('#table-referencias_laborales').DataTable({
                "dom": '',
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
        }
    });
}
function editarReferenciasLaborales(id_referenciasl){
    $.ajax({
        url: "../controlador/cvreferencias_laborales.php?op=verReferencialaboralespecifica",
        type: "POST",
        data: {id_referenciasl : id_referenciasl},
        success: function(datos){
            /*console.log(datos);*/
            datos = JSON.parse(datos);
            $("#id_referenciasl").val(datos[0].id_referenciasl);
            $("#referencias_nombrel").val(datos[0].referencias_nombrel);
            $("#referencias_profesionl").val(datos[0].referencias_profesionl);
            $("#referencias_empresal").val(datos[0].referencias_empresal);
            $("#referencias_telefonol").val(datos[0].referencias_telefonol);
            $("#modal-referencias_laborales").modal("show");
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
                    /*console.log(datos);*/
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
    var formData = new FormData($("#form-documentos_obligatorios")[0]);
    $.ajax({
        url: "../controlador/cvdocumentos_obligatorios.php?op=guardaryeditardocumentos_obligatorios",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            //console.log(datos);
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-documentos_obligatorios')[0].reset();
                $('#modal-documentos_obligatorios').modal('toggle');
                mostrarDocumentosObligatorios();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarDocumentosObligatorios(){
    if ( $.fn.DataTable.isDataTable('#table-documentos_obligatorios') ) {
        $('#table-documentos_obligatorios').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cvdocumentos_obligatorios.php?op=mostrarDocumentosObligatorios",
        type: "POST",
        success: function(datos){
            //console.log(datos);
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{  
                    url = dividirCadena(datos[""+cont].documento_archivo, "../", 1);
                    tabla+=`<tr>
                            <td>
                            <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarDocumentoObligatorio(`+datos[""+cont].id_documento+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i>  </button></td>
                            <td>`+datos[""+cont].documento_nombre+`</td>
                            <td>`+((datos[""+cont].documento_archivo == "")?"":`<a href="../cv/`+url+` " class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Documento en pesataña nueva"><i class="fas fa-link"></i></a>`)+`</td>
                        </tr>`;
                }
                cont++;
            }
            $(".body-documentos_obligatorios").html(tabla);
            $('#table-documentos_obligatorios').DataTable({
                "dom": '',
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
        }
    });
}
function eliminarDocumentoObligatorio(id_documento){
    alertify.confirm('Confirmar eliminación', 'Realmente desea eliminar este dato?', 
        function(){ 
            $.ajax({
                url: "../controlador/cvdocumentos_obligatorios.php?op=eliminarDocumentoObligatorio",
                type: "POST",
                data: {"id_documento": id_documento},
                success: function(datos){
                    /*console.log(datos);*/
                    datos = JSON.parse(datos);
                    alertify.message(datos.valor);
                    mostrarDocumentosObligatorios();
                }
            });
        }, 
        function(){ 
            alertify.error('Cancelado')
        }
    );   
}
//Documentos adicionales
function guardarDocumentosAdicionales(){
    var formData = new FormData($("#form-documentos_adicionales")[0]);
    $.ajax({
        url: "../controlador/cvdocumentos_adicionales.php?op=guardaryeditardocumentos_adicionales",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            console.log(datos);
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-documentos_adicionales')[0].reset();
                $('#modal-documentos_adicionales').modal('toggle');
                mostrarDocumentosAdicionales();
            }else{
                alertify.error(data.valor);
            }
        }
    });
}
function mostrarDocumentosAdicionales(){
    if ( $.fn.DataTable.isDataTable('#table-documentos_adicionales') ) {
        $('#table-documentos_adicionales').DataTable().destroy();
    }
    $.ajax({
        url: "../controlador/cvdocumentos_adicionales.php?op=mostrarDocumentosAdicionales",
        type: "POST",
        success: function(datos){
            //console.log(datos);
            datos = JSON.parse(datos);
            var cont = 0;
            var tabla = "";
            while(cont < datos.length){
                if(datos[""+cont].id_usuario_cv == 0){
                    tabla += `<li class="list-group-item">
                                <div class="jumbotron text-center"> <h3> Aún no hay Registros. </h3></div>
                            </li>`;
                }else{  
                    url = dividirCadena(datos[""+cont].documento_archivoA, "../", 1);
                    tabla+=`<tr>
                                <td>
                                <button class="btn btn-flat btn-danger btn-sm" onclick="eliminarDocumentoAdicional(`+datos[""+cont].id_documentoA+`)" data-toggle="tooltip" data-placement="bottom" title="Eliminar"> <i class="fas fa-trash"></i> 
                                </button></td>
                                <td>`+datos[""+cont].documento_nombreA+`</td>
                                <td>`+((datos[""+cont].documento_archivoA == "")?"":`<a href="../cv/`+url+`" class="btn btn-link" target="_blank" data-toggle="tooltip" data-placement="left" title="Abrir Documento en pesataña nueva"><i class="fas fa-link"></i></a>`)+`</td>
                            </tr>`;
                }
                cont++;
            }
            $(".body-documentos_adicionales").html(tabla);
            $('#table-documentos_adicionales').DataTable({
                "dom": '',
                "destroy" : true,
                "paging": false,
                "destroy" : true,
            });
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
                    //console.log(datos);
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
    var formData = new FormData($("#form-areas_de_conocimiento")[0]);
    $.ajax({
        url: "../controlador/cv_areas_de_conocimiento.php?op=guardaryeditararea",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){	
            /*console.log(datos);*/
            var data = JSON.parse(datos);
            if(data.estatus == 1){  
                alertify.success(data.valor);
                $('#form-areas_de_conocimiento')[0].reset();
                mostrarAreas();
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
            //console.log(datos);
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
                    /*console.log(datos);*/
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
