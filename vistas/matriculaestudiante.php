<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
    header("Location: ../");
}else{
	$menu = 5;
    $submenu = 501;
    require 'header.php';
	if($_SESSION['matricularestudiante']==1){
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Matricula estudiante</span><br>
                        <span class="fs-14 f-montserrat-regular">Espacio para matricular estudiantes a un programa académico.</span>
                </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Matricular estudiante</li>
                    </ol>
            </div>
            </div>
        </div>
    </div>
    <section class="container-fluid px-4">
        <!--Fondo de la vista -->
        <div class="row">

        
            <div class="col-4" id="seleccionprograma">
                <form name="formularioverificar" id="formularioverificar" method="POST" class="row">
                    <div class="col-9 m-0 p-0">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <input type="text" placeholder="" value="" required class="form-control border-start-0" name="credencial_identificacion" id="credencial_identificacion" maxlength="20">
                                <label>Número Identificación</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                    </div>

                    <div class="col-3 m-0 p-0">
                        <button type="submit" id="btnVerificar" class="btn btn-success py-3">Buscar</button> 
                    </div>
                </form>
            </div>

            <div class="col-8" id="mostrardatos">
                <div class="row">
                    <div class="col-4 py-2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="rounded bg-light-white p-2 text-gray ">
                                    <i class="fa-solid fa-user-slash" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                                <span class="">Nombres </span> <br>
                                <span class="text-semibold fs-14">Apellidos </span> 
                            </div>
                        </div>
                    </div>

                    <div class="col-4 py-2">
                        <div class="row align-items-center">
                            <div class="col-auto ">
                                <span class="rounded bg-light-white p-2 text-gray">
                                    <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                                <span class="">Correo electrónico</span> <br>
                                <span class="text-semibold fs-14">correo@correo.com</span> 
                            </div>
                        </div>
                    </div>

                    <div class="col-4 py-2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="rounded bg-light-white p-2 text-gray">
                                    <i class="fa-solid fa-mobile-screen" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10">
                                <span class="">Número celular</span> <br>
                                <span class="text-semibold fs-14">+570000000</span> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="card col-12 table-responsive p-4" id="listadoregistros">
                <table id="tbllistado" class="table table-hover" style="width:100%">
                    <thead>
                        <th>Id estudiante</th>
                        <th>Programa</th>
                        <th>Jornada</th>
                        <th>Escuela</th>
                        <th>Estado</th>
                        <th>Grupo</th>
                        <th>Nuevo del</th>
                        <th>Periodo Activo</th>
                    </thead>
                    <tbody>                            
                    </tbody>
                </table>
            </div>

            <div class=" col-12" id="formularioregistros">
                <div class="row">

                    <div class="col-12 text-center p-4">
                        <h3 class="titulo-3 text-bold fs-24">«El buen <span class="text-gradient">rendimiento comienza</span>  con una <span class="text-gradient">actitud positiva»</span></h3>
                        <p class="lead text-secondary">El secreto de avanzar es comenzar». —Mark Twain</p>
                    </div>

                    <div class="col-12 tono-3 p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="rounded bg-light-blue p-3 text-primary ">
                                    <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                </span> 
                            
                            </div>
                            <div class="col-10 line-height-16">
                                <span class="">Formulario</span> <br>
                                <span class="text-semibold fs-20 line-height-16">Nuevo estudiante</span> 
                            </div>
                        </div>
                    </div>

                    <form name="formulario" id="formulario" class="card col-12 p-4" method="POST">	
                        <div class="row">
                            <input type="hidden" name="credencial_usuario" id="credencial_usuario">

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="credencial_nombre" id="credencial_nombre" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Primer Nombre</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value=""  class="form-control border-start-0" name="credencial_nombre_2" id="credencial_nombre_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Segundo Nombre</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value="" required="" class="form-control border-start-0" name="credencial_apellido" id="credencial_apellido" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Primer Apellido</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="text" placeholder="" value=""  class="form-control border-start-0" name="credencial_apellido_2" id="credencial_apellido_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                        <label>Segundo Apellido</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                <div class="form-group mb-3 position-relative check-valid">
                                    <div class="form-floating">
                                        <input type="mail" placeholder="" value="" required class="form-control border-start-0 usuario_email" name="credencial_login" id="credencial_login" maxlength="50" required>
                                        <label>Correo CIAF</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please enter valid input</div>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar registro</button>
                                <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Crear nuevo estudiante</button>
                               
                            </div>
                        </div>

                    </form>

                </div>
            </div>


        </div>    
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="myModalAgregarPrograma" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Matricular Nuevo Programa Académico</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form name="formulario2" class="col-12 row" id="formulario2" method="POST">  
					    <input type="hidden" id="id_credencial" name="id_credencial">

                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="fo_programa" id="fo_programa"></select>
                                    <label>Programa Académico</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada_e" id="jornada_e"></select>
                                    <label>Jornada de estudio</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-6">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="grupo" id="grupo"></select>
                                    <label>Grupo</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>

                        <div class="col-12">
                                <h6 class="title">Pago de la matricula</h6>
                            </div>
                            <p class="pl-2">Esta opción define el valor a cancelar de la matricula financiera</p>

                        <div class="col-12">
                            <div class="form-group mb-3 position-relative check-valid">
                                <div class="form-floating">
                                    <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="pago" id="pago">
                                        <option value="1">Pago normal</option>
                                        <option value="0">Pago con Nivelatorio</option>
                                    </select>
                                    <label>Pago de la matricula</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please enter valid input</div>
                        </div>


                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				            <button class="btn btn-success btn-block" type="submit" id="btnGuardar2"><i class="fa fa-save"></i> Matricular programa</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal para ingresar los datos del estudiante al momento de cambiar el estado a graduado -->
<div id="cambio_estado_graduado" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambio Estado Graduado</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="box box-info">
                        <div class="alert alert-warning alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h5><i class="icon fas fa-exclamation-triangle"></i> Atención!</h5>
                              Campos obligatorios para registrar Estudiante Graduado
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <input type="hidden" id="data"/>
                        <input type="hidden" id="id_estudiante"/>
                        <input type="hidden" id="id_credencial"/>
                        <input type="hidden" id="id_programa_ac"/>
                        <form id="datos_graduado" class="form-horizontal">
                            <div class="box-body row">
                                <div class="form-group col-12 row">
                                    <label for="periodo_grado" class="col-sm-2 control-label">Periodo Grado</label>
                                    <div class="col-sm-10">
                                        <select name="periodo_grado" class="form-control" id="periodo_grado" required ></select>
                                    </div>
                                </div>
                                <div class="form-group col-12 row">
                                    <label for="cod_saber_pro" class="col-sm-2 control-label">Código Saber Pro</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="cod_saber_pro" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 row">
                                    <label for="acta_grado" class="col-sm-2 control-label">Acta de Grado</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="acta_grado" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 row">
                                    <label for="folio" class="col-sm-2 control-label">Folio</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="folio" required>
                                    </div>
                                </div>
                                <div class="form-group col-12 row">
                                    <label for="fecha_grado" class="col-sm-2 control-label">Fecha Grado</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="fecha_grado" required>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="registrarGraduado()">Guardar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<?php
    }else{
        require 'noacceso.php';
    }		
    require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/matriculaestudiante.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>