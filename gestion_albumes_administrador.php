<?php
session_start();
if((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es")!=0)){
     header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
	  <head>
		 <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		 <title>Albumes</title>
		 <link rel="stylesheet" type="text/css" href="css/gestion_albumes_administrador.css"/>
		 <script type="text/javascript" src="js/gestion_albumes_administrador.js" ></script>
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
		
        <div id="albumes">
                  <a href="gestion_archivos_administrador.php"><img class="back" src="images/back.png" onclick="volver()"></a>
	         <h1>Albumes</h1>
		    <?php
				 #ConexiÃ³n con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
				echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
					mysqli_close($link);
				}
				
				$correo=$_POST["usuario"];

				#Consulta de SQL: Obtener todos los albumes del usuario de la BD.		
				$sql="SELECT nombre, id FROM ALBUM WHERE correo='$correo'";
				
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				
				$cont= mysqli_num_rows($result);
				
				if($cont==0){ # En caso de que no haya albumes
					echo"En este momento el usuario no tiene ningun album creado.";
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
			 
				#Cierre de la conexiÃ³n con la BD.
				mysqli_close($link);	   	   
		    ?>
                 </div>
	         <div id="divVerAlbum" style="display:none">
			<form method="post" action="gestion_fotos_administrador.php" id="verAlbum">		
				<input type="text" name="album" id="album" />
                                <input type="hidden" name="usuario" id="usuario" value="<?=$_POST['usuario']?>"/> 				
			</form>		
		 </div>		
		 
	  </body>
</html>