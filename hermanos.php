<?php require_once('clases/connection.php'); ?>
<?php require("usuarios/aut_verifica.inc.php"); ?>
<?php


try{
	$nivel_acceso=10;
	if ($nivel_acceso <= $_COOKIE['usuario_nivel']){
		header ("Location: $redir?error_login=5");
		exit;
	}
	$conn=getDatabaseConnection1($_COOKIE['base']);

	$action = $_POST['action'];
	echo 'step1';

	if($action == 1) {
		$OParr = new CMySQL1(
			$conn,
			"select * from hermanos where (al1=? and al2=?) OR (al1=? and al2=?) ",
			array($_POST['al1'], $_POST['al2'], $_POST['al2'], $_POST['al1'])
		);
		if($OParr->GetNRows()==0){
			$OParr = new CMySQL1($conn,"INSERT INTO hermanos(al1, al2) VALUES (?,?)",array($_POST['al1'],$_POST['al2']));
		}
	}elseif ($action == 2){
		$OParr=new CMySQL1(
			$conn,
			"delete from hermanos where (al1=? and al2=?) OR (al1=? and al2=?)",
			array($_POST['al1'],$_POST['al2'],$_POST['al2'],$_POST['al1'])
		);
	}

	$h1=new CMySQL1($conn,"SELECT * FROM hermanos where al1=?",array($_POST['al1']));
	$html='';
	do{
		$Oal=new CMySQL1($conn,"SELECT idalumno,alumno FROM alumnos WHERE idalumno=?  order by alumnos.alumno",array($h1->Row['al2']));
		$html.='<option value="'.$Oal->Row['idalumno'].'">'.$Oal->Row['alumno'].'</option>';
	}while($h1->GetRow());


	$h2=new CMySQL1($conn,"SELECT * FROM hermanos where al2=?",array($_POST['al1']));
	do{
		$Oal=new CMySQL1($conn,"SELECT idalumno,alumno FROM alumnos WHERE idalumno=?  order by alumnos.alumno",array($h1->Row['al1']));
		$html.='<option value="'.$Oal->Row['idalumno'].'">'.$Oal->Row['alumno'].'</option>';
	}while($h2->GetRow());
	echo $html;

}catch(Exception $ex){
	print_r($ex);
}

?>

