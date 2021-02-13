<?php require_once('./clases/connection.php'); ?>
<?php require("./usuarios/aut_verifica.inc.php"); ?>
<?php
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
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Libreta de Calificaciones</title>
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <style>
        *{
            box-sizing: border-box;
        }
        .table-small , .table-small thead, .table-small tbody,.table-small tr, .table-small td, table-small th{
            font-size: 0.7rem !important;
            border: solid;
            border-width: 1px;
            max-width: 100%;
        }
        .table-small td {
            padding: 0.2rem !important;
        }
        table tr th{
            text-align: left;
        }
    </style>
</head>
<body>
<div class="card card-primary">
    <div class="card-header">
        <h1>
            <?php echo $_COOKIE['nombre']  ?>
        </h1>
    </div>
    <div class="card-body">
        <table>
            <tr>
                <th>
                   Estudiante:
                </th>
                <th>
                    <?php echo $_COOKIE['alumno']  ?>
                </th>
            </tr>
            <tr>
                <th>
                    Cédula:
                </th>
                <th>
                    <?php echo $_COOKIE['ci']  ?>
                </th>
            </tr>
            <tr>
                <th>
                    Curso:
                </th>
                <th>
                    <?php echo $_COOKIE['curso']  ?>
                </th>
            </tr>
        </table>
        <table class="table table-responsive-sm table-bordered table-hover table-small" id="cuantitativas">
            <thead>
            <tr class="bg-dark">
                <th colspan="22">NOTAS CUANTITATIVAS</th>
            </tr>
            <tr>
                <th rowspan="3">Asignatura</th>
                <th colspan="9">PRIMER QUIMESTRE</th>
                <th colspan="9">SEGUNDO QUIMESTRE</th>
                <th colspan="3">PROMEDIOS FINALES</th>
            </tr>
            <tr class="bg-primary">
                <th colspan="4">Parciales</th>
                <th colspan="3">Evaluación</th>
                <th rowspan="2">PROM</th>
                <th rowspan="2">EQ</th>
                <th colspan="4">Parciales</th>
                <th colspan="3">Evaluación</th>
                <th rowspan="2">PROM</th>
                <th rowspan="2">EQ</th>
                <th rowspan="2">PRO ANUAL</th>
                <th rowspan="2">EXA SUPLE</th>
                <th rowspan="2">NOTA FINAL</th>
            </tr>

            <tr class="bg-info">
                <th>P1</th>
                <th>P2</th>
                <th>PRO</th>
                <th>80%</th>
                <th>AT</th>
                <th>EX</th>
                <th>20%</th>
                <th>P1</th>
                <th>P2</th>
                <th>PRO</th>
                <th>80%</th>
                <th>AT</th>
                <th>EX</th>
                <th>20%</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include ('./ModCalificaciones.php');
            include ('./ModPromedios.php');
            function getBG($value){
                $bg = '';
                if($value>0 && $value <= 4){
                    $bg = 'bg-danger';
                }
                if($value>4 && $value < 7){
                    $bg = 'bg-warning';
                }
                if($value>=7 && $value < 9){
                    $bg = 'bg-primary';
                }
                if($value>=9 && $value <= 10){
                    $bg = 'bg-success';
                }
                return $bg;
            }
            ?>
            </tbody>
        </table>
        <div class="row">
            <table>
                <tr>
                    <td>
                        <div class="col-md-6 align-self-end">
                            <?php
                            include ('./ModCualitativas.php');
                            if ($notasc) {

                                ?>

                                <table class="table table-responsive-sm table-bordered table-hover table-small" id="cualitativas">
                                    <thead>
                                    <tr class="bg-dark">
                                        <th colspan="22">NOTAS CUALITATIVAS</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">ASIGNATURA</th>
                                        <th colspan="2">PRIMER QUIMESTRE</th>
                                        <th colspan="2">SEGUNDO QUIMESTRE</th>
                                    </tr>
                                    <tr>
                                        <th>P1</th>
                                        <th>P2</th>
                                        <th>P1</th>
                                        <th>P2</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    do {
                                        echo "<tr>";
                                        printf("<td>%s</td>", $notasc->Row['materia']);
                                        printf("<td>%s</td>", $notasc->Row['cualip1q1']);
                                        printf("<td>%s</td>", $notasc->Row['cualip2q1']);
                                        printf("<td>%s</td>", $notasc->Row['cualip1q2']);
                                        printf("<td>%s</td>", $notasc->Row['cualip2q2']);
                                        echo "</tr>";
                                    } while ($notasc->GetRow());
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                        </div>
                    </td>
                    <td>
                        <?php include ('./ModComportamiento.php');?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table>
                <tr>
                    <td>
                        <div class="col-md-6">
                            <table class="table table-responsive table-bordered table-small" id="escalaC">
                                <thead>
                                <tr class="bg-info">
                                    <th colspan="3">ESCALA DE EVALUACIÓN DE COMPORTAMIENTO</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>A</th>
                                    <td>MUY SATISFACTORIO</td>
                                    <td>LIDERA EL CUMPLIMIENTO DE LOS COMPROMISOS ESTABLECIDOR, PARA LA SANA CONVIVENCIA SOCIAL.</td>
                                </tr>
                                <tr>
                                    <th>B</th>
                                    <td>SATISFACTORIO</td>
                                    <td>CUMPLE CON LOS COMPROMISOS ESTABLECIDOR, PARA LA SANA CONVIVENCIA SOCIAL.</td>
                                </tr>
                                <tr>
                                    <th>C</th>
                                    <td>POCO SATISFACTORIO</td>
                                    <td>FALLA OCASIONALMENTE EN EL CUMPLIMIENTO DE LOS COMPROMISOS ESTABLECIDOR, PARA LA SANA CONVIVENCIA SOCIAL.</td>
                                </tr>
                                <tr>
                                    <th>D</th>
                                    <td>MEJORABLE</td>
                                    <td>FALLA REITERADAMENTE EN EL CUMPLIMIENTO DE LOS COMPROMISOS ESTABLECIDOR, PARA LA SANA CONVIVENCIA SOCIAL.</td>
                                </tr>
                                <tr>
                                    <th>E</th>
                                    <td>INSATISFACTORIO</td>
                                    <td>NO CUMPLE CON LOS COMPROMISOS ESTABLECIDOR, PARA LA SANA CONVIVENCIA SOCIAL.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="col-md-6">
                            <table class="table table-responsive table-bordered table-small" id="escalaR">
                                <thead>
                                <tr class="bg-info">
                                    <th colspan="3">ESCALA DE CALIFICACIONES DEL RENDIMIENTO ACADÉMICO</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th class="bg-success">DA</th>
                                    <td>DOMINA LOS APRENDIZAJES REQUERIDOS</td>
                                    <td>9.00 A 10.00</td>
                                </tr>
                                <tr>
                                    <th class="bg-primary">AA</th>
                                    <td>ALCANZA LOS APRENDIZAJER REQUERIDOS</td>
                                    <td>7.00 A 8.99</td>
                                </tr>
                                <tr>
                                    <th class="bg-warning">PA</th>
                                    <td>PROXIMO A ALCANZAR LOS APRENDIZAJES REQUERIDOS</td>
                                    <td>4.01 A 6.99</td>
                                </tr>
                                <tr>
                                    <th class="bg-danger">NA</th>
                                    <td>NO ALCANZA LOS APRENDIZAJES REQUERIDOS</td>
                                    <td>0.01 A 4.00</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>

        </div>
        <?php $conn = null; ?>

    </div>
</body>
</html>



