<?php require_once('../clases/connection.php'); 
 // No almacenar en el cache del navegador esta página.
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
		header("Pragma: no-cache");                                   		// HTTP/1.0
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Compuline - Servicios Inform&aacute;ticos</title>
<link rel="stylesheet" type="text/css" href="../css/style.css">
  <script src="../sifr/sifr.js" type="text/javascript"></script>
  <script src="../sifr/sifr-debug.js" type="text/javascript"></script>
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/slider.js"></script>
  <script type="text/javascript" src="../js/menu.js"></script>
<!--[if IE 6]>
        <script src="../js/DD_belatedPNG_0.0.8a-min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/styleIE6.css">
        <script>
          DD_belatedPNG.fix('*')
          /* string argument can be any CSS selector */
          /* .png_bg example is unnecessary */
          /* change it to what suits you! */
        </script>
<![endif]-->
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>
<body id="home">
<div class="wrapper">
	
    <div class="header">
	 <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="478" height="85">
<param name="movie" value="flashvortex.swf" />
<param name="quality" value="best" />
<param name="menu" value="true" />
<param name="allowScriptAccess" value="sameDomain" />
<embed src="flashvortex.swf" quality="best" menu="true" width="400" height="55" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" allowScriptAccess="sameDomain" />
</object>
    	<a class="logo" href="../index.php">Rogue Logo</a>
       
<!-- ########################################Menu######################################## -->
        <ul class="menu">
        	<li><a class="selected" href="../index.php">Inicio</a></li>
            <li><a href="#">Cat&aacute;logo</a>
            	<ul class="subnav">
                    <li><a href="#">Promociones</a></li>
                    <li><a href="#">Nuestros Productos</a></li>
                    <li><a href="#">Cotizaciones</a></li>
                </ul>      
            </li>
            <li><a href="#">Servicos</a></li>
            <li><a href="../ShowProd.php">Contactos</a></li>
        </ul>
<!-- ########################################End Menu######################################## -->        
    </div>
    
    <div class="slider">
        <div class="scroller">
<!-- ########################################Slide######################################## -->
		<?php 
			$OImg=new CMySQL("SELECT productos.Id,archivos.Nombre as nombrea ,productos.Nombre,productos.Descripcion,productos.PrecioV FROM archivos,productos where archivos.producto_id=productos.Id and productos.Mostrar=1");
			$OImg1=new CMySQL("SELECT productos.Id FROM productos, detalleprod  WHERE  productos.Mostrar =1 AND detalleprod.Producto_id = productos.Id and productos.Id=1");
			do{
				$lbl=$OImg->Row['Nombre'];
				$nimagen=$OImg->Row['nombrea'];
				$des=$OImg->Row['Descripcion'];
				$precio=number_format($OImg->Row['PrecioV']*1.12,2);
				$Idp=$OImg->Row['Id'];
				$OImg1->SetQuery("SELECT productos.Id FROM productos, detalleprod  WHERE  productos.Mostrar =1 AND detalleprod.Producto_id = productos.Id and productos.Id=$Idp");
    	        print  "<div class='slide'>";
				if ($OImg1->GetNRows()>0)
        	    	print  "<a href='../ShowProd.php?Id=$Idp'><img class='left'   src='../files/$nimagen' alt='Slider Img' width='378' height='346'/>";
				else
				    print  "<img class='left'   src='../files/$nimagen' alt='Slider Img' width='378' height='346'/>";
            	print  "<div class='content'>";
	            print  "<h1>$lbl</h1>";
	            print  "<p>$des. </p>";
    	        print "<ul class='slider-list-links'>";
				if ($OImg1->GetNRows()>0)
        	    print "<li><a class='holder-small' href='../ShowProd.php?Id=$Idp'><span class='holder-small-repeat'>Mas Detalles</span><span class='holder-small-right'></span></a></li>";
            	print "<li><a class='holder-small' href='#'><span class='holder-small-repeat'>Precio  $ $precio</span><span class='holder-small-right'></span></a></li>";
	            print "</ul>";
    	        print "</div>";
        	    print "</div>";
			}while ($OImg->GetRow());
?>
<!-- ########################################End Slide########################################-->            
        </div>
    </div>
<!-- ########################################Slide Holder######################################## -->
    <div class="slider-bar">
        <div class="slider-bar-inner"></div>
    </div>
<!-- ########################################End Slide Holder######################################## -->    

<!-- ########################################Boxes Holder########################################-->    
    <div class="content-boxes">
    
        <div class="box-holder">
            <h2 class="white">Nosotros</h2>
            <p>Compuline es una empresa dedicada a la comercializaci&oacute;n y desarrollo de tecnolog&iacute;a inform&aacute;tica</p>
        </div>
        <div class="box-holder margin-left">
            <h2 class="white">Ingresar</h2>
			 <form action="../rindex.php" method="post">
            <table width="250" height="30" border="0">
			<tr valign="middle"> 
                <td colspan="2" height="20"> 
					<div align="center">
                         <?
                          // Mostrar error de Autentificación.
                          include ("../usuarios/aut_mensaje_error.inc.php");
                          if (isset($_GET['error_login'])){
                              $error=$_GET['error_login'];
                          echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#FF0000'>Error: $error_login_ms[$error]";
                          }
                         ?>
                    </div>
			</tr>
              <tr>
              <tr height="28">
                <td><span class="style1 style1">Usuario</span><span class="style1"> : </span></td>
                <td><input type="text" name="user" size="15" ></td>
              </tr>
              <tr>
                <td><span class="style1">Contrase&ntilde;a :</span></td>
                <td><input type="password" name="pass" size="15"></td>
              </tr>
              <tr>
                <td> <div>
                  <p>
                    <input name="ok" type=submit value="Entrar">
                  </p>
                  </div></td>
                <td>&nbsp;</td>
              </tr>
            </table>
			</form>
        </div>
        
        
        <div class="box-holder right">
            <h2 class="white">Contactos</h2>
            <p>Ibarra, Bolivar 13-122 y Teodoro G&oacute;mez CC. P&iacute;a Mar&iacute;a  Tel: 062606275 094169088</p>
        </div>
    
</div>

<!-- ########################################End Boxes Holder########################################-->


<!-- ########################################Footer Boxes Holder########################################-->    
   
<!-- ########################################End Footer Boxes Holder########################################-->
<div class="clear"></div>
 
<!-- ########################################Footer######################################## --> 
<div class="footer-holder">
    <div class="footer">
    	<p class="left">Actualizado para HTML5/CSS3 - Para su correcto funcionamiento recomendamos usar Firefox 3.6 o Internet explorer 7.0 - Copyright 2011. </p>
          
        <a class="rss" href="#">Subir</a>
    </div>
</div>
<!-- ########################################End Footer######################################## -->
<script type="text/javascript">
//<![CDATA[
/* Replacement calls. Please see documentation for more information. */

if(typeof sIFR == "function"){

// This is the older, ordered syntax

        sIFR.replaceElement(named({sSelector:"body h1", sFlashSrc:"sifr/h1.swf", sColor:"#ffffff", sLinkColor:"#ffffff", sBgColor:"#FFFFFF", sHoverColor:"#ffffff", sWmode:"transparent"}));
        sIFR.replaceElement(named({sSelector:"body .box-holder h2.white", sFlashSrc:"sifr/h2.swf", sColor:"#ffffff", sLinkColor:"#ffffff", sBgColor:"#FFFFFF", sHoverColor:"#6F6F6F", sWmode:"transparent"}));
        sIFR.replaceElement(named({sSelector:"body h2", sFlashSrc:"sifr/h2.swf", sColor:"#000000", sLinkColor:"#C90000", sBgColor:"#FFFFFF", sHoverColor:"#6F6F6F", sWmode:"transparent"}));
        
        sIFR.replaceElement(named({sSelector:"body h3", sFlashSrc:"sifr/h3.swf", sColor:"#000000", sLinkColor:"#0D112F", sBgColor:"#FFFFFF", sHoverColor:"#0D112F", sWmode:"transparent"}));
        sIFR.replaceElement(named({sSelector:"body h3.sidebox", sFlashSrc:"sifr/h3-sidebox.swf", sColor:"#32A700", sLinkColor:"#32A700", sBgColor:"#FFFFFF", sHoverColor:"#32A700", sWmode:"transparent"}));
        sIFR.replaceElement(named({sSelector:"body h4", sFlashSrc:"sifr/h4.swf", sColor:"#0D112F", sLinkColor:"#0D112F", sBgColor:"#FFFFFF", sHoverColor:"#0D112F", sWmode:"transparent"}));
        sIFR.replaceElement(named({sSelector:"body h4.subhead", sFlashSrc:"sifr/h4-subhead.swf", sColor:"#0D112F", sLinkColor:"#0D112F", sBgColor:"#FFFFFF", sHoverColor:"#0D112F", sWmode:"transparent"}));


};

//]]>
</script>
</body>
</html>
