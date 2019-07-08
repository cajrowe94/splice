<nav class="main-nav">
  <h1>SPLICE</h1>
  <ul id="nav-list">
    <?php
      //echo out certain nav items if the user is logged in and add active classes where appropriate
      //HOME PAGE
      if ($activePage == "homePage") echo '<li><a href="index.php" class="active">HOME</a></li>';
      else echo '<li><a href="index.php">HOME</a></li>';

      //STUDENT PAGE
      //only show this nav item if the user is logged in
      if (isset($_SESSION['userId'])){
          if ($activePage == "studentPage"){
            echo '<li><a href="student-page.php" class="active">MY PAGE</a></li>';
          } else echo '<li><a href="student-page.php">MY PAGE</a></li>';
      }

      //REGISTER PAGE
      //only show this page if the user is not registered
      if (!isset($_SESSION['userId'])){
        if ($activePage == "registerStudent"){
          echo '<li><a href="register-student.php" class="active">REGISTER</a></li>';
        } else echo '<li><a href="register-student.php">REGISTER</a></li>';
      }

      //ABOUT PAGE
      if ($activePage == "aboutPage") echo '<li><a href="about.php" class="active">ABOUT</a></li>';
      else echo '<li><a href="about.php">ABOUT</a></li>';
    ?>
  </ul>
  <a class="mobile-nav" href="#"><ion-icon name="menu"></ion-icon></a>
  <?php
    if (isset($_SESSION['userId'])){
      echo '
      <div class="user-info">
        <p class="username">'
        .$_SESSION['uname'].
        '</p>
        <a href="../includes/logout.inc.php" class="logout-link" title="Logout"><ion-icon name="log-out"></ion-icon></a>
      </div>';
    }
    //if no user is logged in, echo out the login form
    else {
      echo '
      <a href="#" id="login-dropdown">Login</a>
      <form action="../includes/login.inc.php" method="post" class="user-login" id="login-form">
        <input type="text" name="unameid" placeholder="Username/Email">
        <input type="password" name="pword" placeholder="Password">
        <input name="login-user" type="submit" value="Login">
      </form>
      ';
    }
   ?>
</nav>
