<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])){
  header("Location: ../");
}else{
	$menu=1;
	require 'header_estudiante.php';
?>

<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-xl-6 col-9">
                <h2 class="m-0 line-height-16" >
					<span class="titulo-2 fs-18 text-semibold">Historial académico</span><br>
                    <span class="fs-14 f-montserrat-regular">De un vistaso a sus expereiancias CIAF</span>
                </h2>
                </div>
                <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                </div>
                <div class="col-12 migas mb-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel_estudiante.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Historial académico</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
	
        <section class="container-fluid px-4">
			<div class="row">
				<div class="col-12 card">
					<div class="row">
						<div class="col-12 tono-3 py-4 borde-bottom" id="nombretabla">
							<div class="row align-items-center">
								<div class="col-auto pl-4">
									<span class="rounded bg-light-blue p-3 text-primary ">
										<i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
									</span> 
								</div>
								<div class="col-10 line-height-18">
									<span class="">Programas</span> <br>
									<span class="text-semibold fs-20">Matriculados</span> 
								</div>
							</div>
						</div>
						<div class="col-12 p-4 table-responsive" id="listadoregistros" >
							<table id="tbllistado" class="table table-hover" style="width:100%">
								<thead>
									<th id="t-paso1">Acciones</th>
									<th id="t-paso3">Programa</th>
									<th id="t-paso4">Jornada</th>
									<th id="t-paso5">Semestre</th>
									<th id="t-paso6">Grupo</th>
									<th id="t-paso7">Estado</th>
									<th id="t-paso8">Periodo Activo</th>
								</thead>
								<tbody>                            
								</tbody>
							</table>
						</div>
					
						<div id="listadomaterias" class="col-12"></div>
						
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</section>				  
    </div><!-- /.content-wrapper -->



		


<?php
	
require 'footer_estudiante.php';
?>
<script src="scripts/historialacademico.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
	ob_end_flush();
?>