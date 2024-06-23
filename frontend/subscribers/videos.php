<?php
require_once('header.php'); // تضمين الملف الذي يحتوي على الهيدر

// استعلام لاسترجاع كل الفيديوهات مع بيانات المستخدم
$qry = "SELECT videos.*, users.name as user_name FROM videos 
        INNER JOIN users ON videos.user_id = users.id 
        ORDER BY videos.id DESC";
require_once('config.php'); // تضمين ملف الاتصال بقاعدة البيانات
$cn = mysqli_connect(DB_HOST, DB_USER_NAME, DB_USER_PASSWORD, DB_NAME);
$rslt = mysqli_query($cn, $qry);

// التأكد من وجود نتائج
if (mysqli_num_rows($rslt) > 0) {
    $videos = mysqli_fetch_all($rslt, MYSQLI_ASSOC);
} else {
    $videos = []; // إذا لم تكن هناك نتائج، يتم تعيين $videos إلى مصفوفة فارغة
}

mysqli_close($cn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* استخدام التنسيقات التي قدمتها */
        * {
            margin: 0;
            box-sizing: border-box;
            padding: 0;
        }

        body {
            background-color: #EAEDED;
            color: white;
            font-family: sans-serif;
            place-items: center;
        }

        .app-vedio {
            position: relative;
            height: 600px;
            background-color: black;
            overflow: scroll;
            width: 100%;
            max-width: 350px;
            border-radius: 20px;
            margin-top: 10px;
            margin-left: 40%;
            scroll-snap-type: y mandatory;
        }

        .app-vedio::-webkit-scrollbar {
            display: none;
        }

        .vedio {
            position: relative;
            height: 100%;
            width: 100%;
            background-color: white;
            scroll-snap-align: start;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding-top: 1px;
            /* تعديل التباعد بين العناصر */
        }

        .vedio-player {
            object-fit: cover;
            width: 100%;
            height: calc(100% - 80px);
            /* تعديل ارتفاع الفيديو */
        }

        .footer {
            position: absolute;
            bottom: 10px;
            /* تعديل موضع .footer بحيث يكون أسفل الفيديو */
            width: 100%;
            display: flex;
            flex-direction: column;
            /* تغيير اتجاه العناصر في .footer */
            align-items: center;
            /* توسيط العناصر داخل .footer */
        }

        .img-marq {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: 10px;
            /* تعديل التباعد بين الصورة والنص المتحرك */
        }

        .download {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }



        .img-marq marquee {
            margin-left: 10px;
            /* تعديل التباعد بين الصورة والنص المتحرك */
            width: 90%;
        }

        .footer-text {
            margin-right: 130px;
            /* محاذاة النص بالوسط */
        }

        .footer-text h3,
        .footer-text p {
            color: white;
            /* تغيير لون النص إلى أبيض */
            margin-top: 10px;

            /* تعديل التباعد بين النصوص */
        }

        html {
            scroll-snap-type: y mandatory;
        }
    </style>
</head>

<body>
    <div class="app-vedio">
        <?php foreach ($videos as $video) : ?>
            <div class="vedio">
                <video src="<?= $video['location'] ?>" class="vedio-player"></video>
                <div class="footer">
                    <div class="footer-text">
                        <h3><?= $video['user_name'] ?></h3>
                        <p class="description">Welcome To My App</p>
                    </div>
                    <div class="img-marq">
                        <marquee>Hello To My Apps New best</marquee>
                    </div>
                    <a href="upload_video.php?video=<?= $video['id'] ?>"><img src="image/download.png" class="download"></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        const videos = document.querySelectorAll('.vedio-player');
        videos.forEach(video => {
            video.addEventListener('click', function() {
                if (video.paused) {
                    video.play();
                    document.querySelector('.footer h3').style.display = "block"; // إظهار اسم المستخدم عند بدء التشغيل
                    document.querySelector('.img-marq').style.display = "flex"; // إظهار الصورة والنص المتحرك عند بدء التشغيل
                } else {
                    video.pause();
                    document.querySelector('.footer h3').style.display = "none"; // إخفاء اسم المستخدم عند إيقاف التشغيل
                    document.querySelector('.img-marq').style.display = "none"; // إخفاء الصورة والنص المتحرك عند إيقاف التشغيل
                }
            });
        });
    </script>
</body>

</html>