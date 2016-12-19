<?php
	function subir_foto($directorio_destino, $nombre_fichero){
		$tmp_name = $_FILES[$nombre_fichero]['tmp_name'];  
		if (is_dir($directorio_destino) && is_uploaded_file($tmp_name)){
			$img_file = $_FILES[$nombre_fichero]['name'];
			$img_type = $_FILES[$nombre_fichero]['type'];
			 
			if (((strpos($img_type, "gif") || strpos($img_type, "jpeg") || strpos($img_type, "jpg")) || strpos($img_type, "png"))){
				if (move_uploaded_file($tmp_name, $directorio_destino . '/' . $img_file)){
					return true;
				}
			}
		}
			//En caso de error
			return false;	
	}
	
	function crear_directorio($ruta){
		if(!mkdir($ruta, 0777)) {
			return false;
		}
		return true;
	}

	#Nombre y apellidos
	if(!filter_var($_POST["nombreyapellidos"], FILTER_VALIDATE_REGEXP,array("options" => array("regexp"=>"/^[A-z]+([ ][A-z]+)+$/")))){
		echo "<script type=\"text/javascript\">alert(\"Formato de nombre y apellidos incorrecto\");</script>";
		exit(1);
	}
	
	#Correo
    if(!filter_var($_POST["correo"], FILTER_VALIDATE_REGEXP,array("options" => array("regexp"=>"/^[0-z]+@[0-z]+\.[a-z]+$/")))){
		echo "<script type=\"text/javascript\">alert(\"Formato de correo incorrecto\");</script>";
		exit(1);
	}
	
	#Password
	if(!filter_var($_POST["password"], FILTER_VALIDATE_REGEXP,array("options" => array("regexp"=>"/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,8}$/")))){
		echo "<script type=\"text/javascript\">alert(\"Formato de contraseña incorrecto. La contraseña debe tener al menos 1 minuscula, 1 mayuscula, 1 digito y entre 6-8 caracteres\");</script>";
		exit(1);
	}
	
	#Comprobar que las contraseñas sean iguales
	if (strcmp($_POST["password"],$_POST["rpassword"]) != 0) {
		echo "<script type=\"text/javascript\">alert(\"Las contraseñas introducidas no son iguales. Intentalo de nuevo.\");</script>";
		exit(1);
	}
	
	#Numero de teléfono
	if(!filter_var($_POST["numtelefono"], FILTER_VALIDATE_REGEXP,array("options" => array("regexp"=>"/^[9|8|7|6]\d{8,8}$/")))){
		echo "<script type=\"text/javascript\">alert(\"Formato de numero de telefono incorrecto\");</script>";
		exit(1);
	}
	
	
	#Conexión con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
	if(!$link){
		echo "<script type=\"text/javascript\">alert(\"Error en el proceso de registro(abrir conexion con la BD)\");</script>";
		mysqli_close($link);
		exit(1);
	}

    #Cifrar la contraseña
    $passCifrado=sha1($_POST['password']);
	
                $ruta="usuarios/".$_POST["correo"];
		if(!(crear_directorio($ruta))){
			echo "<script type=\"text/javascript\">alert(\"Error en el proceso de registro\");</script>";
			mysqli_close($link);
			exit(1);
		}
    #Comprobamos que se ha subido un archivo
	if (is_uploaded_file($_FILES["fotoperfil"]["tmp_name"])){ 
		$nombrefoto=$_FILES["fotoperfil"]["name"];
		$rutafotoperfil=$ruta."/" . $nombrefoto;
		#Guardamos la foto en el servidor
		if (!subir_foto($ruta,'fotoperfil')){
			echo "<script type=\"text/javascript\">alert(\"Error en el proceso de registro (guardar foto)\");</script>";
			mysqli_close($link);
			exit(1);
		}
	}else{
		$rutafotoperfil="";
	}
	
	#Guardamos los valores en la BD 
	$sql="INSERT INTO USUARIOS VALUES ('$_POST[nombreyapellidos]','$_POST[correo]','$passCifrado','$_POST[numtelefono]','$rutafotoperfil',0)";
	if (!mysqli_query($link ,$sql)){
		echo "<script type=\"text/javascript\">alert(\"Error en el proceso de registro\");</script>";
		mysqli_close($link);
		exit(1);
	}
	
	# Mandamos el correo de bienvenida
	$msg = '<p>Tu proceso de registro se ha completado correctamente. No obstante, antes de poder acceder a la aplicación el administrador deberá darte de alta en la misma. Este procedimiento se realizará tan pronto como sea posible, y se te notificará mediante un nuevo mensaje de correo.<p/>'.'</br>'.'<p>Muchas gracias por registrarte en nuestra aplicación, esperamos que te sea de utilidad.</p>'.'</br>'.'<p>El equipo de SWPhotoAlbum.</p>';
	$mensaje = '<html>'.
	'<head><title>Bienvenido a SW PHOTO ALBUM</title></head>'.
	'<body><img src="http://swphotoalbum.hol.es/Aplicacion/images/cabecera_mail.png" alt="Logo de la aplicacion"/><h1>Bienvenido a SW PHOTO ALBUM '.$_POST["nombreyapellidos"].'!</h1>'.
	$msg.
	'<hr>'.
	'Este mensaje ha sido generado automáticamente. Las respuestas que se reciban no serán atendidas. 	
	<p>&copy; SWPhotoAlbum</p>'.
	'</body>'.
	'</html>';
	$cabeceras = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$cabeceras .= 'From: SWPhotoAlbum <no-reply@swphotoalbum.com>';
	mail($_POST["correo"],"Bienvenido a SW PHOTO ALBUM",$mensaje, $cabeceras);
	
	#Si todo ha ido bien
	echo "<script type=\"text/javascript\">alert(\"Registro realizado correctamente\"); window.location = 'login.php';</script>";
	mysqli_close($link);
?>