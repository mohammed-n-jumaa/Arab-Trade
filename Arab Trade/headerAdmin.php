<section class="header_area" style="display: flex; justify-content: space-between; align-items: top !important;">
        <div class="logo"><a href="#"><img src="images/logo.jpg" alt="" /></a></div>
        <div class="top_menu">
          <ul style="margin-top: 10%">
            
            <?php if (isset($_SESSION['full_name'])): ?>
              <li><a href="#">
                  <?= $_SESSION['full_name'] ?>
                </a></li>
              <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
              <li><a data-toggle="modal" data-target="#Login" style=" cursor: pointer;">Login</a></li>

            <?php endif; ?>
          </ul>
        </div>


        <div class=" floatright">
          <ul>
            <li class=" adminLogo"><img src="assets\css\images\admin_logo.jpg" alt="Admin Logo"></li>
          </ul>
        </div>
      </section>

      <div class="main_menu_area">
        <ul id="nav">
          <ul id="nav">

            <li><a href="addnews.php">Add News</a></li>
            <li><a href="manageCourses.php">Mange courses</a> </li>
            <li><a href="mangeAnalysis.php">Mange Analysis</a> </li>
            <li><a href="ManageUser.php">Mange User</a> </li>

          </ul>
        </ul>
      </div>