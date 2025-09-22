<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"]) && $_SESSION["usuario_cargo"] != "Funcionario") {
	header("Location: ../");
} else {
	$menu = 10;
	$submenu = 1021;
	require 'header.php';
	if ($_SESSION['consultamodalidad'] == 1) {
?>
<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-xl-6 col-9">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Modalidad de grado</span><br>
                     <span class="fs-14 f-montserrat-regular">Espacio para visulizar las modalidades de grado matriculadas.</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas mb-0">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Modalidades de grado</li>
                  </ol>
            </div>
         </div>
      </div>
   </div>

	<section class="container-fluid px-4">
		<div class="row">
			<div class="col-12 tono-3 ">
				<div class="row">
					<div class="col-8 pt-2 pl-4 ">
						<div class="row align-items-center pt-2">
							<div class="pl-4 ">
								<span class="rounded bg-light-green p-3 text-success ">
									<i class="fa-solid fa-headset" aria-hidden="true"></i>
								</span> 
							</div>
							<div class="col-10">
							<div class="col-8 fs-14 line-height-18"> 
								<span class="">Resultados</span> <br>
								<span class="text-semibold fs-16" id="dato_periodo">Campaña</span> 
							</div> 
							</div>
						</div>
					</div>

					<div class="col-4 p-0 m-0 pt-2 pr-4">
						<div class="form-group position-relative check-valid">
							<div class="form-floating">
								<select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="periodo" id="periodo" onchange="listar_modalidad(this.value)"></select>
								<label>Periodo Académico</label>
							</div>
						</div>
						<div class="invalid-feedback">Please enter valid input</div>
					</div>
				</div>
			</div>


			<div class="card col-12 p-4 table-responsive">
				<table id="tbllistado" class="table table-hover" style="width: 100%;">
					<thead>
						<td>Documento</td>
						<td>Nombre</td>
						<td>Programa</td>
						<td>Jornada</td>
						<td>Semestre</td>
						<td>Materia</td>
						<td>Modalidad</td>
					</thead>
					<tbody>
						<th colspan="13">
							<div class='jumbotron text-center' style="margin:0px !important">
								<h3>Aquí aparecerán los datos de las personas con modalidades matriculadas.</h3>
							</div>
						</th>
					</tbody>
				</table>
			</div>
				
			
		</div>

	</section>
</div>


		<style>
			.btn_tablas {
				background: white !important;
				font-size: 25px;
				margin-bottom: 5px;
			}
		</style>

	<?php
	} else {
		require 'noacceso.php';
	}
	require 'footer.php';
	?>
	<script src="scripts/consulta_modalidad.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
ob_end_flush();
?>