
function compartir(foto){
        
	var email = document.getElementById("email").value; 
        //Comprobaciones
        if(email.length==0){
           alert("Por favor, introduce un correo");
           return false;
        }
	// AJAX                                                
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ // Cuando llegue correctamente la respuesta, la introducimos en el div
			document.getElementById("divResultado").innerHTML=xhr.responseText;
                        mostrar_compartidos(foto);
		}
	};
	xhr.open("GET","compartir.php?email="+email+"&foto="+foto,true); // Pasamos el correo con el que queremos compartir y la foto como parametros
	xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.
}

function retirar(foto){
        
	var email = document.getElementById("email").value; 
        //Comprobaciones
        if(email.length==0){
           alert("Por favor, introduce un correo");
           return false;
        }
	// AJAX                                                
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ // Cuando llegue correctamente la respuesta, la introducimos en el div
			document.getElementById("divResultado").innerHTML=xhr.responseText;
                        mostrar_compartidos(foto);
		}
	};
	xhr.open("GET","retirar_compartido.php?email="+email+"&foto="+foto,true); // Pasamos el correo con el que queremos dejar de compartir y la foto como parametros
	xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.
}

function mostrar_compartidos(foto){

        var xhr= new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ // Cuando llegue correctamente la respuesta, la introducimos en el div
			document.getElementById("tablaCompartidos").innerHTML=xhr.responseText;
		}
	};
	xhr.open("GET","compartidos.php?foto="+foto,true); // Pasamos la foto como parametro
	xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.

}

 function activarModificar(){
     document.getElementById("boton").style="display:none";
     document.getElementById("divInfo").style="display:none";
     document.getElementById("cambiosForm").style="display:inline";
     document.getElementById("nuevoNombre").value= document.getElementById("nombre").innerHTML;
     document.getElementById("nuevasEtiquetas").value= document.getElementById("etiqueta").innerHTML;
 }

function Modificar(id){
        var nombre = document.getElementById("nuevoNombre").value;
        var etiquetas = document.getElementById("nuevasEtiquetas").value; 
        var v= document.getElementById("nuevaVisibilidad");
	var visibilidad = v.options[v.selectedIndex].value; //Obtenemos el origen

        //Comprobaciones

        if(nombre.length==0){
           alert("Por favor, introduce un nombre");
           return false;
        }
        if(etiquetas.length==0){
           alert("Por favor, introduce al menos una etiqueta");
           return false;
        }

	// AJAX                                                
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ // Cuando llegue correctamente la respuesta, la introducimos en el div
			  alert(xhr.responseText);
                          document.getElementById("nombre").innerHTML=nombre;
                          document.getElementById("etiqueta").innerHTML=etiquetas;
                          document.getElementById("visibilidad").innerHTML=visibilidad;
                          document.getElementById("boton").style="display:inline";
                          document.getElementById("divInfo").style="display:inline";
                          document.getElementById("cambiosForm").style="display:none";
		}
	};
	xhr.open("GET","cambiar_datos_foto.php?id="+id+"&nombre="+nombre+"&etiquetas="+etiquetas+"&visibilidad="+visibilidad,true); // Pasamos la id, nombre, etiquetas y visibilidad de la foto como parametros
	xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.
}	

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
	document.getElementById("verAlbum").submit();
}