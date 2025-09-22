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
$menu=7;
$submenu=706;
require 'header.php';
	if ($_SESSION['horarioplaneacion']==1)
	{
?>


<div id="precarga" class="precarga"></div>
<div class="content-wrapper ">
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-xl-6 col-9">
               <h2 class="m-0 line-height-16">
                     <span class="titulo-2 fs-18 text-semibold">Planeación Horarios</span><br>
                     <span class="fs-14 f-montserrat-regular">Diseñe su horario paso a paso y modifíquelo de forma sencilla a lo largo del año.</span>
               </h2>
            </div>
            <div class="col-xl-6 col-3 pt-4 pr-4 text-right">
               <button class="btn btn-sm btn-outline-warning px-2 py-0" onclick='iniciarTour()'><i class="fa-solid fa-play"></i> Tour</button>
            </div>
            <div class="col-12 migas mb-0">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="panel.php">Inicio</a></li>
                     <li class="breadcrumb-item active">Planeación</li>
                  </ol>
            </div>
         </div>
      </div>
   </div>

   <section class="content px-0">
      <div class="row col-12 m-0 p-0 ">
         <div class=" col-12">
            <div class="row">

               <div class="col-12 px-2 pt-4 borde-bottom">
                  <div class="row">
                     <form id="buscar" name="buscar" method="POST" class="col-12">
                        <div class="row">

                           <div class="col-xl-5 col-lg-4 col-md-4 col-6" id="t-programa">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <select value="" required name="programa_ac" id="programa_ac" class="form-control border-start-0 selectpicker" data-live-search="true" ></select>
                                    <label>Programa</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>

                           <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-jornada">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <select value="" required name="jornada" id="jornada" class="form-control border-start-0 selectpicker" data-live-search="true" ></select>
                                    <label>Jornada</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>


                           <!-- <div class="col-xl-2">
                              <div class="campo-select col-lg-12">
                                    <select name="dia" id="dia" data-live-search="true">
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Dia</label>
                              </div>
                           </div> -->

                           <div class="col-xl-2 col-lg-4 col-md-4 col-6" id="t-semestre">
                              <div class="form-group mb-3 position-relative check-valid">
                                 <div class="form-floating">
                                    <select value="" required name="semestre" id="semestre" class="form-control border-start-0 selectpicker" data-live-search="true" >
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                       <option value="4">4</option>
                                       <option value="5">5</option>
                                       <option value="6">6</option>
                                    </select>
                                    <label>Semestre</label>
                                 </div>
                              </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>

                           <div class="col-xl-3 col-lg-4 col-md-4 col-6" id="t-grupo">
                                 <div class="row">
                                    <div class="form-group mb-3 position-relative check-valid col-8 m-0 p-0">
                                       <div class="form-floating">
                                          <select value="" required name="grupo" id="grupo" class="form-control border-start-0 selectpicker" data-live-search="true" >
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
                                             <option value="11">11</option>
                                             <option value="12">12</option>
                                             <option value="13">13</option>
                                             <option value="14">14</option>
                                             <option value="15">15</option>
                                             <option value="16">16</option>
                                             <option value="17">17</option>
                                             <option value="18">18</option>
                                             <option value="19">19</option>
                                             <option value="20">20</option>
                                          </select>
                                          <label>Grupo</label>
                                       </div>
                                    </div>
                                    <div class="col-auto p-0 m-0">
                                       <input type="submit" value="consultar" class="btn btn-success py-3"></input>
                                    </div>
                                 </div>
                              <div class="invalid-feedback">Please enter valid input</div>
                           </div>

                           <!-- <div class="col-xl-2">
                              <div class="campo-select col-lg-12">
                                    <select name="periodo" id="periodo" data-live-search="true">
                                    </select>
                                    <span class="highlight"></span>
                                    <span class="bar"></span>
                                    <label>Periodo</label>
                              </div>
                           </div> -->
                        </div>
                     </form>  
                  </div>
               </div>
               
               <div class="col-3 tono-2 borde-right-2" id="t-gestion">
                  <div id="mallas" class="row">

                     <div class="col-12 pt-2">
                        <div class="row align-items-center">
                           <div class="pl-2">
                                 <span class="rounded bg-light-green p-2 text-success ">
                                    <i class="fa-regular fa-calendar"></i>
                                 </span> 
                           </div>
                           <div class="col-10">
                           <div class="col-8 fs-14 line-height-18"> 
                                 <span class="">Publicar</span> <br>
                                 <span class="text-semibold fs-16">CLASES</span> 
                           </div> 
                           </div>
                        </div>
                     </div>

                     


                     <div class="col-12 borde-bottom-2 pt-2"></div>

                     <div class="col-12 p-2" id="t-card1">
                        <div class="row">
                           <div class="col-2 text-center ">
                              <span class="badge badge-primary">Sede</span>
                              <figure class="pt-1">
                                 <img src="../files/null.jpg" alt="" class="rounded-circle" width="36px" height="36px">
                              </figure>
                           </div>
                           <div class="col-10">
                              
                             <div class="row">
                                 <div class="col-8"><span class="titulo-2 fs-12 line-height-16"><b>Nombre asignatura </b></span></div>
                                 <div class="col-4">
                                    <button class="btn btn-success btn-xs "  title="Asignar Horario">
                                       <i class="fa fa-plus fa-1x" aria-hidden="true"></i> Crear
                                    </button></div>
                             </div>
                              
                           </div>
                        </div>
                        
                     </div>

                     <div class="col-12 borde-bottom-2 pt-2"></div>

                     <div class="col-12 p-2" id="t-card2">
                        <div class="row">
                           <div class="col-2 text-center ">
                              <span class="badge badge-primary">Sede</span>
                              <figure class="pt-1">
                                 <img src="../files/null.jpg" alt="" class="rounded-circle" width="36px" height="36px">
                              </figure>
                           </div>
                           <div class="col-10">
                              <div class="row">
                                 <div class="col-8">
                                    <span class="titulo-2 fs-12 line-height-16"><b>Nombre asignatura </b></span>
                                 </div>
                                 <div class="col-4 text-center">
                                    <a class="badge badge-info pointer text-white" title="Asignar Horario"><i class="fa fa-plus fa-1x" aria-hidden="true"></i>Nuevo día</a>
                                 </div>
                                 <div class="col-12 fs-12">
                                    <i class="fa-solid fa-caret-right" aria-hidden="true"></i> Martes 01:00 am a 04:30 am - P-304 - c:1
                                 </div>
                                 <div class="col-12">
                                    <button class="btn btn-link text-primary btn-xs" title="Asignar Salón">
                                       <i class="fa-solid fa-plus" aria-hidden="true"></i> Salón
                                    </button>
                                    <button class="btn btn-link text-primary btn-xs" title="Asignar Docente">
                                       <i class="fa-solid fa-plus" aria-hidden="true"></i> Docente
                                    </button>
                                 </div>
                              
                              </div>
                           </div>
                        
                        </div>
                     </div>

                     <div class="col-12 borde-bottom-2 pt-2"></div>

                     <div class="col-12 p-2" id="t-card3">
                        <div class="row">
                           <div class="col-2 text-center ">
                              <span class="badge badge-danger">PAT</span>
                              <figure class="pt-1">
                                 <img src="../files/null.jpg" alt="" class="rounded-circle" width="36px" height="36px">
                              </figure>
                           </div>
                           <div class="col-10">
                              
                              <div class="row">
                                    <div class="col-8">
                                       <span class="titulo-2 fs-12 line-height-16"><b>Nombre asignatura </b></span>
                                    </div>
                                    <div class="col-4 text-center">
                                       <a class="badge badge-info pointer text-white" title="Asignar Horario"><i class="fa fa-plus fa-1x" aria-hidden="true"></i>Nuevo día</a>
                                    </div>

                                    <div class="col-12 fs-12">
                                       <i class="fa-solid fa-caret-right" aria-hidden="true"></i>  Martes 01:00 am a 04:30 am - c:1
                                       <a class="btn btn-link text-danger btn-xs" title="Eliminar Horario">x</a>
                                    </div>
                                    <span class="btn-group">
                                    
                                       <button class="btn btn-link btn-xs text-success" title="Asignar Salón">
                                          <i class="fa fa-school" aria-hidden="true"></i> Salón 
                                       </button>
                                       <button class="btn btn-link text-danger btn-xs"  title="Quitar salón">x</button>
                                    </span>
                                    <span class="btn-group">
                                       <button class="btn btn-link text-success btn-xs" title="Asignar Docente">
                                          <i class="fas fa-user" aria-hidden="true"></i> Docente
                                       </button>
                                       <button class="btn btn-link text-danger btn-xs" >x</button>
                                    </span>
                                    
                                 </div>
                           </div>
                        </div>
                        
                     </div>


                     <div class="col-12 borde-bottom-2 pt-2"></div>

                     <div class="col-12 p-2" id="t-card4">
                        <div class="row">
                           <div class="col-2 text-center ">
                              <span class="badge badge-primary">Sede</span>
                              <figure class="pt-1">
                                 <img src="../files/null.jpg" alt="" class="rounded-circle" width="36px" height="36px">
                              </figure>
                           </div>
                           <div class="col-10">
                              <div class="row">
                                 <div class="col-8">
                                    <span class="titulo-2 fs-12 line-height-16"><b>Nombre asignatura </b></span>
                                 </div>
                                 <div class="col-4 text-center">
                                    <a class="badge badge-info pointer text-white" title="Asignar Horario"><i class="fa fa-plus fa-1x" aria-hidden="true"></i>Nuevo día</a>
                                 </div>
                                 <div class="col-12 fs-12">
                                    <i class="fa-solid fa-caret-right" aria-hidden="true"></i> Martes 01:00 am a 04:30 am - P-304 - c:1
                                    <a class="btn btn-link text-danger btn-xs" title="Eliminar Horario">x</a>
                                 </div>
                                 <span class="btn-group">
                                    <button class="btn btn-link text-success btn-xs" title="Asignar Salón">
                                       <i class="fa fa-school" aria-hidden="true"></i> Salón 
                                    </button>
                                    <button class="btn btn-link text-danger btn-xs"  title="Quitar salón">x</button>
                                 </span>
                                 <span class="btn-group">
                                    <button class="btn btn-link text-success btn-xs" title="Asignar Docente">
                                       <i class="fas fa-user" aria-hidden="true"></i> Docente
                                    </button>
                                    <button class="btn btn-link text-danger btn-xs" >x</button>
                                 </span>
                                 <div class="col-12 fs-12"><i class="fa-solid fa-caret-right" aria-hidden="true">
                                    </i> Martes 01:00 am a 04:30 am - P-304 - c:1
                                    <a class="btn btn-link text-danger btn-xs" title="Eliminar Horario">x</a>
                                 </div>
                                 <button class="btn btn-link text-primary btn-xs" title="Asignar Salón">
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Salón
                                 </button>
                                 <button class="btn btn-link text-primary btn-xs" title="Asignar Docente">
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i> Docente
                                 </button>
                                    

                              </div>
                              
                           </div>
                        </div>
                        
                     </div>

                  </div>
               </div>
               
               <div class="col-9 tono-5" id="t-calendario">
                  <!-- <h2 class="titulo-4" id="titulo"></h2> -->
                  <div class="row" id="calendar" style="width: 100%">
                     <table class="col-12 fs-14" id="demo-tour" cellpadding="5">
                        <thead class="borde-bottom-2">
                           <tr class="text-center titulo-2 fs-12 ">
                              <th class="py-2" style="width:130px">#</th>
                              <th class="py-2">dom </th>
                              <th class="py-2">Lunes</th>
                              <th class="py-2" style="width:150px">Martes</th>
                              <th class="py-2">Miercoles</th>
                              <th class="py-2">Jueves</th>
                              <th class="py-2">Viernes</th>
                              <th class="">Sabado</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">All Day</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">00:00 a.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">01:00 a.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th rowspan="3" class="p-2 borde-right-2" id="t-cal-1">

                                 <div class="bg-white p-2 fs-12 border-left-primary">
                                    <div class="fc-event-main-frame">
                                       <div class="fc-event-time">01:00 am - 04:00 am</div>
                                       <div class="fc-event-title-container">
                                          <div class="fc-event-title fc-sticky">Asignatura <br>Salón _____ <br> doc: _____ </div>
                                       </div>
                                    </div>
                                 </div>

                              </th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">02:00 a.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2" ></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">04:00 a.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">05:00 a.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">06:00 a.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">07:00 a.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">08:00 a.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2" rowspan="4" style="width:150px" id="t-cal-2">
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="p-2 fs-12 border-left-primary" style="background:#252e53">
                                          <div class="fc-event-main-frame">
                                             <div class="fc-event-time">01:00 am - 04:00 am</div>
                                             <div class="fc-event-title-container">
                                                <div class="fc-event-title fc-sticky">Asignatura <br>Salón _____ <br> doc: _____ </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">09:00 a.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">10:00 a.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">11:00 a.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">12:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">01:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">02:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">03:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">04:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">05:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">06:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">07:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">08:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">09:00 p.m</th>
                             <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">10:00 p.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                           <tr class="borde-bottom-2">
                              <th class="borde-right-2">11:00 p.m</th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                              <th class="borde-right-2"></th>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

</div>


<div class="modal" id="myModalCrear">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h6 class="modal-title">Asignar horario</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form name="formularioAgregarGrupo" id="formularioAgregarGrupo" method="POST">
               <div class="row">
               
                  <input type="hidden" name="id_horario_fijo" id="id_horario_fijo" value="">
                  <input type="hidden" name="id_materia" id="id_materia" value="">
                  <input type="hidden" name="jornadamateria" id="jornadamateria" value="">
                  <input type="hidden" name="grupomateria" id="grupomateria" value="">

                  <div class="col-12">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                           <select name="dia" id="dia" required class="form-control border-start-0 selectpicker" data-live-search="true"></select>
                           <label>Dia de clase</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>

                  <div class="col-12">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                           <select id="corte" name="corte" required class="form-control border-start-0 selectpicker" data-live-search="true">
                              <option value="1">1</option>
                              <option value="2">2</option>
                           </select>
                           <label>Corte</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>

                  <div class="col-12">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                           <select id="hora" name="hora" required class="form-control border-start-0 selectpicker" data-live-search="true" onchange="ajustarhasta(this.value)"></select>
                           <label>Hora inicio de clase</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>

                  <div class="col-12">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                           <select id="hasta" name="hasta" required class="form-control border-start-0 selectpicker" data-live-search="true" onchange="calcularhoras(this.value)"></select>
                           <label>Hora final de la clase</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>

                  <div class="col-12">
                     <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                           <input type="text" id="diferencia" name="diferencia"  required class="form-control border-start-0"  >
                           <label>Horas de clase</label>
                        </div>
                     </div>
                     <div class="invalid-feedback">Please enter valid input</div>
                  </div>


                  <div class="form-group col-12">
                     <button class="btn btn-primary btn-block" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Asignar Horario</button>
                  </div>

               </div>
            </form>
         </div>

      </div>
   </div>
</div>

<div class="modal" id="myModalAsignarSalon">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-body p-0 m-0">
            <div id="lista_salones"></div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
         </div>
      </div>
   </div>
</div>




<?php
	}
	else
	{
	  require 'noacceso.php';
	}
		
require 'footer.php';
?>

<script type="text/javascript" src="scripts/horarioplaneacion.js"></script>
<?php
}
	ob_end_flush();
?>

            

<!-- <script src='../fullcalendar/js/moment.min.js'></script>
<link href='../fullcalendar/css/fullcalendar.min.css' rel='stylesheet' />
<script src='../fullcalendar/js/fullcalendar.min.js'></script>
<script src='../fullcalendar/js/es.js'></script>


<script>

      $(document).ready(function(){
         $("#calendar").fullCalendar({
            header:{
               left:'',
               center:'',
               right:'basicWeek'
            },
            weekends: false // will hide Saturdays and Sundays
         });
      });
   </script>  -->


  
<link href='../fullcalendar/css/main.css' rel='stylesheet' />
<script src='../fullcalendar/js/main.js'></script>
<script src='../fullcalendar/locales/es.js'></script>

