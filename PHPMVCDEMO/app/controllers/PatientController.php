<?php
require_once APP_ROOT . '/app/services/PatientService.php';

class PatientController {
    public function index() {
        $patientService = new PatientService();
        $patients = $patientService->getAllPatients();
        require_once APP_ROOT . '/app/views/patient/index.php';
    }

    public function store() {
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $patient = new Patient(null, $name, $gender);

        $patientService = new patientService();
        $patientService->addPatient($patient);

        header('Location: ?controller=home');
        exit();
    }

    public function add() {
        require_once APP_ROOT . '/app/views/patient/add.php';
    }

    public function edit($id) {
        if (isset($id)) {
            $patientService = new PatientService();
            $patient = $patientService->getPatientById($id);

            include APP_ROOT . '/app/views/patient/edit.php';
        } else {
            echo 'Id is null';
        }
    }

    public function update($id) {
        if (isset($id)) {
            $name = $_POST['name'];
            $gender = $_POST['gender'];

            $patient_new = new Patient($id, $name, $gender);
            $patientService = new patientService();
            $patientService->updatePatient($patient_new);
            header('Location: ?controller=home');
            exit();
        }
    }

    public function confirmDelete($id) {
        if (isset($id)) {
            $patientService = new PatientService();
            $patient = $patientService->getPatientById($id); 
            
            if ($patient != null) {
                require_once APP_ROOT . '/app/views/patient/delete.php';
            } else {
                echo 'Không tìm thấy bệnh nhân';
            }
        }
    }

    public function delete($id) {
        if (isset($id)) {
            $patientService = new PatientService();
            $patientService->deletePatient($id);
            header('Location: ?controller=home');
            exit();
        }
    }
}