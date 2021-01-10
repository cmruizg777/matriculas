<?php require_once('clases/connection.php'); ?>
<?php require("usuarios/aut_verifica.inc.php"); ?>
<?php
error_reporting (5);
$nivel_acceso=10; 
if ($nivel_acceso <= $_COOKIE['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	//print_r($_POST);
		$conn=getDatabaseConnection1($_COOKIE['base'],$_COOKIE['server']);
		if($_POST['idalumno']>0){
		    //print_r($_COOKIE['base']);
            //print_r($_COOKIE['server']);
			$OEmp=new CMySQL(
                //"UPDATE alumnos SET   where idalumno=?",
                "UPDATE alumnos SET  ci=?, alumno=?,  nacionalidad=?, fechaN=?, lugarN=?, sexo=?, idetnias=?, 
                              telefono=?, direccion=?, padre=?, padreP=?, madre=?, madreP=?, nhijos=?, orden=?, organizacion=?, 
                              pasaporte=?, ccp=?, ccm=?, mail=?, 	grupo_etnia=? ,provincia=?, canton=?, 
                              telp=?,telm=?,actividades=?,enfermedad=?,referencia=?,insp=?,insm=?,ecp=?,ecm=?,discapacidad=?,
                              carnet=?,tipo_discapacidad=?,porcentaje=?, familiar=?, telefonof=?, direccionf=? where idalumno=?",
                $_COOKIE['base'],
                $_COOKIE['server'],
                array(
                    $_POST['ci'],
                    $_POST['alumno'],
                    $_POST['nacionalidad'],
                    $_POST['fechaN'],
                    $_POST['lugarN'],
                    $_POST['sexo'],
                    $_POST['idetnias'],
                    $_POST['telefono'],
                    $_POST['direccion'],
                    $_POST['padre'],
                    $_POST['padreP'],
                    $_POST['madre'],
                    $_POST['madreP'],
                    $_POST['nhijos'],
                    $_POST['orden'],
                    $_POST['organizacion'],
                    11,
                    $_POST['ccp'],
                    $_POST['ccm'],
                    $_POST['mail'],
                    " ",
                    $_POST['provincia'],
                    $_POST['canton'],
                    $_POST['telp'],
                    $_POST['telm'],
                    $_POST['actividades'],
                    $_POST['enfermedad'],
                    $_POST['referencia'],
                    $_POST['insp'],
                    $_POST['insm'],
                    $_POST['ecp'],
                    $_POST['ecm'],
                    $_POST['discapacidad'],
                    $_POST['carnet'],
                    $_POST['tipo_discapacidad'],
                    $_POST['porcentaje'],
                    $_POST['nfamiliar'],
                    $_POST['telefonof'],
                    $_POST['direccionf'],
                    $_POST['idalumno'])
            );

			$OEmp=new CMySQL(
                "update preinscripcion set ci=? where ci=?",
                $_COOKIE['base'],
                $_COOKIE['server'],
                array($_POST['ci'],$_COOKIE['ci'])
            );

			setcookie('ci',$_POST['ci'],time() + 365 * 24 * 60 * 60,'/');
			$id=$_POST['idalumno'];
			$Omat=new CMySQL(
			    "SELECT Nmatricula FROM `matricula` WHERE idalumno=? and estado=? order by Nmatricula desc limit 1",
                $_COOKIE['base'],
                $_COOKIE['server'],
                array($id,1));
			$OEmp=new CMySQL(
			    "select id from medios_comunicaion where nmatricula=?",
                $_COOKIE['base'],
                $_COOKIE['server'],
                array($Omat->Row['Nmatricula']));
			if($OEmp->GetNRows()==0)
				$OEmp=new CMySQL(
				    "INSERT INTO medios_comunicaion( nmatricula, internet, tipointernet, nusuarios, comunicacion, asig_favoritas, asig_dificiles) VALUES(?,?,?,?,?, ?,?)",
                    $_COOKIE['base'],
                    $_COOKIE['server'],
                    array($Omat->Row['Nmatricula'], $_POST['internet'], $_POST['tipointernet'],$_POST['nusuarios'], $_POST['comunicacion'], $_POST['asig_favoritas'],$_POST['asig_dificiles'])
                );
			else{
				$OEmp=new CMySQL(
				    "update medios_comunicaion set  internet=?, tipointernet=?, nusuarios=?, comunicacion=?, asig_favoritas=?, asig_dificiles=?  where id=?",
                    $_COOKIE['base'],
                    $_COOKIE['server'],
                    array($_POST['internet'],$_POST['tipointernet'],$_POST['nusuarios'], $_POST['comunicacion'], $_POST['asig_favoritas'],$_POST['asig_dificiles'],$OEmp->Row['id']));
				$OEmp=new CMySQL(
				    "update matricula set  representante=?, insr=?, profr=?, telefonoR=?, ccr=?  where Nmatricula=?",
                            $_COOKIE['base'],
                            $_COOKIE['server'],
                            array($_POST['representante'],$_POST['insr'], $_POST['profr'], $_POST['telefonoR'],$_POST['ccr'],$Omat->Row['Nmatricula']));
			}
		}else{
			$OEmp=new CMySQL(
			    "INSERT INTO alumnos( ci, alumno,  nacionalidad, fechaN, lugarN, sexo, idetnias, telefono, direccion, padre, padreP, madre, madreP, nhijos, orden, organizacion, pasaporte, ccp, ccm, mail, 	grupo_etnia , provincia, canton, discapacidad, carnet, tipo_discapacidad, porcentaje, familiar, telefonof, direccionf) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,? ,?,?,?,?,?)",
                $_COOKIE['base'],
                $_COOKIE['server'],
                array($_POST['ci'],$_POST['alumno'],$_POST['nacionalidad'],$_POST['fechaN'],$_POST['lugarN'],$_POST['sexo'],1,$_POST['telefono'],$_POST['direccion'],$_POST['padre'],$_POST['padreP'],$_POST['madre'],$_POST['madreP'],$_POST['nhijos'],$_POST['orden'],$_POST['organizacion'],11,$_POST['ccp'],$_POST['ccm'],$_POST['mail']," ",$_POST['provincia'],$_POST['canton'],1,0,0,0,$_POST['nfamiliar'],$_POST['telefonof'],$_POST['direccionf']));
			$id=$OEmp->GetLastId();
			 setcookie('id_alumno',$id,time() + 365 * 24 * 60 * 60,'/');
			 $OEmp->SetQuery("update preinscripcion set ci=? where ci=?",array($_POST['ci'],$_COOKIE['ci']));
			 setcookie('ci',$_POST['ci'],time() + 365 * 24 * 60 * 60,'/');
		}
$conn=null;
echo $id;;
}  

