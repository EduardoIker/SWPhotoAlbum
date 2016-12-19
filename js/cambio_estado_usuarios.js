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
				alert("Error al cambiar el estado del usuario "+correo+".Inténtalo de nuevo");
			}
		}
	}
	xhr.send(""); 
}