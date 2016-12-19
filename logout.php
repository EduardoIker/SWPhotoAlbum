<?php //Cerramos la sesion
	session_start();
	unset($_SESSION['correo']);  
	session_destroy();
	header("location: index.html");
?>