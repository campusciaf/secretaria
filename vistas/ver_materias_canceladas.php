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
$menu=1;
$submenu=15;
require 'header.php';
	if ($_SESSION['vermateriascanceladas']==1)
	{
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Materias canceladas</span><br>
                        <span class="fs-16 f-montserrat-regular">Visualiza las materias que han sido canceladas</span>
                    </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                    <button class="btn btn-sm btn-outline-warning px-2 py-0 primer_tour" onclick='iniciarTour()'><i
                            class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Materias canceladas</li>
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
                                            <span class="">Materias canceladas</span> <br>
                                            <span class="text-semibold fs-20">Campus virtual</span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="col-12 table-responsive p-2" id="listadoregistros">
                                <table id="tbllistado" class="table" style="width: 100%;">
                                    <thead>
                                        <th>Id estudiante</th>
                                        <th>Documento</th>
                                        <th>Programa</th>
                                        <th>Materia</th>
                                        <th>Periodo Cursó</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

                            <script type="text/javascript" src="scripts/ver_materias_canceladas.js"></script>
                            <?php
}
	ob_end_flush();
?>