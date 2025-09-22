<?php 
require_once "../modelos/VerShopping.php";
require("../public/mail/sendFeria.php");
$vershopping=new VerShopping();

$id_shopping=isset($_POST["id_shopping"])? limpiarCadena($_POST["id_shopping"]):"";
$id_credencial=isset($_POST["id_credencial"])? limpiarCadena($_POST["id_credencial"]):"";



switch ($_GET["op"]){
		
	
	case 'listar':
		$rspta=$vershopping->listar();
 		//Vamos a declarar un array
 		$data= Array();

			$i = 0;			
			while ($i < count($rspta)){
                if($rspta[$i]["shopping_participar"]==1){
                    $estado="<span class='badge badge-warning'>En construcción</span>";
                }else if($rspta[$i]["shopping_participar"]==2){
                    $estado="<span class='badge badge-primary'>Por revisar</span>";
                }else{
                    $estado="<span class='badge badge-success'>Validado</span>";
                }
				$datos_estudiante = $vershopping->datos_estudiante($rspta[$i]["id_credencial"]);
				$nombre=$datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_apellido"];
				$identificacion=$datos_estudiante["credencial_identificacion"];

				$data[]=array(
				"0"=>'<button class="btn btn-danger btn-xs" onclick="negar('.$rspta[$i]["id_shopping"].','.$rspta[$i]["id_credencial"].')" title="No aprobar"><i class="fa-solid fa-x"></i> </button>'.
 					'<button class="btn btn-success btn-xs" onclick="validar('.$rspta[$i]["id_shopping"].','.$rspta[$i]["id_credencial"].')" title="Validar proyecto"><i class="fa-solid fa-check"></i> </button>',
					
				"1"=>$identificacion,
                "2"=>'<img src="../files/shopping/'.$rspta[$i]["shopping_img"].'" width="50px" onclick=verFoto("'.$rspta[$i]["shopping_img"].'")>',
                "3"=>$rspta[$i]["shopping_nombre"],
				"4"=>$rspta[$i]["shopping_descripcion"],
                "5"=>'<a href="https://www.facebook.com/'.$rspta[$i]["shopping_instagram"].'" target="_blank"><i class="fa-brands fa-facebook text-white fa-2x" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/'.$rspta[$i]["shopping_facebook"].'" target="_blank"><i class="fa-brands fa-instagram text-white fa-2x" aria-hidden="true"></i></a>',
                "6"=>($rspta[$i]["shopping_autorizo"]=="0")?'Si publicar':'No publicar',
                "7"=>$estado,
				
					
 				);
				$i++;
			}
		
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
		
		

		
	case 'negar':
		
		$rspta=$vershopping->negar($id_shopping);
		
		if($rspta==0){
			echo "1";
            
            $datos_estudiante = $vershopping->datos_estudiante($id_credencial);
			$nombre=$datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_apellido"];


            $mensaje="Realizar observaciones";


            $correo=$datos_estudiante["credencial_login"];
			$asunto="Ajustar Emprendimiento";

			enviar_correo($correo,$asunto, $mensaje);

		}else{
			
			echo "0";
		}
 		
	break;

	case 'validar':
		$rspta=$vershopping->validar($id_shopping);
	
		if($rspta==0){
			echo "1";

            $datos_estudiante = $vershopping->datos_estudiante($id_credencial);
			$nombre=$datos_estudiante["credencial_nombre"] . ' ' . $datos_estudiante["credencial_apellido"];


            $mensaje="Estamos emocionados de que seas parte de nuestra Feria de emprendimientos. 
            🌟Este espacio fue creado con mucho cariño, porque nuestro objetivo es 
            hacerte la vida más fácil mientras persigues tus sueños de ser  profesional.
            ¡Es hora de destacar tu emprendimiento y que toda la comunidad lo descubra 
            y disfrute de tus increíbles servicios! 🚀💼 ¡Estamos ansiosos por ver brillar 
            tu talento en este evento único! 🌈💖";


            $correo=$datos_estudiante["credencial_login"];
			$asunto="Emprendimiento validado";

			enviar_correo($correo,$asunto, $mensaje);


		}else{
			echo "0";
		}

	break;

    

	
		
}
?>