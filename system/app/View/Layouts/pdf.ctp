<?php
Configure::write('debug', 0);
App::import('Vendor', 'mpdf/mpdf');
$mpdf = new mPDF('ja', 'A4');
$mpdf->writeHTML($content_for_layout);
$mpdf->Output('test.pdf', 'D');