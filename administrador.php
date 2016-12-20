<?php
	session_start();
	if((!isset($_SESSION['correo'])) || (strcmp($_SESSION['correo'],"admin@swphotoalbum.es"))!=0){
		header('location:login.php');
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Gestion usuarios</title>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/estilo_administrador.css" />
		<script type="text/javascript" src="js/cambio_estado_usuarios.js" ></script>
	</head>
	<body>
		<!-- Barra navegacion superior-->
		<ul class="top">
		  <li><img src="images/logo.png" alt="Logo de la aplicación SW Photo Album" /></li>
		  <li><a class="logout" href="logout.php">Logout</a></li>
		  <li><a href="administrador.php">Baja/Alta usuarios</a></li>
		  <li><a href="gestion_archivos_administrador.php">Gestion Albumes/Fotos</a></li>
		  <li><p> Te has identificado como: <?=$_SESSION['correo']?></p></li>
		</ul>
		
		
		<!-- Formulario para login-->
		<div class="tabla">
			<div style="display:none" id="dvloader"><img src="images/rolling.gif" /></div>
			<h2>Usuarios</h2>
			<?php
				#Conexión con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
					echo "<script type=\"text/javascript\">alert(\"Error en el proceso(abrir conexion con la BD)\");</script>";
					mysqli_close($link);
					exit(1);
				}
				
				#Consulta de SQL: Obtener todos los usuarios de la BD.
				$usuarios = mysqli_query($link, "SELECT nombre_apellidos, correo, estado FROM USUARIOS WHERE correo <> 'admin@swphotoalbum.es'" );

				#Creamos la tabla <html> donde queremos que se visualicen los usuarios.
				echo '<table border=1 id="tablausuarios"> <tr> <th> NOMBRE </th> <th> CORREO </th>  <th> DAR DE ALTA/BAJA </th> <th> ELIMINAR </th> </tr>';

				#Insertamos los datos de cada usuario (obtenidos tras la consulta) en la tabla creada anteriormente.
				while ($row = mysqli_fetch_array( $usuarios )) {
					$botonDarAlta="<input type=\"button\" id=\"".$row['correo']."\" value=\"Dar de Alta\" onclick=\"cambiarEstado('".$row['correo']."')\"/>";
					$botonDarBaja="<input type=\"button\" id=\"".$row['correo']."\" value=\"Dar de Baja\" onclick=\"cambiarEstado('".$row['correo']."')\"/>";
					$botonDelete="<input type=\"button\" id=\"eliminarUsuario\" value=\"Eliminar Usuario\" onclick=\"eliminarUsuario('".$row['correo']."')\"/>";
					if($row['estado']==0){ 
						echo '<tr><td>' . $row['nombre_apellidos'] . '</td> <td>' . $row['correo'] . '</td> <td>' . $botonDarAlta . '</td> <td>'. $botonDelete .'</td></tr>';
					}else{
						echo '<tr><td>' . $row['nombre_apellidos'] . '</td> <td>' . $row['correo'] . '</td> <td>' . $botonDarBaja .  '</td> <td>'. $botonDelete .'</td></tr>';
					}
				}
				echo '</table>';
				$usuarios->close();
			 
				#Cierre de la conexión con la BD.
				mysqli_close($link);
			?>
		</div>
		
	</body>
</html>
