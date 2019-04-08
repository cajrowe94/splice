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
                        <a href="data-page.php?filename='.$row['FileName'].'&user='.$userrow['Username'].'" class="data-page-link">Open</a>
                      </div>
                      <div class="title">
                        <p class="name">'.$userrow['FirstName']." ".$userrow['LastName'].": ".$row['Title'].'</p>
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
  <div class="filter-uploads">
    <h2>Uploads Filter</h2>
    <div class="filter-type">
      <p class="filter-year">Year</p>
      <span>All (default): </span><input type="checkbox" name="year2019" value="2019"><br>
      <span>2019</span> <input type="checkbox" name="year2019" value="2019">
      <span>2020</span> <input type="checkbox" name="year2020" value="2020">
    </div>
    <div class="filter-type">
      <p class="filter-month">Month</p>
      <span>All (default):</span> <input type="checkbox" name="monthAll" value="allMonth"><br>
      <span>Jan:</span> <input type="checkbox" name="monthJan" value="January">
      <span>Feb:</span> <input type="checkbox" name="monthFeb" value="February">
      <span>Mar:</span> <input type="checkbox" name="monthApr" value="March"><br>
      <span>Apr:</span> <input type="checkbox" name="monthMay" value="April">
      <span>May:</span> <input type="checkbox" name="monthJun" value="May">
      <span>Jun:</span> <input type="checkbox" name="monthJul" value="June"><br>
      <span>Jul:</span> <input type="checkbox" name="monthAug" value="July">
      <span>Aug:</span> <input type="checkbox" name="monthSep" value="August">
      <span>Sep:</span> <input type="checkbox" name="monthOct" value="September"><br>
      <span>Oct:</span> <input type="checkbox" name="monthNov" value="October">
      <span>Nov:</span> <input type="checkbox" name="monthDec" value="November">
      <span>Dec:</span> <input type="checkbox" name="monthAll" value="December">
    </div>
    <input id="apply-filters" name="filter-btn" type="button" value="Apply">
  </div>
  </body>
</html>
