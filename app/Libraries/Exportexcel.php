<?php 
// if (!defined('BASEPATH')) exit('No direct script access allowed'); 
require_once("PHPExcel/Classes/PHPExcel.php");  
class Exportexcel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}
?>