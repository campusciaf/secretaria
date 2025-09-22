<?php 
require "../config/Conexion.php";
require ('../public/mail/sendSolicitud.php');
require ('../public/mail/templateSolicitud.php');
session_start();
class Estado
{
    public function consultaEstudiante($cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `credencial_identificacion` = :cedula ");
        $sentencia->bindParam(":cedula", $cedula);
        $sentencia->execute();
        $registro = $sentencia->fetch(PDO::FETCH_ASSOC);


        if ($registro) {
           if ($registro['credencial_condicion'] == "1") {
			   
			   $datos= "
			   <input type='hidden' value='".$registro['id_credencial']."' id='id_cedula' readonly />
			   
			   <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                           <label>Nombre:</label>		
                           <div class='input-group mb-3'>
                              <div class='input-group-prepend'>
                                 <span class='input-group-text'><i class='fas fa-user'></i></span>
                              </div>
                              <input type='text' value='" . $registro['credencial_nombre'] . ' ' . $registro['credencial_nombre_2'] . ' ' . $registro['credencial_apellido'] . ' ' . $registro['credencial_apellido_2'] . "' class='form-control' readonly />
                           </div>
                        </div>
						
				 <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                           <label>Estado:</label>		
                           <div class='input-group mb-3'>
                              <div class='input-group-prepend'>
                                 <span class='input-group-text'><i class='fas fa-check' style='color:green'></i></span>
                              </div>
                             <input type='text' value='Activo' id='estado' class='form-control' readonly />
                           </div>
                        </div>	
						
				<a name='desactivar' value='Desactivar'  class='btn btn-danger' onclick=estadoEst(0)>Desactivar</a>";
                echo $datos;  
			   
			   
            
           } else {
			   
			    $datos= "
			  <input type='hidden' value='".$registro['id_credencial']."' id='id_cedula' readonly />
			   
			   <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                           <label>Nombre:</label>		
                           <div class='input-group mb-3'>
                              <div class='input-group-prepend'>
                                 <span class='input-group-text'><i class='fas fa-user'></i></span>
                              </div>
                              <input type='text' value='" . $registro['credencial_nombre'] . ' ' . $registro['credencial_nombre_2'] . ' ' . $registro['credencial_apellido'] . ' ' . $registro['credencial_apellido_2'] . "' class='form-control' readonly />
                           </div>
                        </div>
						
				 <div class='form-group col-xl-12 col-lg-12 col-md-12 col-12'>
                           <label>Estado:</label>		
                           <div class='input-group mb-3'>
                              <div class='input-group-prepend'>
                                 <span class='input-group-text'><i class='fas fa-times' style='color:red'></i></span>
                              </div>
                             <input type='text' value='inhabilitado' id='estado' class='form-control' readonly />
                           </div>
                        </div>	
						
				<a name='activar' value='Activar'  class='btn btn-success' onclick=estadoEst(1)>Activar</a>";
                echo $datos;

           }
           
        } else {
           echo json_encode($registro);
        }
        
    }

    
    public function consultaCorreo($cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare("SELECT * FROM `credencial_estudiante` WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":id",$cedula);
        if ($sentencia->execute()) {
            $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
            return $registro;
        } else {
            echo "false";
        }
        
        
    }

    public function estadoEst($estado,$cedula)
    {
        global $mbd;
        $sentencia = $mbd->prepare("UPDATE `credencial_estudiante` SET `credencial_condicion`= :estado WHERE `id_credencial` = :id ");
        $sentencia->bindParam(":estado", $estado);
        $sentencia->bindParam(":id", $cedula);
        if ($sentencia->execute()) {
            if ($estado == "1") {
                $asunto = "Estado Usuario";
                $mensaje = "Su usuario ha sido activado";
                $correo = self::consultaCorreo($cedula);                
                $nombre = $correo['credencial_nombre'].' '.$correo['credencial_nombre_2'].' '.$correo['credencial_apellido'].' '.$correo['credencial_apellido_2']; 
                $mensaje2 = set_template($mensaje,$nombre);
				
                if(enviar_correo($correo['credencial_login'],$asunto,$mensaje2)){
                $data['status'] = "ok";
                }else {
                    $data['status'] = $correo['credencial_login'];
                }
				
            } else {
                $asunto = "Estado Usuario";
                $mensaje = "Su usuario ha sido Inhabilitado";
                $correo = self::consultaCorreo($cedula);
               $nombre = $correo['credencial_nombre'].' '.$correo['credencial_nombre_2'].' '.$correo['credencial_apellido'].' '.$correo['credencial_apellido_2'];
                $mensaje2 = set_template($mensaje,$nombre);
                enviar_correo($correo['credencial_login'],$asunto,$mensaje2);
                $data['status'] = "ok";
            }
        } else {
            $data['status'] = "err";
        }
        echo json_encode($data);

    }

    

}


?>