<?php
session_start();
require_once("./db/connection.php");

$id = $_GET['id'];
$analyzerDataQuery = "SELECT post.title title, post.inserted_date inserted_date, CONCAT(user.first_name, ' ', user.last_name) fullname, post.content content, post.image image FROM post INNER JOIN users user ON post.inserted_by = user.id WHERE post.id = {$id}";
$commentQuery = "SELECT comment.content comment, comment.inserted_date inserted_date, CONCAT(user.first_name, ' ', user.last_name) fullname FROM comment INNER JOIN users user ON comment.inserted_by = user.id WHERE comment.post_id = {$id}";
$analyzerPdoObject = $connection->prepare($analyzerDataQuery);
$analyzerPdoObject->execute();
$data = $analyzerPdoObject->fetch();

$commentsPdoObject = $connection->prepare($commentQuery);
$commentsPdoObject->execute();

if (isset($_POST['addComment'])) {
  $comment = $_POST['comment'] ?? '';
  if (empty($comment)) {
    $_SESSION['error'] = "Comment can't blank";
    return header("Refresh:0");
  }
  $sql = "INSERT INTO comment (content, inserted_by, inserted_date, status, post_id) VALUES (?, ?, NOW(), 1, ?)";
  $user = $connection->prepare($sql);
  $user->execute([$comment, $_SESSION['id'], $id]);
  $_SESSION['success'] = 'Comment Posted Successfully';
  return header("Refresh:0");
}

?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>ViewPosts</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="assets/font/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/font/font.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/style2.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/addnews.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/jquery.bxslider.css" media="screen" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="ViewPost.css">
  <link rel="stylesheet" type="text/css" href="assets\css\ViewPost.css">
  <style>
    .main_menu_area {
      overflow: visible;
      background: #0D0E0F;
      min-height: 50px
    }

    .main_menu_area ul {
      margin: 0;
      padding: 0;
      list-style: none
    }

    .main_menu_area ul li {
      float: left;
      position: relative
    }

    .main_menu_area ul li a {
      color: #FFF;
      display: block;
      font-family: 'bebasregular';
      font-size: 15px;
      padding: 18px 18.7px
    }

    .main_menu_area ul li a:hover {
      background: #CF0000
    }
  </style>
</head>

<body>
  <div class="body_wrapper">
    <div class="center">
      <?php include 'headerUser.php'; ?>
      <div>
        <div class="post">
          <h2 class="post-title">
            <?= $data['title'] ?>
          </h2>
          <p class="post-meta">
            <?= $data['inserted_date'] ?> |
            <?= $data['fullname'] ?>
          </p>
          <div class="post-content" style="display:  flex; flex-direction: column; align-items: center;">
            <?php if (!empty($data['image'])): ?>
              <img src="<?= "uploads/{$data['image']}" ?>" alt="">
            <?php else: ?>
             
            <?php endif; ?>
          </div>
          <p style="margin-top: 30px;font-size: 15px;">
            <?= nl2br($data['content']) ?>
          </p>
          <div class="post-footer" style="width: 100%">
            <ul>
              <div class="comment-section">
                <p style="font-size: 25px;"><strong>Comments</strong></p>
                <?php if (isset($_SESSION['id'])): ?>
                  <form class="comment-form" method="post">
                    <label for="comment">Add a comment</label>
                    <br>
                    <textarea placeholder="Add a comment" style="padding: 15px;" id="comment" name="comment"></textarea>
                    <input value="Add Comment" class="btn btn-danger" name="addComment" type="submit" />
                  </form>
                <?php endif; ?>

                <div class="comments-container">
                  <?php while ($row = $commentsPdoObject->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="comment">
                      <div class="comment-details">
                        <span class="comment-author">
                          <?= $row['fullname'] ?> |
                          <?= $row['inserted_date'] ?>
                        </span>
                      </div>
                      <div class="comment-text">
                        <?= $row['comment'] ?>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
          </div>
        </div>
        <?php include 'footerUser.php'; ?>
</body>

</html>