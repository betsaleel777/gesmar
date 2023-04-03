<?php

use Elibyy\TCPDF\Facades\TCPDF;

if (!function_exists('createPDF')) {
    function createPDF(string $filename, string $html): string
    {
        TCPDF::Reset();
        TCPDF::SetTitle('Example de Contrat');
        TCPDF::setCellHeightRatio(1.10);
        TCPDF::AddPage();
        TCPDF::writeHTML($html, true, false, true, false, '');
        $pathStorage = public_path() . '/storage' . '/' . $filename;
        TCPDF::Output($pathStorage, 'F');
        return $pathStorage;
    }
}
