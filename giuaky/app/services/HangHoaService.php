<?php
    require_once APP_ROOT . '/app/models/HangHoa.php';

    class PatientService {
        public function getAllPatients() {
            $patients = [];
            $dbConnection = new DBConnection();

            if ($dbConnection != null) {
                $conn = $dbConnection->getConnection();

                if ($conn != null) {
                    $sql = "SELECT * FROM patients";
                    $stmt = $conn->query($sql);

                    while ($row = $stmt->fetch()) {
                        $patient = new Patient($row['id'], $row['name'], $row['gender']);
                        $patients[] = $patient;
                    }

                    return $patients;
                }
            }
        }

        public function getPatientById($id) {
            $dbConnection = new DBConnection();
            if ($dbConnection != null) {
                $conn = $dbConnection->getConnection();
                if ($conn != null) {
                    $sql = "SELECT * FROM patients WHERE id = $id";
                    $stmt = $conn->query($sql);
                    if ($stmt->rowCount() > 0) {
                        $row = $stmt->fetch();
                        $patient = new Patient($row['id'], $row['name'], $row['gender']);
                        return $patient;
                    }
                }
            }
            return null;
        }

        public function addPatient(Patient $patient) {
            $dbConnection = new DBConnection();

            if ($dbConnection != null) {
                $conn = $dbConnection->getConnection();

                if ($conn != null) {
                    $name = $patient->getFullName();
                    $gender = $patient->getGender();
                    $sql = "INSERT INTO patients (name, gender) VALUES ('$name', '$gender')";
                    $conn->exec($sql);
                }
            }
        }

        public function updatePatient(Patient $patient) {
            $dbConnection = new DBConnection();

            if ($dbConnection != null) {
                $conn = $dbConnection->getConnection();

                if ($conn != null) {
                    $id = $patient->getId();
                    $name = $patient->getFullName();
                    $gender = $patient->getGender();
                    $sql = "UPDATE patients SET name='$name', gender='$gender' WHERE id=$id";
                    $conn->exec($sql);
                }
            }
        }

        public function deletePatient($id) {
            $dbConnection = new DBConnection();
            if ($dbConnection != null) {
                $conn = $dbConnection->getConnection();
                if ($conn != null) {
                    // Câu lệnh SQL xóa theo ID
                    $sql = "DELETE FROM patients WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    
                    // Gán tham số và thực thi
                    $stmt->bindParam(':id', $id);
                    return $stmt->execute();
                }
            }
            return false;
        }
    }