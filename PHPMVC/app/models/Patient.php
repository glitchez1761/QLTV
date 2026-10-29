<?php 
    class Patient{
        private $id;
        private $fullname;
        private $gender;

        public function __construct($id,$fullname,$gender)
        {
            $this->id = $id;;
            $this->fullname = $fullname;
            $this->gender = $gender;
        }

        public function getId(){
            return $this->id;
        }

        public function getFullName(){
            return $this->fullname;
        }

        public function getGender(){
            return $this->gender;
        }

        public function setFullName($fullname){
            $this->fullname = $fullname;
        }
    };
?>