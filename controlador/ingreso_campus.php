<?php

require_once "../modelos/IngresoCampus.php";
$ingresocampus = new IngresoCampus();

switch ($_GET['op']) {
    case 'ingresocampus':
        $roll = isset($_POST["roll_php"]) ? limpiarCadena($_POST["roll_php"]) : "";
        $fecha_ingreso = isset($_POST["fecha_ingreso_php"]) ? limpiarCadena($_POST["fecha_ingreso_php"]) : "";
        $fecha_final = date("Y-m-d", strtotime($fecha_ingreso." +6 days"));
        //$max_valor = $ingresocampus->CantidadTotalIngresos($roll, $fecha_ingreso, $fecha_final)["total"];
        if($roll == "todos"){
            $max_valor = 50; 
        }else{
            $max_valor = 25; 
        }
        $dias = array( "Lun.", "Mar.", "Mie.", "Jue.", "Vie.", "Sab.", "Do .");
        $hora = array("12a.m.", "1a.m.", "2a.m.", "3a.m.", "4a.m.", "5a.m.", "6a.m.", "7a.m.", "8a.m.", "9a.m.", "10a.m.", "11a.m.", "12p.m.", "1p.m.", "2p.m.", "3p.m.", "4p.m.", "5p.m.", "6p.m.", "7p.m.", "8p.m.", "9p.m.", "10p.m.", "11p.m.", "12p.m.");
        
        //echo $max_valor ;
        if(date("w", strtotime($fecha_ingreso)) != 1){
            die('
            <div class="alert alert-danger mt-3 mb-3" role="alert">
                Error con el dia que seleccionaste, debes eligir un lunes
            </div>');
        }else{
            $tabla = '<table id="ingreso" class="col-12" >';
            
            $head_tabla = '<thead>
                <th class="p-1 m-0" style="width: 50px;"> </th>
            ';
            for($a = 0; $a <= 23; $a++){
                $head_tabla .= '<th class="p-1 m-0" style="width: 50px;"> '.$hora[$a].'</th>';
            }
            $head_tabla .= '</thead>';
            $body_tabla = '<tbody>';

            for ($a = 0; $a <= 6; $a++) { 
                //echo $fecha_ingreso."<br>";
                $data = $ingresocampus->consultaingreso($roll, $fecha_ingreso);
                $arreglo = array_fill(0, 24, 0);
                for ($i = 0; $i < count($data); $i++) { 
                    $horas = date("G", strtotime($data[$i]["hora"]));
                    $arreglo[$horas]++;
                }
                $max_valor_dia[] = max($arreglo); 
                $body_tabla.= "<tr> <th class='p-0 m-0'> ".$dias[$a]."</th>";
                for ($j = 0; $j <= 23 ; $j++) { 
                    $porcentaje = ($arreglo[$j] * 100)/$max_valor;
                    $red = 3 - $porcentaje;
                    $green = 208 - $porcentaje;
                    $blue = 249 - $porcentaje;
                    
                    $body_tabla .= '<td class="p-0 m-0 border border-white tooltip-dato" style="width: 40px; background-color: rgb('.$red.', '.$green.', '.$blue.')  !important" data-toggle="tooltip" data-placement="left" title="'.$arreglo[$j].'"></td>';
                }
                $body_tabla.= "</tr>";
                $fecha_ingreso = date("Y-m-d", strtotime($fecha_ingreso."+1 days"));
            } 
            $body_tabla .= '</tbody>';
            $tabla .= $head_tabla.$body_tabla."</table>";
            $tabla.= '<div class="mt-3" >
                        <div class="progress mb-3">
                            <div class="progress-bar bg_degradado" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only">100% Complete (warning)</span>
                            </div>
                        </div>
                        <span class="float-left"> 0 </span>
                        <span class="float-right"> '.(max($max_valor_dia)).' </span>
                    </div>';
            echo $tabla;
        }
        break;

}

?>