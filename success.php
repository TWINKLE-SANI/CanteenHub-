<?php
require_once 'Database.php'; 
session_start();

class Success{

    private $data;
    private $sql;

    public function __construct(){

        $db = new Database();
        $conn = $db->getConnection();

        if(isset($_SESSION['formdata'])){
            $data = $_SESSION['formdata'];
            
            if (!isset( $data['firstname'],$data['passwrd'], $data['email'], $data['phone'])) {
                die("Invalid session data.");
            }

            $sql = "INSERT INTO users (firstname, passwrd, email, phone,user_role_id) 
                    VALUES ('" . $data['firstname'] . "', '" . $data['passwrd'] . "', '" . $data['email'] . "', '" . $data['phone'] . "','1')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['signup-success']="USER CREATED SUCCESSFULLY !!";
                header("Location:login.php");
                exit;
            } else {
                echo "Error: " . $conn->error;
            }
        }
        else{
            echo "No Data in formdata.<br>";
        }

        $conn->close();
    }
}

$registerUser=new Success();

?>