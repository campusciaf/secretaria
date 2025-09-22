<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"]))
{
  header("Location: ../");
}
else
{
$menu=14;
$submenu=1427;
require 'header.php';

	if ($_SESSION['oncentercontinuada']==1)
	{
?>
<div id="precarga" class="precarga"></div>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<!--Contenido-->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Ingresa Clientes</span><br>
                        <span class="fs-16 f-montserrat-regular">Obtenga toda la información de sus clientes en un solo
                            sitio</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour " onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 d-none segundo_tour"
                        onclick='iniciarSegundoTour()'><i class="fa-solid fa-play"></i> Tour 2da parte</button>
                </div>

                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Ingresar clientes</li>
                    </ol>
                </div>

                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>

    <section class="container-fluid px-4 py-2">
        <div class="row">

            <div id="titulo" class="col-12 "></div>

            <div class="col-4 p-4 card" id="t-CL">
                <div class="row">
                    <input type="hidden" value="" name="tipo" id="tipo">


                    <div class="col-12">
                        <h3 class="titulo-2 fs-14">Ingresar cliente</h3>
                    </div>
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill"
                                    href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                    aria-selected="true" onclick="muestra(1)">Identificacion validada</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                    aria-selected="false" onclick="muestra(2)">Identificación temporal</a>
                            </li>

                        </ul>
                    </div>

                    <div class="col-12 mt-2" id="input_dato">
                        <div class="row">
                            <div class="col-10 m-0 p-0">
                                <div class="form-group position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" class="form-control border-start-0"
                                            name="dato" id="dato" required>
                                        <label id="valortitulo">Seleccionar tipo</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-2 m-0 p-0">
                                <input type="submit" value="Buscar" onclick="consultacliente()"
                                    class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-4 borde-right" id="datos_estudiante">


                <div class="col-12 px-2 py-3 ">
                    <div class="row align-items-center" id="t-NC">
                        <div class="pl-4">
                            <span class="rounded bg-light-white p-2 text-gray ">
                                <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18" >
                                <span class="">Nombres </span> <br>
                                <span class="text-semibold fs-14">Apellidos </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 py-2 ">
                    <div class="row align-items-center" id="t-Ce">
                        <div class="pl-4">
                            <span class="rounded bg-light-white p-2 text-gray">
                                <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="">Correo electrónico</span> <br>
                                <span class="text-semibold fs-14">correo@correo.com</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 px-2 py-2 ">
                    <div class="row align-items-center" id="t-NT">
                        <div class="pl-4">
                            <span class="rounded bg-light-white p-2 text-gray">
                                <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                            </span>

                        </div>
                        <div class="col-10">
                            <div class="col-5 fs-14 line-height-18">
                                <span class="">Número celular</span> <br>
                                <span class="text-semibold fs-14">+570000000</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

           
                <div class="col-4 " id="panel_detalle">
                    <div class="col-12  pt-3">
                        <div class="row">
                            <div class="col-4 mnw-100 text-center pt-4">
                                <i class="fa-solid fa-trophy avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x"
                                    aria-hidden="true"></i>
                                <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                <p class="small text-secondary">Caso</p>
                            </div>
                            <div class="col-4 mnw-100 text-center pt-4">
                                <i class="fa-solid fa-bullhorn avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x"
                                    aria-hidden="true"></i>
                                <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                <p class="small text-secondary">Campaña</p>
                            </div>
                            <div class="col-4 mnw-100 text-center pt-4">
                                <i class="fa-solid fa-user-check avatar avatar-50 bg-light-white text-gray rounded-circle mb-2 fa-2x"
                                    aria-hidden="true"></i>
                                <h4 class="titulo-2 fs-18 mb-0">-----</h4>
                                <p class="small text-secondary">Estado</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 datos_table">
                <div class="row mt-4" id="t-TP">
                    <div class="col-12 px-2 py-3 tono-3">
                        <div class="row align-items-center">
                            <div class="pl-4">
                                <span class="rounded bg-light-blue p-2 text-primary ">
                                    <i class="fa-solid fa-table"></i>
                                </span>

                            </div>
                            <div class="col-10">
                                <div class="col-5 fs-14 line-height-18">
                                    <span class="">Programas</span> <br>
                                    <span class="text-semibold fs-14">Matriculados</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 card p-4">

                        <table class="table" id="tbl_datos">
                            <thead>
                                <tr>
                                    <th id="t-CS">Caso</th>
                                    <th id="t-P">Nombre curso</th>
                                    <th id="t-P">Estado Curso</th>
                                    <th id="t-Jr">Jornada</th>
                                    <th id="t-FI">Fecha ingresa</th>
                                    <th id="t-ME">Medio</th>
                                    <th id="t-ES">Estado</th>
                                    <th id="t-PC">Periodo campaña</th>
                                    <th id="AC">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- <div class="row datos_table"></div> -->
        <div class="col-12" id="panel_resultado"></div>





        <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->
<!-- inicio modal entrevista -->

<div id="modalNuevoCurso" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Educación continuada</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card card-primary" style="padding: 2% 1%">
                        <div class="panel-body" id="formularioregistros">
                            <form name="formularionuevocurso" id="formularionuevocurso" method="POST">
                                <div class="row">

                                    <div class="col-12" id="t-dp">
                                        <h6 class="title">Datos del curso</h6>
                                    </div>

                                    <input type="hidden" placeholder=""  class="form-control border-start-0" name="identificacion_nc" id="identificacion_nc" >

                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="curso_nc" id="curso_nc"></select>
                                                <label>Curso de interes activos</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>



                                    <div class="col-12" id="t-dpe">
                                        <h6 class="title">Información de campaña</h6>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="medio_nc" id="medio_nc"></select>
                                                <label>Medio de llegada</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="conocio_nc" id="conocio_nc"></select>
                                                <label>Como nos conocio</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="contacto_nc" id="contacto_nc"></select>
                                                <label>Como nos contácto</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button class="btn btn-success" type="submit" id="btnGuardar_nc"><i class="fa fa-save"></i> Registrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalNuevoEstudiante" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Educación continuada</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card card-primary" style="padding: 2% 1%">
                        <div class="panel-body" id="formularioregistros">
                            <form name="nuevacredencialcondatos" id="nuevacredencialcondatos" method="POST">
                                <div class="row">

                                    <div class="col-12" id="t-dp">
                                        <h6 class="title">Datos interesado</h6>
                                    </div>

                                    <input type="hiddens" placeholder=""  class="form-control border-start-0" name="continuada_identificacion" id="continuada_identificacion" >

                                    <div class="col-12">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="continuada_nombre" id="continuada_nombre" required>
                                                <label id="valortitulo">Primer Nombre</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="continuada_nombre_2" id="continuada_nombre_2">
                                                <label id="valortitulo">Segundo Nombre</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="continuada_apellidos" id="continuada_apellidos" required>
                                                <label id="valortitulo">Primer Apellido</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="continuada_apellidos_2" id="continuada_apellidos_2" >
                                                <label id="valortitulo">Segundo Apellido</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="continuada_login" id="continuada_login" required>
                                                <label id="valortitulo">Correo</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" class="form-control border-start-0" name="continuada_datos_telefono" id="continuada_datos_telefono" required>
                                                <label id="valortitulo">Número de Contacto</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button class="btn btn-success btn-block" type="submit" id="btnGuardar_nc"><i class="fa fa-save"></i> Registrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalHabilitarModuloEstudiante" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Habilitar Módulo</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card card-primary" style="padding: 2% 1%">
                        <div class="panel-body" id="formularioregistros">
                            <form name="formularionuevoestudiante" id="formularionuevoestudiante" method="POST">
                                <div class="row">

                                    <div class="col-12" id="t-dp">
                                        <h6 class="title">Datos personales</h6>
                                    </div>

                                    <input type="hidden" placeholder=""  class="form-control border-start-0" name="usuario_identificacion_mc" id="usuario_identificacion_mc" >

                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_nombre_mc" id="usuario_nombre_mc" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                                <label>Primer Nombre</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value=""  class="form-control border-start-0" name="usuario_nombre_2_mc" id="usuario_nombre_2_mc" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                <label>Segundo Nombre</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="usuario_apellido_mc" id="usuario_apellido_mc" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                                <label>Primer Apellido</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="text" placeholder="" value=""  class="form-control border-start-0" name="usuario_apellido_2_mc" id="usuario_apellido_2_mc" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                <label>Segundo Apellido</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3 position-relative check-valid">
                                            <div class="form-floating">
                                                <input type="email" placeholder="" value=""  class="form-control border-start-0" name="usuario_login_mc" id="usuario_login_mc" maxlength="100" required>
                                                <label>Correo usuario</label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">Please enter valid input</div>
                                    </div>

                                    

                                    <div class="col-12 text-center">
                                        <button class="btn btn-success" type="submit" id="btnGuardar_mc"><i class="fa fa-save"></i> Registrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- inicio modal agregar seguimiento -->
<div class="modal" id="myModalAgregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Agregar seguimiento</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div id="agregarContenido" class="row m-0 p-0 mb-4"></div>

                <form name="formularioAgregarSeguimiento" id="formularioAgregarSeguimiento" method="POST"
                    class="col-12 card p-0 m-0">
                    <div class="col-12">
                        <div class="row p-0 borde-bottom">
                            <div class="col-12 p-2">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-green p-2 text-success ">
                                            <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                        </span>

                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Registrar un</span> <br>
                                            <span class="text-semibold fs-20">Seguimiento</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_estudiante_agregar" id="id_estudiante_agregar" value="">
                    <div class="form-group col-lg-12 p-4">
                        <span id="contador">150 Caracteres permitidos</span>
                        <textarea class="form-control" name="mensaje_seguimiento" id="mensaje_seguimiento"
                            maxlength="150" placeholder="Escribir Seguimiento" rows="6" required
                            onKeyUp="cuenta()"></textarea>
                    </div>
                    <div class="form-group col-lg-12 px-4">
                        <div class="radio">
                            <label><input type="radio" name="motivo_seguimiento" id="motivo_seguimiento" value="Cita"
                                    required>Cita</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="motivo_seguimiento" value="Llamada">Llamada</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="motivo_seguimiento" value="Seguimiento">Seguimiento</label>
                        </div>


                        <!-- <div class="radio">
                        <label><input type="radio" name="motivo_seguimiento" value="Compromiso" >Compromiso</label>
                     </div> -->
                    </div>
                    <div class="col-12 p-4">
                        <button class="btn btn-success" type="submit" id="btnGuardarSeguimiento"><i
                                class="fa fa-save"></i> Registrar</button>
                    </div>
                </form>

                <form name="formularioTarea" id="formularioTarea" method="POST" class="card col-12 m-0 p-0 mt-4">

                    <div class="col-12">
                        <div class="row p-0 borde-bottom">
                            <div class="col-12 p-2">
                                <div class="row align-items-center">
                                    <div class="pl-4">
                                        <span class="rounded bg-light-red p-2 text-danger ">
                                            <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                                        </span>

                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Programar una</span> <br>
                                            <span class="text-semibold fs-20">Tarea</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id_estudiante_tarea" id="id_estudiante_tarea" value="">
                    <div class="col-12 pt-4" id="contadortarea">
                        150 Caracteres permitidos
                    </div>
                    <div class="col-12">
                        <textarea class="form-control" name="mensaje_tarea" id="mensaje_tarea" maxlength="150"
                            placeholder="Escribir Mensaje" rows="6" required="" onkeyup="cuentatarea()"></textarea>
                    </div>
                    <div class="col-12 px-4">
                        <div class="row col-12 m-0 p-0">
                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                <label>Dia:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="date" name="fecha_programada" id="fecha_programada"
                                        class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-12 col-12">
                                <label>Hora:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="time" name="hora_programada" id="hora_programada" class="form-control"
                                        required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-4">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="customRadio4" name="motivo_tarea"
                                value="cita" required="">
                            <label class="custom-control-label" for="customRadio4">Cita</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="customRadio5" name="motivo_tarea"
                                value="llamada" required="">
                            <label class="custom-control-label" for="customRadio5">Llamada</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="customRadio6" name="motivo_tarea"
                                value="seguimiento" required="">
                            <label class="custom-control-label" for="customRadio6">Seguimiento</label>
                        </div>
                    </div>

                    <div class="col-12 p-4">
                        <input type="submit" value="Programar Tarea" id="btnGuardarTarea" name="enviar tareas"
                            class="btn btn-danger">
                    </div>



                </form>

            </div>

        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="myModalHistorial">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Historial</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div id="historial" class="col-12"></div>

                    <div class="col-12 mt-4">
                        <div class="card card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                            href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                            aria-selected="true">Seguimiento</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-one-profile" role="tab"
                                            aria-controls="custom-tabs-one-profile" aria-selected="false">Tareas
                                            Programadas</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="card-body p-0">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-one-home-tab">

                                        <div class="row">
                                            <div class="col-12 p-4">
                                                <table id="tbllistadohistorial" class="table" width="100%">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-one-profile-tab">

                                        <table id="tbllistadoHistorialTareas" class="table" width="100%">
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
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- fin modal historial -->
<!-- inicio modal mover -->
<div class="modal" id="myModalMover">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Cambiar de estado</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form name="moverUsuario" id="moverUsuario" method="POST" class="row">
                    <input type="hidden" id="id_estudiante_mover" value="" name="id_estudiante_mover">

                    <p class="pl-3">Mover el estado de cliente</p>

                    <div class="col-12">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <select value="" required class="form-control border-start-0 selectpicker"
                                    data-live-search="true" name="estado" id="estado"></select>
                                <label>Cambiar por:</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>
                    <div class="col-12">
                        <input type="submit" value="Mover usuario" id="btnMover" class="btn btn-success btn-block">
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>
<!-- inicio modal camara -->
<div id="modalwebacam" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Foto para cliente</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="cc">
                        <input type="hidden" id="url">
                        <h2>Camara</h2>
                        <div class="col-md-12" id="my_camera"></div>
                    </div>
                    <div class="col-md-6 img"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="tomarfoto()" class="btn btn-info">Tomar foto</button>
                <button type="button" onclick="restablecer()" class="btn btn-warning">Restablecer</button>
                <button type="button" onclick="guardar()" class="btn btn-success">Guardar Foto</button>
            </div>
        </div>
    </div>
</div>

<!-- fin modal camara -->
<!-- inicio modal soporte_inscripcion -->
<div class="modal fade" id="soporte_inscripcion">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Soporte de inscripcion</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="resultado_ficha">
                <form id="form_soporte" method="post">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Soporte</label>
                        <input type="hidden" name="id" class="id_es">
                        <input type="file" name="soporte" class="form-control-file" id="exampleFormControlFile1">
                    </div>
                    <button type="submit" id="btnGuardarsoporte" class="btn btn-success"><i class="fa fa-save"></i>
                        Guardar</button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- fin modal soporte_inscripcion -->
<div class="modal" id="myModalValidarDocumento">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Cambio de Documento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <!-- Modal body -->
            <div class="modal-body" id="resultado_cambiar_documento">
                <div class="alert alert-info">
                    Este paso deja al interesado en <b>preinscrito</b> y tiene acceso a la plataforma de mercadeo para
                    llenar formulario de inscripción.
                </div>
                <h3>Documento actual</h3>
                <input type="text" id="cambio_cedula" value="" name="cambio_cedula" class="form-control"
                    readonly="readonly">
                <h3>Nuevo Documento</h3>
                <form name="cambioDocumento" id="cambioDocumento" method="POST">
                    <input type="hidden" id="id_estudiante_documento" value="" name="id_estudiante_documento">
                    <input type="text" id="nuevo_documento" name="nuevo_documento" class="form-control"
                        placeholder="Nuevo Documento" required="">
                    <input type="text" id="repetir_documento" name="repetir_documento" class="form-control"
                        placeholder="Repetir Documento" required="">
                    <h5>Modalidad Campaña</h5>
                    <select name="modalidad_campana" id="modalidad_campana" class="form-control selectpicker"
                        data-live-search="true" required>
                    </select>
                    <input type="submit" value="Cambiar Documento" id="btnCambiar" class="btn btn-success btn-block">
                </form>
                <div id="resultado_cedula"></div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/oncentercontinuada.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<!-- <script type="text/javascript" src="../public/webcam/js/webcam.min.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script> -->

<?php
}
	ob_end_flush();
?>