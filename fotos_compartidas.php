<?php
	session_start();
	if((!isset($_SESSION['correo'])) || (strcmp($_SESSION['correo'],"admin@swphotoalbum.es"))==0){
		header('location:login.php');
	}
?>

<!DOCTYPE html>
<html>
	  <head>
		 <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		 <title>Albumes</title>
		 <link rel="stylesheet" type="text/css" href="css/estilo_ver_fotos_compartidas.css"/>
		  <script type="text/javascript" src="js/fotos_compartidas.js" ></script>
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

			    
			 
	    <div id="fotos">
			<h2> Fotos compartidas</h2>
		    <?php
                #Conexion con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
				echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
					mysqli_close($link);
				}

				#Consulta de SQL: Obtener el path de las fotos publicas de la BD.		
				$sql="SELECT DISTINCT email_propietario,nombre_apellidos FROM COMPARTIDO, USUARIOS WHERE email_compartido='$_SESSION[correo]' AND email_propietario=correo";
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido1. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				
				$cont= mysqli_num_rows($result);
				
				if($cont==0){ # En caso de que no haya fotos compartidas
						echo "No hay fotos disponibles.";
				} else{
						#Creamos la tabla <html> donde queremos que se visualicen las fotos.
						echo '<table>';
						$columna=0;
						#Insertamos las fotos (obtenidos tras la consulta) en la tabla creada anteriormente.
						while ($row = mysqli_fetch_array( $result )) {
							echo "<tr class=\"name\"><td colspan=\"3\">".$row['nombre_apellidos']."-".$row['email_propietario']."</td></tr>";
							$sql="SELECT id_foto, path FROM COMPARTIDO, FOTO WHERE email_compartido='$_SESSION[correo]' AND email_propietario='$row[email_propietario]' AND id=id_foto";
							if (!($result1=mysqli_query($link ,$sql))){
								echo mysqli_error($link);
								echo "<script>alert('Se ha producido un error desconocido2. Intentalo de nuevo ')</script>";
								mysqli_close($link);
								exit(1);
							}
							while ($row1 = mysqli_fetch_array( $result1 )) {
							    if($columna==0){
								   echo "<tr>";
						        }
								echo "<td><img src=\"$row1[path]\"  width=\"200px\" height=\"200\" 
								 onclick=\"verFoto('$row1[id_foto]')\"></td>";
								$columna=$columna+1;
								if($columna==3){
									echo "</tr>";
									$columna=0;
								}
							}
							if($columna!=0){
								$columna=0;
								echo "</tr>";
							}
							$result1->close();
						}
						echo '</table>';
				}
					
                #Cierre de la conexion con la BD.
				mysqli_close($link); 	   
		    ?>
	     </div> 
		 
		<div id="divVerFoto" style="display:none">
			<form method="post" id="verFoto" action="mostrar_foto_compartida.php">	
				<input type="text" name="foto" id="foto" />			
			</form>		
		</div>				 
	  </body>
</html>