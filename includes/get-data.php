<?php
  // require 'dbh.inc.php';
  //
  // if (isset($_GET['title']) && isset($_GET['user'])){ //check if a project has been chosen
  //   $title = $_GET['title'];
  //   $user = $_GET['user'];
  //   //first, get userID with the username
  //   $sql = "SELECT *
  //           FROM user
  //           WHERE Username=?;";
  //   $statement = mysqli_stmt_init($conn);
  //   if (!mysqli_stmt_prepare($statement, $sql)){
  //     header("Location: ../pages/index.php?error=sqlerror");
  //     exit();
  //   }
  //   else {
  //     mysqli_stmt_bind_param($statement, "s", $user);
  //     mysqli_stmt_execute($statement);
  //     $result = mysqli_stmt_get_result($statement);
  //     $row = mysqli_fetch_assoc($result);
  //     //second, get the item with the userID
  //     $sql = "SELECT *
  //             FROM item
  //             WHERE UserID=?;";
  //     $statement = mysqli_stmt_init($conn);
  //     if (!mysqli_stmt_prepare($statement, $sql)){
  //       header("Location: ../pages.index.php?error=sqlerror");
  //       exit();
  //     }
  //     else {
  //       mysqli_stmt_bind_param($statement, "s", $row['UserID']);
  //       mysqli_stmt_execute($statement);
  //       $result = mysqli_stmt_get_result($statement);
  //       $row = mysqli_fetch_assoc($result);
  //       //now, save the file into the data folder for the current user
  //     }
  //   }
  //
  //
  //
  // }
  // else {
  //   header("Location: ../pages/index.php");
  // }
