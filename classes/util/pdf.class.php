<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once($_SESSION['config_global']['MAINCONFIG_ROOT_PATH']."/classes/util/tcpdf/tcpdf.php");

/**
 * pdfclass is an extension of tcpdf custom fit on a general purpose
 *
 * @author Arnold P. Orbista <aorbista@xinapse.net>
 * @version 1.0.0
 */
class clsPDF extends TCPDF {
    //put your code here

    public function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding="UTF-8") {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding);
    }

    
}
?>
