<?php 
    function getConnect() {
        $dbhost = "127.0.0.1";
        $dbdatabase = "bd_test";
        $dbusername = "root";
        $dbpassword = ""; 
        $dbport = "3306";

        $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbdatabase, $dbport); 
        
        if ($conn->connect_error) {
            echo 'Koneksi error' . $conn->connect_error;
        } else {
            return $conn;
        }
    }   
?>