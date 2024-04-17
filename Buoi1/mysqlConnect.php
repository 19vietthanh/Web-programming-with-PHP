<?php 
    $mysqli= new mysqli("localhost","root","","classicmodels") or die($mysqli->connect_error);
    ini_set('display_error',1);
    echo "Ket noi thanh cong";
?>