<?php
	session_start();
	if ((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es") == 0)) {
		header("Location: login.php");
		exit();
	}

	#Conexión con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
	if (!$link) {
		echo 'Fallo al concectar a MySQL:' . $link->connect_error;
		mysqli_close($link);
	}

	$foto = $_POST['foto'];

	#Consulta de SQL: Obtener cuantas visitas ha tenido esta foto		
	$sql = "SELECT count(*) as visitas FROM ACCION WHERE id_foto='$foto'";
	if (!($result = mysqli_query($link, $sql))) {
		echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
		mysqli_close($link);
		exit(1);
	}
	$row     = mysqli_fetch_array($result);
	$visitas = $row['visitas'];


	#Consulta de SQL: Obtener cuantas visitas ha tenido esta foto por usuarios registrados		
	$sql = "SELECT count(*) as visitas FROM ACCION WHERE id_foto='$foto' and correo<>'anonimo'";
	if (!($result = mysqli_query($link, $sql))) {
		echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
		mysqli_close($link);
		exit(1);
	}
	$row                = mysqli_fetch_array($result);
	$visitasRegistrados = $row['visitas'];
	$visitasAnonimos    = $visitas - $visitasRegistrados;

	//JSON
	$string = '{
	  "cols": [
			{"id":"","label":"","pattern":"","type":"string"},
			{"id":"","label":"Usuarios","pattern":"","type":"number"}
		  ],
	  "rows": [
			{"c":[{"v":"Usuarios registrados","f":null},{"v":' . $visitasRegistrados . ',"f":null}]},
			{"c":[{"v":"Usuarios anonimos","f":null},{"v":' . $visitasAnonimos . ',"f":null}]}
		  ]
	} ';
	echo $string;
	mysqli_close($link);
?>