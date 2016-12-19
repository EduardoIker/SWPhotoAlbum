function mostrarModificarDatos(){
	document.getElementById("cambioDatosForm").style="display:inline";
	document.getElementById("botonMostrarModificarDatos").style="display:none";
	document.getElementById("botonMostrarModificarContrasena").style="display:none";
	document.getElementById("divInfo").style="display:none";
	document.getElementById("nuevoNombre").value=document.getElementById("nombre_apellidos").innerHTML;
	document.getElementById("nuevoTlf").value=document.getElementById("telefono").innerHTML;
}

function mostrarModificarContrasena(){
	document.getElementById("cambioContraForm").style="display:inline";
	document.getElementById("botonMostrarModificarDatos").style="display:none";
	document.getElementById("botonMostrarModificarContrasena").style="display:none";
}

function modificarDatos(){
		var nombre = document.getElementById("nuevoNombre").value;
        var telefono = document.getElementById("nuevoTlf").value; 

        //Comprobaciones

        if(nombre.length==0){
           alert("Por favor, introduce un nombre");
           return false;
        }
        if(!(/^[9|8|7|6]\d{8}$/.test(telefono))){
           alert("Por favor, introduce un telefono válido");
           return false;
        }

	// AJAX                                                
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ 
			  alert(xhr.responseText);
                         document.getElementById("nombre_apellidos").innerHTML=nombre;
                         document.getElementById("telefono").innerHTML=telefono;
						document.getElementById("botonMostrarModificarDatos").style="display:inline";
						document.getElementById("botonMostrarModificarContrasena").style="display:inline";
						document.getElementById("divInfo").style="display:inline";
						document.getElementById("cambioDatosForm").style="display:none";
		}
	};
	xhr.open("GET","cambiar_datos_usuario.php?nombre="+nombre+"&telefono="+telefono,true); 
	xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.
}

function modificarContrasena(){
	var passActual = document.getElementById("passActual").value;
    var passNuevo = document.getElementById("passNuevo").value; 
	var rPassNuevo = document.getElementById("rPassNuevo").value; 

        //Comprobaciones

        if(passActual.length==0 || passNuevo.length==0 || rPassNuevo==0){
           alert("Por favor, completa todos los campos");
           return false;
        }
        if(!(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,8}$/.test(passNuevo))){
           alert("La contraseña debe tener al menos 1 minuscula, 1 mayuscula, 1 digito y entre 6-8 caracteres");
           return false;
        }
		
		if(passNuevo!=rPassNuevo){
			alert("La contraseña debe tener al menos 1 minuscula, 1 mayuscula, 1 digito y entre 6-8 caracteres");
           return false;
		}

	// AJAX                                                
	var xhr= new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ 
			  alert(xhr.responseText);
                     
						document.getElementById("botonMostrarModificarDatos").style="display:inline";
						document.getElementById("botonMostrarModificarContrasena").style="display:inline";
						document.getElementById("cambioContraForm").style="display:none";
		}
	};
	xhr.open("GET","cambiar_contrasena.php?contrasena="+passNuevo+"&contrasenaAct="+passActual,true); 
	xhr.send(""); // Los parametros se han enviado por el método GET y no POST, por lo que no es necesario enviar nada.
}

