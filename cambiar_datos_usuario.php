<?php
	session_start();
	
    if(isset($_GET['nombre'])){		
       		 
		 #Conexion con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
			mysqli_close($link);
		}
						
		 $nombre=$_GET["nombre"];
		 $telefono=$_GET["telefono"];

		#actualizar en la BD la informacion del usuario	
		$sql="UPDATE USUARIOS SET nombre_apellidos='$nombre', telefono='$telefono' WHERE correo='$_SESSION[correo]'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "Se ha producido un error desconocido. Intentalo de nuevo";
			mysqli_close($link);
			exit(1);
		}						
		echo "Se ha modificado correctamente el usuario.";	
    } 	   
?>