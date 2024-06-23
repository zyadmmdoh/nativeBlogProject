<?php
require_once('header.php');
$user = unserialize($_SESSION["user"]);
$myposts = $user->my_posts($user->id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            width: 100%;
        }

        .profile,
        .post-form,
        .posts {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 10px;
            width: 90%;
            max-width: 800px;
        }

        .profile {
            text-align: center;
        }

        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .post-form {
            margin-bottom: 20px;
        }

        .posts {
            width: 100%;
            /* Full width for posts */
        }

        .post {
            background-color: #fff;
            padding: 15px;
            margin: 0;
            /* Remove margin */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            width: 100%;
            /* Full width for post */
            box-sizing: border-box;
            /* Include padding in width */
        }

        .post img {
            max-width: 100%;
            border-radius: 8px;
        }

        .post-content {
            position: relative;
            padding-bottom: 10px;
        }

        .alert-message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            border-radius: 5px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            text-align: center;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #4CAF50;
            color: white;
        }

        .alert-danger {
            background-color: #f44336;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        .form-control {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            padding: 10px;
            margin-top: 10px;
            border: none;
            background-color: #1877f2;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #155db0;
        }

        .comment-form {
            margin-top: 10px;
        }

        .mt-2 {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="profile">
            <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'uius') { ?>
                <div id="successMessage" class="alert-message">Image updated successfully</div>
            <?php } ?>
            <img src="<?php echo !empty($user->image) ? $user->image : 'profile.jpg'; ?>" alt="Profile Picture">
            <h5><?= $user->name ?></h5>
            <p><?= $user->role ?></p>
            <form action="store_user_image.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image" class="form-control mb-2">
                <button type="submit" class="btn">Save</button>
            </form>
        </div>

        <div class="post-form">
            <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'done') { ?>
                <div class="alert alert-success">Post added successfully</div>
            <?php }
            if (isset($_GET["msg"]) && $_GET["msg"] == 'required_fields') { ?>
                <div class="alert alert-danger">Required fields are missing</div>
            <?php } ?>
            <form action="storePost.php" method="post" enctype="multipart/form-data">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control">

                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control"></textarea>

                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">

                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>

        <div class="posts">
            <?php foreach ($myposts as $post) { ?>
                <div class="post">
                    <div class="post-content">
                        <h5><?= $post["title"] ?></h5>
                        <p><?= $post["content"] ?></p>
                    </div>
                    <?php if (!empty($post["image"])) { ?>
                        <img src="<?= $post["image"] ?>" alt="Post Image">
                    <?php } ?>

                    <form action="store_comment.php" method="post" class="comment-form">
                        <input type="text" name="comment" class="form-control" placeholder="Write a comment...">
                        <input type="hidden" name="post_id" value="<?= $post["id"] ?>">
                        <button type="submit" class="btn">Comment</button>
                    </form>

                    <?php
                    $comments = $user->get_post_comment($post["id"]);
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            echo '<div class="mt-2"><strong>' . $comment["user_id"] . '</strong>: ' . $comment["comment"] . '</div>';
                        }
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
        // Wait until the DOM is fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            // Select the success message element
            var successMessage = document.getElementById('successMessage');

            // Check if the success message element exists
            if (successMessage) {
                // Function to show the message and then hide it after a certain time
                successMessage.style.display = 'block'; // Show the message
                setTimeout(function() {
                    successMessage.style.display = 'none'; // Hide the message after 3 seconds
                }, 10000); // Adjust the time as needed (3000 milliseconds = 3 seconds)
            }
        });
    </script>
</body>

</html>