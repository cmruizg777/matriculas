<?php
    $sql3 = "select 
                matricula.nmatricula,
                matricula.idalumno,
                C1  AS comp1q1,
                C2  AS comp2q1,
                C4  AS comp1q2,
                C5  AS comp2q2,
                C8  AS faltaj1q1,
                c12 AS faltaj2q1,
                (c8+c12) AS faltasjq1,
                C20 AS faltaj1q2,
                c24 AS faltaj2q2,
                (c20+c24) AS faltasjq2,
                (c8+c12+c20+c24) AS faltasj,
                C9  AS faltai1q1,
                c13 AS faltai2q1,
                (c9+c13) AS faltasiq1,
                C21 AS faltai1q2,
                c25 AS faltai2q2,
                (c21+c25) AS faltasiq2,
                (c9+c13+c21+c25) AS faltasi,
                C10 AS atraso1q1,
                C14 AS atraso2q1,
                (c10+c14) AS atrasoq1,
                C22 AS atraso1q2,
                C26 AS atraso2q2,
                (c22+c26) AS atrasoq2,
                (c10+c14+c22+c26) AS atrasos,
                C7  AS diasa1q1,
                C11 AS diasa2q1,
                (c7+c11) AS diasaq1,
                C19 AS diasa1q2,
                C23 AS diasa2q2,
                (c19+c23) AS diasaq2,
                (c7+c11+c19+c23) AS diasa 
                from alumnos,matricula,comportamiento 
                where matricula.idcurso=? 
                AND alumnos.idalumno=matricula.idalumno 
                AND matricula.Nmatricula=comportamiento.Nmatricula
                AND alumnos.idalumno=?";

$comportamiento = new CMySQL1($conn, $sql3, array($idcurso, $idalumno));
echo '<div class="col-md-6">';
?>

<table class="table table-responsive-sm table-bordered table-hover table-small" id="comportamiento">
    <thead>
    <tr class="bg-dark">
        <th colspan="9">Comportamiento y Asistencia</th>
    </tr>
    <tr class="bg-primary">
        <th rowspan="2">DETALLE</th>
        <th colspan="3">QUIMESTRE 1</th>
        <th colspan="3">QUIMESTRE 2</th>
        <th rowspan="2">TOTAL</th>
    </tr>
    <tr>
        <th>P1</th>
        <th>P2</th>
        <th>TQ1</th>
        <th>P1</th>
        <th>P2</th>
        <th>TQ2</th
    </tr>
    </thead>
    <tbody>
        <?php
        do{
            echo '<tr>';
            printf('<th>%s</th>','COMPORTAMIENTO');
            printf('<td>%s</td>',$comportamiento->Row['comp1q1']);
            printf('<td>%s</td>',$comportamiento->Row['comp2q1']);
            printf('<td></td>');
            printf('<td>%s</td>',$comportamiento->Row['comp1q2']);
            printf('<td>%s</td>',$comportamiento->Row['comp1q2']);
            printf('<td></td>');
            printf('<td></td>');
            echo '</tr>';
            echo '<tr>';
            printf('<th>%s</th>','FALTAS JUSTIFICAS');
            printf('<td>%s</td>',$comportamiento->Row['faltaj1q1']);
            printf('<td>%s</td>',$comportamiento->Row['faltaj2q1']);
            printf('<td>%s</td>',$comportamiento->Row['faltasjq1']);
            printf('<td>%s</td>',$comportamiento->Row['faltaj1q2']);
            printf('<td>%s</td>',$comportamiento->Row['faltaj2q2']);
            printf('<td>%s</td>',$comportamiento->Row['faltasjq2']);
            printf('<td>%s</td>',$comportamiento->Row['faltasj']);
            echo '</tr>';
            echo '<tr>';
            printf('<th>%s</th>','FALTAS INJUSTIFICAS');
            printf('<td>%s</td>',$comportamiento->Row['faltai1q1']);
            printf('<td>%s</td>',$comportamiento->Row['faltai2q1']);
            printf('<td>%s</td>',$comportamiento->Row['faltasiq1']);
            printf('<td>%s</td>',$comportamiento->Row['faltai1q2']);
            printf('<td>%s</td>',$comportamiento->Row['faltai2q2']);
            printf('<td>%s</td>',$comportamiento->Row['faltasiq2']);
            printf('<td>%s</td>',$comportamiento->Row['faltasi']);
            echo '</tr>';
            echo '<tr>';
            printf('<th>%s</th>','ATRASOS');
            printf('<td>%s</td>',$comportamiento->Row['atraso1q1']);
            printf('<td>%s</td>',$comportamiento->Row['atraso2q1']);
            printf('<td>%s</td>',$comportamiento->Row['atrasoq1']);
            printf('<td>%s</td>',$comportamiento->Row['atraso1q2']);
            printf('<td>%s</td>',$comportamiento->Row['atraso2q2']);
            printf('<td>%s</td>',$comportamiento->Row['atrasoq2']);
            printf('<td>%s</td>',$comportamiento->Row['atrasos']);
            echo '</tr>';
            echo '<tr>';
            printf('<th>%s</th>','DIAS ASISTIDOS');
            printf('<td>%s</td>',$comportamiento->Row['diasa1q1']);
            printf('<td>%s</td>',$comportamiento->Row['diasa2q1']);
            printf('<td>%s</td>',$comportamiento->Row['diasaq1']);
            printf('<td>%s</td>',$comportamiento->Row['diasa1q2']);
            printf('<td>%s</td>',$comportamiento->Row['diasa2q2']);
            printf('<td>%s</td>',$comportamiento->Row['diasaq2']);
            printf('<td>%s</td>',$comportamiento->Row['diasa']);
            echo '</tr>';
        }while($comportamiento->GetRow());
        echo '</tbody></table></div>'
        ?>
