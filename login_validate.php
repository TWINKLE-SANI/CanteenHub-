<?php
require_once 'Database.php';
session_start();
    class LoginCheck{

        private $username;
        private $passwrd;
        private $user;
        private $user_id;

        public function __construct(){

            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['username'], $_POST['passwrd'])) { 
                $this->username = $_POST['username'];
                $this->passwrd = $_POST['passwrd'];
            }
            else {
                die("Invalid request.");
            }
        }

        public function checkCredentials(){ 
            if (empty($this->username) || empty($this->passwrd)){
                $_SESSION['login_error'] = "Please enter your username and password.";
                header("Location: login.php");
                exit();
            }
            else if(empty($this->username)){
                $_SESSION['login_error'] = "Please enter your username";
                header("Location: login.php");
                exit();
            }
            else if(empty($this->passwrd)){
                $_SESSION['login_error'] = "Please enter your password";
                header("Location: login.php");
                exit();
            }
            $db = new Database();
            $conn = $db->getConnection();
            $stmt = $conn->prepare("SELECT * FROM users WHERE firstname = ?");
            $stmt->bind_param("s", $this->username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $_SESSION['login_error'] = "Username not found.";
                header("Location: login.php");
                exit();
            }

            $user = $result->fetch_assoc();

            if ($user['passwrd'] === $this->passwrd && $user['user_role_id']===2) {
                header("Location: owner_homePage.php");
                exit();
            } 
            else if ($user['passwrd'] === $this->passwrd && $user['user_role_id']===1) {
                $user_id = $user['slno'];
                $_SESSION['slno'] = $user_id;
                header("Location: user_homePage.php");
                exit();
            } 
            else {
                $_SESSION['login_error'] = "Username and password do not match.";
                header("Location: login.php");
                exit();
            }

            $stmt->close();
            $conn->close();
        } 
    }
    $login=new LoginCheck();
    $login->checkCredentials();
?>