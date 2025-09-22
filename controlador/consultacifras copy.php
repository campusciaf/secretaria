<?php
session_start();
require_once "../modelos/ConsultaCifras.php";

date_default_timezone_set("America/Bogota");

$fecha = date('Y-m-d');
$hora = date('H:i:S');

$consultacifras = new ConsultaCifras();

$rsptaperiodo = $consultacifras->periodoactual();
$periodo_actual = $rsptaperiodo['periodo_actual'];
$periodo_anterior = $rsptaperiodo['periodo_anterior'];




switch ($_GET["op"]) {



    case 'listarescuelas':
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $data["mostrar"] .= '<div class="row">';
        $traerescuelas = $consultacifras->listarescuelas();
        for ($a = 0; $a < count($traerescuelas); $a++) {
            $escuela = $traerescuelas[$a]["escuelas"];
            $color = $traerescuelas[$a]["color"];
            $id_escuelas = $traerescuelas[$a]["id_escuelas"];
            $data["mostrar"] .= '

           
                    <a onclick="listar(' . $id_escuelas . ')" class="btn mr-1" style="background-color:' . $color . '" title="ver cifras">
                    
                        <h3 class="titulo-4 text-white">' . $escuela . '</h3>
                       
                    </a>';
        }
        $data["mostrar"] .= '</div>';


        echo json_encode($data);
        break;

    case 'listar':
        $data = array(); //Vamos a declarar un array
        $data["mostrar"] = ""; //iniciamos el arreglo
        $id_escuela = $_POST["id_escuela"];

        $nombreescuela = $consultacifras->nombreescuela($id_escuela);

        $data["mostrar"] .= '<div class=" mt-2 p-1" style="background-color:#e9e9e9">
        <p class="titulo-4 text-center">Escuela de ' . $nombreescuela["escuelas"] . '</p>
        </div>';

        $data["mostrar"] .= '<div class=" m-0 p-1" style="background-color:' . $nombreescuela["color"] . '"></div>';



        $traerestudiantes = $consultacifras->traerestudiantes($id_escuela, $periodo_actual); // consulta para traer los activos de la tabla estudiantes
        $traerestudiantesactivos = $consultacifras->traerestudiantesactivos($id_escuela, $periodo_actual); // consulta para traer los activos de la tabla estudiantes activos

        $traerestudiantesactivosanterior = $consultacifras->traerestudiantesactivos($id_escuela, $periodo_anterior); // consulta para traer los activos de la tabla estudiantes activos el periodo anterior
        $totalestudiantesactivosanterior = 0;

        for ($bb = 0; $bb < count($traerestudiantesactivosanterior); $bb++) {
            $id_programa = $traerestudiantesactivosanterior[$bb]["programa"];

            $buscar_programa = $consultacifras->validarprograma($id_programa);

            $programasi = $buscar_programa["estado_renovacion_financiera"];

            if ($programasi == 1) {
                $totalestudiantesactivosanterior = $totalestudiantesactivosanterior + 1;
            }
        }



        $traerestudiantesnuevos = $consultacifras->traerestudiantesnuevos($id_escuela, $periodo_actual); // consulta para traer los activos nuevos de la tabla estudiantes

        /* consulta para traer los graduados y egresados */
        $totalgraduados = 0;
        $listarprogramaterminal = $consultacifras->listarprogramaterminal($id_escuela); // traer losprogramas que son terminales por escuela
        for ($f = 0; $f < count($listarprogramaterminal); $f++) {
            $id_programa_terminal = $listarprogramaterminal[$f]["id_programa"];
            $traergraduados = $consultacifras->traergraduados($id_programa_terminal, $periodo_anterior); // traer los datos de los graduados y egresados

            $totalgraduados = $totalgraduados + count($traergraduados);
        }
        /* *********************************** */


        $totalestudiantesiniciociaf = 0;
        $totalciaf = 0;
        $totalciafjornadanuevos = 0;
        $totalrematriculajornadaciaf = 0;
        $totalinternosjornadaciaf = 0;
        $totalrenovaronconinternosjornadaciaf = 0;


        $traerjornadas = $consultacifras->traerjornadas($id_escuela); // consulta para traer las jornadas por programa de la tabla escuela_jornadas

        $listarrematricula = $consultacifras->listarrematricula($id_escuela, $periodo_actual); // estudiantes que renovaron tabla estudiantes
        $totalrematricula = count($listarrematricula);

        $listarinternos = $consultacifras->listarinternos($id_escuela, $periodo_actual); // estudiantes que renovaron tabla estudiantes pero internos
        $totalinternos = count($listarinternos);
        $totalrenovaronconinternos = $totalrematricula + $totalinternos; // total de los que renovarn con los internos

        $totalgraduadosciaf = 0;
        for ($a = 0; $a < count($traerjornadas); $a++) {
            $jornada = $traerjornadas[$a]["jornada"];

            // consulta pra taer los datos de los estudiantes que iniciaron, estan en la tabla estudiantes_activos
            $traerestudiantesiniciociaf = $consultacifras->traerestudiantesiniciociaf($id_escuela, $periodo_anterior, $jornada); // consulta para traer los activos de la tabla estudiantes activos el periodo anterior

            for ($aa = 0; $aa < count($traerestudiantesiniciociaf); $aa++) {
                $id_programa = $traerestudiantesiniciociaf[$aa]["programa"];

                $buscar_programa = $consultacifras->validarprograma($id_programa);

                $programasi = $buscar_programa["estado_renovacion_financiera"];

                if ($programasi == 1) {
                    $totalestudiantesiniciociaf = $totalestudiantesiniciociaf + 1;
                }
            }
            // *****************************************

            // total etudiantes 
            $traerestudiantesjornadaciaf = $consultacifras->traerestudiantesjornadaciaf($id_escuela, $periodo_actual, $jornada); // consulta para traer total estudiantes de la sede ciaf
            $totalciaf = $totalciaf + count($traerestudiantesjornadaciaf);



            /* consulta para traer los graduados y egresados e la sede CIAF */

            $listarprogramaterminal2 = $consultacifras->listarprogramaterminal($id_escuela); // traer los programas que son terminales por escuela
            for ($g = 0; $g < count($listarprogramaterminal2); $g++) {
                $id_programa_terminal2 = $listarprogramaterminal2[$g]["id_programa"];
                $traergraduadosciaf = $consultacifras->traergraduadosciaf($id_programa_terminal2, $jornada, $periodo_anterior); // traer los datos de los graduados y egresados

                $totalgraduadosciaf = $totalgraduadosciaf + count($traergraduadosciaf);
            }
            /* *********************************** */

            // total estudiantes nuevos sede ciaf
            $traerestudiantesjornadaciafnuevos = $consultacifras->traerestudiantesjornadaciafnuevos($id_escuela, $periodo_actual, $jornada); // consulta para traer total estudiantes de la sede ciaf
            $totalciafjornadanuevos = $totalciafjornadanuevos + count($traerestudiantesjornadaciafnuevos);

            $listarrematriculajornadaciaf = $consultacifras->listarrematriculajornadaciaf($id_escuela, $periodo_actual, $jornada); // consulta para traer los que renovaron
            $totalrematriculajornadaciaf = $totalrematriculajornadaciaf + count($listarrematriculajornadaciaf);

            $listarinternosjornadaciaf = $consultacifras->listarinternosjornadaciaf($id_escuela, $periodo_actual, $jornada); // estudiantes que renovaron tabla estudiantes pero internos

            $totalinternosjornadaciaf = $totalinternosjornadaciaf + count($listarinternosjornadaciaf);
            $totalrenovaronconinternosjornadaciaf = $totalrematriculajornadaciaf + $totalinternosjornadaciaf; // total de los que renovaron con los internos


        }



        $data["mostrar"] .= '<table class="table table-bordered table-sm compact">';
        $data["mostrar"] .= '<thead>';
        $data["mostrar"] .= '<th></th>';
        $data["mostrar"] .= '<th>Incio ' . $periodo_anterior . '</th>';
        $data["mostrar"] .= '<th>Final ' . $periodo_anterior . '</th>';
        $data["mostrar"] .= '<th>Graduados</th>';
        $data["mostrar"] .= '<th>Nuevos</th>';
        $data["mostrar"] .= '<th>Reintegros</th>';
        $data["mostrar"] .= '<th>Renovaciones</th>';
        $data["mostrar"] .= '<th>Inicio ' . $periodo_actual . '</th>';
        $data["mostrar"] .= '</thead>';
        $data["mostrar"] .= '<tbody>';
        $data["mostrar"] .= '<tr>';
        $data["mostrar"] .= '<td>Total</td>';
        $data["mostrar"] .= '<td>' . $totalestudiantesactivosanterior . '</td>';
        $data["mostrar"] .= '<td></td>';
        $data["mostrar"] .= '<td>' . $totalgraduados . '</td>';
        $data["mostrar"] .= '<td>' . count($traerestudiantesnuevos) . '</td>';
        $data["mostrar"] .= '<td></td>';
        $data["mostrar"] .= '<td><div class="tooltips">' . $totalrenovaronconinternos . ' <span class="tooltiptext">RenovaronG:' . $totalrematricula . ' <br> InternosG:' . $totalinternos . '</span></div></td>';
        $data["mostrar"] .= '<td>' . count($traerestudiantes) . ' - ' . count($traerestudiantesactivos) . '</td>';
        $data["mostrar"] .= '</tr>';
        $data["mostrar"] .= '<tr>';

        $estudiantescontaduria = 0;
        $estudiantescontadurianuevos = 0;
        $estudiantescontaduriarenovaron = 0;
        $totalinternosprogramarenovaron = 0;
        $totalrenovaronconinternosprogramarenovaron = 0;
        $estudiantescontaduriainiciaron = 0;

        if ($id_escuela == 6) { //mostrar los datos de la sede ciaf del programa de contaduria

            $traerdatosprogramacontaduria = $consultacifras->traerdatosprogramacontaduria($id_escuela); // consulta para traer los datos del programa contaduria sede CIAF

            for ($e = 0; $e < count($traerdatosprogramacontaduria); $e++) {
                $id_programa = $traerdatosprogramacontaduria[$e]["id_programa"];
                $nombre = $traerdatosprogramacontaduria[$e]["nombre"];

                $traerestudiantesprogramacontaduriainiciaron = $consultacifras->traerestudiantesprogramainicio($id_programa, $periodo_anterior); // consulta para traer total estudiantes por programa
                $estudiantescontaduriainiciaron = $estudiantescontaduriainiciaron + count($traerestudiantesprogramacontaduriainiciaron);

                $traerestudiantesprogramacontaduria = $consultacifras->traerestudiantesprograma($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa
                $estudiantescontaduria = $estudiantescontaduria + count($traerestudiantesprogramacontaduria);

                $traerestudiantesprogramacontadurianuevos = $consultacifras->traerestudiantesprogramanuevo($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa nuevos
                $estudiantescontadurianuevos = $estudiantescontadurianuevos + count($traerestudiantesprogramacontadurianuevos);

                $traerestudiantesprogramarenovaron = $consultacifras->traerestudiantesprogramarenovaron($id_programa, $periodo_actual); // consulta para traer total estudiantes que renovaron
                $estudiantescontaduriarenovaron = $estudiantescontaduriarenovaron + count($traerestudiantesprogramarenovaron);

                $listarinternosprogramarenovaron = $consultacifras->listarinternosprogramarenovaron($id_programa, $periodo_actual); // estudiantes que renovaron tabla estudiantes pero internos
                $totalinternosprogramarenovaron = $totalinternosprogramarenovaron + count($listarinternosprogramarenovaron);

                $totalrenovaronconinternosprogramarenovaron = $totalinternosprogramarenovaron + $estudiantescontaduriarenovaron; // total de los que renovaron con los internos

            }

            $data["mostrar"] .= '<tr>';
            $data["mostrar"] .= '<td>Sede CIAF</td>';
            $data["mostrar"] .= '<td>' . $estudiantescontaduriainiciaron . '</td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td>No</td>';
            $data["mostrar"] .= '<td>' . $estudiantescontadurianuevos . '</td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td><div class="tooltips">' . $totalrenovaronconinternosprogramarenovaron . ' <span class="tooltiptext">Renovaron:' . $estudiantescontaduriarenovaron . ' <br> Internos:' . $totalinternosprogramarenovaron . '</span></div></td>';
            $data["mostrar"] .= '<td>' . $estudiantescontaduria . '</td>';
            $data["mostrar"] .= '</tr>';
        } else { // mostrar normal los de la sede


            $data["mostrar"] .= '<td>Sede CIAF</td>';
            $data["mostrar"] .= '<td><a onclick=traerdatos("' . $id_escuela . '","CIAF","' . $periodo_anterior . '") style="cursor:pointer" title="ver estudiantes sede">' . $totalestudiantesiniciociaf . '</a></td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td>' . $totalgraduadosciaf . '</td>';
            $data["mostrar"] .= '<td>' . $totalciafjornadanuevos . '</td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td><div class="tooltips">' . $totalrenovaronconinternosjornadaciaf . ' <span class="tooltiptext">Renovaron:' . $totalrematriculajornadaciaf . ' <br> Internos:' . $totalinternosjornadaciaf . '</span></div></td>';
            $data["mostrar"] .= '<td>' . $totalciaf . '</td>';
            $data["mostrar"] .= '</tr>';
        }

        // jornadas en articulación
        $traerjornadasarticulacion = $consultacifras->traerjornadasarticulacion($id_escuela); // consulta para traer las jornadas por programa de la tabla escuela_jornadas
        $totalciaf = 0;
        $totalarticulacionrenovaroninternos = 0;

        for ($b = 0; $b < count($traerjornadasarticulacion); $b++) {
            $jornadaarticulacion = $traerjornadasarticulacion[$b]["jornada"];
            $sede = $traerjornadasarticulacion[$b]["sede"];

            // consulta pra taer los datos de los estudiantes que iniciaron, estan en la tabla estudiantes_activos
            $traerestudiantesiniciociafarticulacion = $consultacifras->traerestudiantesiniciociaf($id_escuela, $periodo_anterior, $jornadaarticulacion); // consulta para traer los activos de la tabla estudiantes activos el periodo anterior
            // *****************************************

            $traerestudiantesjornadaarticulacion = $consultacifras->traerestudiantesjornadaciaf($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf
            $traerestudiantesjornadaarticulacionnuevos = $consultacifras->traerestudiantesjornadaciafnuevos($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf
            $traerestudiantesjornadaarticulacionrenovaron = $consultacifras->traerestudiantesjornadaciafrenovaron($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf que renovaron
            $traerestudiantesjornadaarticulacionrenovaroninternos = $consultacifras->traerestudiantesjornadaciafrenovaroninternos($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf que renovaron
            $totalarticulacionrenovaroninternos = count($traerestudiantesjornadaarticulacionrenovaron) + count($traerestudiantesjornadaarticulacionrenovaroninternos);
            $data["mostrar"] .= '<tr>';
            $data["mostrar"] .= '<td>' . $sede . '</td>';
            $data["mostrar"] .= '<td>' . count($traerestudiantesiniciociafarticulacion) . '</td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td>No</td>';
            $data["mostrar"] .= '<td>' . count($traerestudiantesjornadaarticulacionnuevos) . '</td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td><div class="tooltips">' . $totalarticulacionrenovaroninternos . ' <span class="tooltiptext">Renovaron:' . count($traerestudiantesjornadaarticulacionrenovaron) . ' <br> Internos:' . count($traerestudiantesjornadaarticulacionrenovaroninternos) . '</span></div></td>';
            $data["mostrar"] .= '<td>' . count($traerestudiantesjornadaarticulacion) . '</td>';
            $data["mostrar"] .= '</tr>';
        }
        //  **************************** ********************* 

        $estudiantesintep = 0;
        $estudiantesintepnuevos = 0;
        $estudiantesinteprenovaron = 0;
        $totalprogramarenovaroninternosintep = 0;
        $totalrenovaronconinternosintep = 0;
        $totalgraduadosintep = 0;
        $totalestudiantesintep = 0;

        if ($id_escuela == 6) { //mostrar la universidad INTEP

            $traerdatosprogramauniversidad = $consultacifras->traerdatosprogramauniversidad("INTEP"); // consulta para traer los datos de los programa INTEP
            for ($d = 0; $d < count($traerdatosprogramauniversidad); $d++) {
                $id_programa = $traerdatosprogramauniversidad[$d]["id_programa"];
                $nombre = $traerdatosprogramauniversidad[$d]["nombre"];

                $traerestudiantesprogramaintep = $consultacifras->traerestudiantesprogramainicio($id_programa, $periodo_anterior); // consulta para traer total estudiantes que iniciaron el periodo anterior de la tabla estudiantes_activos
                $totalestudiantesintep = $totalestudiantesintep + count($traerestudiantesprogramaintep);

                $traerestudiantesprograma = $consultacifras->traerestudiantesprograma($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa
                $estudiantesintep = $estudiantesintep + count($traerestudiantesprograma);

                $traerestudiantesprogramanuevo = $consultacifras->traerestudiantesprogramanuevo($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa intep nuevos
                $estudiantesintepnuevos = $estudiantesintepnuevos + count($traerestudiantesprogramanuevo);

                $traerestudiantesprogramarenovaron = $consultacifras->traerestudiantesprogramarenovaron($id_programa, $periodo_actual); // consulta para traer total estudiantes que renovaron
                $estudiantesinteprenovaron = $estudiantesinteprenovaron + count($traerestudiantesprogramarenovaron);

                $listarprogramarenovaroninternosintep = $consultacifras->traerestudiantesrenovaroninternosintep($id_programa, $periodo_actual); // estudiantes que renovaron tabla estudiantes pero internos
                $totalprogramarenovaroninternosintep = $totalprogramarenovaroninternosintep + count($listarprogramarenovaroninternosintep);

                /* consulta para traer los graduados y egresados e la sede CIAF contaduria */

                $listarprogramaterminalintep = $consultacifras->listarprogramaterminalintep($id_programa); // traer los programas que son terminales pora el intep
                for ($h = 0; $h < count($listarprogramaterminalintep); $h++) {
                    $id_programa_terminal_intep = $listarprogramaterminalintep[$h]["id_programa"];
                    $traergraduadosintep = $consultacifras->traergraduados($id_programa_terminal_intep, $periodo_anterior); // traer los datos de los graduados y egresados

                    $totalgraduadosintep = $totalgraduadosintep + count($traergraduadosintep);
                }
                /* *********************************** */
            }
            $totalrenovaronconinternosintep = $totalprogramarenovaroninternosintep + $estudiantesinteprenovaron; // total de los que renovaron con los internos

            $data["mostrar"] .= '<tr>';
            $data["mostrar"] .= '<td>INTEP</td>';
            $data["mostrar"] .= '<td>' . $totalestudiantesintep . '</td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td>' . $totalgraduadosintep . '</td>';
            $data["mostrar"] .= '<td>' . $estudiantesintepnuevos . '</td>';
            $data["mostrar"] .= '<td></td>';
            $data["mostrar"] .= '<td><div class="tooltips">' . $totalrenovaronconinternosintep . ' <span class="tooltiptext">Renovaron:' . $estudiantesinteprenovaron . ' <br> Internos:' . $totalprogramarenovaroninternosintep . '</span></div></td>';
            $data["mostrar"] .= '<td>' . $estudiantesintep . '</td>';
            $data["mostrar"] .= '</tr>';
        }

        if ($id_escuela == 7) { // si la escuela es laborales


            $traerdatosprograma = $consultacifras->traerdatosprograma($id_escuela); // consulta para traer los datos de la tabla programa ac

            for ($c = 0; $c < count($traerdatosprograma); $c++) {
                $id_programa = $traerdatosprograma[$c]["id_programa"];
                $nombre = $traerdatosprograma[$c]["nombre"];
                $traerestudiantesprogramainicio = $consultacifras->traerestudiantesprogramainicio($id_programa, $periodo_anterior); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes

                $traerestudiantesprograma = $consultacifras->traerestudiantesprograma($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes

                $traerestudiantesprogramagraduados = $consultacifras->traerestudiantesprogramagraduados($id_programa, $periodo_anterior); // consulta para traer total estudiantes graduados por programa laboral de la tabla estudiantes


                $traerestudiantesprogramanuevo = $consultacifras->traerestudiantesprogramanuevo($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes
                $traerestudiantesprogramarenovaron = $consultacifras->traerestudiantesprogramarenovaron($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes
                $traerestudiantesprogramarenovaroninterno = $consultacifras->traerestudiantesprogramarenovaroninterno($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes internos
                $totalestudiantesprogramarenovaroninterno = count($traerestudiantesprogramarenovaron) + count($traerestudiantesprogramarenovaroninterno);


                $data["mostrar"] .= '<tr>';
                $data["mostrar"] .= '<td>' . $nombre . '</td>';
                $data["mostrar"] .= '<td>' . count($traerestudiantesprogramainicio) . '</td>';
                $data["mostrar"] .= '<td></td>';
                $data["mostrar"] .= '<td>' . count($traerestudiantesprogramagraduados) . '</td>';
                $data["mostrar"] .= '<td>' . count($traerestudiantesprogramanuevo) . '</td>';
                $data["mostrar"] .= '<td></td>';
                $data["mostrar"] .= '<td><div class="tooltips">' . $totalestudiantesprogramarenovaroninterno . ' <span class="tooltiptext">Renovaron:' . count($traerestudiantesprogramarenovaron) . ' <br> Internos:' . count($traerestudiantesprogramarenovaroninterno) . '</span></div></td>';

                $data["mostrar"] .= '<td>' . count($traerestudiantesprograma) . '</td>';
                $data["mostrar"] .= '</tr>';
                $data["mostrar"] .= '<tr>';

                $estudiantescontaduria = 0;
                $estudiantescontadurianuevos = 0;
                $estudiantescontaduriarenovaron = 0;
                $totalinternosprogramarenovaron = 0;
                $totalrenovaronconinternosprogramarenovaron = 0;
                $estudiantescontaduriainiciaron = 0;

                if ($id_escuela == 6) { //mostrar los datos de la sede ciaf del programa de contaduria

                    $traerdatosprogramacontaduria = $consultacifras->traerdatosprogramacontaduria($id_escuela); // consulta para traer los datos del programa contaduria sede CIAF

                    for ($e = 0; $e < count($traerdatosprogramacontaduria); $e++) {
                        $id_programa = $traerdatosprogramacontaduria[$e]["id_programa"];
                        $nombre = $traerdatosprogramacontaduria[$e]["nombre"];

                        $traerestudiantesprogramacontaduriainiciaron = $consultacifras->traerestudiantesprogramainicio($id_programa, $periodo_anterior); // consulta para traer total estudiantes por programa
                        $estudiantescontaduriainiciaron = $estudiantescontaduriainiciaron + count($traerestudiantesprogramacontaduriainiciaron);

                        $traerestudiantesprogramacontaduria = $consultacifras->traerestudiantesprograma($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa
                        $estudiantescontaduria = $estudiantescontaduria + count($traerestudiantesprogramacontaduria);

                        $traerestudiantesprogramacontadurianuevos = $consultacifras->traerestudiantesprogramanuevo($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa nuevos
                        $estudiantescontadurianuevos = $estudiantescontadurianuevos + count($traerestudiantesprogramacontadurianuevos);

                        $traerestudiantesprogramarenovaron = $consultacifras->traerestudiantesprogramarenovaron($id_programa, $periodo_actual); // consulta para traer total estudiantes que renovaron
                        $estudiantescontaduriarenovaron = $estudiantescontaduriarenovaron + count($traerestudiantesprogramarenovaron);

                        $listarinternosprogramarenovaron = $consultacifras->listarinternosprogramarenovaron($id_programa, $periodo_actual); // estudiantes que renovaron tabla estudiantes pero internos
                        $totalinternosprogramarenovaron = $totalinternosprogramarenovaron + count($listarinternosprogramarenovaron);

                        $totalrenovaronconinternosprogramarenovaron = $totalinternosprogramarenovaron + $estudiantescontaduriarenovaron; // total de los que renovaron con los internos

                    }

                    $data["mostrar"] .= '<tr>';
                    $data["mostrar"] .= '<td>Sede CIAF</td>';
                    $data["mostrar"] .= '<td>' . $estudiantescontaduriainiciaron . '</td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td>No</td>';
                    $data["mostrar"] .= '<td>' . $estudiantescontadurianuevos . '</td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td><div class="tooltips">' . $totalrenovaronconinternosprogramarenovaron . ' <span class="tooltiptext">Renovaron:' . $estudiantescontaduriarenovaron . ' <br> Internos:' . $totalinternosprogramarenovaron . '</span></div></td>';
                    $data["mostrar"] .= '<td>' . $estudiantescontaduria . '</td>';
                    $data["mostrar"] .= '</tr>';
                } else { // mostrar normal los de la sede


                    $data["mostrar"] .= '<td>Sede CIAF</td>';
                    $data["mostrar"] .= '<td><a onclick=traerdatos("' . $id_escuela . '","CIAF","' . $periodo_anterior . '") style="cursor:pointer" title="ver estudiantes sede">' . $totalestudiantesiniciociaf . '</a></td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td>' . $totalgraduadosciaf . '</td>';
                    $data["mostrar"] .= '<td><a onclick=traerdatosnuevos("' . $id_escuela . '","' . $periodo_actual . '","' . @$jornada . '") style="cursor:pointer" title="ver estudiantes nuevos SEDE">' . $totalciafjornadanuevos . '</a></td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td>
                                            <div class="tooltips">' . $totalrenovaronconinternosjornadaciaf . '
                                                    <span class="tooltiptext">
                                                        <a onclick=traerdatosrenovacion("' . $id_escuela . '","' . $periodo_actual . '") style="cursor:pointer">Renovaron:' . $totalrematriculajornadaciaf . '</a><br> 
                                                        <a onclick=traerdatosrenovacioninterna("' . $id_escuela . '","' . $periodo_actual . '") style="cursor:pointer">Internos:' . $totalinternosjornadaciaf . '</span>
                                            </div>
                                        </td>';
                    $data["mostrar"] .= '<td>' . $totalciaf . '</td>';
                    $data["mostrar"] .= '</tr>';
                }

                // jornadas en articulación
                $traerjornadasarticulacion = $consultacifras->traerjornadasarticulacion($id_escuela); // consulta para traer las jornadas por programa de la tabla escuela_jornadas
                $totalciaf = 0;
                $totalarticulacionrenovaroninternos = 0;

                for ($b = 0; $b < count($traerjornadasarticulacion); $b++) {
                    $jornadaarticulacion = $traerjornadasarticulacion[$b]["jornada"];
                    $sede = $traerjornadasarticulacion[$b]["sede"];

                    // consulta pra taer los datos de los estudiantes que iniciaron, estan en la tabla estudiantes_activos
                    $traerestudiantesiniciociafarticulacion = $consultacifras->traerestudiantesiniciociaf($id_escuela, $periodo_anterior, $jornadaarticulacion); // consulta para traer los activos de la tabla estudiantes activos el periodo anterior
                    // *****************************************

                    $traerestudiantesjornadaarticulacion = $consultacifras->traerestudiantesjornadaciaf($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf
                    $traerestudiantesjornadaarticulacionnuevos = $consultacifras->traerestudiantesjornadaciafnuevos($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf
                    $traerestudiantesjornadaarticulacionrenovaron = $consultacifras->traerestudiantesjornadaciafrenovaron($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf que renovaron
                    $traerestudiantesjornadaarticulacionrenovaroninternos = $consultacifras->traerestudiantesjornadaciafrenovaroninternos($id_escuela, $periodo_actual, $jornadaarticulacion); // consulta para traer total estudiantes de la sede ciaf que renovaron
                    $totalarticulacionrenovaroninternos = count($traerestudiantesjornadaarticulacionrenovaron) + count($traerestudiantesjornadaarticulacionrenovaroninternos);
                    $data["mostrar"] .= '<tr>';
                    $data["mostrar"] .= '<td>' . $sede . '</td>';
                    $data["mostrar"] .= '<td><a onclick=traerdatosarticulacion("' . $id_escuela . '","' . $periodo_anterior . '","' . $jornadaarticulacion . '") style="cursor:pointer" title="ver estudiantes ' . $sede . ' ">' . count($traerestudiantesiniciociafarticulacion) . '</a></td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td>No</td>';
                    $data["mostrar"] .= '<td>' . count($traerestudiantesjornadaarticulacionnuevos) . '</td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td>
                                                <div class="tooltips">' . $totalarticulacionrenovaroninternos . ' 
                                                    <span class="tooltiptext">
                                                        <a onclick=traerdatosrenovacionarticulacion("' . $id_escuela . '","' . $periodo_actual . '","' . $jornadaarticulacion . '") style="cursor:pointer">Renovaron:' . count($traerestudiantesjornadaarticulacionrenovaron) . '<a/><br> 
                                                        <a onclick=traerdatosrenovacioninternaarticulacion("' . $id_escuela . '","' . $periodo_actual . '","' . $jornadaarticulacion . '") style="cursor:pointer">Internos:' . count($traerestudiantesjornadaarticulacionrenovaroninternos) . '</a>
                                                    </span>
                                                </div>
                                            </td>';
                    $data["mostrar"] .= '<td>' . count($traerestudiantesjornadaarticulacion) . '</td>';
                    $data["mostrar"] .= '</tr>';
                }
                //  **************************** ********************* 

                $estudiantesintep = 0;
                $estudiantesintepnuevos = 0;
                $estudiantesinteprenovaron = 0;
                $totalprogramarenovaroninternosintep = 0;
                $totalrenovaronconinternosintep = 0;
                $totalgraduadosintep = 0;
                $totalestudiantesintep = 0;

                if ($id_escuela == 6) { //mostrar la universidad INTEP

                    $traerdatosprogramauniversidad = $consultacifras->traerdatosprogramauniversidad("INTEP"); // consulta para traer los datos de los programa INTEP
                    for ($d = 0; $d < count($traerdatosprogramauniversidad); $d++) {
                        $id_programa = $traerdatosprogramauniversidad[$d]["id_programa"];
                        $nombre = $traerdatosprogramauniversidad[$d]["nombre"];

                        $traerestudiantesprogramaintep = $consultacifras->traerestudiantesprogramainicio($id_programa, $periodo_anterior); // consulta para traer total estudiantes que iniciaron el periodo anterior de la tabla estudiantes_activos
                        $totalestudiantesintep = $totalestudiantesintep + count($traerestudiantesprogramaintep);

                        $traerestudiantesprograma = $consultacifras->traerestudiantesprograma($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa
                        $estudiantesintep = $estudiantesintep + count($traerestudiantesprograma);

                        $traerestudiantesprogramanuevo = $consultacifras->traerestudiantesprogramanuevo($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa intep nuevos
                        $estudiantesintepnuevos = $estudiantesintepnuevos + count($traerestudiantesprogramanuevo);

                        $traerestudiantesprogramarenovaron = $consultacifras->traerestudiantesprogramarenovaron($id_programa, $periodo_actual); // consulta para traer total estudiantes que renovaron
                        $estudiantesinteprenovaron = $estudiantesinteprenovaron + count($traerestudiantesprogramarenovaron);

                        $listarprogramarenovaroninternosintep = $consultacifras->traerestudiantesrenovaroninternosintep($id_programa, $periodo_actual); // estudiantes que renovaron tabla estudiantes pero internos
                        $totalprogramarenovaroninternosintep = $totalprogramarenovaroninternosintep + count($listarprogramarenovaroninternosintep);

                        /* consulta para traer los graduados y egresados e la sede CIAF contaduria */

                        $listarprogramaterminalintep = $consultacifras->listarprogramaterminalintep($id_programa); // traer los programas que son terminales pora el intep
                        for ($h = 0; $h < count($listarprogramaterminalintep); $h++) {
                            $id_programa_terminal_intep = $listarprogramaterminalintep[$h]["id_programa"];
                            $traergraduadosintep = $consultacifras->traergraduados($id_programa_terminal_intep, $periodo_anterior); // traer los datos de los graduados y egresados

                            $totalgraduadosintep = $totalgraduadosintep + count($traergraduadosintep);
                        }
                        /* *********************************** */
                    }
                    $totalrenovaronconinternosintep = $totalprogramarenovaroninternosintep + $estudiantesinteprenovaron; // total de los que renovaron con los internos

                    $data["mostrar"] .= '<tr>';
                    $data["mostrar"] .= '<td>INTEP</td>';
                    $data["mostrar"] .= '<td>' . $totalestudiantesintep . '</td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td>' . $totalgraduadosintep . '</td>';
                    $data["mostrar"] .= '<td>' . $estudiantesintepnuevos . '</td>';
                    $data["mostrar"] .= '<td></td>';
                    $data["mostrar"] .= '<td><div class="tooltips">' . $totalrenovaronconinternosintep . ' <span class="tooltiptext">Renovaron:' . $estudiantesinteprenovaron . ' <br> Internos:' . $totalprogramarenovaroninternosintep . '</span></div></td>';
                    $data["mostrar"] .= '<td>' . $estudiantesintep . '</td>';
                    $data["mostrar"] .= '</tr>';
                }

                if ($id_escuela == 7) { // si la escuela es laborales


                    $traerdatosprograma = $consultacifras->traerdatosprograma($id_escuela); // consulta para traer los datos de la tabla programa ac

                    for ($c = 0; $c < count($traerdatosprograma); $c++) {
                        $id_programa = $traerdatosprograma[$c]["id_programa"];
                        $nombre = $traerdatosprograma[$c]["nombre"];
                        $traerestudiantesprogramainicio = $consultacifras->traerestudiantesprogramainicio($id_programa, $periodo_anterior); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes

                        $traerestudiantesprograma = $consultacifras->traerestudiantesprograma($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes

                        $traerestudiantesprogramagraduados = $consultacifras->traerestudiantesprogramagraduados($id_programa, $periodo_anterior); // consulta para traer total estudiantes graduados por programa laboral de la tabla estudiantes


                        $traerestudiantesprogramanuevo = $consultacifras->traerestudiantesprogramanuevo($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes
                        $traerestudiantesprogramarenovaron = $consultacifras->traerestudiantesprogramarenovaron($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes
                        $traerestudiantesprogramarenovaroninterno = $consultacifras->traerestudiantesprogramarenovaroninterno($id_programa, $periodo_actual); // consulta para traer total estudiantes por programa laboral de la tabla estudiantes internos
                        $totalestudiantesprogramarenovaroninterno = count($traerestudiantesprogramarenovaron) + count($traerestudiantesprogramarenovaroninterno);


                        $data["mostrar"] .= '<tr>';
                        $data["mostrar"] .= '<td>' . $nombre . '</td>';
                        $data["mostrar"] .= '<td>' . count($traerestudiantesprogramainicio) . '</td>';
                        $data["mostrar"] .= '<td></td>';
                        $data["mostrar"] .= '<td>' . count($traerestudiantesprogramagraduados) . '</td>';
                        $data["mostrar"] .= '<td>' . count($traerestudiantesprogramanuevo) . '</td>';
                        $data["mostrar"] .= '<td></td>';
                        $data["mostrar"] .= '<td><div class="tooltips">' . $totalestudiantesprogramarenovaroninterno . ' <span class="tooltiptext">Renovaron:' . count($traerestudiantesprogramarenovaron) . ' <br> Internos:' . count($traerestudiantesprogramarenovaroninterno) . '</span></div></td>';

                        $data["mostrar"] .= '<td>' . count($traerestudiantesprograma) . '</td>';
                        $data["mostrar"] .= '</tr>';
                    }
                }
            }
        }



        $data["mostrar"] .= '</tbody>';
        $data["mostrar"] .= '</table>';



        // $traerprogramas = $consultacifras->listarprogramas($id_escuela);
        // for($b=0;$b<count($traerprogramas);$b++){
        //     $nombre_programa=$traerprogramas[$b]["nombre"];

        // $data["mostrar"] .= '
        // <div class="progress-group">
        //     '.$nombre_programa.'
        //     <span class="float-right"><b>
        //     <a onclick="listarestudiantesnivel(&quot;2022-2&quot;,&quot;1&quot;,&quot;1&quot;)" class="text-white" title="Estudiantes que renovaron" style="cursor:pointer">721</a></b>/
        //     79%</span>
        //     <div class="progress progress-sm">
        //         <div class="progress-bar" style="width: 79%"></div>
        //     </div>
        // </div>';
        // }

        $data["mostrar"] .= '</div>';

        echo json_encode($data);

        break;

        /* traer estudiantes de la sede CIAF en la tabla */
    case 'traerdatos':
        $periodo_anterior = $_GET["periodo_anterior"];
        $id_escuela = $_GET["id_escuela"];
        $sede = $_GET["sede"];
        //Vamos a declarar un array
        $data = array();


        $buscarjornadameta = $consultacifras->traerdatos($id_escuela, $periodo_anterior);

        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $id_estudiante_activo = $buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["programa"];

            $buscar_jornada = $consultacifras->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $consultacifras->validarprograma($id_programa);

            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1) {
                $dato_estudiante = $consultacifras->dato_estudiante($id_estudiante);
                $dato_credencial = $consultacifras->dato_estudiante_credencial($id_credencial);

                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                } else {
                    $programa = "a - No esta matriculado";
                }

                $datos_estudiantes = $consultacifras->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                } else {
                    $estado_renovacion = "Pendiente";
                }

                $data[] = array(
                    "0" => $id_estudiante_activo,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,


                );
            }
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;
        /* **************************************** */

        /* traer estudiantes de la sede CIAF en la tabla */
    case 'traerdatosarticulacion':
        $periodo_anterior = $_GET["periodo_anterior"];
        $id_escuela = $_GET["id_escuela"];
        $jornadaarticulacion = $_GET["jornadaarticulacion"];
        //Vamos a declarar un array
        $data = array();


        $buscarjornadameta = $consultacifras->traerdatosarticulacion($id_escuela, $periodo_anterior, $jornadaarticulacion);

        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            $id_estudiante_activo = $buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["programa"];

            $buscar_jornada = $consultacifras->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $consultacifras->validarprograma($id_programa);

            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];


            $dato_estudiante = $consultacifras->dato_estudiante($id_estudiante);
            $dato_credencial = $consultacifras->dato_estudiante_credencial($id_credencial);

            if ($dato_estudiante) {
                $programa = $dato_estudiante["fo_programa"];
                $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                $celular = $dato_estudiante["celular"];
            } else {

                $programa = "a - No esta matriculado";
            }

            $datos_estudiantes = $consultacifras->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
            $estado_renovacion = "";
            if ($datos_estudiantes) {
                $estado_renovacion = "Renovó";
            } else {
                $estado_renovacion = "Pendiente";
            }

            $data[] = array(
                "0" => $id_estudiante_activo,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,


            );
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'traerdatosnuevos':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $jornada = $_GET["jornada"];
        //Vamos a declarar un array
        $data = array();


        $buscarjornadameta = $consultacifras->traerdatosestudiantesnuevossede($id_escuela, $periodo_actual);

        for ($b = 0; $b < count($buscarjornadameta); $b++) {

            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $programa = $buscarjornadameta[$b]["fo_programa"];
            $celular = $buscarjornadameta[$b]["celular"];

            $dato_credencial = $consultacifras->dato_estudiante_credencial($id_credencial);


            $credencial_identificacion = $dato_credencial["credencial_identificacion"];
            $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];


            $estado_renovacion = "Nuevo";

            $data[] = array(
                "0" => $id_estudiante,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,
            );
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'traerdatosrenovacion':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];

        $data = array();


        $buscarjornadameta = $consultacifras->traerdatosestudiantesrenovacionsede($id_escuela, $periodo_actual);

        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["id_programa_ac"];

            $buscar_jornada = $consultacifras->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $consultacifras->validarprograma($id_programa);

            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];

            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1) {
                $dato_estudiante = $consultacifras->dato_estudiante($id_estudiante);
                $dato_credencial = $consultacifras->dato_estudiante_credencial($id_credencial);

                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                } else {
                    $programa = "a - No esta matriculado";
                }

                $datos_estudiantes = $consultacifras->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                } else {
                    $estado_renovacion = "Pendiente";
                }

                $data[] = array(
                    "0" => $id_estudiante,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                );
            }
        }



        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'traerdatosrenovacioninterna':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];

        $data = array();


        $buscarjornadameta = $consultacifras->traerdatosestudiantesrenovacioninternasede($id_escuela, $periodo_actual);

        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $id_programa = $buscarjornadameta[$b]["id_programa_ac"];

            $buscar_jornada = $consultacifras->validarjornada($id_escuela, $jornada_e);
            $buscar_programa = $consultacifras->validarprograma($id_programa);

            $programasi = $buscar_programa["estado_renovacion_financiera"];
            $programaterminal = $buscar_programa["terminal"];

            if ($buscar_jornada["sede"] == "CIAF" and $programasi == 1) {
                $dato_estudiante = $consultacifras->dato_estudiante($id_estudiante);
                $dato_credencial = $consultacifras->dato_estudiante_credencial($id_credencial);

                if ($dato_estudiante) {
                    $programa = $dato_estudiante["fo_programa"];
                    $credencial_identificacion = $dato_credencial["credencial_identificacion"];
                    $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];
                    $celular = $dato_estudiante["celular"];
                } else {
                    $programa = "a - No esta matriculado";
                }

                $datos_estudiantes = $consultacifras->dato_estudiante_periodo_actual($id_credencial, $periodo_actual);
                $estado_renovacion = "";
                if ($datos_estudiantes) {
                    $estado_renovacion = "Renovó";
                } else {
                    $estado_renovacion = "Pendiente";
                }

                $data[] = array(
                    "0" => $id_estudiante,
                    "1" => $credencial_identificacion,
                    "2" => $credencial_nombre,
                    "3" => $programa,
                    "4" => $jornada_e,
                    "5" => $celular,
                    "6" => $estado_renovacion,
                );
            }
        }



        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'traerdatosrenovacioninternaarticulacion':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $id_escuela = $_GET["id_escuela"];
        $jornadaarticulacion = $_GET["jornada"];
        $data = array();

        $buscarjornadameta = $consultacifras->traerestudiantesjornadaciafrenovaroninternos($id_escuela, $periodo_actual, $jornadaarticulacion);


        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $programa = $buscarjornadameta[$b]["fo_programa"];
            $celular = $buscarjornadameta[$b]["celular"];

            $dato_credencial = $consultacifras->dato_estudiante_credencial($id_credencial);

            $credencial_identificacion = $dato_credencial["credencial_identificacion"];
            $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];

            $estado_renovacion = "Renovó";


            $data[] = array(
                "0" => $id_estudiante,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,
            );
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'traerdatosrenovacionarticulacion':
        $periodo_actual = $_GET["periodo_actual"];
        $id_escuela = $_GET["id_escuela"];
        $id_escuela = $_GET["id_escuela"];
        $jornadaarticulacion = $_GET["jornada"];
        $data = array();

        $buscarjornadameta = $consultacifras->traerestudiantesjornadaciafrenovaron($id_escuela, $periodo_actual, $jornadaarticulacion);


        for ($b = 0; $b < count($buscarjornadameta); $b++) {
            // $id_estudiante_activo=$buscarjornadameta[$b]["id_estudiante_activo"];
            $id_estudiante = $buscarjornadameta[$b]["id_estudiante"];
            $id_credencial = $buscarjornadameta[$b]["id_credencial"];
            $jornada_e = $buscarjornadameta[$b]["jornada_e"];
            $programa = $buscarjornadameta[$b]["fo_programa"];
            $celular = $buscarjornadameta[$b]["celular"];

            $dato_credencial = $consultacifras->dato_estudiante_credencial($id_credencial);

            $credencial_identificacion = $dato_credencial["credencial_identificacion"];
            $credencial_nombre = $dato_credencial["credencial_apellido"] . " " . $dato_credencial["credencial_apellido_2"] . " " . $dato_credencial["credencial_nombre"] . " " . $dato_credencial["credencial_nombre_2"];

            $estado_renovacion = "Renovó";


            $data[] = array(
                "0" => $id_estudiante,
                "1" => $credencial_identificacion,
                "2" => $credencial_nombre,
                "3" => $programa,
                "4" => $jornada_e,
                "5" => $celular,
                "6" => $estado_renovacion,
            );
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
}