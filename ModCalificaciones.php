
<?php
    $sql1 = "select 
                periodo.periodo as periodo,
                cursos.curso as curso,
                materias.materia as materia,
                profesores.abreviatura as abreviatura,
                profesores.nombre as nombre,
                slqnotasunion_aux.evaluada as evaluada,
                slqnotasunion_aux.alumno as alumno,
                slqnotasunion_aux.ci as ci,
                slqnotasunion_aux.nmatricula as nmatricula,
                c95 as autoevaluacion,
                c139 as parcial1,
                c140 as parcial2,
                ((c139+c140)/2) as promediop,
                ((c139+c140)/2)*0.80 as promediop80,
                C157 as examen,
                ex120 as examen20,
                (((c139+c140)/2)*0.8)+(ex120) as promedioq,
                IF((((c139+c140)/2)*0.8)+(ex120) = 0, \" \", IF((((c139+c140)/2)*0.8)+(ex120) <= 4, \"NA\", IF(((((c139+c140)/2)*0.8)+(ex120)) < 7, \"PA\", IF(((((c139+c140)/2)*0.8)+(ex120)) < 9, \"AA\", IF(((((c139+c140)/2)*0.8)+(ex120)) <= 10, \"DA\", \"\"))))) AS eq,
                c96 as autoevaluacion2,
                c142 as parcial12,
                c143 as parcial22,
                ((c142+c143)/2) as promediop2,
                ((c142+c143)/2)*0.80 as promediop802,
                C155 as examen2,
                ex220 as examen202,
                (((c142+c143)/2)*0.8)+(ex220) as promedioq2,
                IF((((c142+c143)/2)*0.8)+(ex220) = 0, \" \", IF((((c142+c143)/2)*0.8)+(ex220) <= 4, \"NA\", IF(((((c142+c143)/2)*0.8)+(ex220)) < 7, \"PA\", IF(((((c142+c143)/2)*0.8)+(ex220)) < 9, \"AA\", IF(((((c142+c143)/2)*0.8)+(ex220)) <= 10, \"DA\", \"\"))))) AS eq2,
                c160 as suple 
                from slqnotasunion_aux,cursos,materias,periodo,profesores 
                where periodo.idperiodo=slqnotasunion_aux.idperiodo 
                and cursos.idirigente=profesores.idprofesor 
                and materias.idmateria=slqnotasunion_aux.idmateria 
                And cursos.idcurso=slqnotasunion_aux.idcurso 
                And cursos.idcurso=? 
                And slqnotasunion_aux.idalumno=? order by slqnotasunion_aux.orden ASC";
$notas = new CMySQL1($conn, $sql1, array($idcurso, $idalumno));
do{
    echo "<tr>";
    printf("<td>%s</td>",$notas->Row['materia']);
    printf("<td>%.2f</td>",round($notas->Row['parcial1'],2));
    printf("<td>%.2f</td>",round($notas->Row['parcial2'],2));
    printf("<td>%.2f</td>",round($notas->Row['promediop'],2));
    printf("<td>%.2f</td>",round($notas->Row['promedio80'],2));
    printf("<td>%.2f</td>",round($notas->Row['autoevaluacion'],2));
    printf("<td>%.2f</td>",round($notas->Row['examen'],2));
    printf("<td>%.2f</td>",round($notas->Row['examen20'],2));
    printf("<td class='%s'>%.2f</td>",getBG(round($notas->Row['promedioq'],2)),round($notas->Row['promedioq'],2));
    printf("<td>%s</td>",$notas->Row['eq']);
    printf("<td>%.2f</td>",round($notas->Row['parcial12'],2));
    printf("<td>%.2f</td>",round($notas->Row['parcial22'],2));
    printf("<td>%.2f</td>",round($notas->Row['promediop2'],2));
    printf("<td>%.2f</td>",round($notas->Row['promedio802'],2));
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
