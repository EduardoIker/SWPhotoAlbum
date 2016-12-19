 <?php
session_start();
if((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es")!=0)){
     header("Location: login.php");
     exit();
}
?>
<!DOCTYPE html>
<html>
	  <head>
		 <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		 <title>Albumes</title>
		 <link rel="stylesheet" type="text/css" href="css/gestion_fotos_administrador.css"/>
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		 <script type="text/javascript" src="js/gestion_fotos_administrador.js" ></script>
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
		
        <div id="fotos">
                 <img class="back" src="images/back.png" onclick="volver()"/>
				 <img class="bin" src="images/bin.png"  onclick="eliminarAlbum(<?=$_POST['album']?>)"/>
	         <h1>Fotos</h1>
		     <?php
					 #ConexiÃ³n con la BD
					$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
					if(!$link){
						echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
						mysqli_close($link);
					}
					$album=$_POST['album'];

					#Consulta de SQL: Obtener todas las fotos del album elegido de la BD.		
					$sql="SELECT path, id FROM FOTO WHERE id_album='$album'";
					
					if (!($result=mysqli_query($link ,$sql))){
						echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
						mysqli_close($link);
						exit(1);
					}
					
					$cont= mysqli_num_rows($result);
					
					if($cont==0){ # En caso de que no haya fotos en el album
						echo "El usuario aun no ha subido ninguna foto.";
					} else{
						#Creamos la tabla <html> donde queremos que se visualicen las fotos.
						echo '<table>';
						$columna=0;
						#Insertamos las fotos (obtenidos tras la consulta) en la tabla creada anteriormente.
						while ($row = mysqli_fetch_array( $result )) {
							    if($columna==0){
								   echo "<tr>";
						     	     }
								echo "<td><img src=\"$row[path]\"  width=\"200px\" height=\"200\" 
								 onclick=\"verFoto('$row[id]')\"></td>";
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

          <div id="divVerFoto" style="display:none">
			   <form method="post" action="gestion_foto_administrador.php" id="verFoto">	
				    <input type="text" name="foto" id="foto" />	
                                    <input type="hidden" name="album" id="album" value="<?=$_POST['album']?>"/>	
                                    <input type="hidden" name="usuario" id="usuario" value="<?=$_POST['usuario']?>"/>					
        	   </form>		
     	 </div>		
		 
		 <div id="divVolverAlbumes" style="display:none">
	           <form method="post" action="gestion_albumes_administrador.php" id="volverAlbumes">	
                       <input type="hidden" name="usuario" id="usuario" value="<?=$_POST['usuario']?>"/>						
        	   </form>		
     	 </div>	
		 
    </body>
</html>	