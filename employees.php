<?php
    include('../koneksi.php');
    
    $connection = getConnect(); 
    $request_method = $_SERVER['REQUEST_METHOD']; 

    function get_karyawan($id = 0) {
        global $connection; 
        $querysql = "SELECT * FROM tbl_employee"; 

        if ($id != 0) {
            $querysql .= " WHERE tbl_employee.id = $id;";        
        }
        $respons = array(); 
        $resultdata = mysqli_query($connection, $querysql); 
        
        while ($row = mysqli_fetch_assoc($resultdata)) { 
            $respons[] = $row;
        }
        header("Content-Type:application/json");
        echo json_encode($respons); 
    }

    
    function insert_employee() {
        global $connection; 
        $data = json_decode(file_get_contents("php://input"), true); 
        
        $employeename = $data['employee_name']; 
        $employeesalary = $data['employee_salary'];
        $employeeage = $data['employee_age'];
        
        $querysql = "INSERT INTO `tbl_employee` (`ID`, `employee_name`, `employee_salary`, `employee_age`) VALUES (NULL, '$employeename', '$employeesalary', '$employeeage');";
        
        if (mysqli_query($connection, $querysql)) {
            $respons = array('status' => 1, 'status_message' => 'Employee Added Succesfully');
        } else {
            $respons = array('status' => 0, 'status_message' => 'Employee Added Failed');
        }
        header('Content-Type:application/json');
        echo json_encode($respons);
    }

    
    function update_employe($id) {
    
        global $connection;
        $varpost = json_decode(file_get_contents("php://input"), true);
        
        $employeename = $varpost['employee_name']; 
        $employeesalary = $varpost['employee_salary'];
        $employeeage = $varpost['employee_age'];
        
        $querysql = "UPDATE `tbl_employee` SET `employee_name` = '$employeename', `employee_salary` = '$employeesalary', `employee_age` = '$employeeage' WHERE `tbl_employee`.`ID` = $id;";
        
        if (mysqli_query($connection, $querysql)) {
            $respons = array('status' => 1, 'status_message' => 'Employee Update Succesfully');
        } else {
            $respons = array('status' => 0, 'status_message' => 'Employee Update Failed');
        }
        header("Content-Type:application/json");
        echo json_encode($respons);
    }

    
    function delete_employe($id) {
    
        global $connection;
        
        $querysql = "DELETE FROM `tbl_employee` WHERE `tbl_employee`.`ID` = $id";
        
        if (mysqli_query($connection, $querysql)) {
            $respons = array('status' => 1, 'status_message' => 'Employee Delete Succesfully');
        } else {
            $respons = array('status' => 0, 'status_message' => 'Employee Delete Failed');
        }
        header("Content-Type:application/json");
        echo json_encode($respons);
    }

    
    switch ($request_method) {
        
        case "GET":
            
            if (!empty($_GET["id"])) {
                get_karyawan(intval($_GET["id"])); 
            } else {
                get_karyawan(); 
            }
            break;

        case 'POST':
            insert_employee();
            break;

        case 'PUT':
            $id = intval($_GET["id"]);
            update_employe($id); 
            break;

        case 'DELETE':
            $id = intval($_GET["id"]);
            delete_employe($id);
            break;

      default:
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
?>