function verFoto(Foto){
  document.getElementById("foto").value=Foto;
  document.getElementById("verFoto").submit();
}

function subirFotos(){
  var nombresLista= new Array();
  var etiquetasLista= new Array();
  var visibilidadLista= new Array();
  var numeroFotos= document.getElementById("numFotos").value; 
  if(numeroFotos==0){
       alert("Por favor, seleccione primero las imagenes");
       return false;
  }
  for (var i = 0; i < numeroFotos; i++){
      var nombre = document.getElementById("nombre"+i).value; 
      var etiquetas= document.getElementById("etiquetas"+i).value;
      var select = document.getElementById("visibilidad"+i);
      var visibilidad= select.options[select.selectedIndex].value;
      if(nombre.length==0){
        alert("Por favor, introduce un titulo a cada una de las fotos");
        return false;
      }
      if(etiquetas.length==0){
        alert("Por favor, introduce al menos una etiqueta a cada una de las fotos");
        return false;
      } 
      nombresLista[i]=nombre;
      etiquetasLista[i]=etiquetas;
      visibilidadLista[i]=visibilidad;
  }
  
  var listaNombres=nombresLista.toJSONString();
  var listaEtiquetas=etiquetasLista.toJSONString();
  var listaVisibilidad=visibilidadLista.toJSONString();
  
  document.getElementById("listaNombres").value=listaNombres;
  document.getElementById("listaEtiquetas").value=listaEtiquetas;
  document.getElementById("listaVisibilidad").value=listaVisibilidad;
  return true;
}

function eliminarAlbum(album){
	if(confirm("¿Seguro que deseas eliminar este album? Se eliminarán todas las fotos") == true){
		// AJAX                                                
		var xhr= new XMLHttpRequest();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4 && xhr.status==200){ 
				if(xhr.responseText==0){ //Si la respuesta es 0, se ha eliminado correctamente
					alert("El album se ha eliminado correctamente.");
					volver();
				} else if(xhr.responseText==1){ //Si la respuesta es 1, ha habido algun problema para eliminar el album
					alert("Ha ocurrido algun problema al borrar el album. Intentalo de nuevo.");
				}		
		}};
		xhr.open("GET","eliminar_Album.php?album="+album,true); // Pasamos el album que queremos eliminar
		xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.	
	}
}

function volver(){
    document.getElementById("volverAlbumes").submit();
}