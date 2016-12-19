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
		 <link rel="stylesheet" type="text/css" href="css/estilo_ver_foto.css"/>
		 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		 <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		 <script type="text/javascript" src="js/mostrar_foto.js" ></script>
		 <script type="text/javascript">
					/***************************   PARA EL GRAFICO DE LAS ESTADISTICAS   ****************************************/
			// Load the Visualization API and the piechart package.
			google.load('visualization', '1', {'packages':['corechart']});
			  
			// Set a callback to run when the Google Visualization API is loaded.
			google.setOnLoadCallback(drawChart);
			  foto= <? echo $_POST['foto'];?>;
			function drawChart() {
			  var jsonData = $.ajax({
				  type: "POST",
				  url: "estadisticas_json.php",
				  data: { 
					'foto': foto, 
					},
				  dataType:"json",
				  async: false
				  }).responseText;
				  
			  // Create our data table out of JSON data loaded from server.
			  var data = new google.visualization.DataTable(jsonData);

			  // Instantiate and draw our chart, passing in some options.
			  var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
			  chart.draw(data, {width: 700, height: 400});
			}


		/************************************************************************************************************/
		 </script>
	  </head>
	  <body onload="mostrar_compartidos(<?php echo"$_POST[foto]";?>)">
	  
	    <!-- Barra navegacion superior-->
		<ul class="top">
		  <li><img src="images/logo.png" alt="Logo de la aplicación SW Photo Album" /></li>
		  <li><a class="logout" href="logout.php">Logout</a></li>
		  <li><a href="usuario.php">Ver albumes</a></li>
		  <li><a href="fotos_compartidas.php">Ver fotos compartidas</a></li>
		  <li><a href="perfil.php">Mi perfil</a></li>
		  <li><p> Te has identificado como: <?=$_SESSION['correo']?></p></li>
		</ul>
			
	     <div id="foto">
			<img class="back" src="images/back.png" onclick="volver()">
			<img class="bin" src="images/bin.png"  onclick="eliminarFoto(<?=$_POST['foto']?>)"/>
		    <?php
			    
                #Conexión con la BD
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
                     <br/>
                     <input type="button" name="boton" id="boton" value="Modificar datos" onclick="activarModificar()"/>
                     <form id="cambiosForm" style="display:none">
                         nombre: <input type="text" name="nuevoNombre" id="nuevoNombre"/> <br/>
                         visibilidad: 
                          <?php 
                                   echo "<select name=\"nuevaVisibilidad\" id=\"nuevaVisibilidad\">";
                                   if(strcmp($visibilidad, "privada")== 0){
                                         echo "<option value=\"privada\" selected>privada</option>";
                                         echo "<option value=\"publica\">publica</option>";
                                   } else {
                                         echo "<option value=\"publica\" selected>publica</option>";
                                         echo "<option value=\"privada\">privada</option>";
                                   }
                                   echo "</select>";
                          ?>
                          <br/>
                         Etiquetas: <br/> <textarea id="nuevasEtiquetas" rows="3" cols="40"></textarea>  <br/>
                         <input type="button" name="boton" id="boton" value="Modificar" onclick="Modificar(<?php echo"$_POST[foto]";?>)"/>                      
                     </form> 
	     </div> 
             </br>
             <div id="estadisticas">
                     <h2>Estadisticas</h2>
					 <div id="chart">
					 </div>
             </div>                 
				</br>
               <div id="divCompartir">
                   <form> 
                         <h2>Compartir la foto</h2>
                         <input type="text" id="email" name="email"/>
                         <input type="button" name="Compartir" id="Compartir" value="Compartir" onclick="compartir(<?php echo"$_POST[foto]";?>)"/> 
                         <input type="button" name="Retirar" id="Retirar" value="Retirar" onclick="retirar(<?php echo"$_POST[foto]";?>)"/>  
                   </form>
                   <div id="divResultado">
                   </div>
                   <br/>
                   Usuarios con los que has compartido:
                   <div id="tablaCompartidos">
                   </div>
             </div>
			 <div id="divVerAlbum" style="display:none">
			<form method="post" action="mostrar_fotos.php" id="verAlbum">		
				<input type="text" name="album" id="album" value="<?=$id_album?>"  />			
			</form>		
		 </div>
		 
	  </body>
</html>