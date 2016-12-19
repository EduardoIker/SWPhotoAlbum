function eliminarFoto(foto){
	if(confirm("¿Seguro que deseas borrar esta foto?") == true){
		// AJAX                                                
		var xhr= new XMLHttpRequest();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4 && xhr.status==200){ 
				if(xhr.responseText==0){ //Si la respuesta es 0, se ha eliminado correctamente
					alert("La foto se ha eliminado correctamente.");
					volver();
				} else if(xhr.responseText==1){//Si la respuesta es 1, ha habido algun problema para eliminar la foto
					alert("Ha ocurrido algun problema al borrar la foto. Intentalo de nuevo.");
				}			
		}};
		xhr.open("GET","eliminar_foto.php?foto="+foto,true); // Pasamos la foto que queremos eliminar
		xhr.send(""); // Los parametros se han enviado por el metodo GET y no POST, por lo que no es necesario enviar nada.
	}
}

function volver(){
  document.getElementById("volverAlbum").submit();
}