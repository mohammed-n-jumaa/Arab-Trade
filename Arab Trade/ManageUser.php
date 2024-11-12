<?php
session_start();
require_once("./db/connection.php");


if (isset($_POST['Block'])) {
    $postId = $_POST['post-id'] ?? 0;
    $sql = "UPDATE users SET status = 0 WHERE id = $postId ";
    $delete = $connection->prepare($sql);
    $delete->execute();
    return header('Refresh: 0');
}

if (isset($_POST['UnBlock'])) {
    $postId = $_POST['post-id2'] ?? 0;
    $sql = "UPDATE users SET status = 1 WHERE id = $postId ";
    $delete = $connection->prepare($sql);
    $delete->execute();
    return header('Refresh: 0');
}

$id = $_GET['id'] ?? null;
if (isset($id)) {

    $postQuery = "SELECT degree.image image ,CONCAT(user.first_name, ' ', user.last_name) fullname,  
    FROM degree INNER JOIN users user ON degree.inserted_by = user.id WHERE user.id = {$id}";

    $postData = $connection->prepare($postQuery);
    $postData->execute();
    $postFormData = $postData->fetch();
}





$analyzerDataQuery = "SELECT users.type type, users.id id, users.status status, users.image profile_pic, CONCAT(users.first_name, ' ', users.last_name) fullname, degree.image degree FROM users LEFT JOIN degree ON degree.inserted_by = users.id ORDER BY type DESC";
$analyzerPdoObject = $connection->prepare($analyzerDataQuery);
$analyzerPdoObject->execute();
?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>ManageUser</title>
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

        <div class="modal fade clear-both" id="degree" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Degree</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body clear-both">
                    </div>

                </div>
            </div>
        </div>

        <div class="center">
            <?php include 'headerAdmin.php'; ?>
            <?php if (!empty($_GET['id'])): ?>
                <div>
                    <div>
                        <h2 style="background-color: black; color:white; margin-top:5px; width:450px;">
                            <?php echo "Full Name : " . $postFormData['fullname'] ?>
                        </h2>
                    </div>
                    <div class="float-right">
                        <h2 style="background-color: black; color:white;width:300px;">
                            <?php echo "User ID : " . $_GET['id'] ?? null ?>
                        </h2>
                    </div>
                    <div class="post-content" style="display:  flex; flex-direction: column; align-items: center;">
                        <img style="width: 40%" src="<?= "uploads/{$postFormData['image']}" ?>" alt="News Image selected">
                    </div>

                </div>


            <?php endif; ?>
            <div class="table_info">
                <table class="table">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Full name</th>
                        <th class="text-center">status </th>
                        <th class="text-center">type</th>
                        <th class="text-center">image</th>
                        <th class="text-center">Actions</th>
                    </tr>

                    <?php while ($row = $analyzerPdoObject->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr class="text-center">
                            <td style="vertical-align: middle;">
                                <?= $row['id'] ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <?= $row['fullname'] . ".." ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <?=  $row['status'] == 1 ? 'Active' : 'Inactive'; ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <?= $row['type'] ?? '---' ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <?php if (!empty($row['profile_pic'])): ?>
                                    <img style="width: 50px; border-radius: 200px; height: 50px;"
                                        src="<?= "uploads/{$row['profile_pic']}" ?>" alt="">
                                <?php else: ?>
                                    <img style="width: 75px; border-radius: 200px; height: 75px;"
                                        src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png">
                                <?php endif; ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <div style="display: flex; flex-direction: column; align-items: center">
                                    <?php if ($row['type'] == 'anlyzer'): ?>
                                        <img src="" alt="">
                                        <button data-modal="<?= 'uploads/' . $row['degree'] ?>" class="btn btn-primary"
                                            style="width: 50% ">View
                                            Degree</button>
                                    <?php endif; ?>

                                    <form method="post" style="width: 100%; margin-top: 5px;">
                                        <input type="hidden" name="post-id" value="<?= $row['id'] ?>">
                                        <input name="Block" type="submit" value="Block" class="btn btn-danger"
                                            style="width: 50%;margin-bottom: 5px;">

                                        <input type="hidden" name="post-id2" value="<?= $row['id'] ?>">
                                        <input name="UnBlock" type="submit" value="UnBlock" class="btn btn-warning"
                                            style="width: 50%;">
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

    $('body').on('click', "[data-modal]", function () {
        $("#degree").find(".modal-body").html(`<img src='${$(this).data('modal')}' />`)
        $("#degree").modal().show();
    })
</script>