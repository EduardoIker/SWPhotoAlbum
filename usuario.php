<?php
session_start();
if((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es")==0)){
     header("Location: login.php");
     exit();
}
if(isset($_POST['nombre'])){
		#Conexión con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo "<script type=\"text/javascript\">alert(\"Error en el proceso de crear album(abrir conexion con la BD)\");</script>";
			mysqli_close($link);
			exit(1);
		}
		# VALIDACIONES DE LOS DATOS 
		#Nombre
		if(strcmp($_POST[nombre],"")==0){
			echo "Introduce un nombre para el album";
			exit(1);
		}
		
		$correo=$_SESSION["correo"];
		
		#Guardamos el album en la BD
		$rutaalbum="usuarios/".$correo."/".$_POST[nombre];
		if(!is_dir($rutaalbum))
			mkdir($rutaalbum, 0777,true);
		else{
			echo "Ya existe ese album\n"; 
			exit(-1);
		}
			
		$sql="INSERT INTO ALBUM VALUES (NULL,'$_POST[nombre]', '$_SESSION[correo]')";
		if (!mysqli_query($link ,$sql)){
			die('Error al insertar tupla: ' . mysqli_error($link));
		}
		
	}
?>
<!DOCTYPE html>
<html>
	  <head>
		 <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		 <title>Albumes</title>
		 <link rel="stylesheet" type="text/css" href="css/estilo_usuario.css"/>
		 <script type="text/javascript" src="js/albumes.js" ></script>
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
		
	  
		  <div id="crearNuevo">
		    <h2> Crear un nuevo album </h2>
			<form method="post" action="usuario.php" onsubmit="return validarCrearAlbum();">	
			    <span>Nombre: </span>
				<input type="text" name="nombre" id="nombre" />
				<br/>
				<input type="submit" name="submit" id="submit" value="Crear" />			
			</form>		
		 </div>		
		 </br>
               <div id="albumes">
	         <h1>Mis albumes</h1>
		    <?php
				 #Conexión con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
				echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
					mysqli_close($link);
				}
				
				$correo=$_SESSION["correo"];

				#Consulta de SQL: Obtener todos los albumes del usuario de la BD.		
				$sql="SELECT nombre, id FROM ALBUM WHERE correo='$correo'";
				
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				
				$cont= mysqli_num_rows($result);
				
				if($cont==0){ # En caso de que no haya albumes
					echo"En este momento no tienes ningun album creado.";
				} else{
					#Creamos la tabla <html> donde queremos que se visualicen los albumes.
					echo '<table>';
					$columna=0;
					#Insertamos los albumes (obtenidos tras la consulta) en la tabla creada anteriormente.
					while ($row = mysqli_fetch_array( $result )) {
						    if($columna==0){
								echo "<tr>";
							}
							echo "<td><img src=\"images/icono.png\"  width=\"150px\" height=\"150px\" 
                                                         onclick=\"verAlbum('$row[id]')\"><br/>$row[nombre]</td>";
							$columna=$columna+1;
							if($columna==3){
								echo "</tr>";
								$columna=0;
							}
					}
					echo '</table>';
				}
				
				$result->close();
			 
				#Cierre de la conexión con la BD.
				mysqli_close($link);	   	   
		    ?>
                 </div>
	         <div id="divVerAlbum" style="display:none">
			<form method="post" action="mostrar_fotos.php" id="verAlbum">		
				<input type="text" name="album" id="album" />			
			</form>		
		 </div>		
		 
	  </body>
</html>

	
	
