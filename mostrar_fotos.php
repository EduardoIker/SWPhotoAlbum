<?php
	session_start();
	if((!isset($_SESSION["correo"])) || (strcmp($_SESSION["correo"], "admin@swphotoalbum.es")==0)){
		 header("Location: login.php");
		 exit(1);
	}

    if(isset ($_FILES["files"])){		
        $miCorreo=$_SESSION["correo"];		
		#Conexion con la BD
		$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
		if(!$link){
			echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
			mysqli_close($link);
		}
					
		$nombres=json_decode($_POST['listaNombres']); #nombres de las fotos
		$etiquetas=json_decode($_POST['listaEtiquetas']); #etiquetas de las fotos
		$visibilidad=json_decode($_POST['listaVisibilidad']);#visibilidad de las fotos
		$album=$_POST['album'];
		#buscar el nombre del album para el path
		$sql="select nombre from ALBUM where id='$album'";
			if (!($result=mysqli_query($link ,$sql))){
				echo "Se ha producido un error desconocido. Intentalo de nuevo.";
				mysqli_close($link);
				exit(1);
			}	
		$row = mysqli_fetch_array($result);
		$nombreAlbum=$row['nombre'];
		#obtenemos la cantidad de elementos que tiene el array
        $total = count($_FILES["files"]["name"]);
		#Vamos guardando una a una las fotos en la base de datos
		for ($i = 0; $i < $total; $i++){ 
			$nombrefoto = $_FILES["files"]["name"][$i];
			$ruta="usuarios/".$miCorreo."/".$nombreAlbum."/".$nombrefoto;
                        move_uploaded_file($_FILES["files"]["tmp_name"][$i], $ruta);
			$sql="INSERT INTO FOTO VALUES (NULL,'$album','$ruta','$nombres[$i]','$visibilidad[$i]', '$etiquetas[$i]')";
			if (!($result=mysqli_query($link ,$sql))){
				echo "Se ha producido un error desconocido. Intentalo de nuevo.";
				mysqli_close($link);
				exit(1);
			}		
		}
     } 	   
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8"/>
		<title>Albumes</title>
		<link rel="stylesheet" type="text/css" href="css/estilo_album.css"/>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
            <script type="text/javascript" src="http://www.w3resource.com/JSON/json.js"></script>  
            <script type="text/javascript" src="http://www.w3resource.com/JSON/jsonpath.js"></script>
		<script type="text/javascript" src="js/fotos.js" ></script>
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

        <div id="divSubirFotos">
            <form id="subirFotos" action="mostrar_fotos.php" method="post" onsubmit="return subirFotos()" enctype="multipart/form-data">
				<h2>Subir fotos: </h2>
                <input type="file" id="files" name="files[]" multiple />
                <input type="submit" name="subir" id="subir" value="Subir fotos"/>       
                <br/>
                <script> 
							function handleFileSelect(evt) {
                             document.getElementById("divFotosSeleccionadas").innerHTML="";
                             var files = evt.target.files; // FileList object
                            // Loop through the FileList and render image files as thumbnails.
                            for (var i = 0, f; f = files[i]; i++) {
                               // Only process image files.
                                 if (!f.type.match('image.*')) {
                                    continue;
                                 }
                                var reader = new FileReader();
                               // Closure to capture the file information.
                               reader.onload = (function(theFile) {
                               return function(e) {
                               // Render thumbnail.
                               var span = document.createElement('span');
                               span.innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                               document.getElementById("divFotosSeleccionadas").appendChild(span);                                                     
                          };
                       })(f);
                               //creacion de formulario dinamico por cada foto elegida
                               var formf=document.createElement('FORM');
                               formf.name='form'+i;
                               formf.id='form'+i;
                               var h = document.createElement("h3");
                               var titulo = document.createTextNode("Foto "+(i+1));
                               h.appendChild(titulo);
                               formf.appendChild(h);
                               var nombref=document.createElement('INPUT');
	                       nombref.type='TEXT';
                               nombref.name='nombre'+i;
                               nombref.id='nombre'+i;
                               var lblnombref = document.createTextNode("Titulo: ");
                               formf.appendChild(lblnombref);
                               formf.appendChild(nombref);
                               var br= document.createElement("br");
                               formf.appendChild(br);
                               var etiquetasf= document.createElement("textarea");
                               etiquetasf.name = "etiquetas"+i;
                               etiquetasf.id = "etiquetas"+i;
                               etiquetasf.maxLength = "200";
                               etiquetasf.cols = "21";
                               etiquetasf.rows = "3";
                               var lbletiquetasf = document.createTextNode("Etiquetas: ");
                               formf.appendChild(lbletiquetasf);
                               formf.appendChild(etiquetasf);
                               var visibilidadf = document.createElement("select");
                               visibilidadf.id = "visibilidad"+i;
                               visibilidadf.name = "visibilidad"+i;
                               var array = ["privada","publica"];
                               for (var j = 0; j < array.length; j++) {
                                   var option = document.createElement("option");
                                   option.value = array[j];
                                   option.text = array[j];
                                   visibilidadf.appendChild(option);
                               }
                               var br2= document.createElement("br");
                               formf.appendChild(br2);
                               var lblvisibilidadf = document.createTextNode("Visibilidad: ");
                               formf.appendChild(lblvisibilidadf);
                               formf.appendChild(visibilidadf);
                               var br3= document.createElement("br");
                               formf.appendChild(br3);
                               document.getElementById("divFotosSeleccionadas").appendChild(formf);
                               document.getElementById("numFotos").value=i+1;
                     // Read in the image file as a data URL.
                      reader.readAsDataURL(f);
                    }
                   }
                  document.getElementById('files').addEventListener('change', handleFileSelect, false);
                </script>
                <input type="hidden" id="numFotos" name="numFotos" value="0" />
                <input type="hidden" id="album" name="album" value="<?php echo $_POST[album]; ?>" />
                <input type="hidden" id="listaNombres" name="listaNombres" value="" />
                <input type="hidden" id="listaEtiquetas" name="listaEtiquetas" value="" />
                <input type="hidden" id="listaVisibilidad" name="listaVisibilidad" value="" />
            </form>
            <div id="divFotosSeleccionadas">
            </div>
        </div>
		</br>
        <div id="fotos">
            <a href="usuario.php"><img class="back" src="images/back.png" onclick="volver()"></a>
			<img class="bin" src="images/bin.png"  onclick="eliminarAlbum(<?=$_POST['album']?>)"/>
	        <?php
					#Conexión con la BD
					$link = mysqli_connect("mysql.hostinger.es", "u307992971_root", "Informatica2016", "u307992971_swpa");
					if(!$link){
						echo 'Fallo al concectar a MySQL:' . $link->connect_error; 
						mysqli_close($link);
					}
					$album=$_POST['album'];
					$correo=$_SESSION["correo"];
					
					#Consulta de SQL: Obtener el nombre del album.		
					$sql="SELECT nombre FROM ALBUM WHERE id='$album'";
					if (!($resultado=mysqli_query($link ,$sql))){
						echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
						mysqli_close($link);
						exit(1);
					}
					$fila=mysqli_fetch_array($resultado);
					$NombreAlbum=$fila['nombre'];
					
					echo "<h1>".$NombreAlbum."</h1>";  

					#Consulta de SQL: Obtener todas las fotos del album elegido de la BD.		
					$sql="SELECT path, id FROM FOTO WHERE id_album='$album'";
					
					if (!($result=mysqli_query($link ,$sql))){
						echo "<script>alert('Se ha producido un error desconocido. Intentalo de nuevo')</script>";
						mysqli_close($link);
						exit(1);
					}
					
					$cont= mysqli_num_rows($result);
					
					if($cont==0){ # En caso de que no haya fotos en el album
						echo "Aun no has subido ninguna foto.";
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
				 
					#Cierre de la conexión con la BD.
					mysqli_close($link);
		    ?>
		</div>
		
        <div id="divVerFoto" style="display:none">
			<form method="post" action="mostrar_foto.php" id="verFoto">	
				<input type="text" name="foto" id="foto" />	
			</form>
	        <form method="post" action="usuario.php" id="volverAlbumes">							
        	</form>								
		</div>		
    </body>
</html>	
