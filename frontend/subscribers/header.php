<?php
session_start();
require_once('../../classes.php');

if (empty($user = unserialize($_SESSION["user"]))) {
  header("location:index.php?msg=require_auth");
}

?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="../../assets\js\color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.122.0">
  <title>Album example · Bootstrap v5.3</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

  <link href="../../assets\dist\css\bootstrap.min.css" rel="stylesheet">

  <style>
    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: blue;
      padding: 5px 5%;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .nav-left {
      display: flex;
      align-items: center;
    }

    .nav-left ul li {
      list-style: none;
      display: inline-block;
    }

    .nav-left ul li img {
      width: 28px;
      margin: 0 15px;
      cursor: pointer;
      padding-top: 10px;
    }

    .nav-right {
      display: flex;
      align-items: center;
    }

    .nav-right button {

      padding: 5px;
      border-radius: 5px;
      background-color: white;
      color: #3498DB;
      font-weight: bold;
      outline: none;
      border: none;
      margin-left: 20px;

    }

    .nav-right button a{
text-decoration: none;


    } 
    
    nav .search-box {
      display: flex;
      align-items: center;
      padding: 0 10px;
      background-color: #efefee;
      width: 350px;
      border-radius: 50px;
    }

    .search-box input {
      width: 100%;
      background-color: transparent;
      padding: 10px;
      outline: none;
      border: none;
    }

    .nav-user-icon img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      cursor: pointer;
      margin-left: 20px;
      object-fit: cover;
    }

    .online {
      position: relative;
    }

    .online::after {
      content: "";
      width: 7px;
      height: 7px;
      border: 1px solid #fff;
      border-radius: 50%;
      background-color: rgb(20, 175, 20);
      position: absolute;
      top: 0;
      right: 2px;
    }
  </style>

</head>

<body>
  <nav>
    <div class="nav-left">
      <ul>
        <li><a href="videos.php"><img src="image/video.png"></a></li>
        <li><a href="home.php"><img src="image/profile-home.png"></a></li>

      </ul>
    </div>
    <div class="nav-right">
      <div class="search-box">
        <img src="image/search.png">
        <input type="text" placeholder="Search">
      </div>

      <div class="nav-user-icon online">
        <?php if ($user) : ?>
          <a href="profile.php"><img src="<?php echo !empty($user->image) ? $user->image : 'profile.jpg'; ?>" alt="Profile"></a>
        <?php else : ?>
          <!-- إذا لم يتم تسجيل الدخول، يمكنك إضافة صورة افتراضية هنا -->
          <a href="login.php"><img src="profile.jpg" alt="Profile"></a>
        <?php endif; ?>
      </div>
      <button><a href="../../index.php">Logout</a></button>
    </div>
  </nav>
</body>

</html>