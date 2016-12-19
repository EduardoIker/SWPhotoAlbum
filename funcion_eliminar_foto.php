<?php 
   function eliminar_foto($foto,$link){
	   $sql="DELETE from ACCION WHERE id_foto='$foto'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "1"; //Enviamos un 1 que indica que ha habido algun problema a la hora de eliminar 
			mysqli_close($link);
			exit(1);
		}	
	    $sql="DELETE from COMPARTIDO WHERE id_foto='$foto'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "1"; //Enviamos un 1 que indica que ha habido algun problema a la hora de eliminar 
			mysqli_close($link);
			exit(1);
		}		
        $sql="select path from FOTO WHERE id='$foto'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "1"; //Enviamos un 1 que indica que ha habido algun problema a la hora de eliminar 
			mysqli_close($link);
			exit(1);
		}	 	
        $row=mysqli_fetch_array($result);
        $path=$row['path'];		
		$sql="DELETE from FOTO WHERE id='$foto'";
		if (!($result=mysqli_query($link ,$sql))){
			echo "1"; //Enviamos un 1 que indica que ha habido algun problema a la hora de eliminar 
			mysqli_close($link);
			exit(1);
		}			
		$res=unlink($path);
		if($res != true){
			 echo "1";
		}
   }
?>