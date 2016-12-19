function validarCrearAlbum(){
	var nombre=document.getElementById("nombre").value;
	
	if(nombre==""){
		alert("Introduce un nombre al album");
		return false;
	}
	return true;
}

function verAlbum(Album){

	/*var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
         document.getElementById("albumes").innerHTML = this.responseText; //Muestra las fotos
    }
  };
  xhttp.open("GET", "mostrar_fotos.php?ruta="+ruta, true);
  xhttp.send("");*/
  
  document.getElementById("album").value=Album;
  document.getElementById("verAlbum").submit();
}