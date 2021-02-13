<?php
    $sql2 = "select 
                avg(c95) as autoevaluacion,
                avg(c139) as parcial1,
                avg(c140) as parcial2,
                avg(((c139+c140)/2)) as promediop,
                avg(((c139+c140)/2)*0.80) as promediop80,
                avg(C157) as examen,
                avg(ex120) as examen20,
                avg((((c139+c140)/2)*0.8)+(ex120)) as promedioq,
                IF(avg((((c139+c140)/2)*0.8)+(ex120)) = 0, \" \", IF(avg((((c139+c140)/2)*0.8)+(ex120)) <= 4, \"NA\", IF(avg(((((c139+c140)/2)*0.8)+(ex120))) < 7, \"PA\", IF(avg(((((c139+c140)/2)*0.8)+(ex120))) < 9, \"AA\", IF(avg(((((c139+c140)/2)*0.8)+(ex120))) <= 10, \"DA\", \"\"))))) AS eq,
                avg(c96) as autoevaluacion2,
                avg(c142) as parcial12,
                avg(c143) as parcial22,
                avg(((c142+c143)/2)) as promediop2,
                avg(((c142+c143)/2)*0.80) as promediop802,
                avg(C155) as examen2,
                avg(ex220) as examen202,
                avg((((c142+c143)/2)*0.8)+(ex220)) as promedioq2,
                IF(avg((((c142+c143)/2)*0.8)+(ex220)) = 0, \" \", IF(avg((((c142+c143)/2)*0.8)+(ex220)) <= 4, \"NA\", IF(avg(((((c142+c143)/2)*0.8)+(ex220))) < 7, \"PA\", IF(avg(((((c142+c143)/2)*0.8)+(ex220))) < 9, \"AA\", IF(avg(((((c142+c143)/2)*0.8)+(ex220))) <= 10, \"DA\", \"\"))))) AS eq2
                from slqnotasunion_aux,cursos,materias,periodo,profesores 
                where periodo.idperiodo=slqnotasunion_aux.idperiodo 
                and cursos.idirigente=profesores.idprofesor 
                and materias.idmateria=slqnotasunion_aux.idmateria 
                And cursos.idcurso=slqnotasunion_aux.idcurso 
                And cursos.idcurso=? 
                And evaluada != 'No'
                And slqnotasunion_aux.idalumno=? order by slqnotasunion_aux.orden ASC";

$promedio = new CMySQL1($conn, $sql2, array($idcurso, $idalumno));

do{
    echo "<tr class='table-active'>";
    printf("<th>%s</th>",PROMEDIOS);
    printf("<td>%.2f</td>",round($promedio->Row['parcial1'],2));
    printf("<td>%.2f</td>",round($promedio->Row['parcial2'],2));
    printf("<td>%.2f</td>",round($promedio->Row['promediop'],2));
    printf("<td>%.2f</td>",round($promedio->Row['promedio80'],2));
    printf("<td>%.2f</td>",round($promedio->Row['autoevaluacion'],2));
    printf("<td>%.2f</td>",round($promedio->Row['examen'],2));
    printf("<td>%.2f</td>",round($promedio->Row['examen20'],2));
    printf("<td class='%s'>%.2f</td>",getBG(round($promedio->Row['promedioq'],2)),round($promedio->Row['promedioq'],2));
    printf("<td>%s</td>",$promedio->Row['eq']);
    printf("<td>%.2f</td>",round($promedio->Row['parcial12'],2));
    printf("<td>%.2f</td>",round($promedio->Row['parcial22'],2));
    printf("<td>%.2f</td>",round($promedio->Row['promediop2'],2));
    printf("<td>%.2f</td>",round($promedio->Row['promedio802'],2));
    printf("<td>%.2f</td>",round($promedio->Row['autoevaluacion2'],2));
    printf("<td>%.2f</td>",round($promedio->Row['examen2'],2));
    printf("<td>%.2f</td>",round($promedio->Row['examen202'],2));
    printf("<td class='%s'>%.2f</td>",getBG(round($promedio->Row['promedioq2'],2)),round($promedio->Row['promedioq2'],2));
    printf("<td>%s</td>",$promedio->Row['eq']);
    $q1 = $promedio->Row['promedioq'];
    $q2 = $promedio->Row['promedioq2'];
    $prom = ($q1 + $q2)/2;
    printf("<td class='%s'>%.2f</td>",getBG(round($prom,2)),round($prom,2));
    echo '</tr>';
}while ($promedio->GetRow());




