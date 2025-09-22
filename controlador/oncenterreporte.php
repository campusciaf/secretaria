<?php 
require_once "../modelos/OncenterReporte.php";
date_default_timezone_set('America/Bogota');
session_start();
$consulta =  new Consulta();

$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_campana = $rsptaperiodo["periodo_campana"];
$fecha_tarea_tabla = $rsptaperiodo["fecha_tareas"];

switch ($_GET['op']) {
    case 'listar':


        $data['general']='';

        
    
        $listargeneral = $consulta->listar($periodo_campana);
        $listarprogramaadmin1 = $consulta->listarprograma($periodo_campana,$programaadmin1);
        $listarprogramaadmin2 = $consulta->listarprograma($periodo_campana,$programaadmin2);
        $listarprogramaadmin3 = $consulta->listarprograma($periodo_campana,$programaadmin3);

        $programaadmin1="Nivel 1 - Técnico Profesional en Procesos Empresariales"; 
        $programaadmin2="Nivel 2 - Tecnología en Gestión y auditoria administrativa";
        $programaadmin3="Nivelatorio de Administración de Empresas 2023";

        $listarprogramaadmin1d = $consulta->listarprogramaj($periodo_campana,$programaadmin1,'Diurna');
        $listarprogramaadmin1n = $consulta->listarprogramaj($periodo_campana,$programaadmin1,'Nocturna');
        $listarprogramaadmin1f = $consulta->listarprogramaj($periodo_campana,$programaadmin1,'Fds');
        $listarprogramaadmin1s = $consulta->listarprogramaj($periodo_campana,$programaadmin1,'Sabados');

        $listarprogramaadmin2d = $consulta->listarprogramaj($periodo_campana,$programaadmin2,'Diurna');
        $listarprogramaadmin2n = $consulta->listarprogramaj($periodo_campana,$programaadmin2,'Nocturna');
        $listarprogramaadmin2f = $consulta->listarprogramaj($periodo_campana,$programaadmin2,'Fds');
        $listarprogramaadmin2s = $consulta->listarprogramaj($periodo_campana,$programaadmin2,'Sabados');

        $listarprogramaadmin3d = $consulta->listarprogramaj($periodo_campana,$programaadmin3,'Diurna');
        $listarprogramaadmin3n = $consulta->listarprogramaj($periodo_campana,$programaadmin3,'Nocturna');
        $listarprogramaadmin3f = $consulta->listarprogramaj($periodo_campana,$programaadmin3,'Fds');
        $listarprogramaadmin3s = $consulta->listarprogramaj($periodo_campana,$programaadmin3,'Sabados');


        $programaconta1="Técnico profesional en operaciones contables y financieras"; 
        $programaconta2="NIVELATORIO CONTADURÍA SENA INTEP 2023";

        $listarprogramaconta1d = $consulta->listarprogramaj($periodo_campana,$programaconta1,'Diurna');
        $listarprogramaconta1n = $consulta->listarprogramaj($periodo_campana,$programaconta1,'Nocturna');
        $listarprogramaconta1f = $consulta->listarprogramaj($periodo_campana,$programaconta1,'Fds');
        $listarprogramaconta1s = $consulta->listarprogramaj($periodo_campana,$programaconta1,'Sabados');

        $listarprogramaconta2d = $consulta->listarprogramaj($periodo_campana,$programaconta2,'Diurna');
        $listarprogramaconta2n = $consulta->listarprogramaj($periodo_campana,$programaconta2,'Nocturna');
        $listarprogramaconta2f = $consulta->listarprogramaj($periodo_campana,$programaconta2,'Fds');
        $listarprogramaconta2s = $consulta->listarprogramaj($periodo_campana,$programaconta2,'Sabados');


        $programasst1="Nivel 1 - Técnico Profesional en Procesos de Seguridad y Salud en el Trabajo"; 
        $programasst2="Nivel 2 - Tecnología en Gestión de la Seguridad y Salud en el Trabajo";
        $programasst3="NIVELATORIO EN GESTIÓN INTEGRADA DE LA CALIDAD, MEDIO AMBIENTE, SEGURIDAD Y SALUD OCUPACIONAL";

        $listarprogramasst1d = $consulta->listarprogramaj($periodo_campana,$programasst1,'Diurna');
        $listarprogramasst1n = $consulta->listarprogramaj($periodo_campana,$programasst1,'Nocturna');
        $listarprogramasst1f = $consulta->listarprogramaj($periodo_campana,$programasst1,'Fds');
        $listarprogramasst1s = $consulta->listarprogramaj($periodo_campana,$programasst1,'Sabados');

        $listarprogramasst2d = $consulta->listarprogramaj($periodo_campana,$programasst2,'Diurna');
        $listarprogramasst2n = $consulta->listarprogramaj($periodo_campana,$programasst2,'Nocturna');
        $listarprogramasst2f = $consulta->listarprogramaj($periodo_campana,$programasst2,'Fds');
        $listarprogramasst2s = $consulta->listarprogramaj($periodo_campana,$programasst2,'Sabados');

        $listarprogramasst3d = $consulta->listarprogramaj($periodo_campana,$programasst3,'Diurna');
        $listarprogramasst3n = $consulta->listarprogramaj($periodo_campana,$programasst3,'Nocturna');
        $listarprogramasst3f = $consulta->listarprogramaj($periodo_campana,$programasst3,'Fds');
        $listarprogramasst3s = $consulta->listarprogramaj($periodo_campana,$programasst3,'Sabados');



        

        $programasoftware1="Nivel 1 - Técnica profesional en programación de software"; 
        $programasoftware2="Nivelatorio Ingeniería de Software - SENA";

        $listarprogramasoftware1d = $consulta->listarprogramaj($periodo_campana,$programasoftware1,'Diurna');
        $listarprogramasoftware1n = $consulta->listarprogramaj($periodo_campana,$programasoftware1,'Nocturna');
        $listarprogramasoftware1f = $consulta->listarprogramaj($periodo_campana,$programasoftware1,'Fds');
        $listarprogramasoftware1s = $consulta->listarprogramaj($periodo_campana,$programasoftware1,'Sabados');

        $listarprogramasoftware2d = $consulta->listarprogramaj($periodo_campana,$programasoftware2,'Diurna');
        $listarprogramasoftware2n = $consulta->listarprogramaj($periodo_campana,$programasoftware2,'Nocturna');
        $listarprogramasoftware2f = $consulta->listarprogramaj($periodo_campana,$programasoftware2,'Fds');
        $listarprogramasoftware2s = $consulta->listarprogramaj($periodo_campana,$programasoftware2,'Sabados');



        $programaindustrial1="Nivel 1 - Técnico Profesional en Logística de Producción"; 


        $listarprogramaindustrial1d = $consulta->listarprogramaj($periodo_campana,$programaindustrial1,'Diurna');
        $listarprogramaindustrial1n = $consulta->listarprogramaj($periodo_campana,$programaindustrial1,'Nocturna');
        $listarprogramaindustrial1f = $consulta->listarprogramaj($periodo_campana,$programaindustrial1,'Fds');
        $listarprogramaindustrial1s = $consulta->listarprogramaj($periodo_campana,$programaindustrial1,'Sabados');




        $data['general'].='
            <div class="col-12 my-2">
                <div class="row">
                    <div class="col-xl-7">
                        <table class="text-center col-12 table-sm tono-3 borde">
                            <thead class="tono-4 borde">
                                <tr>
                                    <th rowspan="2" class="text-left titulo-2 fs-16" style="vertical-align: middle;">Administración de empresas</th>
                                    <th colspan="4" class="">Metas '.$periodo_campana.'</th>
                                    <th colspan="4" class="">Cifras '.$periodo_campana.'</th>
                                </tr>
                                <tr>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="">
                                    <td class="text-left">Intensivos Octubre</td>
                                    <td class=""></td>
                                    <td class="">13</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivel I</td>
                                    <td class="">25</td>
                                    <td class="">30</td>
                                    <td class="">30</td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramaadmin1d).'</td>
                                    <td class="">'.count($listarprogramaadmin1n).'</td>
                                    <td class="">'.count($listarprogramaadmin1f).'</td>
                                    <td class="">'.count($listarprogramaadmin1s).'</td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivel II</td>
                                    <td class=""></td>
                                    <td class="">15</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramaadmin2d).'</td>
                                    <td class="">'.count($listarprogramaadmin2n).'</td>
                                    <td class="">'.count($listarprogramaadmin2f).'</td>
                                    <td class="">'.count($listarprogramaadmin2s).'</td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivelatorio SENA</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="">25</td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramaadmin3d).'</td>
                                    <td class="">'.count($listarprogramaadmin3n).'</td>
                                    <td class="">'.count($listarprogramaadmin3f).'</td>
                                    <td class="">'.count($listarprogramaadmin3s).'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-xl-5">

                        <div class="row d-flex justify-content-center py-3">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tg">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-white text-black">
                                                    <i class="fa-solid fa-tags"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Total</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="datogeneral">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">General <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tn">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-red text-danger">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Faltan</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="nocumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">No Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tc">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-green text-success">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Cumplimiento</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="cumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>
                
                    </div>
                </div>      
            
            </div>
        ';

        $data['general'].='
            <div class="col-12 my-2">
                <div class="row">
                    <div class="col-xl-7">

                        <table class="text-center col-12 table-sm tono-3" border="0">
                            <thead class="tono-4">
                                <tr>
                                    <th rowspan="2" class="text-left titulo-2 fs-16" style="vertical-align: middle;">Seguridad y Salud en el Trabajo</th>
                                    <th colspan="4" class="">Metas '.$periodo_campana.'</th>
                                    <th colspan="4" class="">Cifras '.$periodo_campana.'</th>
                                </tr>
                                <tr>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                <tr class="">
                                    <td class="text-left">Intensivos Octubre</td>
                                    <td class=""></td>
                                    <td class="">13</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivel I</td>
                                    <td class="">25</td>
                                    <td class="">30</td>
                                    <td class="">30</td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramasst1d).'</td>
                                    <td class="">'.count($listarprogramasst1n).'</td>
                                    <td class="">'.count($listarprogramasst1f).'</td>
                                    <td class="">'.count($listarprogramasst1s).'</td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivel II</td>
                                    <td class=""></td>
                                    <td class="">15</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramasst2d).'</td>
                                    <td class="">'.count($listarprogramasst2n).'</td>
                                    <td class="">'.count($listarprogramasst2f).'</td>
                                    <td class="">'.count($listarprogramasst2s).'</td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivelatorio SST</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="">25</td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramasst3d).'</td>
                                    <td class="">'.count($listarprogramasst3n).'</td>
                                    <td class="">'.count($listarprogramasst3f).'</td>
                                    <td class="">'.count($listarprogramasst3s).'</td>
                                </tr>
                            </tbody>
                        </table>
                    
                    </div>

                    <div class="col-xl-5">

                        <div class="row d-flex justify-content-center py-3">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tg">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-white text-black">
                                                    <i class="fa-solid fa-tags"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Total</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="datogeneral">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">General <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tn">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-red text-danger">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Faltan</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="nocumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">No Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tc">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-green text-success">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Cumplimiento</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="cumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>
                
                    </div>
                </div>  
            
            </div>
        ';

        $data['general'].='
            <div class="col-12 my-2">
                <div class="row">
                    <div class="col-xl-7">

                        <table class="text-center col-12 table-sm tono-3" border="0">
                            <thead class="tono-4">
                                <tr>
                                    <th rowspan="2" class="text-left titulo-2 fs-16" style="vertical-align: middle;">Contaduría Pública</th>
                                    <th colspan="4" class="">Metas '.$periodo_campana.'</th>
                                    <th colspan="4" class="">Cifras '.$periodo_campana.'</th>
                                </tr>
                                <tr>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="">
                                    <td class="text-left">Intensivos Octubre</td>
                                    <td class=""></td>
                                    <td class="">13</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivel I</td>
                                    <td class="">25</td>
                                    <td class="">30</td>
                                    <td class="">30</td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramaconta1d).'</td>
                                    <td class="">'.count($listarprogramaconta1n).'</td>
                                    <td class="">'.count($listarprogramaconta1f).'</td>
                                    <td class="">'.count($listarprogramaconta1s).'</td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivelatorio SENA</td>
                                    <td class=""></td>
                                    <td class="">15</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramaconta2d).'</td>
                                    <td class="">'.count($listarprogramaconta2n).'</td>
                                    <td class="">'.count($listarprogramaconta2f).'</td>
                                    <td class="">'.count($listarprogramaconta2s).'</td>
                                </tr>

                            </tbody>
                        </table>
                    
                    </div>

                    <div class="col-xl-5">

                        <div class="row d-flex justify-content-center py-3">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tg">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-white text-black">
                                                    <i class="fa-solid fa-tags"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Total</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="datogeneral">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">General <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tn">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-red text-danger">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Faltan</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="nocumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">No Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tc">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-green text-success">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Cumplimiento</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="cumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>
                
                    </div>
                </div>
                    
            
            </div>
        ';

        $data['general'].='
            <div class="col-12 my-2">
                <div class="row">
                    <div class="col-xl-7">

                        <table class="text-center col-12 table-sm tono-3" border="0">
                            <thead class="tono-4">
                                <tr>
                                    <th rowspan="2" class="text-left titulo-2 fs-16" style="vertical-align: middle;">Ingeniería de Software</th>
                                    <th colspan="4" class="">Metas '.$periodo_campana.'</th>
                                    <th colspan="4" class="">Cifras '.$periodo_campana.'</th>
                                </tr>
                                <tr>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="">
                                    <td class="text-left">Intensivos Octubre</td>
                                    <td class=""></td>
                                    <td class="">13</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivel I</td>
                                    <td class="">25</td>
                                    <td class="">30</td>
                                    <td class="">30</td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramasoftware1d).'</td>
                                    <td class="">'.count($listarprogramasoftware1n).'</td>
                                    <td class="">'.count($listarprogramasoftware1f).'</td>
                                    <td class="">'.count($listarprogramasoftware1s).'</td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivelatorio Ingeniería de Software</td>
                                    <td class=""></td>
                                    <td class="">15</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramasoftware2d).'</td>
                                    <td class="">'.count($listarprogramasoftware2n).'</td>
                                    <td class="">'.count($listarprogramasoftware2f).'</td>
                                    <td class="">'.count($listarprogramasoftware2s).'</td>
                                </tr>

                            </tbody>
                        </table>
                    
                    </div>

                <div class="col-xl-5">
                    <div class="row d-flex justify-content-center py-3">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tg">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-white text-black">
                                                    <i class="fa-solid fa-tags"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Total</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="datogeneral">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">General <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tn">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-red text-danger">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Faltan</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="nocumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">No Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tc">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-green text-success">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Cumplimiento</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="cumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>
                
                    </div>
                </div>
                    
            
            </div>
        ';

        $data['general'].='
            <div class="col-12 my-2">
                <div class="row">
                    <div class="col-xl-7">

                        <table class="text-center col-12 table-sm tono-3" border="0">
                            <thead class="tono-4">
                                <tr>
                                    <th rowspan="2" class="text-left titulo-2 fs-16" style="vertical-align: middle;">Ingeniería Industrial</th>
                                    <th colspan="4" class="">Metas '.$periodo_campana.'</th>
                                    <th colspan="4" class="">Cifras '.$periodo_campana.'</th>
                                </tr>
                                <tr>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                    <th class="">Día</th>
                                    <th class="">Noche</th>
                                    <th class="">FDS</th>
                                    <th class="">Sábado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="">
                                    <td class="text-left">Intensivos Octubre</td>
                                    <td class=""></td>
                                    <td class="">13</td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                    <td class=""></td>
                                </tr>
                                <tr class="">
                                    <td class="text-left">Nivel I</td>
                                    <td class="">25</td>
                                    <td class="">30</td>
                                    <td class="">30</td>
                                    <td class=""></td>
                                    <td class="">'.count($listarprogramaindustrial1d).'</td>
                                    <td class="">'.count($listarprogramaindustrial1n).'</td>
                                    <td class="">'.count($listarprogramaindustrial1f).'</td>
                                    <td class="">'.count($listarprogramaindustrial1s).'</td>
                                </tr>


                            </tbody>
                        </table>
                    
                    </div>

                    <div class="col-xl-5">
                        <div class="row d-flex justify-content-center py-3">

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tg">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-white text-black">
                                                    <i class="fa-solid fa-tags"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Total</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="datogeneral">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">General <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tn">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-red text-danger">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Faltan</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="nocumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">No Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-4 col-md-6 col-6 cursor-pointer my-2">
                                <div class="row justify-content-center">
                                    <div class="col-12 hidden">
                                        <div class="row align-items-center" id="t-tc">
                                            <div class="col-auto">
                                                <div class="avatar rounded bg-light-green text-success">
                                                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="col ps-0">
                                                <div class="small mb-0">Cumplimiento</div>
                                                <h4 class="text-dark mb-0">
                                                    <span class="titulo-2 fs-24" id="cumplidas">0</span>
                                                    <small class="text-regular">OK</small>
                                                </h4>
                                                <div class="small">Cumplidas <span class="text-green"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            


                        </div>
                    </div>
                </div>
                </div>
                    
            
            </div>
        ';









        

        echo json_encode($data);

    break;



}

?>