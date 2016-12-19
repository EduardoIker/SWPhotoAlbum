 <?php
    if(isset($_GET['email'])){		
         session_start();
		 if((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es")==0)){
			header("Location: login.php");
			exit();
		 }  
         $miCorreo=$_SESSION["correo"];		
		 #Conexion con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
			mysqli_close($link);
		}
					
		$correo=$_GET['email']; #correo con quien quiero dejar de compartir
		$foto=$_GET['foto']; #id de la foto
		
		#Consulta de SQL: Comprobar que el correo que nos han pasado tiene acceso a la foto.		
		$sql="SELECT * FROM COMPARTIDO WHERE email_compartido='$correo' and id_foto='$foto'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "Se ha producido un error desconocido. Intentalo de nuevo.";
			mysqli_close($link);
			exit(1);
		}		
		$cont= mysqli_num_rows($result);
		if($cont==0){
			echo"El usuario introducido no tiene acceso a la foto. Introduzca otro usuario.";
			exit(0);
		}

		#La foto ha dejado de estar compartido con el correo pasado		
		$sql="DELETE FROM COMPARTIDO where id_foto='$foto' and email_compartido='$correo'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
			mysqli_close($link);
			exit(1);
		}						
		echo "Se ha retirado el acceso al usuario '$correo'";	
     } 	   
?>