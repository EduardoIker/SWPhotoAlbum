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
		 <link rel="stylesheet" type="text/css" href="css/estilo_ver_foto_anonimo.css"/>
		  <!--<script type="text/javascript" src="js/xxxxx.js" ></script>-->
	  </head>
	  <body>
	  
	    <!-- Barra navegacion superior-->
		<ul class="top">
		  <li><img src="images/logo.png" alt="Logo de la aplicación SW Photo Album" /></li>
		  <li><a class="logout" href="logout.php">Logout</a></li>
		  <li><a href="usuario.php">Ver albumes</a></li>
		  <li><a href="fotos_compartidas.php">Ver fotos compartidas</a></li>
		  <li><p> Te has identificado como: <?=$_SESSION['correo']?></p></li>
		</ul>
			 
			 
	     <div id="foto">
		 <img class="back" src="images/back.png" onclick="javascript:window.history.back();">
		    <?php
			    
                #Conexion con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
				echo 'Fallo al conectar a MySQL:' . $link->connect_error; 
					mysqli_close($link);
				}

				$foto=$_POST['foto'];

				#Consulta de SQL: Obtener el path de la foto de la BD.		
				$sql="SELECT path,nombre FROM FOTO WHERE id='$foto'";
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				$row = mysqli_fetch_array($result);
				$path=$row['path'];
				$nombre=$row['nombre'];								
				echo "<h3>$nombre</h3> <br/>
                         <img src=\"$path\">";	  

                #Insertar en la BD que un anonimo ha visitado esta foto	
				$sql="INSERT INTO ACCION VALUES (NULL, '$_SESSION[correo]','$foto')";
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}							  
		    ?>
	     </div> 
		 
	  </body>
</html>