<?php require_once('clases/connection.php'); ?>
<?php
$Ocole=new CMySQL("select * from datos where idinstitucion=?","bddinstituciones","186.4.154.145",array($_GET['idinst']));
setcookie('nombre',$Ocole->Row['nombre'],time() + 365 * 24 * 60 * 60,'/');
setcookie('idinst',$_GET['idinst'],time() + 365 * 24 * 60 * 60,'/');
$conn=getDatabaseConnection1($Ocole->Row['base'],$_GET['server']);
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
  $equipo=2;
}
else if ($mobile_browser > 0) {
// Si es dispositivo mobil has lo que necesites
   $equipo=1;
}
else {
// Si es ordenador de escritorio has lo que necesites
  $equipo=0;
} 

                          include ("usuarios/aut_mensaje_error.inc.php");
                          if (isset($_GET['error_login'])){
                             	$error="Error: ".$error_login_ms[$_GET['error_login']];
								$comm="alert('$error');";
								echo "<script languaje='javascript' type='text/javascript'>$comm</script>";                           
						  }
						 
						  if($_GET['MiEmpresa']!="")
						  $Oemp=new CMySQL1($conn,"select Logo,Id,Nombre from empresas where Id=? ",array($_GET['MiEmpresa']));
						 else
						   $Oemp=new CMySQL1($conn,"select Logo,Id,Nombre from empresas ",array(1));
						   
					if(file_exists("files/".$Oemp->Row['Logo'])){
						 $refimg=($equipo==1)?260:340;
					list($ancho, $alto, $tipo, $atributos) = getimagesize("files/".$Oemp->Row['Logo']); 
					if($ancho>$alto){
						$ancho=round($refimg*$alto/$ancho);
						$alto=$refimg;
					}else{
						$alto=round($refimg*$ancho/$alto);
						$ancho=$refimg;
					}
					$archivo="files/".$Oemp->Row['Logo'];
					$medida=" height='$ancho' width='$alto'";
					}
				
          ?>
 <!DOCTYPE html>
<html lang="en">
<head><meta charset="euc-jp">
	<title><?php echo $Ocole->Row['nombre']?> |  MATRICULAS ONLINE</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/jpeg" href="data:image/jpeg;base64,  <?php echo base64_encode($Ocole->Row['logo'])?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">

				<form class="login100-form validate-form"  action="index.php"  method="post" >
					<div align="center"><img src="data:image/jpeg;base64,  <?php echo base64_encode($Ocole->Row['logo'])?>"  width="100" height="80" border="0" />  </div>
					<span class="login100-form-title p-b-43">
						MATRICULACION EN LINEA
					</span>
					
					
					<div class="wrap-input100 validate-input" >
						<input class="input100" type="text" name="user">
						<span class="focus-input100"></span>
						<span class="label-input100">Cedula</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="pass">
						<span class="focus-input100"></span>
						<span class="label-input100">Contraseña</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<span class="label-input100"></span>
						</div>

						<div align="center" style="color: red">
							
							<?php echo ($_GET['error_login']!="")?$error:""?>
							
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
						<button class="login100-form-btn">
							Ingresar
						</button>
					</div>
					
					
						<input type="hidden" name="base" value="<?php echo $Ocole->Row['base']?>">
						 <input type="hidden" name="id" value="<?php echo $Ocole->Row['idinstitucion']?>">
                         <input type="hidden" name="server" value="<?php echo $Ocole->Row['Servidor']?>">
				</form>

				<div class="login100-more" style="background-image: url('images/bg-02.jpg');"><span class="login100-form-title p-b-43 " style="">
						</br></br><strong class="text-white"><?php echo $Ocole->Row['nombre']?></strong>
					</span>
				</div>
		  </div>
	  </div>
</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>

