<?php
  //so we can use session variables
  session_start();

  if (isset($_POST['upload-data'])){ //form's submit button pressed
    //set connection to database
    require 'dbh.inc.php';

    //assign variables with form input
    $title = $_POST['title'];
    $data = $_FILES['data']['tmp_name'];
    $filename = $_FILES['data']['name'];
    $uID = $_SESSION['userId'];

    //move files into temporary location
    $target_dir = "../data/".$_SESSION['uname']."/";
    $target_file = $target_dir . basename($_FILES["data"]["name"]);
    move_uploaded_file($data, $target_file);

    //**********CHECK FOR EMPTY FIELDS**************/
   if (empty($_FILES['data'])){
     header("Location: ../pages/student-page.php?error=nofilechosen");
     exit();
   }
   //**********INPUTS ARE VALID**************/
   else {
     //create a prepared statement
     $sql = "INSERT INTO item (
       FileName,
       UserID,
       Title,
       ItemData
     ) VALUES (?,?,?,?)";
     $statement = mysqli_stmt_init($conn);
     //check if the statement will work
     if (!mysqli_stmt_prepare($statement, $sql)){
       header("Location: ../pages/student-page.php?error=sqlerror");
       exit();
     }
     else {
       //bind all params to statement
       mysqli_stmt_bind_param($statement, "ssss",
        $filename,
        $uID,
        $title,
        $data
       );
       mysqli_stmt_execute($statement);
       header("Location: ../pages/data-page.php?upload=success");
       exit();
     }
   }
   mysqli_stmt_close($statement);
   mysqli_close($conn);
 }
 else {
   header("Location: ..pages/index.php");
 }
