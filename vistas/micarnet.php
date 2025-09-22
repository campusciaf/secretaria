<?php
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 7;
   require 'header_estudiante.php';

   if (!empty($_SESSION['id_usuario'])) {
?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
   .content-header {
      background-color: transparent !important;
   }

   .card.tono-2 {
      border-radius: 10px;
      transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
   }

   /* Modo oscuro */
   body.tema-oscuro .tono-2 {
      background-color: #1e2a47;
      color: white;
      border: 1px solid #2f3b59;
   }

   /* Modo claro */
   body.tema-claro .tono-2 {
      background-color: #dbe9ff; /* azul pastel */
      color: #132252;
      border: 1px solid #b0c4de;
   }

   .card select {
      background-color: transparent;
      color: inherit;
   }

   .card h4,
   .card h5,
   .card label,
   .card p {
      color: inherit;
   }

   .card img {
      max-height: 80px;
      object-fit: contain;
   }

   @media (max-width: 768px) {
      .conte {
         flex-direction: column !important;
      }
   }
</style>

<div id="precarga" class="precarga"></div>

<div class="content-wrapper">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h2 class="m-0 line-height-16 pl-4">
                  <span class="titulo-2 fs-18 text-semibold">Carnet Estudiantil</span><br>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'>
                  <i class="fa-solid fa-play"></i> Tour
               </button>
            </div>
         </div>
      </div>
   </div>

   <section class="content">
      <div class="card col-12 p-4">
         <div class="row">
            <!-- Columna izquierda -->
            <div class="col-md-4 col-12 mb-4">
               <div class="card tono-2 p-3">
                  <h4 class="mb-3">Selecciona Programa</h4>
                  <div class="form-group mb-3 position-relative check-valid">
                     <div class="form-floating">
                        <select required class="form-control border-start-0 selectpicker" data-live-search="true" name="programa_carnet" id="programa_carnet">
                        </select>
                        <label for="programa_carnet">Programa</label>
                     </div>
                     <div class="invalid-feedback">Por favor selecciona un programa válido</div>
                  </div>
               </div>

               <!-- Carnet -->
               <div class="card tono-2 p-3 mt-3">
                  <h5 class="mb-3">Carnet Estudiantil</h5>
                  <div class="carnets d-flex flex-wrap justify-content-start gap-4"></div>
               </div>
            </div>

            <!-- Columna derecha (convenios) -->
            <div class="col-md-8 col-12">
               <div class="card tono-2 p-3">
                  <h5 class="mb-3">Convenios</h5>
                  <div class="convenios d-flex flex-wrap justify-content-start gap-4"></div>
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

   require 'footer_estudiante.php';
?>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Script personalizado -->
<script type="text/javascript" src="scripts/micarnet.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

<?php
}
ob_end_flush();
?>

</body>
</html>
