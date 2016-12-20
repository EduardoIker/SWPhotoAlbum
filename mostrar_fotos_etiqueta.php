<?php 
		#Conexion con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
			mysqli_close($link);
		}
		
        $Etiqueta=$_GET['etiqueta'];
		#Consulta de SQL: Obtener el path de las fotos publicas de la BD.		
		$sql="SELECT path,id FROM FOTO WHERE visibilidad='publica' and etiquetas like '%$Etiqueta%'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
			mysqli_close($link);
			exit(1);
		}
		
		$cont= mysqli_num_rows($result);
		
		if($cont==0){ # En caso de que no haya fotos publicas con esa etiqueta
				echo "No hay fotos disponibles con esa etiqueta.";
		} else{
				#Creamos la tabla <html> donde queremos que se visualicen las fotos.
				echo '<table>';
				$columna=0;
				#Insertamos las fotos (obtenidos tras la consulta) en la tabla creada anteriormente.
				while ($row = mysqli_fetch_array( $result )) {
						if($columna==0){
						   echo "<tr>";
						}
						echo "<td><img src=\"$row[path]\"  width=\"200px\" height=\"200\" 
						 onclick=\"verFoto('$row[id]')\"></td>";
						$columna=$columna+1;
						if($columna==3){
							echo "</tr>";
							$columna=0;
						}
				}
				echo '</table>';
		}
			
		$result->close();
		#Cierre de la conexiÃƒÂ³n con la BD.
		mysqli_close($link); 	   
?>