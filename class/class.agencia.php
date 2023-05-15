<?php
class agencia{
	
	
	private $id;
	private $descripcion;
	private $direccion;
	private $telefono;
	private $horainicio;
	private $horafin;
	private $foto;
	private $con;
	
	function __construct($cn){
		$this->con = $cn;
	    //echo "EJECUTANDOSE EL CONSTRUCTOR VEHICULO<br><br>";
	}
	

	public function get_form($id=NULL){
		// Código agregado -- //
	if(($id == NULL) || ($id == 0) ) {
			$this->descripcion = NULL;
			$this->direccion = NULL;
			$this->telefono = NULL;
			$this->horainicio = NULL;
			$this->horafin = NULL;
			$this->foto = NULL;
			
			$flag = NULL;
			$op = "new";
			$bandera = 1;
	}else{
			$sql = "SELECT * FROM agencia WHERE id=$id;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
            $num = $res->num_rows;
            $bandera = ($num==0) ? 0 : 1;
            
            if(!($bandera)){
                $mensaje = "tratar de actualizar la agencia con id= ".$id . "<br>";
                echo $this->_message_error($mensaje);
				
            }else{                
                
				
			
		
             // ATRIBUTOS DE LA CLASE VEHICULO   
                $this->descripcion = $row['descripcion'];
                $this->direccion = $row['direccion'];
                $this->telefono = $row['telefono'];
                $this->horainicio = $row['horainicio'];
                $this->horafin = $row['horafin'];
                //$this->anio = $row['anio'];
                //$this->color = $row['color'];
                $this->foto = $row['foto'];
                //$this->avaluo = $row['avaluo'];
				
                //$flag = "disabled";
				$flag = "enabled";
                $op = "act"; 
            }
	}
        
	if($bandera){
    
		$telefono = ["6054874",
						 "6048754",
						 "3091589",
						"3097686",
						"2658749"
						 ];
		$html = '
		<form name="Form_agencia" method="POST" action="PrincipalA.php" enctype="multipart/form-data">
		<input class="form-control" type="hidden" name="id" value="' . $id  . '">
		<input class="form-control" type="hidden" name="op" value="' . $op  . '">
			<table class="table table-striped table-dark" border="2" align="center">
				<tr>
					<th colspan="2">DATOS AGENCIA</th>
				</tr>
				<tr>
					<td>descripcion:</td>
					<td><input class="form-control" type="text" size="15" name="descripcion" value="' . $this->descripcion . '"></td>
				</tr>
				<tr>
					<td>direccion:</td>
					<td><input class="form-control" type="text" size="15" name="direccion" value="' . $this->direccion . '"></td>
				</tr>
				
				<tr>
					<td>telefono:</td>
					<td><input class="form-control" type="text" size="15" name="telefono" value="' . $this->telefono . '"></td>
				</tr>
				<tr>
					<td>horainicio:</td>
					<td><input class="form-control" type="time" name="horainicio" value="' . $this->horainicio . '"></td>
				</tr>
				<tr>
					<td>horafin:</td>
					<td><input class="form-control" type="time" name="horafin" value="' . $this->horafin . '"></td>
				</tr>
				<tr>
					<td>Foto:</td>
					<td><input class="form-control" type="file" name="foto" ' . $flag . '></td>
				</tr>
				
				<tr>
					<th colspan="2"><input class="btn btn-outline-info" type="submit" name="Guardar" value="Guardar">&nbsp&nbsp&nbsp<a class="btn btn-outline-warning" href="PrincipalA.php" role="button">Regresar</a></tr>											
			</table>';
		return $html;
		}
	}
	
	
	
	public function get_list(){
		$d_new = "new/0";                           //Línea agregada
        $d_new_final = base64_encode($d_new);       //Línea agregada
        $d_ind = "ind/0";
        $d_new_index = base64_encode($d_ind);
				
		$html = ' 
		<table class="table table-striped table-dark" border="2" align="center">
			<tr>
				<th colspan="8">Lista de Agencias</th>
			</tr>
			<tr>
				<th colspan="8"><a class="btn btn-outline-success"href="PrincipalA.php?d=' . $d_new_final . '">Nuevo</a></th>
			</tr>
			<tr>
				<th>descripcion</th>
				<th>direccion</th>
				<th>telefono</th>
				<th>horainicio</th>
				<th>horafin</th>
				<th colspan="3">Acciones</th>
			</tr>
			';

		$sql = "SELECT a.id, a.descripcion, a.direccion, a.telefono, a.horainicio, a.horafin
				FROM agencia a;";
		$res = $this->con->query($sql);
		
		
		
		// VERIFICA si existe TUPLAS EN EJECUCION DEL Query
		$num = $res->num_rows;
        if($num != 0){
		
		    while($row = $res->fetch_assoc()){

		    		
				// URL PARA BORRAR
				$d_del = "del/" . $row['id'];
				$d_del_final = base64_encode($d_del);
				
				// URL PARA ACTUALIZAR
				$d_act = "act/" . $row['id'];
				$d_act_final = base64_encode($d_act);
				
				// URL PARA EL DETALLE
				$d_det = "det/" . $row['id'];
				$d_det_final = base64_encode($d_det);	
				
				$html .= '
					<tr>
						<td>' . $row['descripcion'] . '</td>
						<td>' . $row['direccion'] . '</td>
						<td>' . $row['telefono'] . '</td>
						<td>' . $row['horainicio'] . '</td>
						<td>' . $row['horafin'] . '</td>
						<td><a class="btn btn-outline-secondary" role="button" href="PrincipalA.php?d=' . $d_del_final . '">Borrar</a></td>
						<td><a class="btn btn-outline-secondary" role="button" href="PrincipalA.php?d=' . $d_act_final . '">Actualizar</a></td>
						<td><a class="btn btn-outline-secondary" role="button" href="PrincipalA.php?d=' . $d_det_final . '">Detalle</a></td>
					</tr>
					';
			 
		    }
		}else{
			$mensaje = "Tabla Agencias" . "<br>";
            echo $this->_message_BD_Vacia($mensaje);
			echo "<br><br><br>";
		}
		$html .= '<tr><th colspan="8"><a class="btn btn-outline-warning" href="index.html" role="button">Regresar</a></th></tr></table>';
		return $html;
		
	}
	
	
//********************************************************************************************************
	/*
	 $tabla es la tabla de la base de datos
	 $valor es el nombre del campo que utilizaremos como valor del option
	 $etiqueta es nombre del campo que utilizaremos como etiqueta del option
	 $nombre es el nombre del campo tipo combo box (select)
	 * $defecto es el valor para que cargue el combo por defecto
	 */ 
	 
	 // _get_combo_db("marca","id","descripcion","marca",$this->marca)
	 // _get_combo_db("color","id","descripcion","color", $this->color)
	 
	 /*Aquí se agregó el parámetro:  $defecto*/
	private function _get_combo_db($tabla,$valor,$etiqueta,$nombre,$defecto=NULL){
		$html = '<select class="form-control" name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		//$num = $res->num_rows;
		
			
		while($row = $res->fetch_assoc()){

			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}
	

	private function _get_radio($arreglo,$nombre,$defecto=NULL){
		$html = '
		<table border=0 align="left">';
		foreach($arreglo as $etiqueta){
			$html .= '
			<tr>
				<td>' . $etiqueta . '</td>
				<td>';
				$html .= ($defecto == $etiqueta)? '<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '" checked/></td>':'<input type="radio" value="' . $etiqueta . '" name="' . $nombre . '"/></td>';
			
			$html .= '</tr>';
		}
		$html .= '</table>';
		return $html;
	}
	
	
//****************************************** NUEVO CODIGO *****************************************

public function get_detail_agencia($id){

		$sql = "SELECT a.id, a.descripcion, a.direccion, a.telefono, a.horainicio, a.horafin, a.foto
				FROM agencia a
				WHERE a.id=$id;";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();
		
		// VERIFICA SI EXISTE id
		$num = $res->num_rows;
        
	if($num == 0){
        $mensaje = "desplegar el detalle de la agencia con id= ".$id . "<br>";
        echo $this->_message_error($mensaje);
				
    }else{ 
		$html = '
		<table class="table table-striped table-dark" border="2">
			<tr>
				<th colspan="2">DATOS DE LA AGENCIA</th>
			</tr>
			<tr>
				<td>descripcion: </td>
				<td>'. $row['descripcion'] .'</td>
			</tr>
			<tr>
				<td>direccion: </td>
				<td>'. $row['direccion'] .'</td>
			</tr>
			<tr>
				<td>telefono: </td>
				<td>'. $row['telefono'] .'</td>
			</tr>
			<tr>
				<td>horainicio: </td>
				<td>'. $row['horainicio'] .'</td>
			</tr>
			<tr>
				<td>horafin: </td>
				<td>'. $row['horafin'] .'</td>
			</tr>			
			<tr>
				<th colspan="2"><img src="images/' . $row['foto'] . '" width="300px"/></th>
			</tr>	
			<tr>
				<th colspan="2"><a class="btn btn-outline-warning" href="PrincipalA.php" role="button">Regresar</a></th>
			</tr>																						
		</table>';
		
		return $html;
	}	
	
}


	public function delete_agencia($id){
		
		/*$mensaje = "PROXIMAMENTE SE ELIMINARA el vehiculo con id= ".$id . "<br>";
        echo $this->_message_error($mensaje);*/
		
	   
		$sql = "DELETE FROM agencia WHERE id=$id;";
		if($this->con->query($sql)){
			echo $this->_message_ok("eliminó");
		}else{
			echo $this->_message_error("eliminar<br>");
		}
	
	}

	public function update_agencia(){
		
	
			
			$id = $_POST['id'];
		
				
		// ATRIBUTOS DE LA CLASE VEHICULO   
				//$this->id = $id;
                $this->descripcion = $_POST['descripcion'];
                $this->direccion = $_POST['direccion'];
                $this->telefono = $_POST['telefono'];
                $this->horainicio = $_POST['horainicio'];
        		$this->horafin = $_POST['horafin'];
               
			
			$sql = "UPDATE agencia SET  descripcion='$this->descripcion', direccion='$this->direccion', telefono = '$this->telefono', horainicio = '$this->horainicio', horafin = '$this->horafin' WHERE id=$id;";
		

		if($this->con->query($sql)){
			echo $this->_message_ok("actualizo");
		}else{
			echo $this->_message_error("actualizar<br>");
		}
		
	}

	private function _get_name_file($nombre_original, $tamanio){
			$tmp = explode(".",$nombre_original);
			$numElm = count($tmp);
			$ext = $tmp[$numElm-1];
			$cadena = "";
					for($i=1;$i<=$tamanio;$i++){
						$c = rand(65, 122);
						if(($c >= 91) && ($c <=96)){
							$c = NULL;
								$i--;
						}else{
							$cadena .= chr($c);
						}
					}
	return $cadena . "." . $ext;
}

	public function save_agencia(){

		
		// ATRIBUTOS DE LA CLASE VEHICULO   
				//$this->id = $id;
                 $this->descripcion = $_POST['descripcion'];
                $this->direccion = $_POST['direccion'];
                $this->telefono = $_POST['telefono'];
                $this->horainicio = $_POST['horainicio'];
                $this->horafin = $_POST['horafin'];
                
                
                //$this->foto = $_POST['foto'];
                

        /* echo "<br> FILES <br>";
         echo "<pre>";
              print_r($_FILES);
         echo "<pre>";*/

         $this->foto=$this->_get_name_file($_FILES['foto']['name'],12);
         $path = "images/" . $this->foto;

         if(!move_uploaded_file($_FILES['foto']['tmp_name'], $path)){
         	$mensaje="Cargar la imagen";
         	echo $this->_message_error($mensaje);
         }
				
				
		$sql = "INSERT INTO agencia VALUES (NULL, '$this->descripcion',
									'$this->direccion',
									'$this->telefono', 
									'$this->horainicio',
									'$this->horafin',
									'$this->foto'
									);";
		echo $sql;
		
		if($this->con->query($sql)){
			echo $this->_message_ok("guardo");
		}else{
			echo $this->_message_error("guardar<br>");
		}
		
	}

	
//***************************************************************************************	
	
	private function _calculo_matricula($avaluo){
		return number_format(($avaluo * 0.10),2);
	}
	
//***************************************************************************************************************************
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . 'Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a class="btn btn-outline-warning" role="button" href="PrincipalA.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
	
	private function _message_BD_Vacia($tipo){
	   $html = '
		<table border="0" align="center">
			<tr>
				<th> NO existen registros en la ' . $tipo . 'Favor contactar a .................... </th>
			</tr>
	
		</table>';
		return $html;
	
	
	}
	
	private function _message_ok($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a class="btn btn-outline-warning" role="button"  href="PrincipalA.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
//************************************************************************************************************************************************

 
}
?>

