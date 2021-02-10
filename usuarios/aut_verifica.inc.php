<?php
//  Autentificator
//  Gesti?n de Usuarios PHP+Mysql+sesiones
//  by Pedro Noves V. (Cluster)
//  clus@hotpop.com
//  v1.0  - 17/04/2002 Versi?n inicial.
//  v1.01 - 24/04/2002 Solucionado error sintactico en aut_verifica.inc.php.
//  v1.05 - 17/05/2002 Optimizaci?n c?digo aut_verifia.inc.php
//  v1.06 - 03/06/2002 Correcci?n de errores de la versi?n 1.05 y error con navegadores Netscape
//  v2.00 - 18/08/2002 Optimizaci?n c?digo + Seguridad.
//                     Ahora funciona con la directiva registre_globals= OFF. (PHP > 4.1.x)
//                     Optimizaci?n Tablas SQL. (rangos de tipos).
//  v2.01 - 16/10/2002 Solucionado "despistes" de la versi?n 2.00 de Autentificator
//                     en aut_verifica.inc.php y aut_gestion_usuarios.php que ocasinavan errores al trabajar
//                     con la directiva registre_globals= OFF.
//                     Solucionado error definici?n nombre de la sessi?n.
//
// Descripci?n:
// Gesti?n de P?ginas restringidas a Usuarios, con nivel de acceso
// y gesti?n de errores en el Login
// + administraci?n de usuarios (altas/bajas/modificaciones)
//
// Licencia GPL con estas extensiones:
// - Uselo con el fin que quiera (personal o lucrativo).
// - Si encuentra el c?digo de utilidad y lo usas, mandeme un mail si lo desea.
// - Si mejora el c?digo o encuentra errores, hagamelo saber el mail indicado.
//
// Instalaci?n y uso del Gestor de usuarios en:
// documentacion.htm
//  ----------------------------------------------------------------------------


// Motor autentificaci?n usuarios.


require_once('clases/connection.php');

  
$tablet_browser = 0;
$mobile_browser = 0;
$body_class = 'desktop';
 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
    $body_class = "tablet";
}
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
    $body_class = "mobile";
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
    $body_class = "mobile";
}
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}
if ($tablet_browser > 0) {
// Si es tablet has lo que necesites
  $equipo=1;
}
else if ($mobile_browser > 0) {
// Si es dispositivo mobil has lo que necesites
   $equipo=1;
}
else {
// Si es ordenador de escritorio has lo que necesites
  $equipo=0;
} 
// chequear p?gina que lo llama para devolver errores a dicha p?gina.

$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;
// chequear si se llama directo al script.
if ($_SERVER['HTTP_REFERER'] == ""){
//header ("Location: login.php");
//exit;
}


// Chequeamos si se est? autentificandose un usuario por medio del formulario
if (isset($_POST['user']) && isset($_POST['pass'])) {

// Conexi?n base de datos.
// si no se puede conectar a la BD salimos del scrip con error 0 y
// redireccionamos a la pagina de error.
//echo $sql_host.", ".$sql_usuario.", ".$sql_pass;
//$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die(header ("Location:  $redir?error_login=0"));
//mysql_select_db("$sql_db"); and substring(ci,length(ci)-3,length(ci))=?
$conn=getDatabaseConnection1($_POST['base'],$_POST['server']);
$band=0;
$usuario_datos=new CMySQL1($conn,"SELECT `idalumno`, `ci`, `alumno`,sexo from alumnos where ci=? ",array($_POST['user']));
if ($usuario_datos->GetNRows() == 0){
	$band=1;
	$usuario_datos=new CMySQL1($conn,"SELECT  `ci`, `alumnos` as alumno from preinscripcion where ci=?",array($_POST['user']));
}

if ($usuario_datos->GetNRows() != 0) {

    // eliminamos barras invertidas y dobles en sencillas
    $login = stripslashes($_POST['user']);
    // encriptamos el password en formato md5 irreversible.
    unset($login);
    unset ($password);
	if($_POST['pass']!=substr($_POST['user'],strlen($_POST['user'])-4,strlen($_POST['user']))){
		 header ("Location: $redir?error_login=3&idinst=".$_POST['id']."&server=".$_POST['server']);
	    exit;
	}
    $Oper=new CMySQL1($conn,"select idperiodo from periodo  order by idperiodo desc limit 1 ",[]);
	$OCurso=new CMySQL1($conn,"SELECT cursos.curso, cursos.idcurso FROM alumnos,matricula,cursos WHERE cursos.idcurso=matricula.idcurso and alumnos.idalumno=matricula.idalumno and matricula.estado=1 and alumnos.idalumno=? and matricula.idperiodo=?",array($usuario_datos->Row['idalumno'],$Oper->Row['idperiodo']));
	if($band==0)
  	 setcookie('id_alumno',$usuario_datos->Row['idalumno'],time() + 365 * 24 * 60 * 60,'/');
	else
	 setcookie('id_alumno',0,time() + 365 * 24 * 60 * 60,'/');	
	
   	 setcookie('alumno',$usuario_datos->Row['alumno'],time() + 365 * 24 * 60 * 60,'/');
	 setcookie('ci',$usuario_datos->Row['ci'],time() + 365 * 24 * 60 * 60,'/');
	 setcookie('sexo',($band==0)?$usuario_datos->Row['sexo']:'H',time() + 365 * 24 * 60 * 60,'/');
	 setcookie('usuario_nivel',5,time() + 365 * 24 * 60 * 60,'/');
	 setcookie('periodo',$Oper->Row['idperiodo'],time() + 365 * 24 * 60 * 60,'/');
	 setcookie('band',$band,time() + 365 * 24 * 60 * 60,'/');
   	setcookie('base',$_POST['base'],time() + 365 * 24 * 60 * 60,'/');
	setcookie('server',$_POST['server'],time() + 365 * 24 * 60 * 60,'/');
	setcookie('curso',$OCurso->Row['curso'],time() + 365 * 24 * 60 * 60,'/');
    setcookie('id_curso',$OCurso->Row['idcurso'],time() + 365 * 24 * 60 * 60,'/');
    // definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
	$conn=null;
    $pag=$_SERVER['PHP_SELF'];
    header ("Location: $pag?idinst=".$_POST['id']."&server=".$_POST['server']);
    exit;
    
   } else {
      // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      header ("Location: $redir?error_login=2&idinst=".$_POST['id']."&server=".$_POST['server']);
      exit;}
} else {

// -------- Chequear sesi?n existe -------

// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
session_start();

// Chequeamos si estan creadas las variables de sesi?n de identificaci?n del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.

if (!isset($_COOKIE['periodo']) ){
// Borramos la sesion creada por el inicio de session anterior
unset($_COOKIE);
session_destroy();
if($_GET['ubica']!="")
	header ("Location: ../../{$_GET['ubica']}");
else{
  $dir="matriculas/main";
	header ("Location:$dir");//?forma=login.php&lan=es
}
exit;
}
}
?>
