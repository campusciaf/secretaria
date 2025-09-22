<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["usuario_nombre"])) {
   header("Location: ../");
} else {
   $menu = 9;
   $submenu = 900;
   require 'header.php';
   if ($_SESSION['registrarestudiante'] == 1) {
?>
      <div id="precarga" class="precarga"></div>
      <div class="content-wrapper">
         <!-- Main content -->
         <div class="content-header">
            <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                     <h2 class="m-0 line-height-16">
                        <span class="titulo-2 fs-18 text-semibold">Registrar Estudiante</span><br>
                        <span class="fs-16 f-montserrat-regular">Gestione y agregue los estudiantes</span>
                     </h2>
                  </div>
                  <div class="col-12 migas">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión Estudiantes</li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <section class="content">
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 px-4">
                  <div class="row">
                     <div class="col-12 card">
                        <div class="row">
                           <div class="col-6 p-4 tono-3">
                              <div class="row align-items-center">
                                 <div class="pl-3">
                                    <span class="rounded bg-light-blue p-3 text-primary ">
                                       <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                                    </span>
                                 </div>
                                 <div class="col-10">
                                    <div class="col-5 fs-14 line-height-18">
                                       <span class="">Estudiantes plataforma</span> <br>
                                       <span class="text-semibold fs-20">Campus virtual</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-6 tono-3 text-right py-4 pr-4">
                              <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar estudiante</button>
                           </div>
                           <div class="col-12 table-responsive p-4" id="listadoregistros">
                              <table id="tbllistado" class="table" style="width: 100%;">
                                 <thead>
                                    <th>Opciones</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Celular</th>
                                    <th>Correo</th>
                                    <th>Titulo</th>
                                    <th>Periodo</th>
                                    <th>Creado</th>
                                    <th>Estado</th>
                                    <th>Libro</th>
                                    <th>Folio</th>
                                    <th>Número acta</th>
                                    <th>Año de graduacion</th>
                                    <th>Programa</th>
                                    <th>Periodo de acta</th>
                                    <th>Estado Fallecido</th>
                                 </thead>
                                 <tbody>
                                 </tbody>
                              </table>
                           </div>
                           <div class="col-12 panel-body" id="formularioregistros">
                              <form name="formulario" id="formulario" method="POST">
                                 <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                       <div class="card card-primary" style="padding: 2% 1%">
                                          <ul class="nav nav-tabs" role="tablist">
                                             <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#personal">
                                                   <i class="fa fa-id-card"></i> Personal
                                                </a>
                                             </li>
                                             <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#contacto">
                                                   <i class="fa fa-address-book"></i>
                                                   Contácto
                                                </a>
                                             </li>
                                             <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#academica">
                                                   <i class="fa fa-graduation-cap"></i>
                                                   Académica
                                                </a>
                                             </li>
                                             <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#laboral">
                                                   <i class="fa fa-suitcase"></i>
                                                   Laboral
                                                </a>
                                             </li>
                                             <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#complementaria">
                                                   <i class="fa fa-plus-circle"></i>
                                                   Complementaria
                                                </a>
                                             </li>
                                             <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#Emergencia">
                                                   <i class="fa fa-ambulance"></i>
                                                   Emergencia
                                                </a>
                                             </li>
                                          </ul>
                                          <div class="tab-content">
                                             <div id="personal" class="tab-pane in active">
                                                <!-- div personal tab -->
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                   <div class="row mt-3">
                                                      <!-- tipo documento -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_documento" id="tipo_documento">
                                                                  <option selected></option>
                                                                  <option value='tarjeta de identidad'> Tarjeta de Identidad</option>
                                                                  <option value='Cedula de Ciudadania'> Cédula de Ciudadanía</option>
                                                                  <option value='Cedula Extrangeria'>Cédula de Extrangería</option>
                                                               </select>
                                                               <label>Tipo de Documento</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!--  identificacion -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="number" placeholder="" value="" required class="form-control border-start-0" name="identificacion" id="identificacion" maxlength="100" required>
                                                               <label>Identificación</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Primer nombre -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" required class="form-control border-start-0" name="nombre" id="nombre" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                                               <label>Primer Nombre</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- segundo nombre -->

                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_2" id="nombre_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                               <label>Segundo Nombre</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- primer apellido -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" required class="form-control border-start-0" name="apellidos" id="apellidos" maxlength="100" required onchange="javascript:this.value=this.value.toUpperCase();">
                                                               <label>Primer Apellido</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- segundo apellido -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="apellidos_2" id="apellidos_2" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                               <label>Segundo Apellido</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- numero celular -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="number" placeholder="" value="" class="form-control border-start-0" name="celular" id="celular" maxlength="100">
                                                               <label>Número celular</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- correo -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="email" placeholder="" value="" class="form-control border-start-0" name="email" id="email" maxlength="100">
                                                               <label>correo</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Titulo -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="titulo_estudiante" id="titulo_estudiante">
                                                                  <option selected></option>
                                                                  <option value='Tecnico'> Tecnico </option>
                                                                  <option value='Tecnologo'> Tecnologo </option>
                                                                  <option value='Tecnologo'> Profesional </option>
                                                               </select>
                                                               <label>Titulo</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Periodo -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="periodo" id="periodo" maxlength="100">
                                                               <label>Periodo</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Lugar Expedicion -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="expedido_en" id="expedido_en" maxlength="100">
                                                               <label>Lugar de Expedición</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- fecha expedicion -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_expedicion" id="fecha_expedicion">
                                                               <label>Fecha de Expedición:</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- lugar de nacimiento -->

                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="lugar_nacimiento" id="lugar_nacimiento" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();">
                                                               <label>Lugar de Nacimiento</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- fecha de nacimiento -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_nacimiento" id="fecha_nacimiento">
                                                               <label>Fecha de nacimiento</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- genero -->

                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="genero" id="genero">
                                                                  <option selected></option>
                                                                  <option value='Maculino'> Masculino </option>
                                                                  <option value='Femenino'> Femenino </option>
                                                               </select>
                                                               <label>Genero</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- tipo de sangre -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_sangre" id="tipo_sangre"></select>
                                                               <label>Tipo de Sangre</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- EPS -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="eps" id="eps" maxlength="100">
                                                               <label>EPS</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- programa -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="fo_programa" id="fo_programa" maxlength="100" onchange="javascript:this.value=this.value.toUpperCase();" require>
                                                               <label>Programa</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>


                                                      <!-- escuela ciaf -->

                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="escuela_ciaf" id="escuela_ciaf"></select>
                                                               <label>Escuela</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- jornada -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada_e" id="jornada_e">
                                                                  <option selected></option>
                                                                  <option value='Ninguno'> Ninguno </option>
                                                                  <option value='Diurna'> Diurna </option>
                                                                  <option value='Nocturna'> Nocturna </option>
                                                                  <option value='Fds'> Fds </option>

                                                               </select>
                                                               <label>Jornada</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- Grupo etnico -->

                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select type="text" placeholder="" value="" class="form-control border-start-0" name="grupo_etnico" id="grupo_etnico" maxlength="100" onChange="mostrar_nombre_etnico(this.value);"></select>
                                                               <label>Grupo Etnico</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- Nombre etnico -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6" id='comunidad_negra'>
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_etnico" id="nombre_etnico" maxlength="100"></select>
                                                               <label>Nombre Etnico</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Discapacidad -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="discapacidad" id="discapacidad">
                                                                  <option selected></option>
                                                                  <option value='si'> si </option>
                                                                  <option value='no'> no </option>
                                                                  <option value='no informa'> no informa </option>
                                                               </select>
                                                               <label>Discapacidad</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Nombre discapacidad -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_discapacidad" id="nombre_discapacidad" maxlength="100">
                                                               <label>Nombre Discapacidad</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <div class="form-group col-xl-3 col-lg-6 col-md-12 col-12">
                                                         <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                               <span class=></i></span>
                                                            </div>

                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <!-- /#personal -->
                                             <div id="contacto" class="tab-pane">
                                                <!-- div informacion contacto tab -->
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                   <div class="row mt-3">
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="direccion" id="direccion" maxlength="100">
                                                               <label>Dirección Residencia</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- ciudad de residencia -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="municipio" id="municipio" maxlength="100">
                                                               <label>Ciudad Residencia</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Barrio residencia -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="barrio" id="barrio" maxlength="100">
                                                               <label>Barrio Residencia</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Telefono fijo -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="number" placeholder="" value="" class="form-control border-start-0" name="telefono" id="telefono" maxlength="100">
                                                               <label>Teléfono Fijo 1</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- telefono fijo 2 -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="telefono2" id="telefono2" maxlength="100">
                                                               <label>Teléfono Fijo 2</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <div class="form-group ">

                                                         <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                               <span class=""></i></span>
                                                            </div>

                                                         </div>
                                                      </div>
                                                   </div>
                                                   <!-- Div row contacto 2 -->
                                                </div>
                                                <!-- div columna info contacto -->
                                             </div>
                                             <!-- /#contacto -->
                                             <div id="academica" class="tab-pane">
                                                <!-- div informacion academica tab -->
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                   <div class="row mt-3">
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="nombre_colegio" id="nombre_colegio" maxlength="100">
                                                               <label>Nombre del colegio</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- Tipo de institucion -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tipo_institucion" id="tipo_institucion">
                                                                  <option selected></option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                                  <option value="Publica">Publica</option>
                                                                  <option value="Privada">Privada</option>
                                                               </select>
                                                               <label>Tipo de Institución</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Jornada institucion -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="jornada_institucion" id="jornada_institucion">
                                                                  <option selected></option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                                  <option value="Diurna">Diurna</option>
                                                                  <option value="Nocturna">Nocturna</option>
                                                               </select>
                                                               <label>Jornada Institución</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- Año de terminacion -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="date" placeholder="" value="" class="form-control border-start-0" name="ano_terminacion" id="ano_terminacion">
                                                               <label>Año de terminación</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- ciudad colegio -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="ciudad_institucion" id="ciudad_institucion" maxlength="100">
                                                               <label>Ciudad Colegio</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- fecha de icfes -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="date" placeholder="" value="" class="form-control border-start-0" name="fecha_presen_icfes" id="fecha_presen_icfes">
                                                               <label>Fecha de presentación icfes</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- codigo icfes -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="codigo_icfes" id="codigo_icfes" maxlength="100">
                                                               <label>Codigo Icfes</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>


                                                   </div>
                                                   <!-- Div row academica 2 -->
                                                </div>
                                                <!-- div columna info academica -->
                                             </div>
                                             <!-- /#academica -->
                                             <div id="laboral" class="tab-pane">
                                                <!-- div informacion laboral tab -->
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                   <div class="row mt-3">
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="trabaja_actualmente" id="trabaja_actualmente">
                                                                  <option selected></option>
                                                                  <option selected></option>
                                                                  <option value="Si">Si</option>
                                                                  <option value="No">No</option>
                                                               </select>
                                                               <label>Trabaja Actualmente</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- cargo -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="cargo_en_empresa" id="cargo_en_empresa" maxlength="100">
                                                               <label>Cargo Desempeñados</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- nombre empresa -->

                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="empresa_trabaja" id="empresa_trabaja" maxlength="100">
                                                               <label>Nombre Empresa</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- sector empresa -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="sector_empresa" id="sector_empresa">
                                                                  <option selected></option>
                                                                  <option selected></option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                                  <option value="Publica">Publica</option>
                                                                  <option value="Privada">Privada</option>
                                                               </select>
                                                               <label>Sector Empresa</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- telefono empresa -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="number" placeholder="" value="" class="form-control border-start-0" name="tel_empresa" id="tel_empresa" maxlength="100">
                                                               <label>Teléfono Empresa</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- correo -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="email" placeholder="" value="" class="form-control border-start-0" name="email_empresa" id="email_empresa" maxlength="100">
                                                               <label>correo</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                   </div>
                                                   <!-- Div row laboral 2 -->
                                                </div>
                                                <!-- div columna info laboral -->
                                             </div>
                                             <!-- /#laboral -->
                                             <div id="complementaria" class="tab-pane">
                                                <!-- div informacion complementaria tab -->
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                   <div class="row mt-3 ">
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="segundo_idioma" id="segundo_idioma">
                                                                  <option selected></option>
                                                                  <option selected></option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                                  <option value="Si">Si</option>
                                                                  <option value="No">No</option>
                                                               </select>
                                                               <label>Segundo Idioma</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- cual idioma -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="cual_idioma" id="cual_idioma" maxlength="100">
                                                               <label>Cual Idioma</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- aficiones -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="aficiones" id="aficiones" maxlength="100">
                                                               <label>Aficiones</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>


                                                      <!-- tiene computador -->

                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tiene_pc" id="tiene_pc">
                                                                  <option selected></option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                                  <option value="Si, en casa">Si, en casa
                                                                  </option>
                                                                  <option value="Si, en oficina">Si, en
                                                                     oficina</option>
                                                                  <option value="Si, en casa y oficina">
                                                                     Si, en casa y oficina</option>
                                                                  <option value="No tiene">No tiene
                                                                  </option>
                                                               </select>
                                                               <label>Tiene Computador</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- acceso a internet -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tiene_internet" id="tiene_internet">
                                                                  <option selected></option>
                                                                  <option value="Si, en casa">Si, en casa
                                                                  </option>
                                                                  <option value="Si, en oficina">Si, en
                                                                     oficina</option>
                                                                  <option value="Si, en casa y oficina">
                                                                     Si, en casa y oficina</option>
                                                                  <option value="No tiene">No tiene
                                                                  </option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                               </select>
                                                               <label>Tiene acceso a internet</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- tiene hijos -->

                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="tiene_hijos" id="tiene_hijos">
                                                                  <option selected></option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                                  <option value="Si">Si</option>
                                                                  <option value="No">No</option>
                                                               </select>
                                                               <label>Tiene Hijos</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- estado civil -->
                                                      <div class="col-xl-3 col-lg-4 col-md-4 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <select value="" class="form-control border-start-0 selectpicker" data-live-search="true" name="estado_civil" id="estado_civil">
                                                                  <option selected></option>
                                                                  <option value="Ninguno">Ninguno</option>
                                                                  <option value="Soltero(a)">Soltero(a)
                                                                  </option>
                                                                  <option value="Casado(a)">Casado(a)
                                                                  </option>
                                                                  <option value="Unión Libre">Unión Libre
                                                                  </option>
                                                                  <option value="Separado(a)">Separado(a)
                                                                  </option>
                                                                  <option value="Viudo(a)">Viudo(a)
                                                                  </option>
                                                               </select>
                                                               <label>Estado Civil</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                   </div>
                                                   <!-- Div row complementaria 2 -->
                                                </div>
                                                <!-- div columna info complementaria -->
                                             </div>
                                             <!-- /#complementaria -->
                                             <div id="emergencia" class="tab-pane">
                                                <!-- div informacion emergencia tab -->
                                                <div class="form-group col-xl-12 col-lg-12 col-md-12 col-12">
                                                   <div class="row mt-3">

                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="persona_emergencia" id="persona_emergencia" maxlength="100">
                                                               <label>Persona Contacto</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- direccion residencia -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="text" placeholder="" value="" class="form-control border-start-0" name="direccion_emergencia" id="direccion_emergencia" maxlength="100">
                                                               <label>Dirección de Residencia</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- correo -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="email" placeholder="" value="" class="form-control border-start-0" name="email_emergencia" id="email_emergencia" maxlength="100">
                                                               <label>correo</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>

                                                      <!-- telefono fijo -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="number" placeholder="" value="" class="form-control border-start-0" name="tel_fijo_emergencia" id="tel_fijo_emergencia" maxlength="100">
                                                               <label>Telefono Fijo</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                      <!-- numero celular -->
                                                      <div class="col-xl-3 col-lg-3 col-md-3 col-6">
                                                         <div class="form-group mb-3 position-relative check-valid">
                                                            <div class="form-floating">
                                                               <input autocomplete="off" type="number" placeholder="" value="" class="form-control border-start-0" name="celular_emergencia" id="celular_emergencia" maxlength="100">
                                                               <label>Numero Celular</label>
                                                            </div>
                                                         </div>
                                                         <div class="invalid-feedback">Please enter valid input</div>
                                                      </div>
                                                   </div>
                                                   <!-- Div row emergencia 2 -->
                                                </div>
                                                <!-- div columna info emergencia -->
                                             </div>
                                             <!-- /#emergencia -->
                                          </div>
                                          <!-- / div tab content -->
                                       </div>
                                       <!-- // div container-fluid -->
                                    </div>
                                    <div class="alert col-12 panel-footer" style="overflow: auto;">
                                       <span class="float-right">
                                          <input autocomplete="off" type="hidden" id="id_estudiante" name="id_estudiante" />
                                          <button type="submit" class="btn btn-success btn-lg" id="BtnGuardarDatos" title="Guardar">
                                             <i class="fa fa-save"></i>
                                             <b>Registrar estudiante </b>
                                          </button>
                                          <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Atras</button>
                                       </span>
                                    </div>
                              </form>
                           </div>
                        </div>
                        <!-- /.col -->
                     </div><!-- /.row -->
                  </div><!-- /.row -->
               </div><!-- /.row -->
            </div><!-- /.row -->

            <!-- modal datos adicionales -->
            <div class="modal fade" id="estudianteModal" tabindex="-1" role="dialog" aria-labelledby="estudianteModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-sm" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="estudianteModalLabel">Datos adicionales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <form name="registro_acta" id="registro_acta" method="POST" action="#">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="box">
                                    <div class="box-header with-border">
                                       <div class="datos_graduado">
                                          <div class="form-group mb-3 position-relative check-valid">
                                             <div class="form-floating">
                                                <input type="text" required class="form-control border-start-0" name="titulo_acta" id="titulo_acta">
                                                </input>
                                                <input type="hidden" name="id_so" id="id_so">
                                                <label>Programa</label>
                                             </div>
                                             <div class="invalid-feedback">Please enter valid input</div>
                                          </div>
                                       </div>
                                       <div class="form-group mb-3 position-relative check-valid">
                                          <div class="form-floating">
                                             <input type="hidden" id="id_estudiante_acta" name="id_estudiante_acta">
                                             <input autocomplete="off" type="number" placeholder="" value="" required class="form-control border-start-0" name="identificacion_acta" id="identificacion_acta" maxlength="100">
                                             <label>Documento de Identificación</label>
                                          </div>
                                          <div class="invalid-feedback">Please enter valid input</div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group mb-3 position-relative check-valid">
                              <div class="form-floating">
                                 <select class="form-control border-start-0" data-live-search="true" name="estado_est" id="estado_est">
                                    <option selected></option>
                                    <option value="retirado">Retirado</option>
                                    <option value="graduado">Graduado</option>
                                 </select>
                                 <label>Estado</label>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>

                           <div class="datos_graduado">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <input autocomplete="off" type="number" placeholder="" value="" required class="form-control border-start-0" name="numero_acta" id="numero_acta" maxlength="100">
                                    <label for="numero_acta">Numero de acta</label>
                                 </div>
                                 <div class="invalid-feedback">Please enter valid input</div>
                              </div>
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <input autocomplete="off" type="number" placeholder="" value="" required class="form-control border-start-0" name="libro" id="libro" maxlength="100">
                                    <label for="libro">Libro</label>
                                 </div>
                                 <div class="invalid-feedback">Please enter valid input</div>
                              </div>
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <input autocomplete="off" type="text" placeholder="" value="" required class="form-control border-start-0" name="folio" id="folio" maxlength="100">
                                    <label for="folio">Folio</label>
                                 </div>
                                 <div class="invalid-feedback">Please enter valid input</div>
                              </div>
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <input autocomplete="off" type="date" placeholder="" value="" class="form-control border-start-0" name="ano_graduacion" id="ano_graduacion" required>
                                    <label for="ano_graduacion">Año de graduación</label>
                                 </div>
                                 <div class="invalid-feedback">Please enter valid input</div>
                              </div>
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <select required class="form-control border-start-0" data-live-search="true" name="periodo_acta" id="periodo_acta">
                                       <option selected disabled value="">- Periodos -</option>
                                       <option value="2018-2">2018-2</option>
                                       <option value="2018-1">2018-1</option>
                                       <option value="2017-2">2017-2</option>
                                       <option value="2017-1">2017-1</option>
                                       <option value="2016-2">2016-2</option>
                                       <option value="2016-1">2016-1</option>
                                       <option value="2015-2">2015-2</option>
                                       <option value="2015-1">2015-1</option>
                                       <option value="2014-2">2014-2</option>
                                       <option value="2014-1">2014-1</option>
                                       <option value="2013-2">2013-2</option>
                                       <option value="2013-1">2013-1</option>
                                       <option value="2012-2">2012-2</option>
                                       <option value="2012-1">2012-1</option>
                                       <option value="2011-2">2011-2</option>
                                       <option value="2011-1">2011-1</option>
                                       <option value="2010-2">2010-2</option>
                                       <option value="2010-1">2010-1</option>
                                       <option value="2009-2">2009-2</option>
                                       <option value="2009-1">2009-1</option>
                                       <option value="2008-2">2008-2</option>
                                       <option value="2008-1">2008-1</option>
                                       <option value="2007-2">2007-2</option>
                                       <option value="2007-1">2007-1</option>
                                       <option value="2006-2">2006-2</option>
                                       <option value="2006-1">2006-1</option>
                                       <option value="2005-2">2005-2</option>
                                       <option value="2005-1">2005-1</option>
                                       <option value="2004-2">2004-2</option>
                                       <option value="2004-1">2004-1</option>
                                       <option value="2003-2">2003-2</option>
                                       <option value="2003-1">2003-1</option>
                                       <option value="2002-2">2002-2</option>
                                       <option value="2002-1">2002-1</option>
                                       <option value="2001-2">2001-2</option>
                                       <option value="2001-1">2001-1</option>
                                       <option value="2000-2">2000-2</option>
                                       <option value="2000-1">2000-1</option>
                                       <option value="1999-2">1999-2</option>
                                       <option value="1999-1">1999-1</option>
                                       <option value="1998-2">1998-2</option>
                                       <option value="1998-1">1998-1</option>
                                       <option value="1997-2">1997-2</option>
                                       <option value="1997-1">1997-1</option>
                                       <option value="1996-2">1996-2</option>
                                       <option value="1996-1">1996-1</option>
                                       <option value="1995-2">1995-2</option>
                                       <option value="1995-1">1995-1</option>
                                       <option value="1994-2">1994-2</option>
                                       <option value="1994-1">1994-1</option>
                                       <option value="1993-2">1993-2</option>
                                       <option value="1993-1">1993-1</option>
                                       <option value="1992-2">1992-2</option>
                                       <option value="1992-1">1992-1</option>
                                       <option value="1991-2">1991-2</option>
                                       <option value="1991-1">1991-1</option>
                                       <option value="1990-2">1990-2</option>
                                       <option value="1990-1">1990-1</option>
                                       <option value="1989-2">1989-2</option>
                                       <option value="1989-1">1989-1</option>
                                       <option value="1988-2">1988-2</option>
                                       <option value="1988-1">1988-1</option>
                                       <option value="1987-2">1987-2</option>
                                       <option value="1987-1">1987-1</option>
                                       <option value="1986-2">1986-2</option>
                                       <option value="1986-1">1986-1</option>
                                       <option value="1985-2">1985-2</option>
                                       <option value="1985-1">1985-1</option>
                                       <option value="1984-2">1984-2</option>
                                       <option value="1984-1">1984-1</option>
                                       <option value="1983-2">1983-2</option>
                                       <option value="1983-1">1983-1</option>
                                       <option value="1982-2">1982-2</option>
                                       <option value="1982-1">1982-1</option>
                                       <option value="1981-2">1981-2</option>
                                       <option value="1981-1">1981-1</option>
                                       <option value="1980-2">1980-2</option>
                                       <option value="1980-1">1980-1</option>
                                       <option value="1979-2">1979-2</option>
                                       <option value="1979-1">1979-1</option>
                                       <option value="1978-2">1978-2</option>
                                       <option value="1978-1">1978-1</option>
                                       <option value="1977-2">1977-2</option>
                                       <option value="1977-1">1977-1</option>
                                       <option value="1976-2">1976-2</option>
                                       <option value="1976-1">1976-1</option>
                                       <option value="1975-2">1975-2</option>
                                       <option value="1975-1">1975-1</option>
                                       <option value="1974-2">1974-2</option>
                                       <option value="1974-1">1974-1</option>
                                       <option value="1973-2">1973-2</option>
                                       <option value="1973-1">1973-1</option>
                                       <option value="1972-2">1972-2</option>
                                       <option value="1972-1">1972-1</option>
                                    </select>
                                    <label>Periodo</label>
                                 </div>
                                 <div class="invalid-feedback">Please enter valid input</div>
                              </div>
                           </div>

                           <div class="col-xs-12 col-sm-12">
                              <button type="submit" id="btnGuardarActa" class="btn btn-success" name="guardar_estado" style="margin-top: 1%;"> Guardar</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-top: 1%;">Cerrar</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal fade" id="modalFormulario" tabindex="-1" role="dialog" aria-labelledby="modalFormularioLabel" aria-hidden="true">
               <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="modalFormularioLabel">Registrar y Visualizar Materias</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">
                        <div class="row">
                           <div class="col-md-6">
                              <form name="registro_materia" id="registro_materia" method="POST" action="#">
                                 <div class="form-group">
                                    <label for="identificacion2" style="display: none;">Documento de Identificación:</label>
                                    <input autocomplete="off" class="form-control" id="identificacion2" name="identificacion2" type="hidden" placeholder="Documento de Identificación" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="nombre_asig">Nombre Materia:</label>
                                    <input autocomplete="off" class="form-control" name="nombre_asig" id="nombre_asig" type="text" placeholder="Nombre Materia" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="creditos_asig">Créditos:</label>
                                    <input autocomplete="off" class="form-control" name="creditos_asig" id="creditos_asig" type="number" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="semestre_asig">Semestre:</label>
                                    <select name="semestre_asig" id="semestre_asig" class="form-control" required>
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                       <option value="4">4</option>
                                       <option value="5">5</option>
                                       <option value="6">6</option>
                                       <option value="7">7</option>
                                       <option value="8">8</option>
                                       <option value="9">9</option>
                                       <option value="10">10</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="nota">Nota Final:</label>
                                    <input autocomplete="off" class="form-control" name="nota_asig" id="nota_asig" type="number" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="periodo_materia">Periodo:</label>
                                    <select data-live-search="true" id="periodo_materia" name="periodo_materia" class="form-control periodo_asig" required>
                                       <option value="2012-2">2012-2</option>
                                       <option value="2012-1">2012-1</option>
                                       <option value="2011-2">2011-2</option>
                                       <option value="2011-1">2011-1</option>
                                       <option value="2010-2">2010-2</option>
                                       <option value="2010-1">2010-1</option>
                                       <option value="2009-2">2009-2</option>
                                       <option value="2009-1">2009-1</option>
                                       <option value="2008-2">2008-2</option>
                                       <option value="2008-1">2008-1</option>
                                       <option value="2007-2">2007-2</option>
                                       <option value="2007-1">2007-1</option>
                                       <option value="2006-2">2006-2</option>
                                       <option value="2006-1">2006-1</option>
                                       <option value="2005-2">2005-2</option>
                                       <option value="2005-1">2005-1</option>
                                       <option value="2004-2">2004-2</option>
                                       <option value="2004-1">2004-1</option>
                                       <option value="2003-2">2003-2</option>
                                       <option value="2003-1">2003-1</option>
                                       <option value="2002-2">2002-2</option>
                                       <option value="2002-1">2002-1</option>
                                       <option value="2001-2">2001-2</option>
                                       <option value="2001-1">2001-1</option>
                                       <option value="2000-2">2000-2</option>
                                       <option value="2000-1">2000-1</option>
                                       <option value="1999-2">1999-2</option>
                                       <option value="1999-1">1999-1</option>
                                       <option value="1998-2">1998-2</option>
                                       <option value="1998-1">1998-1</option>
                                       <option value="1997-2">1997-2</option>
                                       <option value="1997-1">1997-1</option>
                                       <option value="1996-2">1996-2</option>
                                       <option value="1996-1">1996-1</option>
                                       <option value="1995-2">1995-2</option>
                                       <option value="1995-1">1995-1</option>
                                       <option value="1994-2">1994-2</option>
                                       <option value="1994-1">1994-1</option>
                                       <option value="1993-2">1993-2</option>
                                       <option value="1993-1">1993-1</option>
                                       <option value="1992-2">1992-2</option>
                                       <option value="1992-1">1992-1</option>
                                       <option value="1991-2">1991-2</option>
                                       <option value="1991-1">1991-1</option>
                                       <option value="1990-2">1990-2</option>
                                       <option value="1990-1">1990-1</option>
                                       <option value="1989-2">1989-2</option>
                                       <option value="1989-1">1989-1</option>
                                       <option value="1988-2">1988-2</option>
                                       <option value="1988-1">1988-1</option>
                                       <option value="1987-2">1987-2</option>
                                       <option value="1987-1">1987-1</option>
                                       <option value="1986-2">1986-2</option>
                                       <option value="1986-1">1986-1</option>
                                       <option value="1985-2">1985-2</option>
                                       <option value="1985-1">1985-1</option>
                                       <option value="1984-2">1984-2</option>
                                       <option value="1984-1">1984-1</option>
                                       <option value="1983-2">1983-2</option>
                                       <option value="1983-1">1983-1</option>
                                       <option value="1982-2">1982-2</option>
                                       <option value="1982-1">1982-1</option>
                                       <option value="1981-2">1981-2</option>
                                       <option value="1981-1">1981-1</option>
                                       <option value="1980-2">1980-2</option>
                                       <option value="1980-1">1980-1</option>
                                       <option value="1979-2">1979-2</option>
                                       <option value="1979-1">1979-1</option>
                                       <option value="1978-2">1978-2</option>
                                       <option value="1978-1">1978-1</option>
                                       <option value="1977-2">1977-2</option>
                                       <option value="1977-1">1977-1</option>
                                       <option value="1976-2">1976-2</option>
                                       <option value="1976-1">1976-1</option>
                                       <option value="1975-2">1975-2</option>
                                       <option value="1975-1">1975-1</option>
                                       <option value="1974-2">1974-2</option>
                                       <option value="1974-1">1974-1</option>
                                       <option value="1973-2">1973-2</option>
                                       <option value="1973-1">1973-1</option>
                                       <option value="1972-2">1972-2</option>
                                       <option value="1972-1">1972-1</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="jornada_asig">Jornada:</label>
                                    <select data-live-search="true" id="jornada_asig" name="jornada_asig" class="form-control"></select>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="submit" id="btnGuardarMateria" class="btn btn-success" name="btnGuardarMateria">Registrar materia</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                 </div>
                              </form>
                           </div>
                           <div class="col-md-6">
                              <div class="table-responsive p-4">
                                 <table id="tblmateria" class="table table-striped">
                                    <thead>
                                       <tr>
                                          <th>Nombre materias</th>
                                          <th>Estado</th>
                                          <th>Jornada</th>
                                          <th>Periodo</th>
                                          <th>Semestre</th>
                                          <th>Nota</th>
                                       </tr>
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
      <?php
   } else {
      require 'noacceso.php';
   }
   require 'footer.php';
}
ob_end_flush();
      ?>
      <script type="text/javascript" src="scripts/registrar2012.js"></script>