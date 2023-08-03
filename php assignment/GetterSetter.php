<?php
    class A{
        private $name;
        
        public function __construct($name)
        {
            $this->name = $name;
        }
        public function __toString()
        {
            return $this->name;
        }
        public function getter(){
            return $this->name;
        }
        public function setter($name){
            $this->name = $name;
        }
    }
    $user= new A("Ragavi");
    // $user->setter("Ragavi");
    // echo $user->getter();
    echo $user;

    // abstract class assess{
    //     abstract protected function showProject($project);
    // }

    // class employee extends assess{
    //     public function showProject($project){
    //         return "I am working on" . $project;
    //     }
    // }

    // $employee = new employee();
    // echo $employee->showProject(" project abc");
?>