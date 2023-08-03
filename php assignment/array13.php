<?php
    $var1 = array();
    for($var=200; $var <= 250; $var+= 4){
        // echo "{$var} <br>";
        $var1[]= $var;
    }
    echo implode(" ",$var1);
?>