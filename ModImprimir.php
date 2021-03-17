<?php

require_once './dompdf/autoload.inc.php';

$dompdf = new \Dompdf\Dompdf();

$idmodo = $_COOKIE['idmodo'];
if($idmodo!=2){
    $html = render('./reportes/ReporteCalificaciones.php');
}else{
    $html = render('./reportes/ReporteAmbitos.php');
}

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

function render($file) {

    if (is_file($file)) {
        ob_start();
        include($file);
        $content = ob_get_contents();
        ob_end_clean();
    } else {
        throw new RuntimeException(sprintf('Cant find view file %s!', $file));
    }

    return $content;
}
