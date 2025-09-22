<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 23;
   $submenu = 2316;
   require 'header.php';
   if ($_SESSION['sofi_reporte_general'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h1 class="m-0"><small id="nombre_programa"></small> Total estudiantes </h1>
                  </div>
                  <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="panel.php"> Inicio </a></li>
                        <li class="breadcrumb-item active"> Reporte general Pagos </li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content" style="padding-top: 0px;">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                  <div class="card card-primary" style="padding: 2% 1%">
                     <div class="col-12">
                        <select class="form-control" name="periodo" id="periodo" onchange="listar(this.value)">
                           <option value="2024-1" selected></option>
                        </select>
                     </div>
                     <div class="row justify-content-md-center table-responsive">
                        <table id="listado_estudiantes" class="table text-center">
                           <thead>
                              <th>Documento</th>
                              <th>Nombre</th>
                              <th>Semestre</th>
                              <th>Jornada</th>
                              <th>Id programa</th>
                              <th>Descripción pago</th>
                              <th>Valor Pecuniario</th>
                              <th>Valor Semestre </th>
                              <th>Valor Aporte</th>
                              <th>Valor Pagado</th>
                              <th>Valor Descuento</th>
                              <th>Valor Crédito</th>
                              <th>Tipo Matricula</th>
                              <th>Tipo Estudiante</th>
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
<?php
   } else {
      require 'noacceso.php';
   }
   require 'footer.php';
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/sofi_reporte_general.js?<?= date("Y-m-d-H:i:s"); ?>"></script>