<?php
session_start();
require_once "../modelos/VerCaracterizacionDocente.php";
error_reporting(0); 
$vercaracterizaciondocente = new VerCaracterizacionDocente();
// variables para datos de registro
$fecha = date('Y-m-d');
$hora = date('H:i');
//variable para saber que usuario hizo el registro
$id_usuario = $_SESSION['id_usuario'];
switch ($_GET["op"]) {
    case 'listar':
        $rspta = $vercaracterizaciondocente->mostrarreporte();
        $data = array();
        $reg = $rspta;
        for ($i = 0; $i < count($reg); $i++) {
            $id_docente  = $reg[$i]["id_docente"];
            // $fecha_acepto = $vercaracterizaciondocente->fechaesp($reg[$i]["fechaaceptodata"]);
            // $fecha_actualizacion = $vercaracterizaciondocente->fechaesp($reg[$i]["updatedata"]);

            // omitimos los valores que vengan vacios ya que algunos docentes no han aceptado, las condiciones ni han actualizado el perfil
            if (!empty($reg[$i]["fechaaceptodata"])) {
                $fecha_acepto = $vercaracterizaciondocente->fechaesp($reg[$i]["fechaaceptodata"]);
            } else {
                $fecha_acepto = null;
            }
            if (!empty($reg[$i]["updatedata"])) {
                $fecha_actualizacion = $vercaracterizaciondocente->fechaesp($reg[$i]["updatedata"]);
            } else {
                $fecha_actualizacion = null;
            }
            $p1 = $reg[$i]["p1"];
            $p2 = $reg[$i]["p2"];
            $p3 = $reg[$i]["p3"];
            $p4 = $reg[$i]["p4"];
            $p5 = $reg[$i]["p5"] == 1 ? 'No' : ($reg[$i]["p5"] == 2 ? 'Sí' : '');
            $p6 = $reg[$i]["p6"]== 1 ? 'No' : ($reg[$i]["p6"] == 2 ? 'Sí' : '');
            $p7 = $reg[$i]["p7"];
            $p8 = $reg[$i]["p8"];
            $p9 = $reg[$i]["p9"] == 1 ? 'No' : ($reg[$i]["p9"] == 2 ? 'Sí' : '');
            $p10 = $reg[$i]["p10"];
            $p11 = $reg[$i]["p11"];
            $p12 = $reg[$i]["p12"] == 1 ? 'No' : ($reg[$i]["p12"] == 2 ? 'Sí' : '');
            $p13 = $reg[$i]["p13"];
            $p14 = $reg[$i]["p14"];
            $p15 = $reg[$i]["p15"] == 1 ? 'No' : ($reg[$i]["p15"] == 2 ? 'Sí' : '');
            $p16 = $reg[$i]["p16"];
            $p17 = $reg[$i]["p17"] == 1 ? 'No' : ($reg[$i]["p17"] == 2 ? 'Sí' : '');
            $p18 = $reg[$i]["p18"];
            $p19 = $reg[$i]["p19"];
            $p20 = $reg[$i]["p20"];
            $p21 = $reg[$i]["p21"];
            $p22 = $reg[$i]["p22"] == 1 ? 'No' : ($reg[$i]["p22"] == 2 ? 'Sí' : '');
            $p23 = $reg[$i]["p23"]== 1 ? 'No' : ($reg[$i]["p23"] == 2 ? 'Sí' : '') ;
            $p24 = $reg[$i]["p24"] == 1 ? 'No' : ($reg[$i]["p24"] == 2 ? 'Sí' : '');
            $p25 = $reg[$i]["p25"]== 1 ? 'No' : ($reg[$i]["p25"] == 2 ? 'Sí' : '');
            $p26 = $reg[$i]["p26"]== 1 ? 'No' : ($reg[$i]["p26"] == 2 ? 'Sí' : '');
            $p27 = $reg[$i]["p27"];
            $p28 = $reg[$i]["p28"];
            $p29 = $reg[$i]["p29"] == 1 ? 'No' : ($reg[$i]["p29"] == 2 ? 'Sí' : '');
            $p30 = $reg[$i]["p30"];
            $p31 = $reg[$i]["p31"];
            $p32 = $reg[$i]["p32"];
            $p33 = $reg[$i]["p33"];
            $p34 = $reg[$i]["p34"];
            $p35 = $reg[$i]["p35"];
            $p36 = $reg[$i]["p36"];
            $p37 = $reg[$i]["p37"];
            $p38 = $reg[$i]["p38"];
            $p39 = $reg[$i]["p39"] == 1 ? 'No' : ($reg[$i]["p39"] == 2 ? 'Sí' : '');
            $p40 = $reg[$i]["p40"];
            $p41 = $reg[$i]["p41"];
            $p42 = $reg[$i]["p42"];
            $p43 = $reg[$i]["p43"] == 1 ? 'No' : ($reg[$i]["p43"] == 2 ? 'Sí' : '');
            $p44 = $reg[$i]["p44"] == 1 ? 'No' : ($reg[$i]["p44"] == 2 ? 'Sí' : '');
            $p45 = $reg[$i]["p45"]== 1 ? 'No' : ($reg[$i]["p45"] == 2 ? 'Sí' : '') ;
            $p46 = $reg[$i]["p46"] == 1 ? 'No' : ($reg[$i]["p46"] == 2 ? 'Sí' : '');
            $p47 = $reg[$i]["p47"];
            $p48 = $reg[$i]["p48"];
            $p49 = $reg[$i]["p49"] == 1 ? 'No' : ($reg[$i]["p49"] == 2 ? 'Sí' : '');
            $p50 = $reg[$i]["p50"];
            $datos_docente = $vercaracterizaciondocente->datos_docente($id_docente);
            $identificacion = $datos_docente["usuario_identificacion"];
            $nombre = $datos_docente["usuario_apellido"] . ' ' . $datos_docente["usuario_apellido_2"] . ' ' . $datos_docente["usuario_nombre"] . ' ' . $datos_docente["usuario_nombre_2"];

            $data[] = array(
                "0" => $identificacion,
                "1" => '<p class="text-uppercase">' . $nombre . '</p>',
                "2" => $fecha_acepto,
                "3" => $fecha_actualizacion,
                "4" => $p1,
                "5" => $p2,
                "6" => $p3,
                "7" => $p4,
                "8" => $p5,
                "9" => $p6,
                "10" => $p7,
                "11" => $p8,
                "12" => $p9,
                "13" => $p10,
                "14" => $p11,
                "15" => $p12,
                "16" => $p13,
                "17" => $p14,
                "18" => $p15,
                "19" => $p16,
                "20" => $p17,
                "21" => $p18,
                "22" => $p19,
                "23" => $p20,
                "24" => $p21,
                "25" => $p22,
                "26" => $p23,
                "27" => $p24,
                "28" => $p25,
                "29" => $p26,
                "30" => $p27,
                "31" => $p28,
                "32" => $p29,
                "33" => $p30,
                "34" => $p31,
                "35" => $p32,
                "36" => $p33,
                "37" => $p34,
                "38" => $p35,
                "39" => $p36,
                "40" => $p37,
                "41" => $p38,
                "42" => $p39,
                "43" => $p40,
                "44" => $p41,
                "45" => $p42,
                "46" => $p43,
                "47" => $p44,
                "48" => $p45,
                "49" => $p46,
                "50" => $p47,
                "51" => $p48,
                "52" => $p49,
                "53" => $p50,
                
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);

        break;
}
