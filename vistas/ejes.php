<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 2;
   $submenu = 200;
   require 'header.php';

   if ($_SESSION['adminejes'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Formatos</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione las plataformas a las cuales tenemos
                            acceso</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión de Formatos</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                <div class="row">
                    <div class="col-12 card">
                        <div class="row">
                            <div class="col-6 p-2 tono-3">
                                <div class="row align-items-center">
                                    <div class="pl-3">
                                        <span class="rounded bg-light-blue p-3 text-primary ">
                                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="col-10">
                                        <div class="col-5 fs-14 line-height-18">
                                            <span class="">Formatos institucionales</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-6 tono-3 text-right py-4 pr-4">
                             <button class="btn btn-success pull-right" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Eje </button></h1>

                            </div>
                            <div class="col-12 table-responsive p-2" id="listadoregistros">
                                <table id="tbllistado" class="table" style="width: 100%;">
                                    <thead>
                                    <th>Opciones</th>
                              <th>Nombre del eje</th>
                              <th>Periodo</th>
                              <th>Objetivo</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>



                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="row">
                                        <div class="form-group col-xl-8 col-lg-6 col-md-12 col-sm-12">
                                            <label>Nombre:</label>
                                            <input type="hidden" name="id_ejes" id="id_ejes">
                                            <input type="text" class="form-control" name="nombre_ejes" id="nombre_ejes"
                                                maxlength="50" placeholder="Nombre del Eje" required>
                                        </div>
                                        <div class="form-group col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                            <label>Periodo:</label>
                                            <select class="form-control" name="periodo" id="periodo" required>
                                                <option value="2019-1" name="2019-1">2019-1</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <label>Objetivo:</label>
                                            <textarea class="form-control" name="objetivo" id="objetivo" rows="10"
                                                required>
                           </textarea>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                    class="fa fa-save"></i> Guardar</button>
                                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                                                    class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>

<?php
   } else {
      require 'noacceso.php';
   }

   require 'footer.php';
   ?>

<script type="text/javascript" src="scripts/ejes.js"></script>

<?php
}
ob_end_flush();
?>