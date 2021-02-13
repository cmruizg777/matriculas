
<?php

$sql5 = "select 
                materias.materia as materia,
                slqnotasunion_aux.alumno as alumno,
                slqnotasunion_aux.ci as ci,
                slqnotasunion_aux.nmatricula as nmatricula,
                c95 as autoevaluacion,
                c160 as suple,
                c163 as cualip1q1,
                c164 as cualip2q1,
                c166 as cualip1q2,
                c167 as cualip2q2,
                evaluada 
                from slqnotasunion_aux,cursos,materias,periodo,profesores 
                where periodo.idperiodo=slqnotasunion_aux.idperiodo 
                and cursos.idirigente=profesores.idprofesor 
                and materias.idmateria=slqnotasunion_aux.idmateria 
                And cursos.idcurso=slqnotasunion_aux.idcurso
                And evaluada = 'No' 
                And cursos.idcurso=? 
                And slqnotasunion_aux.idalumno=? order by slqnotasunion_aux.orden ASC";
$notasc = new CMySQL1($conn, $sql5, array($idcurso, $idalumno));


