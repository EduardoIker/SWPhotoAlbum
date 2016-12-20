<?php
	#Conexion con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
	if (!$link) {
		echo 'Fallo al concectar a MySQL:' . $link->connect_error;
		mysqli_close($link);
	}
	include('funcion_eliminar_foto.php');
	$album = $_GET['album'];

	$sql = "Select id from FOTO WHERE id_album='$album'";
	if (!($result = mysqli_query($link, $sql))) {
		echo "1"; //Enviamos un 1 que indica que ha habido algun problema a la hora de eliminar el album
		mysqli_close($link);
		exit(1);
	}

	while ($row = mysqli_fetch_array($result)) {
		$foto = $row['id'];
		eliminar_foto($foto, $link);
	}

	$sql = "Select nombre,correo from ALBUM WHERE id='$album'";
	if (!($result = mysqli_query($link, $sql))) {
		echo "1";
		mysqli_close($link);
		exit(1);
	}
	$row    = mysqli_fetch_array($result);
	$nombre = $row['nombre'];
	$correo = $row['correo'];
	$path   = "usuarios/" . $correo . "/" . $nombre;
	if (!rmdir($path)) {
		echo "1";
		exit(1);
	}
	$sql = "delete from ALBUM WHERE id='$album'";
	if (!($result = mysqli_query($link, $sql))) {
		echo "1";
		mysqli_close($link);
		exit(1);
	}
	echo "0"; //Enviamos un 0 que indica que la eliminacion se ha llevado a cabo con exito
?>          	