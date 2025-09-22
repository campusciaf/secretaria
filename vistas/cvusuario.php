<?php //Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: login.html");
} else {
    $menu = 28;
    $submenu = 2803;
    require 'header.php';
    if ($_SESSION['vitaeusuarioadmin'] == 1) {
?>

<div id="precarga" class="precarga"></div>

<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Hojas de vida</span><br>
                        <span class="fs-14 f-montserrat-regular">Elige los perfiles y estilos de profesionales que más se adapten a tus gustos y necesidades.</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="panel_admin.php">Inicio</a></li>
                    <li class="breadcrumb-item active">Hojas de vida</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content" style="padding-top: 0px;">

        <div class="row p-3">
            <div class="col-md-3 mt-2">
                <div class="rounded bg-purple p-2"><label for="estado_info">Buscar por Estado </label>
                    <select class="form-control" id="estado_info" name="estado_info">
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="interesado">Interesado</option>
                        <option value="contratado">Contratado</option>
                        <option value="desvinculado">Desvinculados</option>
                    </select><br>
                </div>
            </div>

            <div class="col-md-3 mt-2">
                <div class="rounded bg-primary p-2">
                    <label for="categoria_profesional">Buscar por Categoria </label>
                    <select class="form-control" id="categoria_profesional" name="categoria_profesional">
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="Administracion">Administracion</option>
                        <option value="Agropecuaria">Agropecuaria</option>
                        <option value="Alimentos">Alimentos</option>
                        <option value="Arquitectura">Arquitectura</option>
                        <option value="Arte diseño">Arte diseño</option>
                        <option value="Banca finanzas">Banca finanzas</option>
                        <option value="Comercio">Comercio</option>
                        <option value="Construccion">Construccion</option>
                        <option value="Consultoria">Consultoria</option>
                        <option value="Defensa">Defensa</option>
                        <option value="Economia contabilidad">Economia contabilidad</option>
                        <option value="Educacion">Educacion</option>
                        <option value="Electronica">Electronica</option>
                        <option value="Energia">Energia</option>
                        <option value="Entretenimiento">Entretenimiento</option>
                        <option value="Farmaceutica">Farmaceutica</option>
                        <option value="Gas">Gas</option>
                        <option value="Gobierno">Gobierno</option>
                        <option value="Hoteles turismo">Hoteles turismo</option>
                        <option value="Ingenieria tecnologia">Ingenieria tecnologia</option>
                        <option value="Inmobiliaria">Inmobiliaria</option>
                        <option value="Informatica internet">Informatica internet</option>
                        <option value="Juridica">Juridica</option>
                        <option value="Manufactura">Manufactura</option>
                        <option value="Marketing ventas">Marketing ventas</option>
                        <option value="Medios prensa">Medios prensa</option>
                        <option value="Petroleo">Petroleo</option>
                        <option value="Publicidad">Publicidad</option>
                        <option value="Quimica">Quimica</option>
                        <option value="Recursos humanos">Recursos humanos</option>
                        <option value="Salud">Salud</option>
                        <option value="Seguros">Seguros</option>
                        <option value="Telecomunicaciones">Telecomunicaciones</option>
                        <option value="Textil">Textil</option>
                        <option value="Transporte">Transporte</option>
                        <option value="Otros">Otros</option>
                    </select><br>
                </div>   
            </div> 

            <div class="col-md-3 mt-2">
                <div class="rounded bg-navy p-2"><label for="area_conocimiento">Buscar por Area de Conocimiento </label>
                    <select class="form-control" id="area_conocimiento" name="area_conocimiento">
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="Legislación laboral">Legislación laboral</option>
                        <option value="Legislación comercial">Legislación comercial</option>
                        <option value="Legislación tributaria">Legislación tributaria</option>
                        <option value="Régimen de importaciones y exportaciones">Régimen de importaciones y exportaciones</option>
                        <option value="Matemáticas">Matemáticas</option>
                        <option value="Contabilidad">Contabilidad</option>
                        <option value="Finanzas">Finanzas</option>
                        <option value="Planeación">Planeación</option>
                        <option value="Administración">Administración</option>
                        <option value="Economía">Economía</option>
                        <option value="Mercadeo">Mercadeo</option>
                        <option value="Talento Humano">Talento Humano</option>
                        <option value="Logística y distribución internacional">Logística y distribución internacional</option>
                        <option value="Proyectos empresariales">Proyectos empresariales</option>
                        <option value="Tecnologías de la Información">Tecnologías de la Información</option>
                        <option value="Programación de Software">Programación de Software</option>
                        <option value="Desarrollo en Java, PHP, HTML5 y CSS">Desarrollo en Java, PHP, HTML5 y CSS</option>
                        <option value="Administración de bases de datos DBA">Administración de bases de datos DBA</option>
                        <option value="Emprendimiento y planes de negocio">Emprendimiento y planes de negocio</option>
                        <option value="Diseño gráfico">Diseño gráfico</option>
                        <option value="Negocios Internacionales">Negocios Internacionales</option>
                        <option value="Administración documental">Administración documental</option>
                        <option value="Gestión Bancaria">Gestión Bancaria</option>
                        <option value="Atención a la primera infancia">Atención a la primera infancia</option>
                        <option value="Mantenimiento de computadores">Mantenimiento de computadores</option>
                        <option value="Salud ocupacional">Salud ocupacional</option>
                        <option value="Inglés">Inglés</option>
                        <option value="Organización de eventos">Organización de eventos</option>
                        <option value="Metodología de la investigación">Metodología de la investigación</option>
                        <option value="Lectoescritura">Lectoescritura</option>
                        <option value="Teoría del conocimiento">Teoría del conocimiento</option>
                    </select>
                    <br>
                </div>
            </div> 

            <div class="col-md-3 mt-2">
                <div class="rounded bg-teal p-2"><label for="fecha_solicitud">Buscar por Fecha de Solicitud </label><input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud"><br>
                </div>
            </div>

            <div class="card card-primary col-12 mx-0 mt-4" style="padding: 2%" >
                <div class="panel-body table-responsive" id="listadoregistros">
                    <table id="tbllistado" class="table table-condensed table-hover" style="width:100%">
                        <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Celular</th>
                            <th>Email</th>
                            <th>Titulo Obtenido</th>
                            <th>Fecha Ingreso</th>
                            <th>Estado</th>
                            <th>% Avance pasos</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="card card-primary col-12 m-0" style="padding: 2%" id="formularioregistros">
                <form name="formulario" class="row" id="formulario" method="POST">
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Nombres(*): 
                        </label> 
                        <div class="input-group"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fas fa-user-tag"></i>
                            </span> 
                            <input type="hidden" name="id_usuario_cv" id="id_usuario_cv"> 
                            <input type="text" class="form-control" name="nombres" id="usuario_nombre" maxlength="100" placeholder="Nombre Completo" required onchange="javascript:this.value=this.value.toUpperCase();"> 
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Apellidos(*):
                        </label> 
                        <div class="input-group"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fas fa-user-tag"></i>
                            </span> 
                            <input type="text" class="form-control" name="apellidos" id="usuario_apellido" maxlength="100" placeholder="Apellidos Completos" required onchange="javascript:this.value=this.value.toUpperCase();"> 
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Número Identificación(*):
                        </label> 
                        <div class="input-group"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fas fa-id-card"></i>
                            </span> 
                            <input type="text" class="form-control" name="identificacion" id="usuario_identificacion" maxlength="20" placeholder="Documento" required> 
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Fecha de nacimiento(*):
                        </label>
                        <div class="input-group"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fas fa-calendar-day"></i>
                            </span> 
                            <input type="date" class="form-control" name="usuario_fecha_nacimiento" id="usuario_fecha_nacimiento" required> 
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Departamento Nacimiento:
                        </label>
                        <div class="input-group border"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fa fa-city"></i>
                            </span> 
                            <select id="usuario_departamento" name="usuario_departamento" class="form-control selectpicker" data-live-search="true" required>
                            </select> 
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Municipio Nacimiento:
                        </label>
                        <div class="input-group border"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fa fa-city"></i>
                            </span> 
                            <select id="usuario_municipio" name="usuario_municipio" class="form-control selectpicker" data-live-search="true" required></select> 
                        </div>
                    </div>
            
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
                        <label>
                            Dirección:
                        </label> 
                        <div class="input-group"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fas fa-street-view"></i>
                            </span> 
                            <input type="text" class="form-control" name="usuario_direccion_cv" id="usuario_direccion_cv" placeholder="Dirección" maxlength="70" onchange="javascript:this.value=this.value.toUpperCase();"> 
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label>
                            Celular:
                        </label> 
                        <div class="input-group"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fas fa-phone-square"></i>
                            </span> 
                            <input type="text" class="form-control" name="usuario_celular_cv" id="usuario_celular_cv" maxlength="20" placeholder="Celular"> 
                        </div>
                    </div>
                    <div class="form-group col-lg-3 col-md-6 col-sm-12 col-xs-12"> 
                        <label>
                            Email:
                        </label> 
                        <div class="input-group"> 
                            <span class="input-group-text input-group-addon" style="background-color: white !important;">
                                <i class="fas fa-envelope-open-text"></i>
                            </span>
                            <input type="email" class="form-control" name="email" id="usuario_email_cv" maxlength="50" placeholder="Email"> 
                        </div>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                        <button class="btn btn-primary" type="submit" id="btnGuardar">
                            <i class="fa fa-save"></i> Guardar
                        </button> 
                        <button class="btn btn-danger" onclick="cancelarform()" type="button"
                        ><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>

    </section>

</div>    <!-- /.content wrapper-->

<div class="modal fade in" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"> 
            <h4 class="modal-title">Citar Entrevista</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" method="post" name="form_entrevista" id="form_entrevista">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nombre_usuario">Mi nombre:</label> 
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Ingresa tu nombre completo" required> 
                        </div>
                        <div class="form-group"> 
                            <label for="celular_usuario">Número de teléfono:</label> 
                            <input type="number" class="form-control" id="celular_usuario" name="celular_usuario" placeholder="ingresa tu número de teléfono" required>
                        </div>
                        <div class="form-group"> 
                            <label for="mi_correo_electronico">Mi Correo Electronico:</label> 
                            <input type="email" class="form-control" id="mi_correo_electronico" name="mi_correo_electronico" placeholder="Ingresa tu correo electronico" required> 
                        </div>
                        <div class="form-group"> 
                            <label for="correo_electronico">Correo Electronico:</label> 
                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" placeholder="Ingresa correo del destinatario" required> 
                        </div>
                        <div class="form-group"> 
                            <label for="direccion_entrevista">Direccion de la entrevista:</label>
                            <input type="text" class="form-control" id="direccion_entrevista" name="direccion_entrevista" placeholder="dirección" required> 
                        </div>
                        <div class="form-group"> 
                            <label for="fecha_entrevista">Fecha de la entrevista:</label> 
                            <input type="date" class="form-control" id="fecha_entrevista" name="fecha_entrevista" required> 
                        </div>
                        <div class="form-group"> 
                            <label for="hora_entrevista">Hora de la entrevista:</label> 
                            <input type="time" class="form-control" id="hora_entrevista" name="hora_entrevista" required> 
                        </div>
                        <div class="form-group"> 
                            <label for="comentario_entrevista">Comentarios adicionales:</label> 
                            <input type="text" class="form-control" id="comentario_entrevista" name="comentario_entrevista" placeholder=""> 
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button> 
                    <button type="submit" class="btn btn-success">Citar</button> 
            </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/cvusuario.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>