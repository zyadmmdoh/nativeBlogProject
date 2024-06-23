<?php
// يتضمن ملف الهيدر المطلوب
require_once('header.php');
$homePosts = $user->home_posts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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
      padding: 0 20px;
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
    }

    .post {
      background-color: #fff;
      padding: 15px;
      margin: 10px 0;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .post-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .post-header h6 {
      margin: 0;
    }

    .post-header span {
      margin-left: 10px;
      color: #777;
    }

    
    .post-content h5 , .post-content p {
      margin-right: 500px;
    }

    .post img {
      width: 100%;
      max-width: 100%;
      border-radius: 8px;
      margin-bottom: 10px;
      object-fit: cover;
    }

    .alert-message,
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

    .comments {
      margin-top: 15px;
    }

    .comment {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }

    .comment img {
      border-radius: 50%;
      width: 25px;
      height: 25px;
      object-fit: cover;
      margin-right: 10px;
    }

    .comment p {
      margin: 0;
    }

    @media (max-width: 768px) {

      .post,
      .post-form,
      .profile,
      .posts {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <main>
    <section class="py-2 text-center container">
      <div class="profile">
        <h1 class="fw-light">
          Welcome
          <?php if (is_object($user) && property_exists($user, 'name')) : ?>
            <?= htmlspecialchars($user->name) ?>
          <?php else : ?>
            Guest
          <?php endif; ?>
        </h1>
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
        <?php foreach ($homePosts as $post) { ?>
          <div class="post">
            <div class="post-header">
              <h6><?= htmlspecialchars($post["name"]) ?></h6>
              <span><?= htmlspecialchars($post["created_at"]) ?></span>
            </div>
            <div class="post-content">
              <h5><?= htmlspecialchars($post["title"]) ?></h5>
              <p><?= htmlspecialchars($post["content"]) ?></p>
              <?php if (!empty($post["image"])) { ?>
                <img src="<?= htmlspecialchars($post["image"]) ?>" alt="Post Image">
              <?php } ?>
            </div>

            <div class="comments">
              <?php
              $comments = $user->get_post_comment($post["id"]);
              if (!empty($comments)) {
                foreach ($comments as $comment) { ?>
                  <div class="comment">
                    <img src="<?= !empty($comment['image']) ? htmlspecialchars($comment['image']) : 'profile.jpg'; ?>" alt="avatar">
                    <p><?= htmlspecialchars($comment["comment"]) ?></p>
                  </div>
              <?php } // End of inner foreach 
              } // End of if comments 
              ?>
            </div>

            <form action="store_comment.php" method="post" class="comment-form">
              <input type="text" name="comment" class="form-control" placeholder="Write a comment...">
              <input type="hidden" name="post_id" value="<?= htmlspecialchars($post["id"]) ?>">
              <button type="submit" class="btn">Comment</button>
            </form>
          </div>
        <?php } // End of outer foreach 
        ?>
      </div>
    </section>
  </main>
</body>

</html>