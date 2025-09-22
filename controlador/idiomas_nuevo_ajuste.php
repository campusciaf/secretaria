<?php
session_start();

require_once "../modelos/Idiomas.php";
$idiomas = new Idiomas();
switch ($_GET['op']) {
    case 'listar':
        //toma los 3 de ingles(A1, A2, B1) de la tabla de programas 
        $niveles = $idiomas->listar_niveles();
        $data['conte'] = '';
        $data['valor'] = 0;
        $data['cant'] = 0;
        $estado_programa = 0;
        $cant = 0;
        $programa = '';
        $data['nivel'] = '';
        $mensaje = '';
        // Asumimos que todos están pagados al principio
        $todosPagados = true;  
        // Variable para determinar si el usuario puede avanzar al siguiente curso
        $puedeAvanzar = false;  
        // Variable para determinar si el usuario ha perdido el curso
        $haPerdido = false;     
        $data['conte'] .= '
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nivel</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>';
        $bandera = true;
        for ($i = 0; $i < count($niveles); $i++) {
            $valor_nivel = $idiomas->valor_cursos($niveles[$i]['id_programa']);
            $id_credencial = $_SESSION['id_usuario'];
            $traer_id_estudiante = $idiomas->traeridestudiante($id_credencial, $niveles[$i]['id_programa']);
            $id_estudiante = null; // Inicializa $id_estudiante como null
            // Verifica si la función traeridestudiante devolvió un resultado
            if ($traer_id_estudiante && is_array($traer_id_estudiante) && isset($traer_id_estudiante['id_estudiante'])) {
                // Acceder al id_estudiante si existe en el resultado
                $id_estudiante = $traer_id_estudiante['id_estudiante'];
                $estado_programa = $traer_id_estudiante['estado'];
            }
            if($estado_programa != 5 && $bandera){
                //entra al condicional cuando el estudiante no este registrando 
                if (empty($id_estudiante)) {
                    $traerMaterias = $idiomas->getMaterias($niveles[$i]['id_programa']);
                    for ($a = 0; $a < count($traerMaterias); $a++) {
                        if($traerMaterias[$a]['nombre'] != "A1-1"){
                            $data['conte'] .=
                            "<tr>
                                <td> <input type='checkbox' class='nivel-checkbox' id='checkbox_$a' " . (($a == 0) ? '' : 'disabled') . " data-valor='" . $valor_nivel['valor'] . "' data-materia='" . $traerMaterias[$a]['nombre'] . "' data-toggle='tooltip' title='Debes pagar los cursos en orden secuencial'>
                                <label class='h6' for='checkbox_$a'>" . $traerMaterias[$a]['nombre'] . "</label> </td>
                                <td>$ " . $valor_nivel['valor'] . "</td>
                                <td><span class='bg-danger p-1'><i class='fas fa-times'></i> No está pagada</span></td>
                            </tr>";
                        } 
                            //echo $niveles[$i]['id_programa'];
                    }
                    $data['conte'] .= '</tbody>
                        </table>';
                        $bandera = false;
                } else {
                    
                }
            }
        }
        $data["conte"] .= '
        <button type="button" id="btnPagar" onclick="generarBotones()" disabled class="btn btn-sm bg-navy btn-flat btn-block" data-toggle="modal" data-target=".exampleModal_una">
            <i data-toggle="tooltip" data-original-title="Pagar Cuota"><i class="fas fa-hand-holding-usd"> Pagar </i></i>
        </button>';
        echo json_encode($data);
        break;
    case 'generarBotones':
        $nivel_cantidad = $_POST["nivel_cantidad"];
        $texto_materias = $_POST["texto_materias"];
        $nivel_global = $_POST["nivel_global"];
        $jornada_e = $_POST["jornada"];
        $traervalorcursos = $idiomas->traervalocursos($nivel_global);
        $id_programa = $traervalorcursos['id_programa'];
        $precio_curso = $idiomas->valor_cursos($id_programa);
        $valor = $precio_curso['valor'];
        $total_curso_ingles = $valor * $nivel_cantidad;

        $data["info"] = '<!-- =====================================================================
        ///////////   Este es su botón de Botón de pago ePayco gateway   ///////////
        ===================================================================== -->
        <form class="col-6">
            <script src="https://checkout.epayco.co/checkout.js" 
                data-epayco-key="d4b482f39f386634f5c50ba7076eecff" 
                class="epayco-button" 
                data-epayco-amount="' . $total_curso_ingles . '" 
                data-epayco-tax="0"
                data-epayco-tax-base="' . $total_curso_ingles  . '"
                data-epayco-name="Pago Nivel Idiomas '. $texto_materias.'" 
                data-epayco-description=" '.$texto_materias . '" 
                data-epayco-extra1="' . $_SESSION['id_usuario'] . '"
                data-epayco-extra2="' . $_SESSION['credencial_identificacion'] . '"
                data-epayco-extra3="' . $id_programa . '"
                data-epayco-extra4="' . $nivel_global . '"
                data-epayco-extra5="' . $jornada_e . '"
                data-epayco-currency="cop"    
                data-epayco-country="CO" 
                data-epayco-test="false" 
                data-epayco-external="true" 
                data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                data-epayco-confirmation="https://ciaf.digital/vistas/pagosnivelidiomas.php" 
                data-epayco-button="https://ciaf.digital/public/img/btn-enlinea.png"> 
            </script> 
        </form> 
        <!-- ================================================================== -->    
        
        <!-- =====================================================================
            ///////////   Este es su botón de Botón de pago ePayco agregador   ///////////
            ===================================================================== -->
        <form class="col-6">
            <script src="https://checkout.epayco.co/checkout.js" 
                data-epayco-key="8b4e82b040nota_por_asistencia08b31bc5be3f33830392" 
                class="epayco-button" 
                data-epayco-amount="' . $total_curso_ingles . '" 
                data-epayco-tax="0"
                data-epayco-tax-base="' . $total_curso_ingles  . '"
                data-epayco-name="Pago Nivel Idiomas ' . $texto_materias . '" 
                data-epayco-description=" ' . $texto_materias . '" 
                data-epayco-extra1="' . $_SESSION['id_usuario'] . '"
                data-epayco-extra2="' . $_SESSION['credencial_identificacion'] . '"
                data-epayco-extra3="' . $id_programa . '"
                data-epayco-extra4="' . $nivel_global . '"
                data-epayco-extra5="' . $jornada_e . '"
                data-epayco-currency="cop"    
                data-epayco-country="CO" 
                data-epayco-test="false" 
                data-epayco-external="true"
                data-epayco-response="https://ciaf.digital/vistas/gracias.php"  
                data-epayco-confirmation="https://ciaf.digital/vistas/pagosnivelidiomas.php" 
                data-epayco-button="https://ciaf.digital/public/img/btn-efectivo.png">
            </script> 
        </form> 
        <!-- ================================================================== --> ';
        echo json_encode($data);
        break;

    case "selectJornada":
        $rspta = $idiomas->selectJornada();
        for ($i = 0; $i < count($rspta); $i++) {
            echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["codigo"] . "</option>";
        }
        break;
}
