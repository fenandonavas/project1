<?php 

	/**
	* 
	*/
	include_once 'conexion.php';
		
	
	$resultado = false;
	$server = new conexion();
	$conexion = $server->conectar();
	

	if (isset($_POST["json"])){
		$datos = json_decode($_POST["json"]);

#####################   TEST HONEY ALONSO ###########################################
		if ($datos->{"datos"}[0]->{"operacion"} == "ver") {
			$sql = "SELECT id_usuario, documento, nombre, apellido, email FROM usuario";
			$stmts = $conexion->prepare($sql);

			if($stmts->execute()){
				$json = array();
				$stmts->store_result();

				$stmts->bind_result($id, $documento, $nombre, $apellido, $email);

				while ($stmts->fetch()) {
					$fila = array('id' => $id, 'documento' => $documento, 'nombre' => $nombre, 'apellido' => $apellido, 'email' => $email);
					$json[] = $fila;
				}
				$conexion->close();
				echo json_encode($json);

			}else{
					$conexion->close();
				echo $conexion->error;
			}
		}

		
		if ($datos->{"datos"}[0]->{"operacion"} == "guardar") {
			$documento = $datos->{"datos"}[0]->{"documento"};
			$nombre = $datos->{"datos"}[0]->{"nombre"};
			$apellido = $datos->{"datos"}[0]->{"apellido"};
			$email = $datos->{"datos"}[0]->{"email"};
					
			
			$sql='INSERT INTO usuario(documento, nombre, apellido, email) VALUES("'.$documento.'","'.$nombre.'","'.$apellido.'","'.$email.'")'; 
			$stmts = $conexion->prepare($sql);
			
			if ($stmts->execute()) {

				return $resultado = true;			

	        }else{
		    	return $resultado = false;     	
	        }

		}

		if ($datos->{"datos"}[0]->{"operacion"} == "actualizar") {
			$documento = $datos->{"datos"}[0]->{"documento"};    	
			$nombre = $datos->{"datos"}[0]->{"nombre"};
			$apellido = $datos->{"datos"}[0]->{"apellido"};
			$email = $datos->{"datos"}[0]->{"email"};
			$id = $datos->{"datos"}[0]->{"id"};
			

			//echo $descripcion." ".$estilo." ".$id_item;

			$sql="UPDATE usuario SET documento='".$documento."', nombre='".$nombre."', apellido='".$apellido."', email='".$email."' WHERE id_usuario='".$id."'"; 
			if ($conexion->query($sql)) {
				 $respuesta = true;
	        }else{
		    	 $respuesta = false;     	
	        }

	        echo $respuesta;

		}

		if ($datos->{"datos"}[0]->{"operacion"} == "eliminar") {

			$id = $datos->{"datos"}[0]->{"id"};	

			$sql='DELETE FROM usuario WHERE id_usuario = '.$id.';'; 
			$stmts = $conexion->prepare($sql);
			if ($stmts->execute()) {
				

				return $resultado = true;
					
	            
	        }else{
		    	return $resultado = false;     	
	        }

		}


												



	}



 ?>