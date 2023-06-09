<?php
class matricula{
	private $id;
	private $placa;
	private $marca;
	private $anio;
	private $color;
	private $avaluo;

	private $fecha;
	private $agencia;
	private $anio1;
	private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}
		


	public function get_form($id){

			$sql = "SELECT * FROM vehiculo WHERE id='$id'";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de matricular el vehiculo con id= ".$id;
                echo $this->_message_error($mensaje);
            }else{   

			$this->placa = $row['placa'];
			$flag = "disabled";
			$op = "matricular";
			}
				
		
		$html = '
		<br>
		<div class="container">
		<form name="matricula" method="POST" action="PrincipalM.php" enctype="multipart/form-data">
		<input class="form-control" type="hidden" name="id" value="' . $id  . '">
		<input class="form-control" type="hidden" name="op" value="' . $op  . '">
			<table class="table table-striped table-dark" border="2" align="center">
				<tr>
					<th colspan="2" class="text-center" ><h2>DATOS MATRICULA</h2></th>
				</tr>
				<tr>
					<td>Placa:</td>
					<td>< class="form-control" input type="text" size="6" name="placa" value="' . $this->placa . '" '. $flag .'></td>
				</tr>
				<tr>
					<td>Fecha:</td>
					<td><input class="form-control" type="date" size="6" name="fecha"  required></td>
				</tr>
				<tr>
					<td>Agencia:</td>
					<td>' . $this->_get_combo_agencia("agencia","id","descripcion","agencia") . '</td>
				</tr>	
				<tr>
					<td>Anio:</td>
					<td>' . $this->_get_combo_anio("anio1",2000, $this->id) . '</td>
				</tr>
				<tr>
					<th class="text-center" colspan="2"><input class="btn btn-outline-info" type="submit" name="Guardar_Matricula" value="GUARDAR" class="btn btn-primary"></th>&nbsp&nbsp&nbsp<a class="link-light" href="index.html">Regresar</a></button></th>
				</tr>										
			</table></div>';
		return $html;
	}
	
	

	public function get_list_m(){
		$html = '
		<div class="container">
		<table class="table table-striped table-dark" border="2" align="center">
			<tr>
				<th colspan="8" class="text-center">Lista de Vehículos</th>
			</tr>
			<tr class="text-center">
				<th>Placa</th>
				<th>Marca</th>
				<th>Color</th>
				<th>Año</th>
				<th>Avalúo</th>
				<th>Accion</th>
			</tr>';
		$sql = "SELECT v.id, v.placa, m.descripcion as marca, c.descripcion as color, v.anio, v.avaluo  FROM vehiculo v, color c, marca m WHERE v.marca=m.id AND v.color=c.id;";	
		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&id=' . $row['id'] . '">Borrar</a></td>
		while($row = $res->fetch_assoc()){
			$d_matri = "matri/" . $row['id'];
			$d_matri_final = base64_encode($d_matri);				
			$html .= '
				<tr class="text-center">
					<td>' . $row['placa'] . '</td>
					<td>' . $row['marca'] . '</td>
					<td>' . $row['color'] . '</td>
					<td>' . $row['anio'] . '</td>
					<td>' . $row['avaluo'] . '</td>
					<td><button type="button" class="btn btn-outline-secondary"><a class="link-light" href="PrincipalM.php?d=' . $d_matri_final . '">Matricular</a></button></td>
					</tr>';
		}
		$html .= '  
		</table></div>';
		
		return $html;
		
	}
	
	public function get_list_m2(){
		$html = '
		<br><div class="container">
		<table class="table table-striped table-dark" border="2" align="center">
			<tr>
				<th colspan="8" class="text-center">Lista de Vehículos Matriculados</th>
			</tr>
			<tr class="text-center">
				<th>Fecha</th>
				<th>Vehiculo</th>
				<th>Agencia</th>
				<th>Año</th>
			</tr>';

		$sql = "SELECT * FROM matricula";
		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&id=' . $row['id'] . '">Borrar</a></td>
		while($row = $res->fetch_assoc()){
			//$d_matri = "matri/" . $row['id'];
			//$d_matri_final = base64_encode($d_matri);	
			$html .= '
				<tr class="text-center">
					<td>' . $row['fecha'] . '</td>
					<td>' . $row['vehiculo'] . '</td>
					<td>' . $row['agencia'] . '</td>
					<td>' . $row['anio'] . '</td>
					</tr>';
		}
		$html .= '  
		</table></div>
		<center>
		<a class="btn btn-outline-warning" href="index.html" role="button">Regresar</a></center>';
		
		return $html;
		
	}

//***************************************************************************************


	private function _get_combo_agencia($tabla,$valor,$valor2,$nombre){
		$html = '<select class="form-control" name="' . $nombre . '">';
		$sql = "SELECT $valor,$valor2 FROM $tabla;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= '<option value="' . $row[$valor] . '">' . $row[$valor2] .'</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}


private function _get_combo_anio($nombre, $anio_inicial) {
    $html = '<select class="form-control" name="' . $nombre . '">';

    // Obtener los años ya utilizados
    $sql = "SELECT DISTINCT anio FROM matricula";
    $result = $this->con->query($sql);
    $anios_usados = array();
    while ($row = $result->fetch_assoc()) {
        $anios_usados[] = $row['anio'];
    }

    $anio_actual = date('Y');
    for ($i = $anio_inicial; $i <= $anio_actual; $i++) {
        // Agregar el elemento de la lista solo si el año no se ha utilizado antes
        if (!in_array($i, $anios_usados)) {
            $html .= '<option value="' . $i . '">' . $i . '</option>' . "\n";
        }
    }

    $html .= '</select>';
    return $html;
}



	public function save_matricula(){
		
		$this->fecha = $_POST['fecha'];
		$this->id = $_POST['id'];
		$this->agencia = $_POST['agencia'];
		$this->anio1 = $_POST['anio1'];

		$sql = "INSERT INTO matricula VALUES(NULL, '$this->fecha', '$this->id', '$this->agencia', '$this->anio2');";

        $validacion = "SELECT * FROM matricula WHERE vehiculo='$this->id' AND anio='$this->anio2' AND agencia='$this->agencia'";

		$res = $this->con->query($validacion);
		$row = $res->fetch_assoc();

		$carro = $row['vehiculo'];
		$anio_matriculado = $row['anio'];
		$agenc = $row['agencia'];
        
        if($carro == $this->id && ($anio_matriculado == $this->anio2 || $agenc == $this->agencia)){
        echo $this->_message_error("No puede matricular dos veces el mismo vehiculo en un mismo anio o una misma agencia.");
        } else {
          if($this->con->query($sql)){
               echo $this->_message_ok("guardó");
           } else {
                echo $this->_message_error("guardar");
            }	
          }
	}	
	
//*************************************************************************	
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a class="btn btn-outline-warning" href="PrincipalM.php">Regresar</a></th>
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
				<th><a class="btn btn-outline-warning" href="PrincipalM.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
//****************************************************************************	
	
} // FIN SCRPIT
?>

