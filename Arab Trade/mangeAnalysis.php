<?php
session_start();
require_once("./db/connection.php");

if (isset($_POST['delete'])) {
  $postId = $_POST['post-id'] ?? 0;
  $sql =  "UPDATE post SET status = 0 WHERE id = $postId ";
  $delete = $connection->prepare($sql);
  $delete->execute();
  return header('Refresh: 0');
}

$analyzerDataQuery = "SELECT * FROM post where status = 1  ORDER BY inserted_date DESC";
$analyzerPdoObject = $connection->prepare($analyzerDataQuery);
$analyzerPdoObject->execute();
?>

<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Mange Analysis</title>
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
      <div class="backgro">
        <center>
          <h2 style="color: black;font-size: 20px;padding-top: 15px;"><strong>Mange Analysis</strong></h2>
        </center><br>
      </div>
     
      <div class="table_info">
        <table class="table">
          <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Title</th>
            <th class="text-center">status</th>
            <th class="text-center">inserted_by</th>
            <th class="text-center">inserted_date</th>
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
                <?= $row['status'] ?>
              </td>
              <td style="vertical-align: middle;">
                <?= $row['inserted_by'] ?>
              </td>
              
              <td style="vertical-align: middle;">
                <?= $row['inserted_date'] ?>
              </td>
              
              <td style="vertical-align: middle;">
                <?= $row['updated_date'] ?? '---' ?>
              </td>
              <td style="vertical-align: middle;">
                <?php if (!empty($row['image'])): ?>
                  <img style="width: 50px; border-radius: 200px; height: 50px;" src="<?= "uploads/{$row['image']}" ?>"
                    alt="">
                <?php else: ?>
                  <img style="width: 75px; border-radius: 200px; height: 75px;"
                    src="images/logo.jpg">
                <?php endif; ?>
              </td>
              <td style="vertical-align: middle;">
                <div style="display: flex; flex-direction: column; align-items: center">
                 
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
  $("#analyzer-form").on('submit', function (e) {
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