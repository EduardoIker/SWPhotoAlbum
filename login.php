<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Login</title>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/estilo_login.css" />
		<script type="text/javascript" src="js/validaciones_login.js" ></script>
	</head>
	<body>
		<!-- Barra navegacion superior-->
		<ul class="top">
		  <li><img src="images/logo.png" alt="Logo de la aplicación SW Photo Album" /></li>
		  <li><a href="registro.html">Registrarse</a></li>
		  <li><a href="index.html">Inicio</a></li>
		</ul>
		
		
		<!-- Formulario para login-->
		<form method="post" action="login.php" onsubmit="return validarCamposLogin();" >
			<div>
				<h1> Login </h1>
				<span>Correo electrónico: </span>
				<input type="text" name="correo" id="correo" />
				<br/>
				<span>Contraseña: </span>
				<input type="password" name="password" id="password" />
				<br/>
				<input type="submit" name="submit" id="submit" value="Entrar" />
			</div>
		</form>
		
	</body>
</html>

<?php
	if(isset($_POST['correo'])){
		#Conexión con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo "<script type=\"text/javascript\">alert(\"Error en el proceso de login(abrir conexion con la BD)\");</script>";
			mysqli_close($link);
			exit(1);
		}
		
		# VALIDACIONES DE LOS DATOS 

	
		#Correo
		if(strcmp($_POST['correo'],"")==0){
			echo "<script>alert('Completa el campo Email')</script>";
			exit(1);
		}
		
		#Password
		if(strcmp($_POST['password'],"")==0){
			echo "<script>alert('Completa el campo Password')</script>";
			exit(1);
		}
		
		$correo=$_POST['correo'];
		$password=$_POST['password'];
		$passwordCifrado=sha1($password);
	
		$sql="SELECT * FROM USUARIOS where correo='$correo' and password='$passwordCifrado'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
			mysqli_close($link);
			exit(1);
		}
		$cont= mysqli_num_rows($result);
		
		if($cont==1){
			$columna= mysqli_fetch_array($result);
			$estado=$columna['estado'];
			if($estado==1){
				session_start();
				$_SESSION["correo"]=$correo;
				if(strcmp($correo,"admin@swphotoalbum.es")==0){
					header('location:administrador.php');
				}else{
					header('location:usuario.php');
				}
			}else{
				echo "<script>alert('La cuenta no se encuentra activa. Puedes ponerte en contacto con el administrador a través del formulario de contacto de la página inicial')</script>";
				mysqli_close($link);
				exit(1);
			}
		}else{
            echo "<script>alert('Datos de acceso incorrectos. Intentalo de nuevo')</script>";
			mysqli_close($link);
			exit(1); 
		}
	}
?>