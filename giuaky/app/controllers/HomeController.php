<?php
require_once APP_ROOT . '/app/services/HangHoaService.php';

class HomeController {
    public function index() {
        $patientService = new PatientService();
        
        $patients = $patientService->getAllPatients();
        
        require_once APP_ROOT . '/app/views/home/index.php';
    }
}