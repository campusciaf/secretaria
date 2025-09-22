<?php 

require_once "../modelos/CvPanel.php";

date_default_timezone_set("America/Bogota");
$fecha=date('Y-m-d');
$hora=date('H:i:S');
$panel=new Panel();


switch ($_GET["op"]){
    case 'listar':
		$rspta=$panel->cv_listar();
        $data= Array();
		$data["0"] ="";
		$reg=$rspta;
        
        for ($i=0;$i<count($reg);$i++){	
            $data["0"] .= '
                <div class="box box-default">
                    <div class="box-header with-border bg-green">
                        <h3 class="box-title">'.$reg[$i]["nombre_educacion_continuada"].'</h3>
                    </div>
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> '.$reg[$i]["tipo_educacion_continuada"].'</strong>
                        <p class="text-muted">
                            '.$reg[$i]["descripcion_educacion_continuada"].'
                        </p>
                        <hr>
                        <strong><i class="fas fa-file-alt margin-r-5"></i> Modalidad:</strong>
                        '.$reg[$i]["modalidad_educacion_continuada"].'
                    </div>
                </div>';

		}

        $results = array($data);
        echo json_encode($results);
	break;

}

?>