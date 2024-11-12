<?php
session_start();
require_once("./db/connection.php");

$id = $_GET['id'];
$analyzerDataQuery = "SELECT news.title title, news.inserted_date inserted_date, 
CONCAT(admins.first_name, ' ', admins.last_name) fullname, news.content content, news.image image 
FROM news INNER JOIN admin admins ON news.inserted_by = admins.id WHERE news.id = {$id}";

$analyzerPdoObject = $connection->prepare($analyzerDataQuery);
$analyzerPdoObject->execute();
$data = $analyzerPdoObject->fetch();





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
                        <img style="width: 40%" src="<?= "uploads/{$data['image']}" ?>" alt="News Image">

                    </div>
                    <p style="margin-top: 30px;font-size: 15px;">
                        <?= nl2br($data['content']) ?>
                    </p>

                    <div class="post-footer" style="width: 100%">
                        <ul>

                    </div>
                </div>
                <?php include 'footerUser.php'; ?>
</body>

</html>