<!DOCTYPE html>
<html>
	  <head>
		 <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		 <title>Albumes</title>
		 <link rel="stylesheet" type="text/css" href="css/estilo_ver_fotos_anonimo.css"/>
		  <script type="text/javascript" src="js/fotos_anonimo.js" ></script>
	  </head>
	  <body>
	  
	      <!-- Barra navegacion superior-->
		<ul class="top">
		  <li><img src="images/logo.png" alt="Logo de la aplicacion SW Photo Album" /></li>
		  <li><a href="index.html">Inicio</a></li>
		  <li><a href="mostrar_fotos_anonimos.php">Ver fotos</a></li>
		</ul>

             
		 <div id="bucarPorEtiqueta">
		    <h2> Buscar foto por etiqueta</h2>
			    <span>Etiqueta </span>
				<input type="text" name="etiqueta" id="etiqueta" />
				<br/>
				<input type="button" name="submit" id="submit" value="Buscar" onclick="verFotosEtiqueta()"/>				
		</div>	
		
		</br>
			 
	       <div id="fotos">
		    <?php
			    
                #ConexiÃ³n con la BD
				$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
				if(!$link){
				echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
					mysqli_close($link);
				}

				#Consulta de SQL: Obtener el path de las fotos publicas de la BD.		
				$sql="SELECT path,id FROM FOTO WHERE visibilidad='publica'";
				if (!($result=mysqli_query($link ,$sql))){
					echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
					mysqli_close($link);
					exit(1);
				}
				
				$cont= mysqli_num_rows($result);
				
				if($cont==0){ # En caso de que no haya fotos publicas
						echo "No hay fotos disponibles.";
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
	     </div> 
		 
		 <div id="divVerFoto" style="display:none">
			<form method="post" id="verFoto" action="mostrar_foto_anonimo.php">	
				<input type="text" name="foto" id="foto" />			
			</form>		
		 </div>				 
	  </body>
</html>