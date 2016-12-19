function verFoto(foto){
    document.getElementById("foto").value=foto;
    document.getElementById("verFoto").submit();
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