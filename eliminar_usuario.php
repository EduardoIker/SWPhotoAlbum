<?php
	session_start();
	if((!isset($_SESSION['correo'])) || (strcmp($_SESSION['correo'],"admin@swphotoalbum.es"))!=0){
		header('location:login.php');
	}
	
	$correo=$_GET['correo'];
	
	/*********** ELIMINACIONES EN LA BASE DE DATOS **********/
	
	#Conexión con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
	if(!$link){
		echo "1";
		mysqli_close($link);
		exit(1);
	}
	
	$sql="SELECT id FROM ALBUM WHERE correo='$correo'";
	if (!($result=mysqli_query($link ,$sql))){
		echo "1";
		mysqli_close($link);
		exit(1);
	}	
        
	while ($album=mysqli_fetch_array($result)){
		$id_album=$album['id'];
		$sql="SELECT id FROM FOTO WHERE id_album='$id_album'";
		if (!($result1=mysqli_query($link ,$sql))){
			echo "1";
			mysqli_close($link);
			exit(1);
		}	
		while ($foto=mysqli_fetch_array($result1)){
			$id_foto=$foto['id'];
			// Borrar de COMPARTIDO
			$sql="DELETE FROM COMPARTIDO WHERE id_foto='$id_foto'";
			if (!(mysqli_query($link ,$sql))){
				echo "1";
				mysqli_close($link);
				exit(1);
			}	
			// Borrar de ACCION
			$sql="DELETE FROM ACCION WHERE id_foto='$id_foto'";
			if (!(mysqli_query($link ,$sql))){
				echo "1";
				mysqli_close($link);
				exit(1);
			}	
			// Borrar de FOTO
			$sql="DELETE FROM FOTO WHERE id='$id_foto'";
			if (!(mysqli_query($link ,$sql))){
				echo "1";
				mysqli_close($link);
				exit(1);
			}			
		}
		// Borrar el ALBUM
		$sql="DELETE FROM ALBUM WHERE id='$id_album'";
		if (!(mysqli_query($link ,$sql))){
			echo "1";
			mysqli_close($link);
			exit(1);
		}	
	}
	// Borrar de COMPARTIDO donde figure el usuario a eliminar en el atributo 'email_compartido'
	$sql="DELETE FROM COMPARTIDO WHERE email_compartido='$correo'";
	if (!(mysqli_query($link ,$sql))){
		echo "1";
		mysqli_close($link);
		exit(1);
	}
	
	// Borrar el usuario de la tabla USUARIOS
	$sql="DELETE FROM USUARIOS WHERE correo='$correo'";
	if (!(mysqli_query($link ,$sql))){
		echo "1";
		mysqli_close($link);
		exit(1);
	}
	
	/*********** ELIMINACIONES EN EL DIRECTORIO DEL SERVIDOR **********/
	function delete_directory($dirname) {
         if (is_dir($dirname))
           $dir_handle = opendir($dirname);
		 if (!$dir_handle)
			  return false;
		 while($file = readdir($dir_handle)) {
			   if ($file != "." && $file != "..") {
					if (!is_dir($dirname."/".$file))
						 unlink($dirname."/".$file);
					else
						 delete_directory($dirname.'/'.$file);
			   }
		 }
		 closedir($dir_handle);
		 rmdir($dirname);
		 return true;
	}
	
	$path='usuarios/'.$correo;
	if(delete_directory($path)){
		//Enviar correo
		$cabeceras = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$cabeceras .= 'From: SWPhotoAlbum <no-reply@swphotoalbum.com>';
		$msg = "<p>Hola ".$correo.",</p><p>Tu cuenta ha sido eliminada de la aplicación SW Photo Album por el administrador debido a un uso inadecuado de la misma.</p><p>Sentimos las molestias.</p><p>Atentamente,</p><p>El equipo de SWPhotoAlbum</p>";
		$mensaje = '<html>'.
		'<head><title>ELIMINACION DE CUENTA en SW PHOTO ALBUM</title></head>'.
		'<body><img src="http://swphotoalbum.hol.es/Aplicacion/images/cabecera_mail.png" alt="Logo de la aplicacion"/><h1>ELIMINACION DE CUENTA en SW PHOTO ALBUM</h1>'.
		$msg.
		'<hr>'.
		'Este mensaje ha sido generado automáticamente. Las respuestas que se reciban no serán atendidas. 	
		<p>&copy; SWPhotoAlbum</p>'.
		'</body>'.
		'</html>';
		mail($correo,"ELIMINACION DE CUENTA en SW PHOTO ALBUM",$mensaje, $cabeceras);
		//Valor a devolver
		echo "0";
	}else{
		echo "1";
	}
?>