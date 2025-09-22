<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
    header("Location: ../");
} else {
    $menu = 30;
    $submenu = 3003;

    require 'header.php';

    if ($_SESSION['graduadosgeneral'] == 1) {
?>
        <div id="precarga" class="precarga"></div>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-xl-8 col-lg-7 col-md-8 col-9">
                            <h2 class="m-0 line-height-16">
                                <span class="titulo-2 fs-18 text-semibold">Consulta Graduados</span><br>
                                <span class="fs-16 f-montserrat-regular">Un vinculo que no termina</span>
                            </h2>
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-4 col-3 pt-4 pr-4 text-right">
                            <button class="btn btn-sm btn-outline-warning px-2 py-0" data-bs-toggle="tooltip" data-bs-placement="top" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                        </div>
                        <div class="col-12 migas">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                                <li class="breadcrumb-item active">Consulta Graduados</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="row mx-0">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                        <div class="row tono-3">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-6 py-4 tono-3">
                                <div class="row align-items-center">
                                <div class="col-auto ">
                                    <span class="rounded bg-light-blue p-3 text-primary ">
                                        <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <div class="col-auto line-height-18">
                                        <span class="">Egresados</span> <br>
                                        <span class="text-semibold fs-20">General</span>
                                </div>
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-6 text-right py-4 ">
                                <button class="btn btn-primary" id="btnagregar" data-toggle="modal" data-target="#reportModal">
                                    Reporte caracterización
                                </button>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-3">
                                <div class="row ">
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
                                        <a onclick="listargraduados(7)" title="ver cifras" class="row pointer my-2 mr-1">
                                            <div class="col-auto rounded bg-light-red p-2">
                                                <div class="text-red text-center pt-1">
                                                    <i class="fa-regular fa-calendar-check fa-2x  text-red"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 borde">
                                                <span class="">Técnicos laborales</span><br>
                                                <span class="text-semibold fs-20" id="tecnico_laboral"></span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
                                        <a onclick="listargraduados(1)" title="ver cifras" class="row pointer my-2 mr-1">
                                            <div class="col-auto rounded bg-light-orange p-2">
                                                <div class="text-red text-center pt-1">
                                                    <i class="fa-regular fa-calendar-check fa-2x text-orange "></i>
                                                </div>
                                            </div>
                                            <div class="col-9 borde">
                                                <span class="">Técnicos profesionales</span><br>
                                                <span class="text-semibold fs-20" id="tecnico_profesional"></span>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
                                        <a onclick="listargraduados(2)" title="ver cifras" class="row pointer my-2 mr-1">
                                            <div class="col-auto rounded bg-light-green p-2">
                                                <div class="text-red text-center pt-1">
                                                    <i class="fa-regular fa-calendar-check fa-2x text-green"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 borde">
                                                <span class="">Tecnólogos</span><br>
                                                <span class="text-semibold fs-20" id="tecnologo"></span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
                                        <a onclick="listargraduados(3)" title="ver cifras" class="row pointer my-2 mr-1">
                                            <div class="col-auto rounded bg-light-purple p-2">
                                                <div class="text-red text-center pt-1">
                                                    <i class="fa-regular fa-calendar-check fa-2x text-purple"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 borde">
                                                <span class="">Profesioanles</span><br>
                                                <span class="text-semibold fs-20" id="profesional"></span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-xl-2 col-lg-4 col-md-4 col-6">
              
                                        <a onclick="listargraduados(0)" title="ver cifras" class="row pointer my-2 mr-1">
                                            <div class="col-auto rounded bg-light-yellow p-2">
                                                <div class="text-red text-center pt-1">
                                                    <i class="fa-regular fa-calendar-check fa-2x text-yellow"></i>
                                                </div>
                                            </div>
                                            <div class="col-9 borde">
                                                <span class="">General</span><br>
                                                <span class="text-semibold fs-20" id="total_general"></span>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                </a>
                            </div>

                            <div class="col-lg-12 table-responsive card" id="listadoregistrosmeta">
                                <table id="tbllistadograduados" class="table ">
                                    <thead>
                                        <th>Opciones</th>
                                        <th>Nombre Estudiante</th>
                                        <th>Documento</th>
                                        <th>Celular</th>
                                        <th>ECAES</th>
                                        <th>Programa</th>
                                        <th>Correo Personal</th>
                                        <th>Correo Institucional</th>
                                        <th>Acta de Grado</th>
                                        <th>Folio</th>
                                        <th>Fecha Grado</th>
                                        <th>Periodo Ingreso</th>
                                        <th>Periodo grado</th>
                                        <th>Tiempo sem.</th>
                                        <th>Jornada</th>
                                        <th>Estado</th>
                                        <th>Ciclo</th>
                                        <th>Periodo Activo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                             
                        </div>
                    </div>
                </div>
            </section>
        </div>



        <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reportModalLabel">Reporte de Caracterización</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body table-responsive">
                        <table id="tblconsultaegresadoModal" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Correo ciaf</th>
                                    <th>Programa</th>
                                    <th>¿Tienes hijos?</th>
                                    <th>Número de hijos</th>
                                    <th>¿Trabajas?</th>
                                    <th>Tipo trabajador</th>
                                    <th>Empresa donde trabajas</th>
                                    <th>Sector de empresa</th>
                                    <th>Cargo</th>
                                    <th>Profesión</th>
                                    <th>Salario</th>
                                    <th>Estudio adicional</th>
                                    <th>Formación</th>
                                    <th>Tipo de Formación</th>
                                    <th>Informacion</th>
                                    <th>Posgrado</th>
                                    <th>Colaborativa</th>
                                    <th>Actualización</th>
                                    <th>Recomendar</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="myModalHistorial">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Historial</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="overflow: auto">
                            <div id="historial"></div>
                            <br>
                            <div class="alert" style="width:100%; clear: both">
                                <h3>Historial Seguimiento</h3><br>
                                <table id="tbllistadohistorialegresado" class="table" width="100%">
                                    <thead>
                                        <th>Caso</th>
                                        <th>Motivo</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de observación</th>
                                        <th>Asesor</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <br>
                                <h3>Historial Tareas Programadas</h3>
                                <table id="tblseguimientohistorialegresado" class="table" width="100%">
                                    <thead>
                                        <th>Estado</th>
                                        <th>Motivo</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de observación</th>
                                        <th>Asesor</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal" id="myModalAgregar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Agregar seguimiento</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div style="overflow: auto">
                            <div id="agregarContenido"></div>
                            <br>
                            <form name="formularioAgregarSeguimiento" id="formularioAgregarSeguimiento" method="POST" class="card col-12">
                                <h3>Registrar Seguimiento</h3>
                                <input type="hidden" name="id_credencial_tabla" id="id_credencial_tabla" value="">
                                <div class="form-group col-lg-12">
                                    <span id="contador">600 Caracteres permitidos</span>
                                    <textarea class="form-control" name="mensaje_seguimiento" id="mensaje_seguimiento" maxlength="600" placeholder="Escribir Seguimiento" rows="6" required onKeyUp="cuenta()"></textarea>
                                </div>


                                <div class="col-12 pb-4 pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="customRadio1" name="motivo_seguimiento" value="cita" required="">
                                        <label class="custom-control-label" for="customRadio1">Cita</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="customRadio2" name="motivo_seguimiento" value="llamada" required="">
                                        <label class="custom-control-label" for="customRadio2">Llamada</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="customRadio3" name="motivo_seguimiento" value="seguimiento" required="">
                                        <label class="custom-control-label" for="customRadio3">Seguimiento</label>
                                    </div>
                                </div>

                                <button class="btn btn-success" type="submit" id="btnGuardarSeguimiento"><i class="fa fa-save"></i> Registrar</button>
                            </form>
                            <form name="formularioTarea" id="formularioTarea" method="POST" class="card col-12">
                                <h3>Programar tarea</h3>
                                <input type="hidden" name="id_credencial_tarea" id="id_credencial_tarea">
                                <span id="contadortarea">150 Caracteres permitidos</span>
                                <textarea class="form-control" name="mensaje_tarea" id="mensaje_tarea" maxlength="600" placeholder="Escribir Mensaje" rows="6" required onKeyUp="cuentatarea()"></textarea>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_programada" id="fecha_programada" required>
                                                <label>Día</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-12 mt-2">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="time" placeholder="" value="" class="form-control border-start-0" name="hora_programada" id="hora_programada" required>
                                                <label>Hora</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                </div>
                                <div class="col-12 pb-4 pl-3">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="customRadio4" name="motivo_tarea" value="cita" required="">
                                        <label class="custom-control-label" for="customRadio4">Cita</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="customRadio5" name="motivo_tarea" value="llamada" required="">
                                        <label class="custom-control-label" for="customRadio5">Llamada</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" id="customRadio6" name="motivo_tarea" value="seguimiento" required="">
                                        <label class="custom-control-label" for="customRadio6">Seguimiento</label>
                                    </div>
                                </div>
                                <!-- <input type="submit" value="Programar Tarea" id="btnGuardarTarea" name="enviar tareas" class="btn btn-danger"> -->
                                <button class="btn btn-success" type="submit" id="btnGuardarTarea"><i class="fa fa-save"></i> Programar Tarea</button>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- modal editar -->
        <div class="modal fade" id="formularioegresados" tabindex="-1" aria-labelledby="formularioegresados" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Formulario de Egresados</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 panel-body">
                                    <form name="formulario_editar" id="formulario_editar" method="POST">

                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="title">Datos Personales de Egresados</h6>
                                            </div>
                                            <input type="hidden" name="id_estudiante" id="id_estudiante">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_nombre" id="credencial_nombre" maxlength="100">
                                                        <label>Primer Nombre</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_nombre_2" id="credencial_nombre_2" maxlength="100">
                                                        <label>Segundo Nombre</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_apellido" id="credencial_apellido" maxlength="100">
                                                        <label>Primer Apellido</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_apellido_2" id="credencial_apellido_2" maxlength="100">
                                                        <label>Segundo Apellido</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>


                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="20">
                                                        <label>Número Identificación</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_nacimiento" id="fecha_nacimiento">
                                                        <label>Fecha de Nacimiento</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_sangre" id="tipo_sangre"></select>
                                                        <label>Tipo de Sangre</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="genero" id="genero" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                        <label>Genero</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="grupo_etnico" id="grupo_etnico" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                        <label>Grupo Etnico</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>

                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_etnico" id="nombre_etnico" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                        <label>Nombre Etnico</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>

                                            <div class="col-12">
                                                <h6 class="title">Datos de Contacto</h6>
                                            </div>
                                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="departamento_nacimiento" id="departamento_nacimiento" onChange="mostrarmunicipio(this.value)"></select>
                                                        <label>Departamento Nacimiento</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>

                                            <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="lugar_nacimiento" id="lugar_nacimiento"></select>
                                                        <label>Municipio Nacimiento</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-6 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0 direccion" name="direccion" id="direccion" maxlength="70">
                                                        <label>Dirección de Residencia</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-6 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0 barrio" name="barrio" id="barrio" maxlength="70">
                                                        <label>Barrio de Residencia</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0 telefono" name="telefono" id="telefono" maxlength="20">
                                                        <label>Teléfono Fijo</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0 celular" name="celular" id="celular" maxlength="20">
                                                        <label>Número Celular</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="email" placeholder="" value="" class="form-control border-start-0 email" name="email" id="email" maxlength="50">
                                                        <label>Correo Personal</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                <div class="form-group mb-3 position-relative check-valid">
                                                    <div class="form-floating">
                                                        <input type="text" placeholder="" value="" class="form-control border-start-0 instagram" name="instagram" id="instagram" maxlength="50">
                                                        <label>Instagram</label>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please enter valid input</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="myModalData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Caracterizacion Egresado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section class="container-fluid px-4">
                            <!-- First Section: Data Authorization -->
                            <div id="section-authorization" class="row">
                                <div class="col-12 tono-3 py-4">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="rounded bg-light-blue p-3 text-primary">
                                                <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <div class="col-10 line-height-18">
                                            <span class="">Caracterización</span> <br>
                                            <span class="titulo-2 text-semibold fs-20 line-height-18">Egresado</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 py-4">
                                    <p class="text-justify">
                                        ¡Te invitamos a responder las siguientes preguntas, queremos conocerte más para que sigamos creando experiencias juntos!
                                    </p>
                                    <h2 class="fs-18 titulo-2 text-semibold">Autorización de datos personales</h2>
                                    <p class="text-justify">
                                        Conforme lo establece la Ley 1581 de 2012 y sus decretos reglamentarios,
                                        manifiesto, de manera libre, previa y expresa, que con el diligenciamiento
                                        de la presento encuesta, autorizo a CIAF, para realizar la recolección,
                                        tratamiento, almacenamiento y uso de los datos que suministro, cuya finalidad es:
                                        Brindar al estudiante servicios de bienestar institucional y social,
                                        Realizar Gestión administrativa, contable y financiera, Atención de (PQRS),
                                        Obtener datos con Fines históricos y estadísticos, Realizar Publicidad y mercadeo,
                                        Cumplir Requerimientos institucionales y del Ministerio de Educación Nacional.
                                    </p>
                                    <p class="text-justify">
                                        En virtud de lo anterior, autorizo a CORPORACIÓN INSTITUTO DE ADMINISTRACIÓN Y FINANZAS –CIAF-,
                                        a realizar el tratamiento de datos personales para los fines previamente comunicados y acepto la política
                                        de tratamiento de datos personales publicada
                                        <a href="https://ciaf.edu.co/tratamientodatos" target="_blank" title="Tratamiento de datos">https://ciaf.edu.co/tratamientodatos</a>
                                    </p>
                                    <form name="formulariodata" id="formulariodata" method="POST">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="1" name="acepto" id="acepto" required>
                                                <input type="hidden" value="" name="id_credencial_e" id="id_credencial_e" required>
                                                <a href="https://ciaf.digital/public/web_tratamiento_datos/politicaciaf_tratamientodatos.pdf" target="_blank">Acepto términos y condiciones</a>
                                            </label><br>
                                            <button class="btn btn-success btn-block" type="submit" id="btnData">Continuar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="myModalCaraterizacion">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Caracterizacion Egresado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Second Section: Questions -->
                        <div class="row">
                            <form name="formulariodatos" id="formulariodatos" method="POST">
                                <div class="col-xl-12" id="preguntas"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php
    } else {
        require 'noacceso.php';
    }

    require 'footer.php';
    ?>

    <script type="text/javascript" src="scripts/consultagraduadosgeneral.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>