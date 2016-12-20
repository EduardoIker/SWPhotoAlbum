<?php
	#Conexión con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
	if (!$link) {
		echo 'Fallo al concectar a MySQL:' . $link->connect_error;
		mysqli_close($link);
	}

	$foto = $_GET['foto'];

	#Consulta de SQL: Obtener todos los usuarios con quien se ha compartido la foto		
	$sql = "select email_compartido from COMPARTIDO where id_foto='$foto'";

	if (!($result = mysqli_query($link, $sql))) {
		echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
		mysqli_close($link);
		exit(1);
	}

	$cont = mysqli_num_rows($result);

	if ($cont == 0) { # En caso de que no se haya compartido con nadie la foto
		echo "Aun no lo has compartido con nadie.";
	} else {
		#Creamos la tabla <html> donde queremos que se visualicen los usuarios compartidos.
		echo '<table border=1>';
		echo '<tr><th>Correo</th></tr>';
		$columna = 0;
		#Insertamos los correos (obtenidos tras la consulta) en la tabla creada anteriormente.
		while ($row = mysqli_fetch_array($result)) {
			if ($columna == 0) {
				echo "<tr>";
			}
			echo "<tr><td>$row[email_compartido]</td></tr>";
		}
		echo '</table>';
	}

	$result->close();

	#Cierre de la conexión con la BD.
	mysqli_close($link);
?>