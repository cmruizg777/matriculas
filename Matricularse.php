<?php require_once('clases/connection.php'); ?>
<?php require("usuarios/aut_verifica.inc.php"); ?>
<?php
	$conn=getDatabaseConnection1($_COOKIE['base']);
$errors = array();
error_reporting (5);
$nivel_acceso=10; 
if ($nivel_acceso <= $_COOKIE['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
$action=$_COOKIE['id_alumno'];
$snom=array("","ERO","DO","RO","TO","TO","TO","MO","VO","NO","MO");
$OClie=new CMySQL1($conn,"select cursos.curso,periodo.periodo,periodo.idperiodo from matricula,periodo,cursos where matricula.idperiodo=periodo.idperiodo and cursos.idcurso=matricula.idcurso and matricula.idalumno=? order by matricula.Nmatricula desc limit 1 ",array($action));
if($_COOKIE['band']==0){
	$arr=explode(" ",$OClie->Row['curso']);
	$nc=substr($arr[0],0,1);
	$nc++;
	$nuevocurso=$nc.$snom[$nc]." ".$arr[1]." ".$arr[2];
	$nuevoperiodo=$OClie->Row['idperiodo']+1;
	$Onuevoperiodo=new CMySQL1($conn,"select distinct cursos.idcurso,cursos.curso,periodo.periodo,periodo.idperiodo from matricula,periodo,cursos where cursos.idperiodo=periodo.idperiodo and periodo.idperiodo=? and  cursos.curso=?",array($nuevoperiodo,$nuevocurso)); 
	$pperiodo=$Onuevoperiodo->Row['periodo'];
	$idcurso=$Onuevoperiodo->Row['idcurso'];
}else{
	$usuario_datos=new CMySQL1($conn,"SELECT  idcurso,curso, idperiodo from preinscripcion where ci=?",array($_COOKIE['ci']));
	$nuevocurso=$usuario_datos->Row['curso'];
	$nuevoperiodo=$usuario_datos->Row['idperiodo'];
	$Onuevoperiodo=new CMySQL1($conn,"select distinct cursos.idcurso,cursos.curso,periodo.periodo,periodo.idperiodo from matricula,periodo,cursos where cursos.idperiodo=periodo.idperiodo and periodo.idperiodo=? and  cursos.curso=?",array($nuevoperiodo,$nuevocurso)); 
	$pperiodo=$Onuevoperiodo->Row['periodo'];
	$idcurso=$Onuevoperiodo->Row['idcurso'];
}
$Omatricula=new CMySQL1($conn,"select  	Nmatricula from matricula  where idalumno=? and  idperiodo=? ",array($_COOKIE['id_alumno'],$_COOKIE['periodo']));
$matriculado=($Omatricula->GetNRows()>0)?1:0;
if($idcurso==""){
	$ocurso=new CMySQL1($conn,"SELECT  idcurso,idperiodo from preinscripcion where ci=? ",array($_COOKIE['ci']));
	$idcurso=$ocurso->Row['idcurso'];
	$nuevoperiodo=$ocurso->Row['idperiodo'];
	$OClie1=new CMySQL1($conn,"select distinct cursos.idcurso,cursos.curso,periodo.periodo,periodo.idperiodo from matricula,periodo,cursos where cursos.idperiodo=periodo.idperiodo and periodo.idperiodo=? and  cursos.idcurso=?",array($nuevoperiodo,$idcurso));
	$pperiodo=$OClie1->Row['periodo'];
	$nuevocurso=$OClie1->Row['curso'];
}	
?>
<head>
<script>

function Matricular(){
	if( $("#idalumno").val()>0){
	$.ajax({
		url:'AjaxMatricular.php',
		type:'POST',
		data:'idperiodo=<?php echo $nuevoperiodo?>&idcurso=<?php echo $idcurso?>&idalumno=<?php echo $_COOKIE['id_alumno']?>' ,
		}).done(function(respuesta){
			
			if(respuesta!=0){
				alertify.success('Su Matricula se ha registrado correctamente');
				setTimeout('redir()',2000);
			}else
				alertify.error('Ocurrion Algun Error Comuniquese con el Administrador');
		});
	}else{
		alertify.error('Primero debe Actualizar sus Datos Personales');
	}	
}

function redir(){
	window.location.href='index.php?forma=Matricularse.php';
}
</script>
</head>
<body>
<div class="card card-primary">
    <div class="card-header">
       <h3 class="card-title" id="titulo">Matriculaci&oacute;n en linea </h3>
              </div>
          <div class="card-body">
			<form role="form"  method="post" name="NuevoCli" id="NuevoCli" action="javascript:GuardaCliente()">
             <div class="box-body">
             <?php if($_COOKIE['id_alumno']>0):?>
             <?php if(!$matriculado):?>
             <div class="callout callout-info">
                  <h4>Curso Anterior</h4></br>

                  <p><b>Curso: </b><?php echo $OClie->Row['curso']?></p>
                  <p><b>Periodo: </b><?php echo $OClie->Row['periodo']?></p>
              </div>
            
  				<div class="callout callout-warning">
                  <h4>Curso A Matricularse</h4></br>

                  <p><b>Curso: </b><?php echo $nuevocurso?></p>
                  <p><b>Periodo: </b><?php echo $pperiodo?></p>
              </div>
               <button type="button" class="btn btn-block btn-success" onClick="Matricular()">Confirmar Matriculacion</button>
			</div> 
            <?php else:?>
           	 <div class="callout callout-warning"></br></br>
                 <h4>Esta Matriculado  en </h4></br>

                  <p><b>Curso: </b><?php echo $OClie->Row['curso']?></p>
                  <p><b>Periodo: </b><?php echo $OClie->Row['periodo']?></p>
              </div>
             
			</div> 
            <?php endif?>
            <?php else:?>
            <div class="callout callout-warning">
                  <h4>Para Matricularse debe registrar sus Datos</h4></br>

                  
              </div>
               <button type="button" class="btn btn-block btn-success" onClick="window.location.href='index.php?forma=ModAlumnos.php'">Registrar Datos</button>
            <?php endif?>
            <input type="hidden" id="idalumno" value="<?php echo $_COOKIE['id_alumno']?>">
</form>
  </div>
 </div> 
			</div> 

<?php $conn=null;?>
</body>


