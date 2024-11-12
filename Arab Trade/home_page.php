<?php
session_start();
require_once("./db/connection.php");
$newsDataQuery = "SELECT * FROM news where status  =1 ORDER BY id DESC LIMIT 3";
$newsPdoObject = $connection->prepare($newsDataQuery);
$newsPdoObject->execute();


$postDataQuery = "SELECT * FROM post where status  =1 ORDER BY id DESC LIMIT 3";
$postPdoObject = $connection->prepare($postDataQuery);
$postPdoObject->execute();


$CoursesDataQuery = "SELECT * FROM courses where status  =1  ORDER BY id DESC LIMIT 3";
$CoursesPdoObject = $connection->prepare($CoursesDataQuery);
$CoursesPdoObject->execute();
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>ArabTrade</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="assets/font/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/font/font.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/style2.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/responsive.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="assets/css/jquery.bxslider.css" media="screen" />
  <link href="assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
  <link rel="stylesheet" type="text/css" href="assets/css/forms/switches.css">
  <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="assets/css/styleN.css.css">

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

    .news-style {
      display: grid;
      grid-template-columns: repeat(50px, 3fr);
      grid-gap: 1rem;
      row-gap: 50px;
      max-width: 350px;
    }
  </style>


</head>

<body>
  <div class="body_wrapper">
    <div class="center">
      <?php include 'headerUser.php'; ?>
      <div class="slider_area">
        <div class="slider">
          <ul class="bxslider">
            <li><img src="images/photo.jpg" style="height: 350px;width: 1000px;" alt=""  /></li>
            <li><img src="images/photo2.jpg" style="height: 350px;width: 1000px;" alt=""  /></li>
          </ul>
        </div>
      </div>
      <div class="content_area">
        <div class="main_content floatleft">
          <div class="left_coloum floatleft">

            <div class="single_left_coloum_wrapper">
              <h2 class="title">News</h2>
              <a class="more" href="ViewNews.php">more</a>
              <?php while ($row = $newsPdoObject->fetch(PDO::FETCH_ASSOC)): ?>
                <a href="ViewNewsDet.php?id=<?= $row['id'] ?>">
                  <div class="single_left_coloum floatleft">
                    <?php if (!empty($row['image'])): ?>
                      <img style="border: 1px dotted grey;" src="<?= "uploads/{$row['image']}" ?>" alt="">
                    <?php else: ?>
                      <img src="https://archive.org/download/no-photo-available/no-photo-available.png">
                    <?php endif; ?>
                    <h3>
                      <?= $row['title'] ?>
                    </h3>
                    <p>
                      <?= substr($row['content'],0,90)?>
                    </p>
                    <a class="readmore" href="ViewNewsDet.php?id=<?= $row['id'] ?>">read more</a>
                  </div>
                </a>
              <?php endwhile; ?>
            </div>

            <div class="single_left_coloum_wrapper">
              <h2 class="title">analysis</h2>
              <a class="more" href="Analysis.php">more</a>
              <?php while ($row = $postPdoObject->fetch(PDO::FETCH_ASSOC)): ?>
                <a href="ViewPost.php?id=<?= $row['id'] ?>">
                  <div class="single_left_coloum floatleft">
                    <?php if (!empty($row['image'])): ?>
                      <img style="border: 1px dotted grey;" src="<?= "uploads/{$row['image']}" ?>" alt="">
                    <?php else: ?>
                      <img src="https://archive.org/download/no-photo-available/no-photo-available.png">
                    <?php endif; ?>
                    <h3>
                      <?= $row['title'] ?>
                    </h3>
                    <p>
                      <?= substr($row['content'],0,90) ?>
                    </p>
                    <a class="readmore" href="ViewPost.php?id=<?= $row['id'] ?>">read more</a>
                  </div>
                </a>
              <?php endwhile; ?>
            </div>
            <div class="single_left_coloum_wrapper">
              <h2 class="title">Courses</h2>
              <a class="more" href="ViewNews.php">more</a>
              <?php while ($row = $CoursesPdoObject->fetch(PDO::FETCH_ASSOC)): ?>
                <a href="ViewNewsDet.php?id=<?= $row['id'] ?>">
                  <div class="single_left_coloum floatleft">
                    <?php if (!empty($row['image'])): ?>
                      <img style="border: 1px dotted grey;" src="<?= "uploads/{$row['image']}" ?>" alt="">
                    <?php else: ?>
                      <img src="https://archive.org/download/no-photo-available/no-photo-available.png">
                    <?php endif; ?>
                    <h3>
                      <?= $row['title'] ?>
                    </h3>
                    <p>
                      <?= substr($row['content'],0,90)?>
                    </p>
                    <a class="readmore" href="ViewCoursesDet.php?id=<?= $row['id'] ?>">read more</a>
                  </div>
                </a>
              <?php endwhile; ?>
            </div>

            <div class="single_left_coloum_wrapper single_cat_left">
              <h2 class="title">Crypetocurrncy</h2>
              <a class="more" href="crypetocurrncy.php">more</a>
              <div class="single_cat_left_content floatleft">
                <h3>ADAUSDT</h3>
                <div class="td-content" style="font-size:15px;margin-top:15px;" data-currency="ADAUSDT">-API-</div>
              </div>
              <div class="single_cat_left_content floatleft">
                <h3>SOLUSDT</h3>
                <div class="td-content" style="font-size:15px;margin-top:15px;" data-currency="SOLUSDT">-API-</div>
              </div>


              <div class="single_cat_left_content floatleft">
                <h3>MATICUSDT</h3>
                <div class="td-content" style="font-size:15px;margin-top:15px;" data-currency="MATICUSDT">-API-</div>
              </div>

              <div class="single_cat_left_content floatleft">
                <h3>DOTUSDT</h3>
                <div class="td-content" style="font-size:15px;margin-top:15px;" data-currency="DOTUSDT">-API-</div>
              </div>

              <div class="single_cat_left_content floatleft">
                <h3>BTCUSDT</h3>
                <div class="td-content" style="font-size:15px;margin-top:15px;" data-currency="BTCUSDT">-API-</div>
              </div>

              <div class="single_cat_left_content floatleft">
                <h3>ETHUSDT</h3>
                <div class="td-content" style="font-size:15px;margin-top:15px;" data-currency="ETHUSDT">-API-</div>
              </div>

            </div>
          </div>
          <div class="right_coloum floatright">


          </div>
        </div>
        <div class="sidebar floatright">
          <div class="single_sidebar"> <img src="images/opensooq.jpeg" alt="" /> </div>
          <div class="single_sidebar"> <img src="images/talabat.jpeg" alt="" /> </div>
          <div class="single_sidebar"> <img src="images/Carfo.webp" alt="" /> </div>
          <div class="single_sidebar">
            <div class="single_sidebar"> <img src="images/zrqaaUni.png" alt="" /></div>
          </div>
        </div>
        <?php include 'footerUser.php'; ?>
      </div>
    </div>
</body>

</html>

<script>
  const neededCurrencies = [
    'BTCUSDT',
    'ETHUSDT',
    'BNBUSDT',
    'ADAUSDT',
    'SOLUSDT',
    'MATICUSDT',
    'DOTUSDT',
  ]

  $(document).ready(function () {
    $.ajax({
      url: 'https://api.binance.com/api/v3/ticker/price',
      async: false,
      success: function (response) {
        response?.forEach(item => {
          if (neededCurrencies.includes(item.symbol)) {
            $(`[data-currency="${item.symbol}"]`).text((Math.round(item.price * 100) / 100).toFixed(2))
          }
        });
      }
    })
  })
</script>