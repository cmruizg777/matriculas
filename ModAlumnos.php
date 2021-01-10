<?php require_once('clases/connection.php'); ?>
<?php require("usuarios/aut_verifica.inc.php"); ?>
<?php

$conn = getDatabaseConnection1($_COOKIE['base'], $_COOKIE['server']);
$errors = array();
error_reporting(5);
$nivel_acceso = 10;
if ($nivel_acceso <= $_COOKIE['usuario_nivel']) {
    header("Location: $redir?error_login=5");
    exit;
}
$action = $_COOKIE['id_alumno'];
$PProd = $_POST['fun1'];
$iddel = $_POST['del'];
$idmod = $_POST['mod'];
$param = $_POST['param'];
$tab = $_POST['tab'];
if ($action > 0)
    $OClie = new CMySQL1($conn, "SELECT * FROM alumnos where idalumno=?", array($action));
else
    $OClie = new CMySQL1($conn, "SELECT `ci`, `alumnos` as alumno FROM preinscripcion  where ci=?", array($_COOKIE['ci']));
$Omat = new CMySQL1($conn, "SELECT * FROM `matricula` WHERE idalumno=? and estado=? order by Nmatricula desc limit 1", array($OClie->Row['idalumno'], 1));
$Omedios = new CMySQL1($conn, "SELECT * FROM medios_comunicaion WHERE  nmatricula=?", array($Omat->Row['Nmatricula']));
$Oetnia = new CMySQL1($conn, "select * from  etnias", array(1));
$prof = array("Aeronautica, transportes y nautica", "Agricultura, jardineria y mineralogia", "Ciencias experimentales", "Ciencias sociales", "Comunicacion, publicidad y relaciones publicas", "Construccion y edificacion", "Cuerpos de seguridad y criminologia", "Deporte y educacion fisica", "Diseno: grafico, textil, industrial e interiores", "Economia y administracion de empresas", "Educacion y formacion", "Hosteleria, turismo y restauracion", "Humanidades", "Idiomas, filologia, traduccion", "Imagen personal", "Imagen y sonido", "Industria, mecanica, electricidad y electronica", "Informatica y telecomunicaciones", "Medio ambiente y veterinaria", "Musica, danza y teatro", "Sanidad y salud", "Tecnicas artesanales y artisticas");
$instr = array("Primaria", "Secundaria", "Media superior", "Superior", "Post-universitaria");
$ecivil = array("Soltero/a", "Casado/a", "Union libre o union de hecho", "Separado/a", "Divorciado/a", "Viudo/a");
$porciones = explode(" ", $OClie->Row['alumno']);
$ape1 = $porciones[0];
$ape2 = $porciones[1];
$Oestu = new CMySQL1($conn, "SELECT idalumno, alumno FROM alumnos WHERE (alumno like '%$ape1%'  OR  alumno like '%$ape2%') and idalumno!=? order by alumno", array($OClie->Row['idalumno']));
?>
<head>

</head>
<body>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title" id="titulo"><?php echo ($_COOKIE['id_alumno'] > 0) ? "Editar" : "Registrar" ?> Datos
            Personales </h3>
    </div>

    <div class="card-body">
        <form role="form" id="NuevoCli" method="post" action="javascript:GuardaCliente()">
            <div class="box-body">
                <div align="right">
                    <button type="submit" id="btnSave" class="btn btn-success dropzone-with-swa btn-sm"><i
                                class='fas fa-save'></i> Guardar
                    </button>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                                           href="#custom-tabs-three-home" role="tab"
                                           aria-controls="custom-tabs-three-home" aria-selected="true">DATOS DEL
                                            ESTUDIANTE</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                           href="#custom-tabs-three-profile" role="tab"
                                           aria-controls="custom-tabs-three-profile" aria-selected="false">
                                            DATOS FAMILIARES
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-messages-tab" data-toggle="pill"
                                           href="#custom-tabs-three-messages" role="tab"
                                           aria-controls="custom-tabs-three-messages" aria-selected="false">DATOS DEL
                                            REPRESENTANTE</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-three-settings-tab" data-toggle="pill"
                                           href="#custom-tabs-three-settings" role="tab"
                                           aria-controls="custom-tabs-three-settings" aria-selected="false">DIAGNOSTICO
                                            PLAN EDUCATIVO COVID-19</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel"
                                         aria-labelledby="custom-tabs-three-home-tab">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">C&eacute;dula : <b style="color:red">
                                                        *</b></label>
                                                <input type="text" class="form-control input-sm" name="ci" id="ci"
                                                       value="<?php echo $OClie->Row['ci']; ?>" required="required">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Nombres : <b style="color:red">
                                                        *</b></label>

                                                <input type="text" class="form-control input-sm" name="alumno"
                                                       id="alumno" value="<?php echo $OClie->Row['alumno'] ?>"
                                                       required="required">

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Telefono : <b style="color:red">
                                                        *</b></label>

                                                <input type="text" class="form-control input-sm" name="telefono"
                                                       id="telefono" value="<?php echo $OClie->Row['telefono'] ?>"
                                                       required="required">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Direccion : <b style="color:red"> *</b></label>

                                                <input type="text" class="form-control input-sm" name="direccion"
                                                       id="direccion" value="<?php echo $OClie->Row['direccion'] ?>"
                                                       required="required">

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Correo : <b style="color:red">
                                                        *</b></label>

                                                <input type="mail" class="form-control input-sm" name="mail" id="mail"
                                                       value="<?php echo $OClie->Row['mail'] ?>" required="required">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail2">Correo Estudiantil: </label>

                                                <input type="mail" class="form-control input-sm" name="maile" id="maile"
                                                       value="<?php echo $OClie->Row['maile'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Nacionalidad : <b style="color:red">
                                                        *</b></label>

                                                <input type="text" class="form-control input-sm" name="nacionalidad"
                                                       id="nacionalidad"
                                                       value="<?php echo $OClie->Row['nacionalidad'] ?>"
                                                       required="required">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Actividades que Realiza en el Tiempo
                                                    Libre:</label>

                                                <input type="text" class="form-control input-sm" name="actividades"
                                                       id="actividades"
                                                       value="<?php echo $OClie->Row['actividades'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Fecha Nacimiento : <b style="color:red">
                                                        *</b></label>
                                                <input type="text" class="form-control input-sm" name="fechaN"
                                                       id="fechaN" value="<?php echo $OClie->Row['fechaN']; ?>"
                                                       required>

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Lugar de Nacimiento <b
                                                            style="color:red"> *</b></label>

                                                <input type="text" class="form-control input-sm" name="lugarN"
                                                       id="lugarN" value="<?php echo $OClie->Row['lugarN'] ?>"
                                                       required="required">

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Sexo : <b style="color:red">
                                                        *</b></label>
                                                <?php $a = array("H" => "Masculino", "M" => "Femenino");

                                                echo "<select name=\"sexo\"  id=\"sexo\"class='form-control input-sm' required>\n";
                                                foreach ($a as $id => $v) {
                                                    if (strtoupper($OClie->Row['sexo']) == strtoupper($id))
                                                        echo "<option value=\"$id\" selected>$v</option>";
                                                    else
                                                        echo "<option value=\"$id\">$v</option>";
                                                    $i++;
                                                }
                                                echo "</select>\n"; ?>


                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Etnia : <b style="color:red">
                                                        *</b></label>

                                                <select id="idetnias" name="idetnias" class='form-control'
                                                        required="required">
                                                    <?php do {

                                                        if ($Oetnia->Row['idetnias'] == $OClie->Row['idetnias'])
                                                            echo "<option value=\"{$Oetnia->Row['idetnias']}\" selected>{$Oetnia->Row['etnias']}</option>";
                                                        else
                                                            echo "<option value=\"{$Oetnia->Row['idetnias']}\">{$Oetnia->Row['etnias']}</option>";
                                                    } while ($Oetnia->GetRow()); ?>
                                                </select>
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Provincia : <b style="color:red"> *</b></label>
                                                <?php $a = array("Azuay", "Bolivar", "Ca?ar", "Carchi", "Chimborazo", "Cotopaxi", "El Oro", "Esmeraldas", "Galapagos", "Guayas", "Imbabura", "Loja", "Los Rios", "Manabi", "Morona-Santiago", "Napo", "Orellana", "Pastaza", "Pichincha", "Santa Elena", "Santo Domingo de los Tsachilas", "Sucumbios", "Tungurahua", "Zamora-Chinchipe");
                                                $i = 0;
                                                echo "<select name=\"provincia\"  id=\"provincia\"class='form-control input-sm'>\n";
                                                foreach ($a as $v) {
                                                    if (strtoupper($OClie->Row['provincia']) == strtoupper($v))
                                                        echo "<option value=\"$v\" selected>$v</option>";
                                                    else
                                                        echo "<option value=\"$v\">$v</option>";
                                                    $i++;
                                                }
                                                echo "</select>\n"; ?>
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Canton : <b style="color:red">
                                                        *</b></label>
                                                <input type="text" class="form-control input-sm" name="canton"
                                                       id="canton" value="<?php echo $OClie->Row['canton'] ?>" required>
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Sitios de Referencia Domicilio:</label>

                                                <input type="text" class="form-control input-sm" name="referencia"
                                                       id="referencia" value="<?php echo $OClie->Row['referencia'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Actualmente Padece Alguna
                                                    Enfermedad:</label>

                                                <input type="text" class="form-control input-sm" name="enfermedad"
                                                       id="enfermedad" value="<?php echo $OClie->Row['enfermedad'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Tiene Discapacidad :</label>
                                                <select name="discapacidad" id="discapacidad"
                                                        class='form-control input-sm' onChange="verDisca(this.value)">
                                                    <?php $a = array(0 => "No", 1 => "Si");
                                                    foreach ($a as $v => $t) {
                                                        if (strtoupper($OClie->Row['discapacidad']) == $v)
                                                            echo "<option value=\"$v\" selected>$t</option>";
                                                        else
                                                            echo "<option value=\"$v\">$t</option>";
                                                        $i++;
                                                    } ?>
                                                </select>
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6" id="dtipodis" style="display:none">
                                                <label for="exampleInputEmail1">Tipo Discapacidad :</label>
                                                <select name="tipo_discapacidad" id="tipo_discapacidad"
                                                        class='form-control input-sm'>
                                                    <?php $a = array(1 => "Fisica", 2 => "Sensorial", 3 => "Intelectual", 4 => "Psiquica", 5 => "Viceral", 6 => "Multiple");
                                                    echo "<option value=\"0\" selected>Seleccione</option>";
                                                    foreach ($a as $v => $t) {
                                                        if (strtoupper($OClie->Row['tipo_discapacidad']) == $v)
                                                            echo "<option value=\"$v\" selected>$t</option>";
                                                        else
                                                            echo "<option value=\"$v\">$t</option>";
                                                        $i++;
                                                    } ?>
                                                </select>
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row" id="dtipodis1" style="display:none">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Carnet de Conadis :</label>

                                                <input type="text" class="form-control input-sm" name="carnet"
                                                       id="carnet" value="<?php echo $OClie->Row['carnet'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Porcentaje Discapacidad :</label>
                                                <input type="text" class="form-control input-sm" name="porcentaje"
                                                       id="porcentaje" value="<?php echo $OClie->Row['porcentaje'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->


                                    </div><!--tab1-->
                                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                                         aria-labelledby="custom-tabs-three-profile-tab">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Padre :</label>

                                                <input type="text" class="form-control input-sm" name="padre" id="padre"
                                                       value="<?php echo $OClie->Row['padre'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Madre :</label>

                                                <input type="text" class="form-control input-sm" name="madre" id="madre"
                                                       value="<?php echo $OClie->Row['madre'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Profesion Padre :</label>

                                                <input type="text" class="form-control input-sm" name="padreP"
                                                       id="padreP" value="<?php echo $OClie->Row['padreP'] ?>">
                                                <!--select name="padreP"  id="padreP"class='form-control input-sm'>
                                                  <option value="" selected>Seleccione</option-->
                                                <!--?php
                                                   foreach($prof as $v){
                                                       if(($OClie->Row['padreP'])==$v)
                                                           echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                           echo "<option value=\"$v\">$v</option>";
                                                       $i++;
                                                   }>
                                                </select-->

                                            </div><!-- /.col-lg-6 -->

                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Profesion Madre :</label>
                                                <input type="text" class="form-control input-sm" name="madreP"
                                                       id="madreP" value="<?php echo $OClie->Row['madreP'] ?>">
                                                <!--select name="madreP"  id="madreP"class='form-control input-sm' >
                                                     <option value="" selected>Seleccione</option-->
                                                <!--?php
                                                   foreach($prof as $v){
                                                       if(($OClie->Row['madreP'])==$v)
                                                           echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                           echo "<option value=\"$v\">$v</option>";
                                                       $i++;
                                                   }?>
                                                </select-->

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Instruccion Padre :</label>
                                                <select name="insp" id="insp" class='form-control input-sm'>
                                                    <option value="" selected>Seleccione</option>
                                                    <?php
                                                    foreach ($instr as $v) {
                                                        if (($OClie->Row['insp']) == $v)
                                                            echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                            echo "<option value=\"$v\">$v</option>";
                                                        $i++;
                                                    } ?>
                                                </select>

                                            </div><!-- /.col-lg-6 -->

                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Instruccion Madre :</label>
                                                <select name="insm" id="insm" class='form-control input-sm'>
                                                    <option value="" selected>Seleccione</option>
                                                    <?php
                                                    foreach ($instr as $v) {
                                                        if (($OClie->Row['insm']) == $v)
                                                            echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                            echo "<option value=\"$v\">$v</option>";
                                                        $i++;
                                                    } ?>
                                                </select>

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Cedula Padre :</label>
                                                <input type="text" class="form-control input-sm" name="ccp" id="ccp"
                                                       value="<?php echo $OClie->Row['ccp'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Cedula Madre :</label>
                                                <input type="text" class="form-control input-sm" name="ccm" id="ccm"
                                                       value="<?php echo $OClie->Row['ccm'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Estado Civil Padre :</label>
                                                <select name="ecp" id="ecp" class='form-control input-sm'>
                                                    <option value="" selected>Seleccione</option>
                                                    <?php
                                                    foreach ($ecivil as $v) {
                                                        if (($OClie->Row['ecp']) == $v)
                                                            echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                            echo "<option value=\"$v\">$v</option>";
                                                        $i++;
                                                    } ?>
                                                </select>
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Estado Civil Madre :</label>
                                                <select name="ecm" id="ecm" class='form-control input-sm'>
                                                    <option value="" selected>Seleccione</option>
                                                    <?php
                                                    foreach ($ecivil as $v) {
                                                        if (($OClie->Row['ecm']) == $v)
                                                            echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                            echo "<option value=\"$v\">$v</option>";
                                                        $i++;
                                                    } ?>
                                                </select>

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Telefono Padre :</label>
                                                <input type="text" class="form-control input-sm" name="telp" id="telp"
                                                       value="<?php echo $OClie->Row['telp'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Telefono Madre :</label>
                                                <input type="text" class="form-control input-sm" name="telm" id="telm"
                                                       value="<?php echo $OClie->Row['telm'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Numero de Hijos :</label>
                                                <input type="text" class="form-control input-sm" name="nhijos"
                                                       id="nhijos" value="<?php echo $OClie->Row['nhijos'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Organizacion Conyugal :</label>
                                                <input type="text" class="form-control input-sm" name="organizacion"
                                                       id="organizacion"
                                                       value="<?php echo $OClie->Row['organizacion'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="divider"></div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Familiar Cercano:</label>
                                                <input type="text" class="form-control input-sm" name="nfamiliar"
                                                       id="nfamiliar" value="<?php echo $OClie->Row['familiar'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Teléfono del Familiar:</label>
                                                <input type="text" class="form-control input-sm" name="telefonof"
                                                       id="telefonof"
                                                       value="<?php echo $OClie->Row['telefonof'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="exampleInputEmail1">Dirección del Familiar:</label>
                                                <input type="text" class="form-control input-sm" name="direccionf"
                                                       id="direccionf" value="<?php echo $OClie->Row['direccionf'] ?>">

                                            </div><!-- /.col-lg-12-->
                                        </div><!-- /.row -->
                                    </div><!-- tab2-->
                                    <div class="tab-pane fade" id="custom-tabs-three-messages" role="tabpanel"
                                         aria-labelledby="custom-tabs-three-messages-tab">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Parentezco :</label>

                                                <select type="text" class="form-control input-sm" id="familiar">
                                                    <option value="0" selected>Seleccione</option>
                                                    <option value="1">Madre</option>
                                                    <option value="2">Padre</option>
                                                    <option value="3">Otro</option>
                                                </select>

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Nombre del Representante :</label>

                                                <input type="text" class="form-control input-sm" name="representante"
                                                       id="representante"
                                                       value="<?php echo $Omat->Row['representante'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Cedula :</label>

                                                <input type="text" class="form-control input-sm" name="ccr" id="ccr"
                                                       value="<?php echo $Omat->Row['ccr'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Instruccion :</label>
                                                <select name="insr" id="insr" class='form-control input-sm'>
                                                    <option value="" selected>Seleccione</option>
                                                    <?php
                                                    foreach ($instr as $v) {
                                                        if (($Omat->Row['insr']) == $v)
                                                            echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                            echo "<option value=\"$v\">$v</option>";
                                                    } ?>
                                                </select>

                                            </div><!-- /.col-lg-6 -->

                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Profesion :</label>
                                                <input type="text" class="form-control input-sm" name="profr" id="profr"
                                                       value="<?php echo $OClie->Row['profr'] ?>">
                                                <!--select name="profr"  id="profr"class='form-control input-sm' >
                                                     <option value="" selected>Seleccione</option-->
                                                <!--?php
                                                   foreach($prof as $v){
                                                       if(($Omat->Row['profr'])==$v)
                                                           echo "<option value=\"$v\" selected>$v</option>";
                                                        else
                                                           echo "<option value=\"$v\">$v</option>";
                                                       $i++;
                                                   }?>
                                                </select-->


                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Telefono :</label>
                                                <input type="text" class="form-control input-sm" name="telefonoR"
                                                       id="telefonoR" value="<?php echo $Omat->Row['telefonoR']; ?>">
                                            </div><!-- /.col-lg-6 -->

                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Agregue Hermanos en la Institucion
                                                    :</label>
                                                <div class="input-group input-group-sm">
                                                    <select name="lista" id="lista" class='form-control input-sm'>
                                                        <?php
                                                        do {
                                                            echo "<option value=\"{$Oestu->Row['idalumno']}\">{$Oestu->Row['alumno']}</option>";
                                                        } while ($Oestu->GetRow()) ?>
                                                    </select>
                                                    <span class="input-group-append">
                            <button type="button" class="btn btn-info btn-flat" onClick="addHer()">Agregar</button>
                          </span>
                                                </div>

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">

                                            </div><!-- /.col-lg-6 -->

                                            <div class="col-6">
                                                <div>
                                                    <label for="exampleInputEmail1">Lista de Hermanos en la Institucion
                                                        :</label>


                                                    <select multiple class="custom-select" id="cboh">
                                                        <?php
                                                        $h1=new CMySQL1($conn,"SELECT * FROM hermanos where al1=?",array($OClie->Row['idalumno']));
                                                        do{
                                                            $Oal=new CMySQL1($conn,"SELECT idalumno,alumno FROM alumnos WHERE idalumno=?  order by alumnos.alumno",array($h1->Row['al2']));
                                                            echo '<option value="'.$Oal->Row['idalumno'].'">'.$Oal->Row['alumno'].'</option>';
                                                        }while($h1->GetRow());
                                                        $h1=new CMySQL1($conn,"SELECT * FROM hermanos where al2=?",array($OClie->Row['idalumno']));
                                                        do{
                                                            $Oal=new CMySQL1($conn,"SELECT idalumno,alumno FROM alumnos WHERE idalumno=?  order by alumnos.alumno",array($h1->Row['al1']));
                                                            echo '<option value="'.$Oal->Row['idalumno'].'">'.$Oal->Row['alumno'].'</option>';
                                                        }while($h1->GetRow());
                                                        ?>
                                                    </select>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-danger" onclick="borrah()">Borrar Hermano</button>
                                                </div>
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->

                                    </div><!-- tab3-->
                                    <div class="tab-pane fade" id="custom-tabs-three-settings" role="tabpanel"
                                         aria-labelledby="custom-tabs-three-settings-tab">

                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Dispone de Internet en su Casa:</label>
                                                <select name="internet" id="internet" class='form-control input-sm'
                                                        onChange="verInter(this.value)" required>
                                                    <?php $a = array(0 => "No", 1 => "Si");
                                                    foreach ($a as $v => $t) {
                                                        if (strtoupper($Omedios->Row['internet']) == $v)
                                                            echo "<option value=\"$v\" selected>$t</option>";
                                                        else
                                                            echo "<option value=\"$v\">$t</option>";
                                                        $i++;
                                                    } ?>
                                                </select>
                                            </div><!-- /.col-lg-6 -->

                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Tipo de Internet :</label>
                                                <select name="tipointernet" id="tipointernet"
                                                        class='form-control input-sm' required>
                                                    <?php $a = array(1 => "RECARGAS", 2 => "PLAN FIJO EN CASA", 3 => "PLAN DE DATOS EN CELULAR");
                                                    echo "<option value=\"0\" selected>Seleccione</option>";
                                                    foreach ($a as $v => $t) {
                                                        if (strtoupper($Omedios->Row['tipointernet']) == $v)
                                                            echo "<option value=\"$v\" selected>$t</option>";
                                                        else
                                                            echo "<option value=\"$v\">$t</option>";
                                                    } ?>
                                                </select>
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Usuarios que utilizan el Internet
                                                    :</label>
                                                <input type="text" class="form-control input-sm" name="nusuarios"
                                                       id="nusuarios" value="<?php echo $Omedios->Row['nusuarios']; ?>"
                                                       data-inputmask='"mask": "99"' data-mask>
                                            </div><!-- /.col-lg-6 -->

                                            <div class="col-6">
                                                <label for="exampleInputEmail1">Medio de Comunicacion Usado para Entrega
                                                    de Tareas :</label>
                                                <input type="text" class="form-control input-sm" name="comunicacion"
                                                       id="comunicacion"
                                                       value="<?php echo $Omedios->Row['comunicacion'] ?>">
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">En Cuarentena Cuales Fueron las
                                                    Asignaturas de su Preferencias:</label>

                                                <input type="text" class="form-control input-sm" name="asig_favoritas"
                                                       id="asig_favoritas"
                                                       value="<?php echo $Omedios->Row['asig_favoritas'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                            <div class="col-6">
                                                <label for="exampleInputEmail1">En Cuarentena Cuales Fueron las
                                                    Asignaturas Presento Dificultad :</label>

                                                <input type="text" class="form-control input-sm" name="asig_dificiles"
                                                       id="asig_dificiles"
                                                       value="<?php echo $Omedios->Row['asig_dificiles'] ?>">

                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->
                                    </div><!-- tab4-->
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>


                    <div class="card-body">
                        <input type="hidden" name="Nmatricula" id="Nmatricula"
                               value="<?php echo $Omat->Row['Nmatricula'] ?>">
                        <input type="hidden" id="MM_update" name="MM_update" value="form1">
                        <input type="hidden" name="idalumno" id="idalumno"
                               value="<?php echo $OClie->Row['idalumno']; ?>">
                    </div>
                </div>
            </div>
        </form>
        </section>
        <?php $conn = null; ?>
        <script>

            document.getElementById('familiar').onchange = function () {
                var valor = this.value;
                if (valor == 1) {
                    document.getElementById('representante').value = document.getElementById('madre').value;
                    document.getElementById('ccr').value = document.getElementById('ccm').value;
                    document.getElementById('insr').value = document.getElementById('insm').value;
                    document.getElementById('profr').value = document.getElementById('madreP').value;
                    document.getElementById('telefonoR').value = document.getElementById('telm').value;
                } else if (valor == 2) {
                    document.getElementById('representante').value = document.getElementById('padre').value;
                    document.getElementById('ccr').value = document.getElementById('ccp').value;
                    document.getElementById('insr').value = document.getElementById('insp').value;
                    document.getElementById('profr').value = document.getElementById('padreP').value;
                    document.getElementById('telefonoR').value = document.getElementById('telp').value;
                } else {
                    document.getElementById('representante').value = '';
                    document.getElementById('ccr').value = '';
                    document.getElementById('insr').value = '';
                    document.getElementById('profr').value = '';
                    document.getElementById('telefonoR').value = '';
                }
            }
            verDisca(document.getElementById('discapacidad').value);

            document.getElementById('ci').focus();

            function borrah() {
                console.log($("#cboh").val())
                if ($("#cboh").val().length > 0) {
                    $.post("hermanos.php", {
                        action: 2,
                        al1: $("#idalumno").val(),
                        al2: $("#cboh").val()
                    }, function (data) {
                        $("#cboh").html(data);
                    });
                }else{
                    alertify.error('Debe seleccionar un hermano');
                }
            }

            function addHer() {
                if ($("#lista").val() > 0) {
                    $.post(
                        "hermanos.php",
                        {action: 1, al1: $("#idalumno").val(), al2: $("#lista").val()},
                        function (data, status, xhr) {
                            $("#cboh").html(data);
                        }
                    );
                }
            }

            /*function getHermanos(){
                console.log('Buscando hermanos ...')
                $.post(
                    "hermanos.php",
                    {action: 3, al1: $("#idalumno").val()},
                    function (data) {
                        $("#cboh").html(data);
                        console.log(data)
                    }
                );

            }*/

            function validaCed() {
                var cedula = document.getElementById('ci').value;
                //Preguntamos si la cedula consta de 10 digitos
                if (cedula.length > 0)

                    if (cedula.length == 10) {

                        //Obtenemos el digito de la region que sonlos dos primeros digitos
                        var digito_region = cedula.substring(0, 2);

                        //Pregunto si la region existe ecuador se divide en 24 regiones
                        if (digito_region >= 1 && digito_region <= 24) {

                            // Extraigo el ultimo digito
                            var ultimo_digito = cedula.substring(9, 10);

                            //Agrupo todos los pares y los sumo
                            var pares = parseInt(cedula.substring(1, 2)) + parseInt(cedula.substring(3, 4)) + parseInt(cedula.substring(5, 6)) + parseInt(cedula.substring(7, 8));

                            //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
                            var numero1 = cedula.substring(0, 1);
                            var numero1 = (numero1 * 2);
                            if (numero1 > 9) {
                                var numero1 = (numero1 - 9);
                            }

                            var numero3 = cedula.substring(2, 3);
                            var numero3 = (numero3 * 2);
                            if (numero3 > 9) {
                                var numero3 = (numero3 - 9);
                            }

                            var numero5 = cedula.substring(4, 5);
                            var numero5 = (numero5 * 2);
                            if (numero5 > 9) {
                                var numero5 = (numero5 - 9);
                            }

                            var numero7 = cedula.substring(6, 7);
                            var numero7 = (numero7 * 2);
                            if (numero7 > 9) {
                                var numero7 = (numero7 - 9);
                            }

                            var numero9 = cedula.substring(8, 9);
                            var numero9 = (numero9 * 2);
                            if (numero9 > 9) {
                                var numero9 = (numero9 - 9);
                            }

                            var impares = numero1 + numero3 + numero5 + numero7 + numero9;

                            //Suma total
                            var suma_total = (pares + impares);

                            //extraemos el primero digito
                            var primer_digito_suma = String(suma_total).substring(0, 1);

                            //Obtenemos la decena inmediata
                            var decena = (parseInt(primer_digito_suma) + 1) * 10;

                            //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
                            var digito_validador = decena - suma_total;

                            //Si el digito validador es = a 10 toma el valor de 0
                            if (digito_validador == 10)
                                var digito_validador = 0;

                            //Validamos que el digito validador sea igual al de la cedula
                            if (digito_validador == ultimo_digito) {
                                a = 1;
                            } else {
                                alert('la cedula:' + cedula + ' es incorrecta');
                            }

                        } else {
                            // imprimimos en consola si la region no pertenece
                            alert('Esta cedula no pertenece a ninguna region');
                        }
                    } else {
                        //imprimimos en consola si la cedula tiene mas o menos de 10 digitos

                        alert('Esta cedula  no tiene los Digitos acorde al formato');
                    }

            }

            function GuardaCliente() {
                $('#btnSave').attr('disabled', true);
                var str = $("#NuevoCli").serialize();
                $.ajax({
                    url: 'AjaxModAlumno.php',
                    type: 'POST',
                    data: str,
                }).done(function (respuesta) {

                    if (respuesta != 0) {
                        alertify.success('Sus Datos se Actualizaron Correctamente');
                        $("#idalumno").val(respuesta);
                    } else
                        alertify.error('Ocurrion Algun Error');
                    $('#ci').focus();
                    $('#btnSave').attr('disabled', false);
                });
            }

            function borrar() {
                if (confirm("Seguro desea Eliminar"))
                    RComando('del=' + document.getElementById('Id').value, 'Modalumnos.php');
            }

            function verDisca(valor) {
                var eldiv = document.getElementById('dtipodis');
                var eldiv1 = document.getElementById('dtipodis1');
                eldiv.style.display = 'none';
                eldiv1.style.display = 'none';
                if (valor == 1) {
                    eldiv.style.display = 'block';
                    eldiv1.style.display = 'block';
                }
            }


        </script>
    </div>
</body>


