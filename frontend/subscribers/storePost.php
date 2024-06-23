<?php
session_start();

if (!empty($_REQUEST["title"] && !empty($_REQUEST["content"]))) {

    require_once('../../classes.php');
    $user = unserialize($_SESSION["user"]);


    if ($_FILES["image"]["name"]) {
        $imageName = "../../images/posts/" . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], $imageName);
    } else {
        $imageName = null;
    }





    $user->store_post($_REQUEST["title"], $_REQUEST["content"], $imageName, $user->id);
    header("location:profile.php?msg=done");
} else {
    header("location:profile.php?msg=required_fields");
}
