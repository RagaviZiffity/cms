<?php
    class A{
        public $name;
        public $age;

        public function __construct($name, $age)
        {
            $this->name= $name;
            $this->age= $age;
        }
    }
    $user = new A("Ragavi", 21);
    echo $user->name;
    echo $user->age;
    
?>