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
$submenu=1410;
require 'header.php';
	if ($_SESSION['oncenternuevocliente']==1)
	{
		
	
function generarCodigo($longitud) {
	//  $key = '';
	//  $pattern = '1234567890';
	//  $max = strlen($pattern)-1;
	//  for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
	//  return $key;

   $num = rand(1000000000,9999999999);
   return $num;
}
$id="1".generarCodigo(10);

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
            <div class="col-sm-6">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Nuevos Clientes</span><br>
                     <span class="fs-16 f-montserrat-regular">Ingrese nuevos clientes a tus campañas</span>
               </h2>
            </div>
            <div class="col-6 pt-4 pr-4 text-right">
            <button class="btn btn-sm btn-outline-warning px-2 py-0"  onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
               
            </div>

            <div class="col-12 migas">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Nuevo cliente</li>
                  </ol>
            </div>
            
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <section class="content" style="padding-top: 0px;">
      <div class="row">
        
         <div class="col-12 text-center pt-4">
            <h3 class="titulo-3 text-bold fs-24">¿No hay <span class="text-gradient">un botón fácil en</span> las <span class="text-gradient">ventas?</span></h3>
            <p class="lead text-secondary"> Es el precio que se debe pagar para obtener un ingreso alto. —Jeb Blount</p>
         </div>

         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card card-primary" style="padding: 2% 1%">
               <div class="panel-body" id="formularioregistros">
                  <form name="formulario" id="formulario" method="POST">
                     <div class="row">

                     <div class="col-12" id="t-dp">
                           <h6 class="title">Datos de plataforma</h6>
                     </div>

                     <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_documento" id="tipo_documento"></select>
                                 <label>Tipo Documento</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                        <div class="form-group mb-3 position-relative check-valid">
                           <div class="form-floating">
                              <input type="text" placeholder="" value="<?php echo $id; ?>"  class="form-control border-start-0" name="identificacion" id="identificacion" maxlength="100" required>
                              <label>Identificación</label>
                           </div>
                        </div>
                        <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-4 col-lg-4 col-md-4 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="fo_programa" id="fo_programa"></select>
                                 <label>Programa de interes</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada_e" id="jornada_e"></select>
                                 <label>Jornada de interes</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-12" id="t-dpe">
                           <h6 class="title">Datos personales</h6>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_direccion" name="nombre" id="nombre" maxlength="70" onchange="javascript:this.value=this.value.toUpperCase();">
                                 <label>Primer Nombre</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_direccion" name="nombre_2" id="nombre_2" maxlength="70"  onchange="javascript:this.value=this.value.toUpperCase();">
                                 <label>Segundo Nombre</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_direccion" name="apellidos" id="apellidos" maxlength="70" onchange="javascript:this.value=this.value.toUpperCase();">
                                 <label>Primer Apellido</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_direccion" name="apellidos_2" id="apellidos_2" maxlength="70"  onchange="javascript:this.value=this.value.toUpperCase();">
                                 <label>Segundo Nombre</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_celular" name="celular" id="celular" maxlength="20" >
                                 <label>Número Celular</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="email" placeholder="" value=""  class="form-control border-start-0 usuario_celular" name="email" id="email" maxlength="50" >
                                 <label>Correo Personal</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-12" id="t-rp">
                           <h6 class="title">Referencias personales</h6>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_direccion" name="ref_familiar" id="ref_familiar" maxlength="70"  onchange="javascript:this.value=this.value.toUpperCase();">
                                 <label>Referencia familiar</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <input type="text" placeholder="" value="" class="form-control border-start-0 usuario_celular" name="ref_telefono" id="ref_telefono" maxlength="20" >
                                 <label>Número teléfonico</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-12" id="t-ca">
                           <h6 class="title">Datos campaña</h6>
                     </div>

                     <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="medio" id="medio"></select>
                                 <label>Medio de llegada</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>
                     <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="conocio" id="conocio"></select>
                                 <label>Como nos conocio</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select value="" required class="form-control border-start-0 selectpicker" data-live-search="true" name="contacto" id="contacto"></select>
                                 <label>Como nos contácto</label>
                              </div>
                           </div>
                           <div class="invalid-feedback">Please enter valid input</div>
                     </div>

                     <div class="col-12 text-center">
    <button class="btn btn-success" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Registrar</button>
</div>
<script>
    document.getElementById("btnGuardar").id = "t-rr";
</script>


                  </form>
               </div>
            </div>
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!--Fin-Contenido-->

<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/oncenternuevocliente.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>
<?php
}
	ob_end_flush();
?>