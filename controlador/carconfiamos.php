<?php
session_start();
require_once "../modelos/CarConfiamos.php";

$carconfiamos = new CarConfiamos();
$periodo_actual = $_SESSION['periodo_actual'];
$id_credencial = $_SESSION['id_usuario'];

date_default_timezone_set("America/Bogota");
$fecha = date('Y-m-d');
$hora = date('H:i:s');


$p1=isset($_POST["p1"])? limpiarCadena($_POST["p1"]):"";
$p2=isset($_POST["p2"])? limpiarCadena($_POST["p2"]):"";
$p3=isset($_POST["p3"])? limpiarCadena($_POST["p3"]):"";
$p4=isset($_POST["p4"])? limpiarCadena($_POST["p4"]):"";
$p5=isset($_POST["p5"])? limpiarCadena($_POST["p5"]):"";
$p6=isset($_POST["p6"])? limpiarCadena($_POST["p6"]):"";
$p7=isset($_POST["p7"])? limpiarCadena($_POST["p7"]):"";
$p8=isset($_POST["p8"])? limpiarCadena($_POST["p8"]):"";
$p9=isset($_POST["p9"])? limpiarCadena($_POST["p9"]):"";
$p10=isset($_POST["p10"])? limpiarCadena($_POST["p10"]):"";
$p11=isset($_POST["p11"])? limpiarCadena($_POST["p11"]):"";
$p12=isset($_POST["p12"])? limpiarCadena($_POST["p12"]):"";
$p13=isset($_POST["p13"])? limpiarCadena($_POST["p13"]):"";
$p14=isset($_POST["p14"])? limpiarCadena($_POST["p14"]):"";
$p15=isset($_POST["p15"])? limpiarCadena($_POST["p15"]):"";
$p16=isset($_POST["p16"])? limpiarCadena($_POST["p16"]):"";
$p17=isset($_POST["p17"])? limpiarCadena($_POST["p17"]):"";
$p18=isset($_POST["p18"])? limpiarCadena($_POST["p18"]):"";
$p19=isset($_POST["p19"])? limpiarCadena($_POST["p19"]):"";
$p20=isset($_POST["p20"])? limpiarCadena($_POST["p20"]):"";
$p21=isset($_POST["p21"])? limpiarCadena($_POST["p21"]):"";
$p22=isset($_POST["p22"])? limpiarCadena($_POST["p22"]):"";
$p23=isset($_POST["p23"])? limpiarCadena($_POST["p23"]):"";
$p24=isset($_POST["p24"])? limpiarCadena($_POST["p24"]):"";
$p25=isset($_POST["p25"])? limpiarCadena($_POST["p25"]):"";
$p26=isset($_POST["p26"])? limpiarCadena($_POST["p26"]):"";
$p27=isset($_POST["p27"])? limpiarCadena($_POST["p27"]):"";
$p28=isset($_POST["p28"])? limpiarCadena($_POST["p28"]):"";
$p29=isset($_POST["p29"])? limpiarCadena($_POST["p29"]):"";
$p30=isset($_POST["p30"])? limpiarCadena($_POST["p30"]):"";

switch ($_GET['op']) {

    case 'verificar':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		    $rspta=$carconfiamos->verificar($id_credencial);

        $data = $rspta ? '1' : '0';
        echo json_encode($data);

		
	break;

    case 'guardardata':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo

        $aceptodata=0;
        $rspta=$carconfiamos->insertardata($id_credencial,$aceptodata,$fecha);
        $rspta ? "1" : "2";

        $data["0"] .= $rspta;

        $results = array($data);
        echo json_encode($data);

    break; 	

    case 'listarPreguntas':

        $data= Array();
		$data["datos"] ="";//iniciamos el arreglo
        $data["condi"] ="";//para saber si es hombre o mujer

        $pre=$carconfiamos->listar($id_credencial);
        $data["condi"] .=$pre["genero"];//para saber si es hombre o mujer

        $data["datos"] .= '';
            $data["datos"] .= '<div class="row">';

                $data["datos"] .= '

                <div class="col-12">
                    <h6 class="title">Información básica</h6>
                </div>';
                
      


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp1">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop1"].'"  id="p1_val">
                                <select class="form-control border-start-0" name="p1" id="p1" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Menos 1 SMLV">Menos 1 SMLV</option>
                                    <option value="1-3 SMLV">1-3 SMLV</option>
                                    <option value="3-5 SMLV">3-5 SMLV</option>
                                    <option value="5-7 SMLV">5-7 SMLV</option>
                                    <option value="7-10 SMLV">7-10 SMLV</option>
                                    <option value="MÁS DE 10 SMLV">MÁS DE 10 SMLV</option>
                                    <option value="No genero ingresos">No genero ingresos</option>
                                </select>
                                <label>¿Cuáles son tus ingresos mensuales? (en pesos colombianos)</label>
                            </div>
                        </div>
                    </div>
                </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp2">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop2"].'"  id="p2_val">
                                <select class="form-control border-start-0" name="p2" id="p2" required>
                                    <option value="">Seleccionar</option>
                                    <option value="Recursos propios">Recursos propios</option>
                                    <option value="Esposo (a)">Esposo (a)</option>
                                    <option value="Papá">Papá</option>
                                    <option value="Mamá">Mamá</option>
                                    <option value="Empresa">Empresa</option>
                                    <option value="Beca">Beca</option>
                                </select>
                                <label>¿Quién paga tu matrícula?</label>
                            </div>
                        </div>
                    </div>
                </div>';
              
                $data["datos"] .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp3">
                        <div class="form-group mb-3 position-relative check-valid">
                            <div class="form-floating">
                                <div class="form-floating">
                                    <input type="hidden" value="'.$pre["cop3"].'"  id="p3_val">
                                    <select class="form-control border-start-0" name="p3" id="p3" required>
                                        <option value="">Seleccionar</option>
                                        <option value="No">No</option>
                                        <option value="Si">Si</option>
                                    </select>
                                    <label>¿Cuentas con algún apoyo financiero?</label>
                                </div>
                            </div>
                        </div>
                    </div>';

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp4">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop4"].'"  id="p4_val">
                                <select class="form-control border-start-0" name="p4" id="p4" required>
                                    <option value="">Seleccionar</option>
                                    <option value="No">No</option>
                                    <option value="Si">Si</option>
                                </select>
                                <label>¿En la actualidad recibes prima y/o cesantías?</label>
                            </div>
                        </div>
                    </div>
                </div>';

                if($pre["cop5"]==1){
                    $p5option='
                        <option value="1" selected>No</option>
                        <option value="2">Si</option>
                    ';
                }else{
                    $p5option='
                    <option value="1" >No</option>
                    <option value="2" selected>Si</option>
                    ';
                }

                $data["datos"] .= '
                <div class="col-xl-4 col-lg-3 col-md-6 col-12">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <select required class="form-control border-start-0" name="p5" id="p5" onchange="mostrarp5(this.value)">
                                '.$p5option.'
                            </select>
                            <label>¿Cuentas con obligaciones financieras?</label>
                        </div>
                    </div>
                </div>';


                $data["datos"] .= '
                <div class="col-xl-4 col-lg-6 col-md-6 col-12" id="mostrarp6">
                    <div class="form-group mb-3 position-relative check-valid">
                        <div class="form-floating">
                            <div class="form-floating">
                                <input type="hidden" value="'.$pre["cop6"].'"  id="p6_val">
                                <select class="form-control border-start-0" name="p6" id="p6">
                                    <option value="">Seleccionar</option>
                                    <option value="Vivienda">Vivienda</option>
                                    <option value="Educativa">Educativa</option>
                                    <option value="Vehículo">Vehículo</option>
                                    <option value="Personales">Personales</option>
                                    
                                </select>
                                <label>¿De qué tipo?</label>
                            </div>
                        </div>
                    </div>
                </div>';

  
                $data["datos"] .= '<div class="col-12 p-4 text-right" style="margin-bottom:100px"><button type="submit" class="btn btn-success">Guardar datos</button></div>';


            $data["datos"] .= '</div>';
        $data["datos"] .= '';
        
        $results = array($data);
        echo json_encode($data);

    break;

    case 'guardaryeditar':

		$data= Array();
		$data["estado"] ="";


			$rspta=$carconfiamos->editarDatos($id_credencial,$p1,$p2,$p3,$p4,$p5,$p6,$fecha);
			$datos=$rspta ? "si" : "no";	
		

		$data["estado"] = $datos;
        echo json_encode($data);
	break;

    
}

?>