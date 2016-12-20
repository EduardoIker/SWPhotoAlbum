function cambiarEstado(correo){
	//AJAX
	var xhr= new XMLHttpRequest();
	xhr.open("GET","cambiar_estado_usuario.php?correo="+correo,true); 
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4 && xhr.status==200){ 
			if(xhr.responseText=="1"){
				var boton=document.getElementById(correo);
				if(boton.value=="Dar de Alta"){
					boton.value="Dar de Baja";
				}else if(boton.value=="Dar de Baja"){
					boton.value="Dar de Alta";
				}
				alert("Estado del usuario "+correo+" cambiado correctamente");
			}else{
				alert("Error al cambiar el estado del usuario "+correo+".Intentalo de nuevo");
			}
		}
	}
	xhr.send(""); 
}

function eliminarUsuario(correo){
	if(confirm("¿Seguro que deseas eliminar este usuario? Todos sus albumes, junto con sus fotos, serán borrados")==true){
		//AJAX
		var xhr= new XMLHttpRequest();
		xhr.open("GET","eliminar_usuario.php?correo="+correo,true); 
		document.getElementById("dvloader").style="display:inline";
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4 && xhr.status==200){ 
				document.getElementById("dvloader").style="display:none";
				if(xhr.responseText=="0"){
					alert("El usuario "+correo+" ha sido eliminado correctamente");
				}else{
					alert("Error al eliminar el usuario "+correo+". Inténtalo de nuevo.");
				}
				window.location.replace("http://swphotoalbum.hol.es/Aplicacion/administrador.php");
			}
		}
		xhr.send("");
	}
}