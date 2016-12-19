function validarCamposLogin(){
	var correo=document.getElementById("correo").value;
	var password=document.getElementById("password").value;
	
	if(correo==""){
		alert("Introduce un correo electrónico");
		return false;
	}
	if(!(/^[0-z]+@[0-z]+\.[a-z]+$/.test(correo))){
			alert("Introduce un correo válido");
			return false;
	}
	
	if(password==""){
		alert("Introduce una contraseña");
		return false;
	}
	
	return true;
}