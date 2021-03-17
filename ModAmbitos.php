<?php require_once('clases/connection.php'); ?>
<?php require("usuarios/aut_verifica.inc.php"); ?>
<?php
    $sec = $_COOKIE['secuencia'];

    $sql1 = "Select 
	secuencia,orden,ambito,idsubambito,subambito , slqnotasunion1.*
    from ambitos 
	 inner join subambitos on ambitos.idambito=subambitos.idambito 
	 left join slqnotasunion1 ON slqnotasunion1.idambito=ambitos.idambito AND slqnotasunion1.idcurso=?
    where secuencia=? and activo=1 AND idalumno=? order by orden,idambito,idsubambito  ";

            //"La secuencia es 1=inicial1, 2=inicial2, 3=primero de basica \"";
    //163 p1q1 164 p2q1 166 p1q2 167 p2q2 evaluada="No"
    $sql2 = "Select slqnotasunion1.* 
                from slqnotasunion1,cursos,profesores,periodo 
                where periodo.idperiodo=slqnotasunion1.idperiodo and cursos.idcurso=slqnotasunion1.idcurso 
                And cursos.idirigente=profesores.idprofesor And cursos.idcurso=? and idalumno=? order by alumno asc ;";

$conn = getDatabaseConnection1($_COOKIE['base'], $_COOKIE['server']);
$errors = array();
error_reporting(5);
$nivel_acceso = 10;
if ($nivel_acceso <= $_COOKIE['usuario_nivel']) {
    header("Location: $redir?error_login=5");
    exit;
}
$idalumno = $_COOKIE['id_alumno'];
$idcurso  = $_COOKIE['id_curso'];

$ambitos = new CMySQL1($conn, $sql1, array($idcurso,$sec,$idalumno));

//$notas = new CMySQL1($conn, $sql2, array($idcurso, $idalumno));

?>
<head>
    <style>
        .table-small{
            font-size: 0.7rem !important;
        }
        .table-small td {
            padding: 0.2rem !important;
        }
    </style>
</head>
<body>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title" id="titulo"> Libreta de calificaciones</h3>
        <a href="./ModImprimir.php" target="_blank" class="btn btn-success float-sm-right" type="button" id="imprimir">
            Descargar/Imprimir
        </a>
    </div>

    <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-hover table-small" id="ambitos">
            <thead>
            <tr>
                <th rowspan="1">AMBITOS DE DESARROLLO Y APRENDIZAJE</th>
                <th colspan="4">PRIMER QUIMESTRE</th>
                <th colspan="4">SEGUNDO QUIMESTRE</th>
            </tr>

            </thead>
            <tbody>
            <?php

            $aux = '';
            $cont = 0;
            do{
                if($aux != $ambitos->Row['ambito']){
                    echo '<tr class="bg-primary">';
                    printf('<th>%s</th>',$ambitos->Row['ambito']);
                    echo '<th>I</th>';
                    echo '<th>EP</th>';
                    echo '<th>A</th>';
                    echo '<th>N/E</th>';
                    echo '<th>I</th>';
                    echo '<th>EP</th>';
                    echo '<th>A</th>';
                    echo '<th>N/E</th>';
                    echo '</tr>';
                    $cont=1;
                }
                $aux = $ambitos->Row['ambito'];
                echo "<tr>";
                printf("<td>%s</td>",$ambitos->Row['subambito']);
                $nota1 = $ambitos->Row["i$cont"];
                $cont2 = $cont +35;
                $nota2 = $ambitos->Row["i$cont2"];

                $a1 = getArrayNotas($nota1);
                $a2 = getArrayNotas($nota2);

                foreach ($a1 as $a){
                    printf("<td><h5>%s</h5></td>",$a);
                }
                foreach ($a2 as $a){
                    printf("<td><h5>%s</h5></td>",$a);
                }

                echo '</tr>';
                $cont++;
            }while ($ambitos->GetRow());

            function getArrayNotas($nota){
                $array_notas = ['','','',''];
                switch ($nota){
                    case 'I':
                        $array_notas = ['X','','',''];
                        break;
                    case 'EP':
                        $array_notas = ['','X','',''];
                        break;
                    case 'A':
                        $array_notas = ['','','X',''];
                        break;
                    case 'NE':
                        $array_notas = ['','','','X'];
                        break;
                }
                return $array_notas;
            }
            ?>
            </tbody>
        </table>
        <div class="row">

            <div class="col-md-6 align-self-end">
                    <table class="table table-responsive-sm table-bordered table-hover table-small" id="cualitativas">
                        <thead>

                        <tr>
                            <th >ESCALA CUALITATIVA</th>
                            <th >EQUIVALENCIA</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>INICIA EL PROCESO DE DESARROLLO</td>
                            <td>I</td>
                        </tr>
                        <tr>
                            <td>EN PROCESO DE DESARROLLO</td>
                            <td>EP</td>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td>ADQUIRIDO</td>
                        </tr>
                        <tr>
                            <td>NE</td>
                            <td>NO EVALUADO</td>
                        </tr>
                        </tbody>
                    </table>
            </div>

            <?php include ('ModComportamiento.php');?>

        </div>

        <?php $conn = null; ?>

    </div>
</body>
