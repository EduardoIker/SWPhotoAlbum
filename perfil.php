<?php
	session_start();
	if((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es")==0)){
		 header("Location: login.php");
		 exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		<title>Albumes</title>
		<link rel="stylesheet" type="text/css" href="css/estilo_perfil.css"/>
		<script type="text/javascript" src="js/perfil.js"></script>
	</head>
	<body> 
	    <!-- Barra navegacion superior-->
		<ul class="top">
			<li><img src="images/logo.png" alt="Logo de la aplicación SW Photo Album" /></li>
			<li><a class="logout" href="logout.php">Logout</a></li>
			<li><a href="usuario.php">Ver albumes</a></li>
			<li><a href="fotos_compartidas.php">Ver fotos compartidas</a></li>
			<li><a href="perfil.php">Mi perfil</a></li>
			<li><p> Te has identificado como: <?=$_SESSION['correo']?></p></li>
		</ul>
		
        <div id="perfil">
	        <h1>Mi Perfil</h1>
		    <?php
				 #Conexión con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
				echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
					mysqli_close($link);
				}
				
				$correo=$_SESSION["correo"];
	
				$sql="SELECT nombre_apellidos, telefono, ruta_img_perfil FROM USUARIOS WHERE correo='$correo'";
				
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				$row=mysqli_fetch_array($result);
				$nombre_apellidos=$row['nombre_apellidos'];
				$telefono=$row['telefono'];
				$imagen=$row['ruta_img_perfil'];
				
				if(strcmp($imagen,"")==0){
					$imagen="images/avatar.png";
				}
				
				echo "<img src=\"$imagen\" /> </br>";
				
				echo "Correo: <span id=\"correo\">$correo</span><br/>";
				echo "<div id=\"divInfo\">
                                         Nombre y Apellidos: <span id=\"nombre_apellidos\">$nombre_apellidos</span><br/>
                                         Telefono: <span id=\"telefono\">$telefono</span>
                    </br>  </div>";
				
				
				$result->close();
					   	   
		    ?>
			<input type="button" name="botonMostrarModificarDatos" id="botonMostrarModificarDatos" value="Modificar datos" onclick="mostrarModificarDatos()"/>
			<input type="button" name="botonMostrarModificarContrasena" id="botonMostrarModificarContrasena" value="Modificar Contraseña" onclick="mostrarModificarContrasena()"/>
			<form id="cambioDatosForm" style="display:none">
				Nombre y Apellidos: <input type="text" name="nuevoNombre" id="nuevoNombre"/> <br/>
				Telefono: <input type="text" name="nuevoTlf" id="nuevoTlf"/> <br/>
				<input type="button" name="botonModificarDatos" id="botonModificarDatos" value="Modificar datos" onclick="modificarDatos()"/>
			</form>
			<form id="cambioContraForm" style="display:none">
				Contraseña Actual : <input type="password" name="passActual" id="passActual"/> <br/>
				Nueva Contraseña: <input type="password" name="passNuevo" id="passNuevo"/> <br/>
				Repetir Nueva Contraseña: <input type="password" name="rPassNuevo" id="rPassNuevo"/> <br/>
				<input type="button" name="botonModificarContrasena" id="botonModificarContrasena" value="Modificar Contraseña" onclick="modificarContrasena()"/>
			</form>
			</br>
			<h3>Información sobre los albumes:</h3>
			<table border="1">
			<tr><th>Album</th><th>Numero de fotos</th></tr>
			<?php
				#Consulta de SQL: Obtener todos los albumes del usuario de la BD		
				$sql="SELECT id, nombre FROM ALBUM WHERE correo='$correo'";
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				while($row=mysqli_fetch_array($result)){
					$album=$row['nombre'];
					$id_album=$row['id'];
					echo "<tr><td>".$album."</td>";
					$sql="SELECT COUNT(*) AS num FROM FOTO WHERE id_album='$id_album'";
					if (!($result1=mysqli_query($link ,$sql))){
						echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
						mysqli_close($link);
						exit(1);
					}
					$row1=mysqli_fetch_array($result1);
					$num_fotos=$row1['num'];
					echo "<td>".$num_fotos."</td></tr>";
				}
				#Cierre de la conexión con la BD.
				mysqli_close($link);	
			?>
			</table>
        </div>		 
	</body>
</html>

	
	
