<?php
session_start();
$errors = [];
if(empty($_REQUEST["name"])) $errors["name"] = "name is required";
if(empty($_REQUEST["email"])) $errors["email"] = "email is required";
if(empty($_REQUEST["pw"]) || empty($_REQUEST["pc"])) 
{$errors["pw"] = "password and password confirmation is required";}
else if ($_REQUEST["pw"] != $_REQUEST["pc"]) {
    $errors["pc"] ="password confirmation must be equal to password";
}
$name =htmlspecialchars(trim($_REQUEST["name"]));
$email =filter_var($_REQUEST["email"],FILTER_SANITIZE_EMAIL);
$password =htmlspecialchars($_REQUEST["pw"]);
$password_confirmation =htmlspecialchars($_REQUEST["pc"]);
$phone=htmlspecialchars($_REQUEST["phone"]);


if(!empty($_REQUEST["email"]) && !filter_var($_REQUEST["email"],FILTER_VALIDATE_EMAIL)) $errors["email"] ="email invalid format please add aa@pp.cc";

if (empty($errors)) {
    require_once('classes.php');
    try {
        $rslt = Subscriber::register($name,$email, md5($password),$phone);
        header("location:index.php?msg=sr");

    } catch (\Throwable $th) {
        header("location:register.php?msg=ar");
    }

}else {
    $_SESSION["errors"]=$errors;
    header("location:register.php");
}
?>