
<?php
    $sql1 = "Select 
                ambitos.idambito, secuencia,orden,ambito,idsubambito,subambito 
                from ambitos inner join subambitos on ambitos.idambito=subambitos.idambito 
                where secuencia=3 and activo=1  order by orden,idsubambito asc ;";
            //"La secuencia es 1=inicial1, 2=inicial2, 3=primero de basica \"";
    //163 p1q1 164 p2q1 166 p1q2 167 p2q2 evaluada="No"
    $sql2 = "Select slqnotasunion1.*,profesores.abreviatura,profesores.nombre,periodo.periodo,cursos.idespecialidad 
                from slqnotasunion1,cursos,profesores,periodo 
                where periodo.idperiodo=slqnotasunion1.idperiodo and cursos.idcurso=slqnotasunion1.idcurso 
                And cursos.idirigente=profesores.idprofesor And cursos.idcurso=382 order by alumno asc ;";

    $notas = new CMySQL1($conn, $sql1, array($idcurso, $idalumno));

do{
    echo "<tr>";
        printf("<td>%s</td>",$notas->Row['materia']);
        printf("<td>%.2f</td>",round($notas->Row['parcial1'],2));
        printf("<td>%.2f</td>",round($notas->Row['parcial2'],2));
        printf("<td>%.2f</td>",round($notas->Row['promediop'],2));
        printf("<td>%.2f</td>",round($notas->Row['promediop80'],2));
        printf("<td>%.2f</td>",round($notas->Row['autoevaluacion'],2));
        printf("<td>%.2f</td>",round($notas->Row['examen'],2));
        printf("<td>%.2f</td>",round($notas->Row['examen20'],2));
        printf("<td class='%s'>%.2f</td>",getBG(round($notas->Row['promedioq'],2)),round($notas->Row['promedioq'],2));
        printf("<td>%s</td>",$notas->Row['eq']);
        printf("<td>%.2f</td>",round($notas->Row['parcial12'],2));
        printf("<td>%.2f</td>",round($notas->Row['parcial22'],2));
        printf("<td>%.2f</td>",round($notas->Row['promediop2'],2));
        printf("<td>%.2f</td>",round($notas->Row['promediop802'],2));
        printf("<td>%.2f</td>",round($notas->Row['autoevaluacion2'],2));
        printf("<td>%.2f</td>",round($notas->Row['examen2'],2));
        printf("<td>%.2f</td>",round($notas->Row['examen202'],2));
        printf("<td class='%s'>%.2f</td>",getBG(round($notas->Row['promedioq2'],2)),round($notas->Row['promedioq2'],2));
        printf("<td>%s</td>",$notas->Row['eq']);
        $q1 = $notas->Row['promedioq'];
        $q2 = $notas->Row['promedioq2'];
        $suple = $notas->Row['suple'];
        $prom = ($q1 + $q2)/2;
        $final = $prom;
        if($prom<7){
            $final = ($q1 + $q2 + $suple)/3;
        }
        printf("<td class='%s'>%.2f</td>",getBG(round($prom,2)),round($prom,2));
        printf("<td>%.2f</td>",round($notas->Row['suple'],2));
        printf("<td class='%s'>%.2f</td>",getBG(round($final,2)),round($final,2));
    echo '</tr>';
}while ($notas->GetRow());
