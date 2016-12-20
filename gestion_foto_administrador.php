<?php
	session_start();
	if((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es")!=0)){
		 header("Location: login.php");
		 exit(1);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		<title>Albumes</title>
		<link rel="stylesheet" type="text/css" href="css/gestion_foto_administrador.css"/>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/gestion_foto_administrador.js" ></script>
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
		
	    <div id="foto">
            <img class="back" src="images/back.png" onclick="volver()" />
		    <img class="bin" src="images/bin.png"  onclick="eliminarFoto(<?=$_POST['foto']?>)"/>
		    <?php
			    #Conexion con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
					echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
					mysqli_close($link);
				}
				
				$correo=$_SESSION["correo"];
				$foto=$_POST['foto'];

				#Consulta de SQL: Obtener el path de la foto de la BD.		
				$sql="SELECT path,nombre,visibilidad,etiquetas,id_album FROM FOTO WHERE id='$foto'";
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				$row = mysqli_fetch_array($result);
				$path=$row['path'];
				$nombre=$row['nombre'];	
				$id_album=$row['id_album'];
                $visibilidad=$row['visibilidad'];
                $etiquetas=$row['etiquetas'];						
				echo "<h3 id=\"nombre\">$nombre</h3> <br/>
                        <img src=\"$path\"> <br/> 
                        <div id=\"divInfo\">
                        Visibilidad: <span id=\"visibilidad\">$visibilidad</span><br/>
                        Etiquetas: <span id=\"etiqueta\">$etiquetas</span>
                        </div>";	 
				
		    ?>                  
	    </div> 	
        <div id="divVolverAlbum" style="display:none">
	        <form method="post" action="gestion_fotos_administrador.php" id="volverAlbum">			
                <input type="hidden" name="album" id="album" value="<?=$_POST['album']?>"/>		
                <input type="hidden" name="usuario" id="usuario" value="<?=$_POST['usuario']?>"/>			
            </form>		
     	</div>			 
	</body>
</html>