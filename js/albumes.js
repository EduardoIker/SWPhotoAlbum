function validarCrearAlbum(){
	var nombre=document.getElementById("nombre").value;
	
	if(nombre==""){
		alert("Introduce un nombre al album");
		return false;
	}
	return true;
}

function verAlbum(Album){  
  document.getElementById("album").value=Album;
  document.getElementById("verAlbum").submit();
}