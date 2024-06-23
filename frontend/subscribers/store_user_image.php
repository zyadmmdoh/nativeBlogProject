<?php

session_start();
require_once('../../classes.php');
$user = unserialize($_SESSION["user"]);
if (!empty($_FILES["image"]["name"])) {
    $imageName = "../../images/users/" . $_FILES["image"]["name"];
    move_uploaded_file($_FILES["image"]["tmp_name"], $imageName);

    $user->update_profile_pic($imageName,$user->id);
    $user->image = $imageName;
    $_SESSION["user"] = serialize($user);
    header("location:profile.php?msg=uius");

}else {
    header("location:profile.php?msg=required_image");
}


?>