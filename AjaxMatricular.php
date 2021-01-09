<?php require_once('clases/connection.php'); ?>
<?php require("usuarios/aut_verifica.inc.php"); ?>
<?php
error_reporting (5);
$nivel_acceso=10; 
if ($nivel_acceso <= $_COOKIE['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

$conn=getDatabaseConnection1($_COOKIE['base']);
if($_POST['idalumno']>0){
		$Omatricula=new CMySQL1($conn,"select  	Nmatricula from matricula  where idalumno=? and  idperiodo=? and  idcurso=?",array($_POST['idalumno'],$_POST['idperiodo'],$_POST['idcurso']));
		if($Omatricula->GetNRows()==0){
			$Odatos=new CMySQL1($conn,"select * from alumnos where idalumno=?",array($_POST['idalumno']));
			$repre=($Odatos->Row['padre']!="")?$Odatos->Row['padre']:$Odatos->Row['madre'];
			$qrepre=($Odatos->Row['padre']!="")?"P":"M";
			$ccr=($qrepre=="P")?$Odatos->Row['ccp']:$Odatos->Row['ccm'];
			$repre=($repre!="")?$repre:" ";
			$Ofolio=new CMySQL1($conn,"select max(folio) as folio from matricula",array(1));
			$folio=($Ofolio->Row['folio']=="")?0:$Ofolio->Row['folio']+1;
			$OMat=new CMySQL("INSERT INTO matricula( idalumno, idperiodo, idcurso, representante, telefonoR, fecha, estado, procedencia, observaciones, folio, mail, vecesm, quienr, pasaporter, ccr, fretiro, bi, idbi, q1, q2, pr, migrado) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?)",$_COOKIE['base'],array($_POST['idalumno'],$_POST['idperiodo'],$_POST['idcurso'],$repre,$Odatos->Row['telefono'],date("d/m/Y"),1," ","Matricula en Linea",$folio,($Odatos->Row['mail']=="")?" ":$Odatos->Row['mail'],1,$qrepre,0,$ccr," ",0,0,0,0,0,0));
			$id=$OMat->GetLastId();
		}
	}
$conn=null;
echo $id;

