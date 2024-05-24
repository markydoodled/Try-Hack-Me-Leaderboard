use Dompdf\Dompdf;

<?php
require_once 'dompdf/autoload.inc.php';
$dompdf = new Dompdf();
$html = file_get_contents('index.html');
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$outputFile = '/~/Downloads/leaderboard.pdf';
file_put_contents($outputFile, $dompdf->output());
echo 'PDF exported successfully!';
?>