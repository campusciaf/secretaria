<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 8;
   $submenu = 801;
   require 'header.php';
   if ($_SESSION['buscarperfil'] == 1) {

?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper ">
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-xl-6 col-9">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Gestion de perfil estudiante</span><br>
                        <span class="fs-16 f-montserrat-regular">Configure los datos personales del estudiante</span>
                     </h2>
                  </div>
                  <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
                     <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestion de perfil estudiante</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="container-fluid px-4 py-2">
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-3 card">
                  <div class="row">
                     <input type="hidden" value="" name="tipo" id="tipo">
                     <div class="col-12">
                        <h3 class="titulo-2 fs-14">Buscar Estudiante:</h3>
                     </div>
                     <div class="col-12">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                           <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true" onclick="filtroportipo(1)">Identificacion</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="filtroportipo(2)">Correo</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false" onclick="filtroportipo(3)">Celular</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false" onclick="filtroportipo(4)">Nombre</a>
                           </li>
                        </ul>
                     </div>
                     <div class="col-12 mt-2" id="input_dato_estudiante">
                        <div class="row">
                           <div class="col-9 m-0 p-0 col-xl-9 col-lg-9 col-md-9 ">
                              <div class="form-group position-relative check-valid">
                                 <div class="form-floating">
                                    <input type="text" placeholder="" value="" class="form-control border-start-0" name="dato_estudiante" id="dato_estudiante">
                                    <label id="valortituloestudiante">Buscar Estudiante</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>

                           <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-3 m-0 p-0">
                              <input type="submit" value="Buscar" onclick="verificarDocumento()" class="btn btn-success py-3 btn-block" disabled id="btnconsulta" />
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-8 col-lg-5 col-md-6 col-sm-12 col-12" id="mostrar_datos_estudiante">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm">
                           <div class="px-2  pb-2">
                              <div class="row align-items-center">
                                 <div class="col-2">
                                    <span class="rounded bg-light-blue p-2 text-primary ">
                                       <i class="fa-solid fa-user-slash"></i>
                                    </span>
                                 </div>
                                 <div class="col-10">
                                    <span class="">Nombre:</span> <br>
                                    <span class="text-semibold fs-12 box_nombre_estudiante">-
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="px-2  pb-2">
                              <div class="row align-items-center">
                                 <div class="col-2">
                                    <span class="rounded bg-light-red p-2 text-danger">
                                       <i class="fa-regular fa-envelope"></i>
                                    </span>
                                 </div>
                                 <div class="col-10">
                                    <span class="">Correo electrónico</span> <br>
                                    <span class="text-semibold fs-12 box_correo_electronico">-</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm">
                           <div class="px-2 pb-2">
                              <div class="row align-items-center">
                                 <div class="col-2">
                                    <span class="rounded bg-light-green p-2 text-success">
                                       <i class="fa-solid fa-mobile-screen"></i>
                                    </span>
                                 </div>
                                 <div class="col-10">
                                    <span class="">Número celular</span> <br>
                                    <span class="text-semibold fs-12 box_celular">-</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 col-sm-12">
                     <div class="px-2 pb-2">
                        <div class="col-12 ">
                           <span class="text-semibold fs-12 box_programa">-</span>
                        </div>
                     </div>
                  </div>
               </div>


               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-top: 10px;">
                  <table class="table table-striped compact table-sm" id="datos_estudiantes">
                     <thead>
                           <tr>
                              <th scope="col">Identificación</th>
                              <th scope="col">Apellidos</th>
                              <th scope="col">Nombres</th>
                           </tr>
                     </thead>
                     <tbody>
                     </tbody>
                  </table>
               </div>

               <div class="modal" id="ModalMostrarFormulario">
                  <div class="modal-dialog modal-xl modal-dialog-centered">
                     <div class="modal-content">
                           <div class="modal-header">
                              <h6 class="modal-title">Editar Estudiante</h6>
                              <button type="button" class="close" data-dismiss="modal" onclick="cancelarform()">&times;</button>
                           </div>
                           <div class="modal-body">
                              <div class="panel-body p-3">
                                 <form name="info_personal_formulario" id="info_personal_formulario" method="POST">
                                       <div class="row" id="formularios">
                                          <div class="col-12">
                                             <div class="col-md-12" id="informacion-personal-form">
                                                   <div class="col-12 panel-body" id="formularioregistros">
                                                      <div class="row">
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_nombre" id="credencial_nombre" maxlength="100">
                                                                  <label>Primer Nombre</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_nombre_2" id="credencial_nombre_2" maxlength="100">
                                                                  <label>Segundo Nombre</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_apellido" id="credencial_apellido" maxlength="100">
                                                                  <label>Primer Apellido</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_apellido_2" id="credencial_apellido_2" maxlength="100">
                                                                  <label>Segundo Apellido</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="genero" id="genero"></select>
                                                                  <label>Género</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_nacimiento" id="fecha_nacimiento">
                                                                  <label>Fecha de nacimiento</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="departamento_nacimiento" id="departamento_nacimiento" onChange="mostrarmunicipio(this.value)"></select>
                                                                  <label>Departamento Nacimiento</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="municipio_nacimiento_estudiante" id="municipio_nacimiento_estudiante"></select>
                                                                  <label>Ciudad Nacimiento </label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="depar_residencia" id="depar_residencia" onChange="mostrarmunicipioresidencia(this.value)"></select>
                                                                  <label>Departamento Residencia</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="municipio" id="municipio"></select>
                                                                  <label>Municipio residencia </label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="direccion_residencia" id="direccion_residencia" maxlength="100">
                                                                  <label>Dirección</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="barrio_residencia" id="barrio_residencia" maxlength="100">
                                                                  <label>Barrio residencia</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                               <div class="form-group mb-3 position-relative check-valid">
                                                                  <div class="form-floating">
                                                                     <select value="" class="form-control border-start-0" data-live-search="true" name="estrato" id="estrato">
                                                                           <option value="" selected disabled>Selecciona una opción</option>
                                                                           <option value="1">1</option>
                                                                           <option value="2">2</option>
                                                                           <option value="3">3</option>
                                                                           <option value="4">4</option>
                                                                           <option value="5">5</option>
                                                                           <option value="6">6</option>
                                                                     </select>
                                                                     <label>Estrato </label>
                                                                  </div>
                                                               </div>
                                                               <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>

                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="telefono" id="telefono" maxlength="100">
                                                                  <label>Teléfono</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>

                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="celular" id="celular" maxlength="100">
                                                                  <label>Celular</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="grupo_etnico" id="grupo_etnico"></select>
                                                                  <label>Grupo Etnico</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_etnico" id="nombre_etnico" maxlength="100">
                                                                  <label>Nombre Etnico</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="desplazado_violencia" id="desplazado_violencia" maxlength="100">
                                                                  <label>Desplazado Violencia</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_documento" id="tipo_documento">
                                                                     <option selected>Tipo de documento</option>
                                                                     <option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
                                                                     <option value="Pasaporte">Pasaporte</option>
                                                                     <option value="Cédula de Ciudadanía">Cédula de Ciudadanía</option>
                                                                     <option value="ppt">Pasaporte protección temporal</option>
                                                                  </select>
                                                                  <label>Tipo Documento</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="cedula_estudiante" id="cedula_estudiante" maxlength="100">
                                                                  <label>Identficación</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_expedicion" id="fecha_expedicion">
                                                                  <label>Fecha de Expedición</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="id_municipio_nac" id="id_municipio_nac" maxlength="100">
                                                                  <label>Codigo municipio nacimiento</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="tipo_residencia" id="tipo_residencia" maxlength="100">
                                                                  <label>Tipo residencia</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_sangre" id="tipo_sangre"></select>
                                                                  <label>Tipo de sangre</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="codigo_pruebas" id="codigo_pruebas" maxlength="100">
                                                                  <label>Codigo Saber</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="email" id="email" maxlength="100">
                                                                  <label>Email</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="expedido_en" id="expedido_en" maxlength="100">
                                                                  <label>Lugar Expedición</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="credencial_login" id="credencial_login" maxlength="100">
                                                                  <label>Correo Ciaf</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>

                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="estado_civil" id="estado_civil"></select>
                                                                  <label>Estado civil</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                      
                                                         
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="conflicto_armado" id="conflicto_armado" maxlength="100">
                                                                  <label>Conflicto armado</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="zona_residencia" id="zona_residencia" maxlength="100">
                                                                  <label>Zona Residencia</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="cod_postal" id="cod_postal" maxlength="100">
                                                                  <label>Codigo Postal</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="whatsapp" id="whatsapp" maxlength="100">
                                                                  <label>Whatsapp</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                         <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                                            <div class="form-group mb-3 position-relative check-valid">
                                                               <div class="form-floating">
                                                                  <input type="text" placeholder="" value="" class="form-control border-start-0" name="instagram" id="instagram" maxlength="100">
                                                                  <label>Instagram</label>
                                                               </div>
                                                            </div>
                                                            <div class="invalid-feedback">Please enter valid input</div>
                                                         </div>
                                                      </div>
                                             </div>
                                             </form>
                                          </div>
                                       </div>
                                       <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right p-2">
                                          <input type="number" class="d-none cedula_estu" id="cedula_estu" name="cedula_estu">
                                          <input type="number" class="d-none id_credencial_oculto" id="id_credencial_oculto" name="id_credencial_oculto">
                                          <input type="number" class="d-none id_credencial_guardar_estudiante" id="id_credencial_guardar_estudiante" name="id_credencial_guardar_estudiante">
                                          <button class="btn btn-success" type="submit" id="guardar_personal"><i class="fa fa-save"></i> Guardar</button>
                                       </div>
                                 </form>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>


            
            </div>
         </section>
      </div>
   <?php
      require 'footer.php';
   } else {
      require 'noacceso.php';
   }
   ?>
<?php
}
ob_end_flush();
?>
<script type="text/javascript" src="scripts/buscarperfil.js?<?php echo date("Y-m-d-H:i:s"); ?>"></script>

</body>

</html>