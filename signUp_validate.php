<?php
session_start();

class Validate{

  private $firstname="";
  private $passwrd = "";
  private $email = "";
  private $phone = "";

  public $firstnameErr = "";
  public $passwrdErr = "" ;
  public $emailErr = "" ;
  public $phoneErr = "";

  function __construct(){
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $slno = trim($_POST["slno"]);
      $firstname = trim($_POST["firstname"]);
      $passwrd  = trim($_POST["passwrd"]);
      $email     = trim($_POST["email"]);
      $phone     = trim($_POST["phone"]);}

    function validate_firstname($v) {
      if(empty($v)){
          return "Please enter your firstname";
      }
      else if(!ctype_alpha($v)){
        return "Please enter only letters.";
      }
      else{
          return "";
      }
    }

    function validate_password($v) {
        if(empty($v)){
            return "Please enter your password";
        }
        else if(strlen($v) < 6) {
            return "At least 6 characters." ;
        }
        else{
            return "";
        }
    }
    function validate_email($v) {
        if(empty($v)){
            return "Please enter your email";
        }
        else if(!filter_var($v, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email address." ;
        }
        else{
            return "";
        }
    }
    function validate_phone($v) {
        if(empty($v)){
            return "Please enter your phone number";
        }
        else if(ctype_digit($v) && strlen($v) === 10) {
            return "" ;
        }
        else{
            return "Enter exactly 10 digits.";
        }
    } 

  $firstnameErr = validate_firstname($firstname);
  $passwrdErr  = validate_password($passwrd);
  $emailErr     = validate_email($email);
  $phoneErr     = validate_phone($phone);

  if (!$firstnameErr  && !$passwrdErr && !$emailErr && !$phoneErr) {
      $_SESSION['formdata'] = [
              'slno' => $slno,
              'firstname' => $firstname,
              'passwrd'  => $passwrd,
              'email'     => $email,
              'phone'     => $phone
          ];
          header("Location: success.php");
          exit;
      }
      else{
        $_SESSION['errors'] = [
              'firstnameErr' => $firstnameErr,
              'passwrdErr'  => $passwrdErr,
              'emailErr'     => $emailErr,
              'phoneErr'     => $phoneErr
          ];
          header("Location: signUp.php");
          exit;
      }

  }

}
  
$validator = new Validate();

?>