<?php

require_once APP_ROOT.'/app/services/PatientService.php';

class HomeController{
    public function index(){
        $patientService = new PatientService();
        $patients = $patientService->getAllPatiens();
        include APP_ROOT.'/app/views/home/index.php'; // canh bao van dua loi 
    }
}

?>
