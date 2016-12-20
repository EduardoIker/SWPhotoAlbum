<?php
    if(isset($_GET['id'])){		
		 #Conexion con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
			mysqli_close($link);
		}
					
		$id=$_GET["id"];		
		$nombre=$_GET["nombre"];
		$etiquetas=$_GET["etiquetas"];
		$visibilidad=$_GET["visibilidad"];

		#Actualizar en la BD la foto		
		$sql="UPDATE FOTO SET nombre='$nombre', etiquetas='$etiquetas',visibilidad='$visibilidad' WHERE id='$id'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "Se ha producido un error desconocido. Intentalo de nuevo";
			mysqli_close($link);
			exit(1);
		}						
		echo "Se ha modificado correctamente la foto.";	
    } 	   
?>