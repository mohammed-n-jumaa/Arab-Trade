<?php session_start();
require_once("./db/connection.php");
$sql = "SELECT * FROM users WHERE id = {$_SESSION['id']}";
$pdo = $connection->prepare($sql);
$pdo->execute();
$userData = $pdo->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['change-image'])) {
  $fileNemeNew = '';
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
  
  $updateSql = "UPDATE users SET image = ? WHERE id = {$_SESSION['id']}";
  $updatePdo = $connection->prepare($updateSql);
  $updatePdo->execute([$fileNemeNew]);
  return header('Refresh: 0');
}
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Profile</title>
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
  <link rel="stylesheet" type="text/css" href="assets/css/profile.css">
  <style>
    .card {
      box-shadow: 0 4px 8px 1px rgba(105, 105, 105);
      margin-top: 25px;
      display: flex;
      justify-content: center;
      flex-direction: column;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fff;
      border-radius: 10px;
      padding: 30px;
    }


    .card img {
      width: 80%;
      border-radius: 20%;
      margin-bottom: 20px;
    }

    .card h1 {
      font-size: 28px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 18px;
      color: #555;
      margin-bottom: 15px;
      padding-top: 15px;
      padding-left: 25px;
    }

    .card p:hover {
      color:
    }

    .card .title {
      color: #00BFFF;
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .card a {
      text-decoration: none;
      color: #333;
      font-size: 24px;
      margin-right: 20px;
    }

    .card a:hover {
      color: #00BFFF;
    }

    .card input[type=submit] {
      border: none;
      outline: none;
      padding: 10px 20px;
      background-color: black;
      color: white;
      font-size: 18px;
      border-radius: 25px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 20px;
    }

    .card button:hover {
      background-color: white;
      color: black;
      border: 2px solid black;
    }

    .image {
      position: relative;
    }

    #profile-picture {
      width: 200px;
      height: 200px;
      border-radius: 30%;
      object-fit: cover;

    }

    #change-picture {
      position: absolute;
      bottom: 0;
      right: 0;
      background-color: #333;
      color: #fff;
      border: none;
      padding: 10px;
      cursor: pointer;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;

    }

    .image:hover #change-picture {
      opacity: 0.8;
    }

    #picture-input {
      display: none;

    }

    .details {
      margin-left: 50px;
    }

    h2 {
      font-size: 36px;
      margin-bottom: 10px;
    }

    p {
      font-size: px;
      margin-bottom: 5px;
    }

    #profile-pic-input {
      padding-left: 30%;
      padding-top: 10px;
    }

    .img-circle {
      width: 200px;
      border-radius: 200px;
    }
  </style>
</head>




<body>
  <div class="body_wrapper">
    <div class="center">
      <?php
      if ($_SESSION['user_type'] == 'admin') {
        include 'headerAdmin.php';
      } else {
        include 'headerUser.php';
      }
      ?>

      <div class="card">
        <?php if (empty($userData['image'])): ?>
          <img class="img-circle" src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" style="height: 60px;width: 90px;" alt="">
        <?php else: ?>
          <img class="img-circle" src="<?= 'uploads/' . $userData['image'] ?>"  alt="Profile Picture"  id="profile-picture">
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
          <input type="file" name="image" id="profile-pic-input"><br>
          <input name="change-image" value="Upload Profile Picture" type="submit">
        </form>

        <br><br><br><br>
        <p>
          <label>Type : </label>
          <?= $userData['type'] ?>
        </p>
        <p>
          <label>Full Name : </label>
          <?= $_SESSION['full_name'] ?>
        </p><br>
        <p>
        <label>Email  : </label>
          <?= $userData['email'] ; ?>
        </p><br>
        <p>
        <label>Status : </label>
          <?= $userData['status'] == 1 ? 'Active' : 'inactive'; ?>
        </p><br>
       
      </div>





      <?php
      if ($_SESSION['user_type'] == 'admin') {
        include 'footerAdmin.php';
      } else {
        include 'footerUser.php';
      }
      ?>



</body>

</html>