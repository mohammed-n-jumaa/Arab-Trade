<?php
session_start();
require_once("./db/connection.php");
if (isset($_SESSION['type']) && $_SESSION['type'] != 'anlyzer') {
  header('home_page.php');
}

if (isset($_POST['delete'])) {
  $postId = $_POST['post-id'] ?? 0;
  $sql =  "UPDATE news SET status = 0 WHERE id = $postId ";
  $delete = $connection->prepare($sql);
  $delete->execute();
  return header('Refresh: 0');

}

$id = $_GET['id'] ?? null;

if (isset($id)) {
  $postQuery = "SELECT * FROM news WHERE id = {$id} AND status = 1";
  $postData = $connection->prepare($postQuery);
  $postData->execute();
  $postFormData = $postData->fetch();
}

if (isset($_POST['update-post'])) {
  $title = $_POST['title'] ?? '';
  $content = $_POST['content'] ?? '';
  if (empty($title) || empty($content))
    die('Invalid Data');

  $fileNemeNew = "";
  if (!empty($_FILES['image'])) {
    $file = $_FILES['image'];
    $fileName = $_FILES['image']['name'];
    $fileTempName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowedExt = array("jpg", "jpeg", "png", "pdf");

    if (empty($fileActualExt) || in_array($fileActualExt, $allowedExt)) {
      if ($fileError == 0) {
        if ($fileSize < 10000000) {
          $fileNemeNew = uniqid('', true) . "." . $fileActualExt;
          $fileDestination = 'uploads/' . $fileNemeNew;
          move_uploaded_file($fileTempName, $fileDestination);
        }
      }
    }

  }

  $fileNemeNew = !empty($fileNemeNew) ? $fileNemeNew : $postFormData['image'];
  $sql = "UPDATE news SET title = ?, content = ?, updated_by = ?, updated_date = NOW(), image = ? WHERE id = $id";
  $user = $connection->prepare($sql);
  $user->execute([$title, $content, $_SESSION['id'], $fileNemeNew]);
  $_SESSION['success'] = 'News Updated Successfully';
  return header('Refresh: 0');
}

if (isset($_POST['new-post'])) {
  $title = $_POST['title'] ?? '';
  $content = $_POST['content'] ?? '';
  if (empty($title) || empty($content))
    die('Invalid Data');

  $file = $_FILES['image'];
  $fileName = $_FILES['image']['name'];
  $fileTempName = $_FILES['image']['tmp_name'];
  $fileSize = $_FILES['image']['size'];
  $fileError = $_FILES['image']['error'];
  $fileType = $_FILES['image']['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));
  $allowedExt = array("jpg", "jpeg", "png", "pdf");
  $fileNemeNew = "";

  if (in_array($fileActualExt, $allowedExt)) {
    if ($fileError == 0) {
      if ($fileSize < 10000000) {
        $fileNemeNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestination = 'uploads/' . $fileNemeNew;
        move_uploaded_file($fileTempName, $fileDestination);
      } else {
        echo "File Size Limit beyond acceptance";
      }
    } else {
      echo "Something Went Wrong Please try again!";
    }
  } else {
    echo "You can't upload this extention of file";
  }


  $sql = "INSERT INTO news (title, content, inserted_by, inserted_date, status, image) VALUES (?, ?, ?, NOW(), 1, ?)";
  $user = $connection->prepare($sql);
  $user->execute([$title, $content, $_SESSION['id'], $fileNemeNew]);
  $_SESSION['success'] = 'News Added Successfully';
  return header('Refresh: 0');
}

$analyzerDataQuery = "SELECT * FROM news WHERE  status = 1 ORDER BY inserted_date DESC";
$analyzerPdoObject = $connection->prepare($analyzerDataQuery);
$analyzerPdoObject->execute();
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Add News</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="assets/font/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/font/font.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/style2.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/jquery.bxslider.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/news.css">
  <style>
    .adminLogo {
      width: 50%;
      height: 50%;
      padding-top: 0px;
      padding-right: 0px;
    }

    tr td a:hover {

      color: red;
      text-decoration: underline;

    }

    tr th {

      color: black;
      text-decoration: underline;

    }

    .table_info {
      height: auto;
      border: solid 1px black;
      margin-top: 3px;
      margin-bottom: 13px;
      border-radius: 5px;
      font-size: 15px;
      font-family: monospace;
    }
  </style>
</head>

<body>
  <div class="body_wrapper">
    <div class="center">
      <?php include 'headerAdmin.php'; ?>

      <div class="newsDiv">
        <div class="titlediv">
          <h2 style="letter-spacing: 2px;"><strong>Add News</strong></h2>
          <hr>
        </div>

        <form action="" id="Admin-form" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <label style="letter-spacing: 1px;">Title</label>
              <div style="margin-top: 10px">
                <input value="<?= $postFormData['title'] ?? '' ?>" type="text" style="padding: 10px;"
                  class="form-control" placeholder="Title" name="title"></input>
              </div>
              <span class="text-danger" style="margin-top: 10px; display: block;" data-input="title"></span>
            </div>

            <div class="col-lg-6">
              <label style="letter-spacing: 1px;">Select photo</label>
              <div style="margin-top: 10px">
                <input type="file" class="form-control" id="img" name="image" accept="image/*">
              </div>
            </div>

            <div class="col-lg-12" style="margin-top: 100px;">
              <label style="letter-spacing: 1px;">Content</label>
              <div style="margin-top: 10px">
                <textarea placeholder="Content" name="content" style="width: 100%; padding: 10px;"
                  rows="10"><?= $postFormData['content'] ?? '' ?></textarea>
              </div>
              <span class="text-danger" style="margin-top: 10px; display: block;" data-input="content"></span>
            </div>

            <div class="col-lg-12">
              <input type="submit" name="<?= isset($id) ? 'update-post' : 'new-post' ?>" value="Publish"
                class="btn btn-info" style="margin-top: 25px;">
            </div>
          </div>
        </form>



      </div>
      <div class="table_info">
        <table class="table" >
          <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Title</th>
            <th class="text-center">inserted_by</th>
            <th class="text-center">inserted_date</th>
            <th class="text-center">updated_by</th>
            <th class="text-center">updated_date </th>
            <th class="text-center">image</th>
            <th class="text-center">Actions</th>
          </tr>

          <?php while ($row = $analyzerPdoObject->fetch(PDO::FETCH_ASSOC)): ?>
            <tr class="text-center">
              <td style="vertical-align: middle;">
                <?= $row['id'] ?>
              </td>
              <td style="vertical-align: middle;">
                <?= substr($row['title'], 0, 5) . ".." ?>
              </td>
              <td style="vertical-align: middle;">
                <?= $row['inserted_by']?? '--' ?>
              </td>
              <td style="vertical-align: middle;">
                <?= $row['inserted_date'] ?>
              </td>
              <td style="vertical-align: middle;">
                <?= $row['updated_by']?? '--' ?>
              </td>
              <td style="vertical-align: middle;">
                <?= $row['updated_date'] ?? '--' ?>
              </td>
              <td style="vertical-align: middle;">
                <?php if (!empty($row['image'])): ?>
                  <img style="width: 50px; border-radius: 200px; height: 50px;" src="<?= "uploads/{$row['image']}" ?>"
                    alt="">
                <?php else: ?>
                  <img style="width: 75px; border-radius: 200px; height: 75px;"
                    src="https://archive.org/download/no-photo-available/no-photo-available.png">
                <?php endif; ?>
              </td>
              <td style="vertical-align: middle;">
                <div style="display: flex; flex-direction: column; align-items: center">
                  <a href="?id=<?= $row['id'] ?>" class="btn btn-warning" style="width: 60% ">UPDATE</a>
                  <form method="post" style="width: 100%; margin-top: 5px;">
                    <input type="hidden" name="post-id" value="<?= $row['id'] ?>">
                    <input name="delete" type="submit" value="DELETE" class="btn btn-danger" style="width: 60%;">
                  </form>
                </div>
              </td>
            </tr>
          <?php endwhile; ?>
        </table>
      </div>
      <?php include 'footerAdmin.php'; ?>
    </div>
  </div>
</body>

</html>

<script>
  $("#Admin-form").on('submit', function (e) {
    const requiredInputs = ['title', 'content']
    requiredInputs.forEach((item) => {
      const input = $(`[name="${item}"]`)
      if (input.val().length == 0) {
        e.preventDefault();
        $(`[data-input="${item}"]`).text(`${item} can't be Empty!`)
      }
    })
  })
</script>