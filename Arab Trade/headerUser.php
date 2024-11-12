<?php

require_once("./db/connection.php");
if (isset($_POST['submit-user'])) {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        die('Invalid Data');
    }

    $sql = "INSERT INTO users (status, first_name,  last_name, email, Password, type) VALUES (1, ?, ?, ?, ?, 'user')";
    $connection->prepare($sql)->execute([$firstName, $lastName, $email, sha1($password)]);
    $_SESSION['success'] = 'User registered successfully ...  go to login';
}

if (isset($_POST['submit-anlyzer'])) {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die(' Error Format E-mail');
    }

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        die('Invalid Data');
    }

    $file = $_FILES['Degree'];
    $fileName = $_FILES['Degree']['name'];
    $fileTempName = $_FILES['Degree']['tmp_name'];
    $fileSize = $_FILES['Degree']['size'];
    $fileError = $_FILES['Degree']['error'];
    $fileType = $_FILES['Degree']['type'];

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

    $sql = "INSERT INTO users (status, first_name,  last_name, email, Password, type) VALUES
   (0, ?, ?, ?, ?, 'anlyzer')";
    $user = $connection->prepare($sql);
    $user->execute([$firstName, $lastName, $email, sha1($password)]);
    $userId = $connection->lastInsertId();

    $sql = "INSERT INTO `degree`(`image`,`inserted_by`, `updated_date`) VALUES (?, ?, NOW())";
    $connection->prepare($sql)->execute([$fileNemeNew, $userId]);
    $_SESSION['success'] = 'Analyzer registered successfully ... go to login';
}




if (isset($_POST['submit_login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($email) || empty($password)) {
        die('Invalid Data');
    }

    $type = 'user';
    $password = sha1($password);
    $sql = "SELECT * FROM users WHERE email = '$email' AND Password = '$password'";
    $result = $connection->prepare($sql);
    $result->execute();
    $userData = $result->fetch(PDO::FETCH_ASSOC);

    if ($userData === false) {
        $type = 'admin';
        $sql = "SELECT * FROM admin WHERE email = '$email' AND Password = '$password'";
        $result = $connection->prepare($sql);
        $result->execute();
        $userData = $result->fetch(PDO::FETCH_ASSOC);
        if ($userData['status'] == 0) {
            $_SESSION['error'] = "Your account need an admin approvment, wait for 48 hours";
            return header('Refresh: 0');
        }

        if ($userData === false) {
            $_SESSION['error'] = 'Wrong email or password!';
            return header('Refresh: 0');
        }
    }

    if ($userData['status'] == 0) {
        $_SESSION['error'] = "Your account need an admin approvment, wait for 48 hours";
        return header('Refresh: 0');
    }

    $_SESSION['id'] = $userData['id'];
    $_SESSION['type'] = $userData['type'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['status'] = $userData['status'];
    $_SESSION['full_name'] = "{$userData['first_name']} {$userData['last_name']}";
    $_SESSION['user_type'] = $type;

    if ($type == 'user')
        return header("Location: home_page.php");
    return header("Location: Admn_Home_Page.php");
}
?>

<div class="modal fade clear-both" id="Login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body clear-both">
                <form method="post" class="form-group">
                    <div class="row">
                        <div id="email" class="col-lg-12">
                            <br>
                            <label class="text-info h6">Email </label>
                            <input id="email" name="email" type="text" value="" class="form-control" placeholder="Email"
                                required>
                        </div>

                        <br>

                        <div id="password" class="col-lg-12">
                            <label class="text-info h6">Password</label>
                            <input id="password" name="password" type="password" class="form-control" value=""
                                placeholder="Password" required>
                        </div>
                        <br><br>
                        <div class="col-lg-12">
                            <input type="submit" name="submit_login" class="btn btn-info">
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>







<div class="modal fade clear-both" id="userRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body clear-both">
                <form method="post" class="form-group">
                    <div class="row">
                        <div id="username-field" class="col-lg-6 col-md-6">
                            <label class="text-info h6">First Name</label>
                            <input id="username" name="first_name" type="text" class="form-control"
                                placeholder="First Name" required>
                        </div>
                        <div id="username-field" class="col-lg-6 col-md-6">
                            <label class="text-info h6">Last Name</label>
                            <input id="username" name="last_name" type="text" class="form-control"
                                placeholder="Last Name" required>
                        </div>

                        <div id="email-field" class="col-lg-12">
                            <br>
                            <label class="text-info h6">Email </label>
                            <input id="email" name="email" type="text" value="" class="form-control" placeholder="Email"
                                required>
                        </div>

                        <br>

                        <div id="password-field" class="col-lg-12">
                            <label class="text-info h6">Password</label>
                            <input id="password" name="password" type="password" class="form-control" value=""
                                placeholder="Password" required>
                        </div>
                        <br><br>
                        <div class="col-lg-12">
                            <input type="submit" name="submit-user" class="btn btn-info">
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="anlyzerRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Analyzer register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-group" enctype="multipart/form-data">
                    <div class="row">
                        <div id="username-field" class="col-lg-6 col-md-6">
                            <label class="text-info h6">First Name</label>
                            <input id="username" name="first_name" type="text" class="form-control"
                                placeholder="First Name" required>
                        </div>
                        <div id="username-field" class="col-lg-6 col-md-6">
                            <label class="text-info h6">Last Name</label>
                            <input id="username" name="last_name" type="text" class="form-control"
                                placeholder="Last Name" required>
                        </div>

                        <div id="email-field" class="col-lg-12">
                            <br>
                            <label class="text-info h6">Email</label>
                            <input id="email" name="email" type="text" value="" class="form-control" placeholder="Email"
                                required>
                        </div>

                        <br>
                        <div id="password-field" class="col-lg-12">
                            <label class="text-info h6">Password</label>
                            <input id="password" name="password" type="password" class="form-control" value=""
                                placeholder="Password" required>
                        </div>

                        <br>
                        <div id="password-field" class="col-lg-12">
                            <label title='Add your last degree for crypto currency.' class="text-info h6 tooltip_cont"
                                for="anlyzer">Degree</label>
                            <input id="anlyzer" name="Degree" type="file" class="form-control" required>
                        </div>

                        <br>
                        <div class="col-lg-12">
                            <input type="submit" name="submit-anlyzer" class="btn btn-info">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<section class="header_area" style="display: flex; justify-content: space-between; align-items: top !important;">
    <div class="logo"><a href="home_page.php"><img src="images/logo.jpg" alt="" /></a></div>
    <div class="top_menu">
        <ul style="margin-top: 10%">
            <li><a href="home_page.php">Home</a></li>
            <li><a href="About.php">About</a></li>


            <?php if (isset($_SESSION['full_name'])): ?>
                <li><a href="profile.php">
                        <?= $_SESSION['full_name'] ?>
                    </a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a data-toggle="modal" data-target="#Login" style=" cursor: pointer;">Login</a></li>
                <li id="register-header" style="position: relative;">
                    <a href="#">Register</a>
                    <section id="sub-menu"
                        style="position: relative; color: black; top: 20px; background-color: white; box-shadow: 2px 2px 5px grey; padding: 10px; border-radius: 5px; display: none;">
                        <a data-toggle="modal" data-target="#userRegister" style="color: black; cursor: pointer;">User</a>
                        <a data-toggle="modal" data-target="#anlyzerRegister"
                            style="color: black; cursor: pointer; border-top:1px solid black; margin-top: 5px; padding-top: 5px">Anlyzer</a>
                    </section>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="">
        <img src="images\zrqaaUni.jpeg" style="width:100px; height:100px; margin-top: 0;" alt="0000000">
    </div>
</section>
<div class="main_menu_area">
    <ul id="nav" class="Divnav">
        <li><a href="ViewNews.php">News</a> </li>
        <li><a href="crypetocurrncy.php">Cryptocurrency</a></li>
        <li><a href="Analysis.php">Analysis</a></li>
        <li><a href="Courses.php">Courses</a> </li>
        <li><a href="whale_wallet.php"> Whale Wallets</a></li>
        <li><a href="#">Contact us</a>
            <ul>
                <li><a href="https://www.facebook.com/profile.php?id=100092708387867">Facebook</a></li>
                <li><a href="https://instagram.com/arab_trade2?igshid=MzNlNGNkZWQ4Mg== ">instagram</a></li>
                <li><a href="https://twitter.com/arabtrade20?s=21&t=JJhm_w-onm3TULmJHNPD5Q">Twitter</a> </li>
            </ul>
        </li>
    </ul>
</div>

<?php

if (!empty($_SESSION['success'])) {
    echo "<div class='alert alert-success' style='margin-top: 15px;'>{$_SESSION['success']}</div>";
    $_SESSION['success'] = '';
}


if (!empty($_SESSION['error'])) {
    echo "<div class='alert alert-danger' style='margin-top: 15px;'>{$_SESSION['error']}</div>";
    $_SESSION['error'] = '';
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        $(".tooltip_cont").tooltip({});
    })
</script>