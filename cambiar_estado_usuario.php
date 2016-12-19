<?php
	session_start();
	if((!isset($_SESSION['correo'])) || (strcmp($_SESSION['correo'],"admin@swphotoalbum.es"))!=0){
		header('location:login.php');
	}

	$correo=$_GET['correo'];
	#Conexión con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
	if(!$link){
		echo "0";
		mysqli_close($link);
		exit(1);
	}
	#Consulta de SQL: Obtener todos los usuarios de la BD.
	$usuario = mysqli_query($link, "SELECT estado FROM USUARIOS WHERE correo='$correo'");
	if($usuario === FALSE){
		echo "0";
		mysqli_close($link);
		exit(1);
	}
	$row = mysqli_fetch_array($usuario);
	$elEstado=$row['estado'];
	if($elEstado==0){
		$nuevoEstado=1;
	}else{
		$nuevoEstado=0;
	}
	$usuario = mysqli_query($link, "UPDATE USUARIOS SET estado='$nuevoEstado' WHERE correo='$correo'");
	if($usuario === FALSE){
		echo "0";
		mysqli_close($link);
		exit(1);
	}

	
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$cabeceras .= 'From: SWPhotoAlbum <no-reply@swphotoalbum.com>';

    if($nuevoEstado==1){
		$msg = "<p>Hola ". $correo.",</p><p>Tu cuenta ha sido dada de alta en la aplicación SW Photo Album por el administrador. Esperamos que la disfrutes!</p><p>Atentamente,</p><p>El equipo de SWPhotoAlbum</p>";
		$mensaje = '<html>'.
		'<head><title>ALTA en SW PHOTO ALBUM</title></head>'.
		'<body><img src="http://swphotoalbum.hol.es/Aplicacion/images/cabecera_mail.png" alt="Logo de la aplicacion"/><h1>ALTA en SW PHOTO ALBUM</h1>'.
		$msg.
		'<hr>'.
		'Este mensaje ha sido generado automáticamente. Las respuestas que se reciban no serán atendidas. 	
		<p>&copy; SWPhotoAlbum</p>'.
		'</body>'.
		'</html>';
		mail($correo,"ALTA en SW PHOTO ALBUM",$mensaje, $cabeceras);
	}else if($nuevoEstado==0){
		$msg = "<p>Hola ".$correo.",</p><p>Tu cuenta ha sido dada de baja en la aplicación SW Photo Album por el administrador debido a un uso inadecuado de la misma.</p><p>Si estas interesado en recuperar el acceso a tu cuenta, ponte en contacto con nosotros a través del formulario de la seccion 'Contacto' de la página principal.</p><p>Atentamente,</p><p>El equipo de SWPhotoAlbum</p>";
		$mensaje = '<html>'.
		'<head><title>BAJA en SW PHOTO ALBUM</title></head>'.
		'<body><img src="http://swphotoalbum.hol.es/Aplicacion/images/cabecera_mail.png" alt="Logo de la aplicacion"/><h1>BAJA en SW PHOTO ALBUM</h1>'.
		$msg.
		'<hr>'.
		'Este mensaje ha sido generado automáticamente. Las respuestas que se reciban no serán atendidas. 	
		<p>&copy; SWPhotoAlbum</p>'.
		'</body>'.
		'</html>';
		mail($correo,"BAJA en SW PHOTO ALBUM",$mensaje, $cabeceras);
	}

	#Cierre de la conexión con la BD.
	mysqli_close($link);
	echo "1";
?>