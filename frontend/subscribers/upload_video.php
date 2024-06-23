<?php
require_once('header.php'); // تضمين الملف الذي يحتوي على الهيدر

// التأكد من أن المستخدم مسجل دخوله والحصول على معلوماته
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن مسجلاً دخوله
    exit();
}

$user = unserialize($_SESSION['user']);

// عملية رفع الفيديو
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video']) && !empty($_FILES['video']['name'])) {
    $uploadDir = 'videos/';
    $uploadFile = $uploadDir . basename($_FILES['video']['name']);
    $videoName = htmlspecialchars($_POST['name']);
    $videoTitle = htmlspecialchars($_POST['title']);
    $videoSubject = htmlspecialchars($_POST['subject']);
    $user_id = $user->id;

    if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadFile)) {
        $location = $uploadFile;

        // قم بحفظ الفيديو والبيانات في قاعدة البيانات
        $qry = "INSERT INTO videos (user_id, name, location, title, subject) 
                VALUES ('$user_id', '$videoName', '$location', '$videoTitle', '$videoSubject')";
        require_once('config.php'); // تضمين ملف الاتصال بقاعدة البيانات
        $cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
        $rslt = mysqli_query($cn, $qry);
        mysqli_close($cn);

        // إعادة توجيه المستخدم بعد الإضافة
        header('Location: videos.php?msg=uploaded');
        exit();
    } else {
        echo '<p>Sorry, there was an error uploading your file.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Upload Video</h2>
        <form action="upload_video.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <textarea class="form-control" id="subject" name="subject" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">Choose Video</label>
                <input type="file" class="form-control" id="video" name="video" accept="video/mp4,video/x-m4v,video/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>

</html>