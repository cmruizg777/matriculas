<?php require_once('clases/connection.php'); ?>
<?php require_once('allfiles/programas.php'); 
require("usuarios/aut_verifica.inc.php"); 
$Ocol=new CMySQL("select * from datos where idinstitucion=?","bddinstituciones",array($_COOKIE['idinst']));
//$Oper=new CMySQL("select idperiodo from periodo order by idperiodo desc limit 1",$_COOKIE['base'],array(1));
$Oper=new CMySQL("SELECT idperiodo FROM `slqnotasunion` WHERE idalumno=? order by idnota desc limit 1",$_COOKIE['base'],array($_COOKIE['id_alumno']));
 //print_r($_COOKIE);exit;
$Odet=new CMySQL("SELECT *,cursos.curso,periodo.periodo,materias.materia FROM `slqnotasunion`,cursos,periodo,.materias WHERE cursos.idcurso=slqnotasunion.idcurso and  materias.idmateria=slqnotasunion.idmateria and periodo.idperiodo=slqnotasunion.idperiodo  and slqnotasunion.idalumno=? and slqnotasunion.idperiodo=? ORDER BY materias.materia ASC",$_COOKIE['base'],array($_COOKIE['id_alumno'],$Oper->Row['idperiodo']));
if ($Odet->GetNRows()==0)
$Odet->SetQuery("SELECT *,cursos.curso,periodo.periodo,materias.materia FROM `slqnotasunion`,cursos,periodo,.materias WHERE cursos.idcurso=slqnotasunion.idcurso and  materias.idmateria=slqnotasunion.idmateria and periodo.idperiodo=slqnotasunion.idperiodo  and slqnotasunion.idalumno=? and slqnotasunion.idperiodo=? ORDER BY materias.materia ASC",array($_COOKIE['id_alumno'],$Oper->Row['idperiodo']));
//echo $_COOKIE['base']." ".$_COOKIE['ci']]." ".$Oper->Row['idperiodo'];
$Oprof=new CMySQL("select abreviatura,nombre from profesores where idprofesor=?",$_COOKIE['base'],array($Odet->Row['idirigente']));
$pdf = new Creport('a4','landscape');
$pdf -> ezSetcmMargins(1.5,1.5,1.5,1);
// put a line top and bottom on all the pages
$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0,0,0,1);
$imagee = imagecreatefromjpeg("data:image/jpeg;base64,".base64_encode($Ocol->Row['logo']));
$pdf->addImage($imagee,35,765,100);//$pdf->line(20,25,578,25);

//$imagee = imagecreatefrompng("files/".$_SESSION['Logo']);
//$pdf->addImage($imagee,65,779,100);
//$pdf->line(20,40,550,40);
$pdf->ezStartPageNumbers(440,30,9,'right',utf8_decode(' Página {PAGENUM} de {TOTALPAGENUM}'));
$pdf->saveState();
$pdf->restoreState();
$pdf->closeObject();
// note that object can be told to appear on just odd or even pages by changing 'all' to 'odd'
// or 'even'.
$pdf->addObject($all,'all');
//$mainFont = './fonts/Helvetica.afm';
$mainFont = '/fonts/Times-Roman.afm';
$codeFont = '/fonts/Courier.afm';
//select a font
 //(img,x,y,w,[h],[quality=75]
//$pdf->ezImage('logoc.png',0, 90,'none', 'left');
//$imagee = imagecreatefromjpeg("files/{$Ocol->Row['base']}".".jpg");
//$pdf->addImage($imagee,35,500,65);
//$imagee = imagecreatefrompng("images/leducacion.png");
//$pdf->addImage($imagee,680,500,130);
//$pdf->ezImage("files/{$Ocol->Row['base']}".".jpg", 0, 65, 'none', 'left');
//$pdf->ezImage("images/leducacion.png", 0, 100, 'none', 'right');
$pdf->selectFont($mainFont);
$pdf->ezText("<b>".$Ocol->Row['nombre'],13,array('justification'=>'center'));
$pdf->ezText("REPORTE DE CALIFICACIONES</b>\n\n",13,array('justification'=>'center'));

$titles1 = array("l1"=>"","l2"=>"","l3"=>"","l4"=>"");
$data[]=array("l1"=>"<b>NOMBRE:</b>","l2"=>$Odet->Row['alumno'],"l3"=>"<b>CURSO/GRADO:</b>","l4"=>$Odet->Row['curso']);
$data[]=array("l1"=>"<b>PERIODO LECTIVO:</b>","l2"=>$Odet->Row['periodo'],"l3"=>"<b>TUTOR(A):</b>","l4"=>$Oprof->Row['abreviatura']." ".$Oprof->Row['nombre']);
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>0,'showLines'=>0,'fontSize' => 10,'xOrientation' => 'center','width' =>650,'titleFontSize' => 8,'cols'=>array(				'l1'=>array('justification'=>'left','width'=>110),
									'l2'=>array('justification'=>'left','width'=>290),
									'l3'=>array('justification'=>'left','width'=>90),
									'l4'=>array('justification'=>'left','width'=>275)
								)));
unset($data);								
$titles1 = array('ASIGNATURA'=>'<b>ASIGNATURA', 'PRIMERQ'=>'PRIMER QUIMESTRE','SEGUNDOQ'=>'SEGUNDO QUIMESTRE','PROAN'=>'PRO ANUAL</b>');
$data[] = array('ASIGNATURA'=>'<b>ASIGNATURA', 'PRIMERQ'=>'PRIMER QUIMESTRE','SEGUNDOQ'=>'SEGUNDO QUIMESTRE','PROAN'=>'PRO ANUAL</b>');
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>0,'showLines'=>1,'fontSize' => 10,'xOrientation' => 'center','width' =>650,'titleFontSize' => 8,'cols'=>array(				'ASIGNATURA'=>array('justification'=>'left','width'=>150),
									'PRIMERQ'=>array('justification'=>'center','width'=>267),
									'SEGUNDOQ'=>array('justification'=>'center','width'=>267),
									'PROAN'=>array('justification'=>'center','width'=>83)
								)));
unset($data);								
$titles1 = array('ASIGNATURA'=>'<b>', 'PARCIALES'=>'PARCIALES','EXA1'=>'EXA','EXA2'=>'EXA','PRO1'=>'PRO','EC1'=>'EC', 'PARCIALES1'=>'PARCIALES','EXA11'=>'EXA','EXA22'=>'EXA','PRO11'=>'PRO','EC11'=>'EC','PRO111'=>'PRO','EC111'=>'EC</b>');
$data[] = array('ASIGNATURA'=>'<b>', 'PARCIALES'=>'PARCIALES','EXA1'=>'EXA','EXA2'=>'EXA','PRO1'=>'PRO','EC1'=>'EC', 'PARCIALES1'=>'PARCIALES','EXA11'=>'EXA','EXA22'=>'EXA','PRO11'=>'PRO','EC11'=>'EC','PRO111'=>'PRO','EC111'=>'EC</b>');
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>0,'showLines'=>1,'fontSize' => 8,'xOrientation' => 'center','width' =>650,'titleFontSize' => 10,'cols'=>array(				'ASIGNATURA'=>array('justification'=>'left','width'=>150),									'PARCIALES'=>array('justification'=>'center','width'=>151),
									'EXA1'=>array('justification'=>'center','width'=>29),
									'EXA2'=>array('justification'=>'center','width'=>29),
									'PRO1'=>array('justification'=>'center','width'=>29),
									'EC1'=>array('justification'=>'center','width'=>29),
									'PARCIALES1'=>array('justification'=>'center','width'=>151),
									'EXA11'=>array('justification'=>'center','width'=>29),
									'EXA22'=>array('justification'=>'center','width'=>29),
									'PRO11'=>array('justification'=>'center','width'=>29),
									'EC11'=>array('justification'=>'center','width'=>29),
									'PRO111'=>array('justification'=>'center','width'=>41),
									'EC111'=>array('justification'=>'center','width'=>42)
								)));
unset($data);	
$titles1 = array('ASIGNATURA'=>'<b>', 'P1'=>'P1', 'P2'=>'P2', 'P3'=>'P3', 'PRO'=>'PRO', 'P80'=>'80%','Q1'=>'Q1','P20'=>'20%','Q2'=>'Q1','Q3'=>'Q1', 'P11'=>'P1', 'P22'=>'P2', 'P33'=>'P3', 'PRO1'=>'PRO', 'P801'=>'80%','Q22'=>'Q2','P201'=>'20%','Q23'=>'Q2','Q24'=>'Q2','AN'=>'AN','AN1'=>'AN</b>');
$data[] = array('ASIGNATURA'=>'<b>', 'P1'=>'P1', 'P2'=>'P2', 'P3'=>'P3', 'PRO'=>'PRO', 'P80'=>'80%','Q1'=>'Q1','P20'=>'20%','Q2'=>'Q1','Q3'=>'Q1', 'P11'=>'P1', 'P22'=>'P2', 'P33'=>'P3', 'PRO1'=>'PRO', 'P801'=>'80%','Q22'=>'Q2','P201'=>'20%','Q23'=>'Q2','Q24'=>'Q2','AN'=>'AN','AN1'=>'AN</b>');
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>0,'showLines'=>1,'fontSize' => 8,'xOrientation' => 'center','width' =>650,'titleFontSize' => 10,'cols'=>array('ASIGNATURA'=>array('justification'=>'left','width'=>150),													
									'P1'=>array('justification'=>'right','width'=>30),
									'P2'=>array('justification'=>'right','width'=>30),
									'P3'=>array('justification'=>'right','width'=>30),
									'PRO'=>array('justification'=>'right','width'=>30),
									'P80'=>array('justification'=>'right','width'=>31),
									'Q1'=>array('justification'=>'right','width'=>29),
									'P20'=>array('justification'=>'right','width'=>29),
									'Q2'=>array('justification'=>'right','width'=>29),
									'Q3'=>array('justification'=>'right','width'=>29),
									'P11'=>array('justification'=>'right','width'=>30),
									'P22'=>array('justification'=>'right','width'=>30),
									'P33'=>array('justification'=>'right','width'=>30),
									'PRO1'=>array('justification'=>'right','width'=>30),
									'P801'=>array('justification'=>'right','width'=>31),
									'Q22'=>array('justification'=>'right','width'=>29),
									'P201'=>array('justification'=>'right','width'=>29),
									'Q23'=>array('justification'=>'right','width'=>29),
									'Q24'=>array('justification'=>'right','width'=>29),
									'AN'=>array('justification'=>'right','width'=>41),
									'AN1'=>array('justification'=>'right','width'=>42)
								)));
unset($data);	
 $p11=$p12=$p13=$p1=$p2=$p3=$nmat=$pro=$t80=$qq1=$t20=$qqq1=0;
   do{
  $nmat++;
  $p1+=$Odet->Row['c139'];
  $p2+=$Odet->Row['c140'];
  $p3+=$Odet->Row['c141'];
  $p11+=$Odet->Row['c142'];
  $p12+=$Odet->Row['c143'];
  $p13+=$Odet->Row['c144'];
  $pro+=($Odet->Row['c139']+$Odet->Row['c140']+$Odet->Row['c141'])/3;
  $t80+=(($Odet->Row['c139']+$Odet->Row['c140']+$Odet->Row['c141'])/3)*80/100;
  $qq1+=$Odet->Row['c157'];
  $t20+=$Odet->Row['c157']/5;
  $qqq1+=$Odet->Row['q1'];
  if($Odet->Row['c163']=="")
  	$q1="";
	if($Odet->Row['q1']>=9 and $Odet->Row['q1']<=10)
		$q1="DA";
	if($Odet->Row['q1']>=7 and $Odet->Row['q1']<=8.99)
		$q1="AA";
	if($Odet->Row['q1']>=4.01 and $Odet->Row['q1']<=6.99)
		$q1="PA";
	if($Odet->Row['q1']>=9 and $Odet->Row['q1']<=4)
		$q1="NA";	
if($Odet->Row['c139']!=0)
  $data[] = array('ASIGNATURA'=>$Odet->Row['materia'], 'P1'=> number_format($Odet->Row['c139'],2), 'P2'=>number_format($Odet->Row['c140'],2), 'P3'=>number_format($Odet->Row['c141'],2), 'PRO'=>number_format(($Odet->Row['c139']+$Odet->Row['c140']+$Odet->Row['c141'])/3,2), 'P80'=>number_format(($Odet->Row['c139']+$Odet->Row['c140']+$Odet->Row['c141'])/3*80/100,2),'Q1'=>number_format($Odet->Row['c157'],2),'P20'=>number_format($Odet->Row['c157']/5,2),'Q2'=>number_format($Odet->Row['q1'],2),'Q3'=>$q1, 'P11'=>number_format($Odet->Row['c142'],2),  'P22'=>number_format($Odet->Row['c143'],2), 'P33'=>($Odet->Row['c144']>0)?number_format($Odet->Row['c144'],2):"", 'PRO1'=>'', 'P801'=>'','Q22'=>'','P201'=>'','Q23'=>'','Q24'=>'','AN'=>'','AN1'=>'');
  }while($Odet->GetRow());
  
  
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>1,'showLines'=>1,'fontSize' => 7.5,'xOrientation' => 'center','width' =>650,'titleFontSize' => 10,'cols'=>array('ASIGNATURA'=>array('justification'=>'left','width'=>150),													
									'P1'=>array('justification'=>'right','width'=>30),
									'P2'=>array('justification'=>'right','width'=>30),
									'P3'=>array('justification'=>'right','width'=>30),
									'PRO'=>array('justification'=>'right','width'=>30),
									'P80'=>array('justification'=>'right','width'=>31),
									'Q1'=>array('justification'=>'right','width'=>29),
									'P20'=>array('justification'=>'right','width'=>29),
									'Q2'=>array('justification'=>'right','width'=>29),
									'Q3'=>array('justification'=>'right','width'=>29),
									'P11'=>array('justification'=>'right','width'=>30),
									'P22'=>array('justification'=>'right','width'=>30),
									'P33'=>array('justification'=>'right','width'=>30),
									'PRO1'=>array('justification'=>'right','width'=>30),
									'P801'=>array('justification'=>'right','width'=>31),
									'Q22'=>array('justification'=>'right','width'=>29),
									'P201'=>array('justification'=>'right','width'=>29),
									'Q23'=>array('justification'=>'right','width'=>29),
									'Q24'=>array('justification'=>'right','width'=>29),
									'AN'=>array('justification'=>'right','width'=>41),
									'AN1'=>array('justification'=>'right','width'=>42)
								)));
unset($data);	
$data[] = array('ASIGNATURA'=>"<b>PROMEDIOS</b>", 'P1'=> number_format($p1/$nmat,2), 'P2'=>number_format($p2/$nmat,2), 'P3'=>number_format($p3/$nmat,2), 'PRO'=>number_format((($p1+$p2+$p3)/3)/$nmat,2), 'P80'=>number_format((($p1+$p2+$p3)/3*80/100)/$nmat,2),'Q1'=>number_format($qq1/$nmat,2),'P20'=>number_format($t20/$nmat,2),'Q2'=>number_format($qqq1/$nmat,2),'Q3'=>'', 'P11'=>number_format($p11/$nmat,2),  'P22'=>number_format($p12/$nmat,2), 'P33'=>($p13>0)?number_format($p13/$nmat,2):"", 'PRO1'=>'', 'P801'=>'','Q22'=>'','P201'=>'','Q23'=>'','Q24'=>'','AN'=>'','AN1'=>'');
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>1,'showLines'=>1,'fontSize' => 7.5,'xOrientation' => 'center','width' =>650,'titleFontSize' => 10,'cols'=>array('ASIGNATURA'=>array('justification'=>'left','width'=>150),													
									'P1'=>array('justification'=>'right','width'=>30),
									'P2'=>array('justification'=>'right','width'=>30),
									'P3'=>array('justification'=>'right','width'=>30),
									'PRO'=>array('justification'=>'right','width'=>30),
									'P80'=>array('justification'=>'right','width'=>31),
									'Q1'=>array('justification'=>'right','width'=>29),
									'P20'=>array('justification'=>'right','width'=>29),
									'Q2'=>array('justification'=>'right','width'=>29),
									'Q3'=>array('justification'=>'right','width'=>29),
									'P11'=>array('justification'=>'right','width'=>30),
									'P22'=>array('justification'=>'right','width'=>30),
									'P33'=>array('justification'=>'right','width'=>30),
									'PRO1'=>array('justification'=>'right','width'=>30),
									'P801'=>array('justification'=>'right','width'=>31),
									'Q22'=>array('justification'=>'right','width'=>29),
									'P201'=>array('justification'=>'right','width'=>29),
									'Q23'=>array('justification'=>'right','width'=>29),
									'Q24'=>array('justification'=>'right','width'=>29),
									'AN'=>array('justification'=>'right','width'=>41),
									'AN1'=>array('justification'=>'right','width'=>42)
								)));
$pdf->ezText("\n",13,array('justification'=>'center'));
$titles1 = array("l1"=>"","l2"=>"");
$data[]=array("l1"=>"<b>ESCALA DE EVALUACION DEL COMPORTAMIENTO</b>","l2"=>"ESCALA DE CALIFICACIONES DEL RENDIMIENTO ACADEMICO");
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>0,'showLines'=>1,'fontSize' => 8,'xOrientation' => 'center','width' =>650,'titleFontSize' => 8,'cols'=>array('l1'=>array('justification'=>'left','width'=>282),
									'l2'=>array('justification'=>'left','width'=>283)
								)));
unset($data);		
$titles1 = array("f1"=>"","f2"=>"","f3"=>"","f11"=>"","f22"=>"","f33"=>"");
$data[]=array("f1"=>"A","f2"=>"MUY SATISFACTORIO","f3"=>"Lidera el cumplimiento de los compromisos establecidos para la sana convivencia social","f11"=>"DA","f22"=>"DOMINS LOS APRENDIZAJES REQUERIDOS","f33"=>"9 A 10");
$data[]=array("f1"=>"B","f2"=>"SATISFACTORIO","f3"=>"Cumple con los compromisos establecidos para la sana convivencia social","f11"=>"AA","f22"=>"ALCANZA LOS APREDIZAJES REQUERIDOS","f33"=>"7 A 8.99");
$data[]=array("f1"=>"C","f2"=>"POCO SATISFACTORIO","f3"=>"Falla ocacionalmente en el cumplimiento de los compromisos establecidos para la sana convivencia social","f11"=>"PA","f22"=>"PROXIMO A ALCANZAR LOS APREDIZAJES REQUERIDOS","f33"=>"4.01 A 6.99");
$data[]=array("f1"=>"D","f2"=>"MEJORABLE","f3"=>"Falla reiteradamente en el cumplimiento de los compromisos establecidos para la sana convivencia social","f11"=>"NA","f22"=>"NO ALCANZA LOS APREDIZAJES REQUERIDOS","f33"=>"0 A 4");
$data[]=array("f1"=>"E","f2"=>"INSATISFACTORIO","f3"=>"No cumple con los compromisos establecidos para la sana convivencia social","f11"=>"","f22"=>"","f33"=>"");
$pdf->ezTable($data,$titles1,'',array('showHeadings'=>0,'shaded'=>0,'showLines'=>1,'fontSize' =>6,'xOrientation' => 'center','width' =>650,'titleFontSize' => 8,'cols'=>array('f1'=>array('justification'=>'left','width'=>20),
									'f2'=>array('justification'=>'left','width'=>84),
									'f3'=>array('justification'=>'left','width'=>178),
									'f11'=>array('justification'=>'left','width'=>20),
									'f22'=>array('justification'=>'left','width'=>179),
									'f33'=>array('justification'=>'left','width'=>84),
								)));
unset($data);		
						
$pdf->ezStream();