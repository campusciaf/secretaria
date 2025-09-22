<?php 
require_once "../modelos/ConsultaVariables.php";

$consultavariables=new ConsultaVariables();

$id_categoria=isset($_POST["id_categoria"])? limpiarCadena($_POST["id_categoria"]):"";

$programa=isset($_POST["programa"])? limpiarCadena($_POST["programa"]):"";
$jornada=isset($_POST["jornada"])? limpiarCadena($_POST["jornada"]):"";
$semestre=isset($_POST["semestre"])? limpiarCadena($_POST["semestre"]):"";
$periodo=isset($_POST["periodo"])? limpiarCadena($_POST["periodo"]):"";

switch ($_GET["op"]){
		
	    case 'listar':
        $data= Array();
		$data["0"] ="";//iniciamos el arreglo
		$data["0"] .= '<div class="row">';        
        $rspta=$consultavariables->listarbotones();// consulta para listar los botones
        //Codificar el resultado utilizando json
        for ($i=0;$i<count($rspta);$i++){// bucle para imprimir la consulta
            
            $rspta2=$consultavariables->listarcategoria($rspta[$i]["id_categoria"]);// consulta para saber cuantas preguntas son
            $total_preguntas=count($rspta2);
            
            //$rspta3=$consultavariables->totalRespuestas($rspta[$i]["id_categoria"],$programa,$jornada,$semestre,$periodo);// consulta para saber la cantidad de respuestas por categoria
         	//$total_respuestas=count($rspta3);
            
           @$porcentaje= ($total_respuestas*100)/$total_preguntas;
            
         $data["0"] .= ' 
		 
		 
		 <div class="card card-widget widget-user-2 col-xl-4 col-lg-6 col-md-6 col-12">
              <div class="widget-user-header bg-success">
                <div class="widget-user-image">
				  <img class="img-circle elevation-2" src="../files/caracterizacion/'.$rspta[$i]["categoria_imagen"].'" alt="categoria">
                </div>
                <h3 class="widget-user-username">'.$rspta[$i]["categoria_nombre"].'</h3>
                <h5 class="widget-user-desc">...</h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link" onclick=listarVariable('.$rspta[$i]["id_categoria"].')>
                      Variables <span class="float-right badge bg-primary">'.$total_preguntas.'</span>
                    </a>
                  </li>';
			$rsptausuarios=$consultavariables->totalUsuarios($rspta[$i]["id_categoria"],$programa,$jornada,$semestre,$periodo);
			$total_usuarios=count($rsptausuarios);
			$data["0"] .= '
				  <li class="nav-item">
                    <a href="#" class="nav-link">
                      Usuarios <span class="float-right badge bg-primary">'.$total_usuarios.'</span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>';

         }
		$data["0"] .= '</div>';
		
 		$results = array($data);
 		echo json_encode($results);
	
		break;
		
		case "selectPrograma":	
		$rspta = $consultavariables->selectPrograma();
		echo "<option value=''>Seleccionar</option>";
		echo "<option value='todas'>Todos los Programas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["id_programa"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;
	
	case "selectJornada":	
		$rspta = $consultavariables->selectJornada();
		echo "<option value=''>Seleccionar</option>";
		echo "<option value='todas'>Todas los Jornadas</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["nombre"] . "'>" . $rspta[$i]["nombre"] . "</option>";
				}
	break;	
	
	case "selectPeriodo":	
		$rspta = $consultavariables->selectPeriodo();
		echo "<option value=''>Seleccionar</option>";
		echo "<option value='todas'>Todas los Periodos</option>";
		for ($i=0;$i<count($rspta);$i++)
				{
					echo "<option value='" . $rspta[$i]["periodo"] . "'>" . $rspta[$i]["periodo"] . "</option>";
				}
	break;	
		
}
?>