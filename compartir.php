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
					
		$correo=$_GET['email']; #correo con quien quiero compartir
		$foto=$_GET['foto']; #id de la foto

                if(strcmp($miCorreo, $correo)== 0){
                    echo"No puedes compartir contigo mismo.";
                    exit(0);
                }
		
		#Consulta de SQL: Comprobar que el correo que nos han pasado existe en la BD.		
		$sql="SELECT * FROM USUARIOS WHERE correo='$correo'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
			mysqli_close($link);
			exit(1);
		}		
		$cont= mysqli_num_rows($result);
		if($cont==0){
			echo"El correo introducido no esta registrado";
			exit(0);
		}
		
		#Consulta de SQL: Comprobar la foto no esta actualmente compartida con dicho usuario		
		$sql="SELECT * FROM COMPARTIDO WHERE id_foto='$foto' AND email_compartido='$correo'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
			mysqli_close($link);
			exit(1);
		}		
		$cont= mysqli_num_rows($result);
		if($cont!=0){
			echo"La foto indicada ya esta compartida con el usuario";
			exit(0);
		}

		#Guardar en la BD que la foto se ha compartido con el correo pasado		
		$sql="INSERT INTO COMPARTIDO VALUES ('$miCorreo','$foto','$correo')";
		if (!($result=mysqli_query($link ,$sql))){
			echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
			mysqli_close($link);
			exit(1);
		}						
		echo "Se ha compartido correctamente con '$correo'";	
     } 	   
?>