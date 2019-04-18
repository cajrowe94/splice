<?php include_once("../includes/headers.inc.php");?>
<!DOCTYPE html>
<html lang="en">
  <body>
	<header>
    <?php
      $activePage = "homePage";
      include_once("../includes/nav.inc.php");
    ?>
	</header>
  <section class="section-main">
    <div class = "student-uploads">
      <div class="uploads-heading">
        <h1 class="uploads-title">Student Uploads</h1>
      </div>
      <div class="uploads-body">
        <?php
            //get all of current user's uploads
            require '../includes/dbh.inc.php';
            $sql = "SELECT *
                    FROM item";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)){
              header("Location: student-page.php?error=sqlerror");
              exit();
            }
            else {
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              //loop through item table
              //get the first and last name from each user
              while($row = mysqli_fetch_assoc($result)){
                $usersql = "SELECT FirstName,LastName,Username
                            FROM user
                            WHERE UserID=?;";
                $userstmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($userstmt, $usersql)){
                  header("Location: student-page.php?error=sqlerror");
  								exit();
                }
                else {
                  mysqli_stmt_bind_param($userstmt,"s", $row['UserID']);
                  mysqli_stmt_execute($userstmt);
                  $userresult = mysqli_stmt_get_result($userstmt);
                  $userrow = mysqli_fetch_assoc($userresult);
                  //convert time to a readable format
                  $time = strtotime($row['UploadDate']);
                  $myFormatForView = date("m/d/y", $time);
                  echo '
                    <div class="upload">
                      <div class="link-overlay">
                        <a href="data-page.php?filename='.$row['FileName'].'&user='.$userrow['Username'].'&title='.$row['Title'].'" class="data-page-link">Open</a>
                      </div>
                      <div class="title">
                        <p class="name">'.$userrow['FirstName']." ".$userrow['LastName'].'</p>
                        <p class="proj-title">"'.$row['Title'].'"</p>
                        <p class="date">'.$myFormatForView.'</p>
                      </div>
                    </div>
                  ';
                }

              }
            }
      ?>

      </div>
    </div>
  </section>
  </body>
</html>
