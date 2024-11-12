<?php
session_start();
require_once("./db/connection.php");
$analyzerDataQuery = "SELECT * FROM courses WHERE status = 1 ORDER BY inserted_date DESC";
$analyzerPdoObject = $connection->prepare($analyzerDataQuery);
$analyzerPdoObject->execute();
?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Courses</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="assets/font/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/font/font.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/style2.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/jquery.bxslider.css" media="screen" />
  <link rel="stylesheet" href="assets/css/styleN.css.css">
  <style>
    .backgro {
      border: solid 1px black;
      padding-top: 10px;
      margin-top: 2px;
      margin-bottom: 10px;
      background-color: #101010;
      color: white;
      height: 50px;

    }
    .main_menu_area{overflow:visible; background:#0D0E0F; min-height:50px}
.main_menu_area ul{margin:0; padding:0; list-style:none}
.main_menu_area ul li{float:left; position:relative}
.main_menu_area ul li a{color:#FFF; display:block; font-family:'bebasregular'; font-size:15px; padding:18px 18.7px}
.main_menu_area ul li a:hover{background:#CF0000}
  </style>
</head>

<body>
  <div class="body_wrapper">
    <div class="center">
      <?php include 'headerUser.php'; ?>
      <div class="backgro">
        <center>
          <h2 style="color: white;font-size: 20px;"><strong>Courses</strong></h2>
        </center><br>
      </div>

      <div class="container">
        <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'anlyzer'): ?>
          <a href="addcourses.php" class="btn btn-danger" style="font-weight:bold; letter-spacing: 1px;">
            Manage Courses
          </a>
        <?php endif; ?>
        <hr>

        <div class="news-grid">
          <?php while ($row = $analyzerPdoObject->fetch(PDO::FETCH_ASSOC)): ?>
            <a href="ViewCoursesDet.php?id=<?= $row['id'] ?>" class="news-story">
              <?php if (!empty($row['image'])): ?>
                <div class="news-image" style="background-image: url(<?= "uploads/{$row['image']}" ?>)"></div>
              <?php else: ?>
                <div class="news-image"
                  style="background-image: url(https://archive.org/download/no-photo-available/no-photo-available.png)">
                </div>
              <?php endif; ?>

              <div class="news-content">
                <p class="date">
                  <?= $row['inserted_date'] ?>
                </p>
                <h2>
                  <?= $row['title'] ?>
                </h2>
                <p>
                  <?= substr($row['content'], 0, 50) . " ..." ?>
                </p>
              </div>
            </a>
          <?php endwhile; ?>
        </div>
      </div>
      <?php include 'footerUser.php'; ?>
    </div>
  </div>
</body>

</html>