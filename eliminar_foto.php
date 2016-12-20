<?php		    
	#Conexion con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
	if(!$link){
		echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
		mysqli_close($link);
	}
	include('funcion_eliminar_foto.php');
	$foto=$_GET['foto'];   
	eliminar_foto($foto,$link);		
	echo "0"; //Enviamos un 0 que indica que la eliminacion se ha llevado a cabo con exito
?>          

