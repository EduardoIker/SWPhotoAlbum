<?php
	session_start();
	
    if(isset($_GET['contrasena'])){		
       		 
		 #Conexion con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
			mysqli_close($link);
		}
						
		 $contrasenaActual=sha1($_GET["contrasenaAct"]);
		 $nuevaContrasena=sha1($_GET["contrasena"]);

		 #Comprobar la contraseña actual	
		$sql="SELECT password FROM USUARIOS WHERE correo='$_SESSION[correo]'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "Se ha producido un error desconocido. Intentalo de nuevo";
			mysqli_close($link);
			exit(1);
		}	
		
		$row=mysqli_fetch_array($result);
		$contrasenaActualBD=$row['password'];
		
		if(strcmp($contrasenaActual,$contrasenaActualBD)!=0){
			echo "La contraseña actual no es correcta";
			mysqli_close($link);
			exit(1);
		}
		 
		#actualizar en la BD la informacion del usuario	
		$sql="UPDATE USUARIOS SET password='$nuevaContrasena' WHERE correo='$_SESSION[correo]'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "Se ha producido un error desconocido. Intentalo de nuevo";
			mysqli_close($link);
			exit(1);
		}						
		echo "Se ha modificado correctamente la contraseña";
		mysqli_close($link);
    } 	   
?>