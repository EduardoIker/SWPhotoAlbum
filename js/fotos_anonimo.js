function verFoto(Foto){
  document.getElementById("foto").value=Foto;
  document.getElementById("verFoto").submit();
}

function verFotosEtiqueta(){
        
	var etiqueta = document.getElementById("etiqueta").value; 
        //Comprobaciones
        if(etiqueta.length==0){
           alert("Por favor, introduce una etiqueta");
           return false;
        }

	// AJAX                                                
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ // Cuando llegue correctamente la respuesta, la introducimos en el div
			document.getElementById("fotos").innerHTML=xhr.responseText;
                }
        };
	xhr.open("GET","mostrar_fotos_etiqueta.php?etiqueta="+etiqueta,true); // Pasamos la etiqueta como parametro
	xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.
}
