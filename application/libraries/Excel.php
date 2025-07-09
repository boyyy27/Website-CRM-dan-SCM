<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel {
    public function __construct() {
    }

    public function createSpreadsheet() {
        return new Spreadsheet();
    }

    public function createWriter($spreadsheet) {
        return new Xlsx($spreadsheet);
    }
} 