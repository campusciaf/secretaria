<?php 
require_once "../modelos/HorarioOcupacion.php";

$consulta=new HorarioOcupacion();


date_default_timezone_set("America/Bogota");	
$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');


$rsptaperiodo = $consulta->periodoactual();
$periodo_actual = $rsptaperiodo["periodo_actual"];
$periodo_anterior = $rsptaperiodo["periodo_anterior"];
$periodo_siguiente = $rsptaperiodo["periodo_siguiente"];

switch ($_GET["op"]){
		

	case 'iniciar':

        $data= Array();
		$data["datos"] ="";

        $periodo=$_POST["periodo"];
		$sede=$_POST["sede"];
        $jornada=$_POST["jornada"];
		$dia=$_POST["dia"];

       

        if($jornada=="1"){
            $horas=array('07:00:00','07:30:00','08:00:00','09:00:00','10:00:00','11:00:00','12:00:00');
        }else if($jornada=="2"){
            $horas=array('13:00:00','14:00:00','15:00:00','16:00:00','17:00:00','18:00:00');
        }else{
            $horas=array('18:30:00','19:00:00','20:00:00','20:15:00','21:00:00','21:45:00','22:00:00','22:30:00');
        }

        if($jornada=="1"){
            $horascol=array('07:00:00','07:30:00','08:00:00','09:00:00','10:00:00','11:00:00','12:00:00');
        }else if($jornada=="2"){
            $horascol=array('1:00:00','2:00:00','3:00:00','4:00:00','5:00:00','6:00:00');
        }else{
            $horascol=array('6:30pm','7pm','8pm','8:15pm','9pm','9:45','10pm','10:30pm');
        }


        $data["datos"] .= '<table class="table table-sm "> ';
            $data["datos"] .= '<thead>';
                $data["datos"] .= '<th class="py-4">Salón</th>';
                    $h=0;
                    while($h<count($horascol)){
                        $data["datos"] .= '<th class="py-4">'.$horascol[$h].'</th>';
                        $h++;
                    }
                $data["datos"] .= '<th class="py-4" style="width:300px">% Ocupación</th>';
            $data["datos"] .= '</thead>';
            $data["datos"] .= '<tbody>';
        

                $traresalon=$consulta->traerSalones($sede);
                $ocupadogeneral=0;
                for ($i=0;$i<count($traresalon);$i++){
                    $salon=$traresalon[$i]["codigo"];
                    $data["datos"] .= '<tr>';
                        $data["datos"] .= '<td>' . $salon . '</td> ';

                        $ocupado=0;
                        $noocupado=0;
                        $k=0;
                        while($k<count($horas)){
                            $mihora=$horas[$k];

                            $verificar=$consulta->verificarhorario($salon,$dia,$mihora,$periodo);
                            if($verificar==true){
                                $ocupado++;
                                $data["datos"] .= '<td>Si</td>';
                                
                            }else{
                                $noocupado++;
                                $data["datos"] .= '<td>No</td>';
                            }
                            
                            $k++;
                            
                        }
                        $ocupadogeneral=$ocupadogeneral+$ocupado;
                        $porcentajeocupacionsalon=($ocupado*100)/count($horascol);
                        if($porcentajeocupacionsalon<50){
                            $barra="bg-success";
                        }else if($porcentajeocupacionsalon<60){ 
                            $barra="bg-teal";
                        }else if($porcentajeocupacionsalon<70){ 
                            $barra="bg-primary";
                        }
                        else if($porcentajeocupacionsalon<80){ 
                            $barra="bg-warning";
                        }
                        else if($porcentajeocupacionsalon<90){ 
                            $barra="bg-orange";
                        }else{
                            $barra="bg-danger";
                        }

                        $data["datos"] .= '<td>
                            <div class="col-12">'.round($porcentajeocupacionsalon,2).'%</div>
                            <div class="progress progress-sm">
                                <div class="progress-bar '. $barra.'" style="width: '.round($porcentajeocupacionsalon,2).'%"></div>
                            </div>
                        </td> ';

                       
                        
                    $data["datos"] .= '</tr>';
                }
            $data["datos"] .= '</tbody>';

        $data["datos"] .= '</table>';

        $general=($ocupadogeneral*100)/(count($traresalon)*count($horas));
		$data["datos"] .= '<div class="col-12 bg-success p-3" style="position:fixed; bottom:0%"> Porcentaje general de ocupación: '.round($general,2) . '% </div>';
        echo json_encode($data);

	break;

    case "selectSede":	
		$rspta = $consulta->selectSede();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["sede"] . "'>" . $rspta[$i]["sede"] . "</option>";
				}
	break;
	
		
	case "selectPeriodo":	
		$rspta = $consulta->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;

	case "selectSalon":	
		$rspta = $consulta->selectSalon();
		echo "<option value=''>Seleccionar</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["codigo"] . "'>" . $rspta[$i]["codigo"] . "</option>";
				}
	break;
		









}
?>