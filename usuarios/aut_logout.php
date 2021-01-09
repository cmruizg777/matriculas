<?
//  Autentificator
//  Gesti�n de Usuarios PHP+Mysql+sesiones
//  by Pedro Noves V. (Cluster)
//  clus@hotpop.com
// -----------------------------------------

// Cargamos variables

// le damos un mobre a la sesion (por si quisieramos identificarla)
setcookie('id_alumno',0,time() + 365 * 24 * 60 * 60,'/');	
	
   	 setcookie('alumno',"",time() + 365 * 24 * 60 * 60,'/');
	 setcookie('ci',"",time() + 365 * 24 * 60 * 60,'/');
	 setcookie('sexo',"",time() + 365 * 24 * 60 * 60,'/');
	 setcookie('usuario_nivel',0,time() + 365 * 24 * 60 * 60,'/');
	 
	 setcookie('periodo',"",time() + 365 * 24 * 60 * 60,'/');
	 setcookie('band',"",time() + 365 * 24 * 60 * 60,'/');
?>
<html>
<head>
<title>Area de Administraci�n de http://www.tupagina.tal - Salir!</title>
<meta http-equiv="Refresh" content="1;url=../../"></head>
</body>
</html>
