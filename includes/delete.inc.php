<?php
session_start();
  //connect to database
  require 'dbh.inc.php';
  //deleting a comment
  if(isset($_GET['cid'])){
    $commentId = $_GET['cid'];
    //delete the comments first
    $sql = "DELETE FROM comment WHERE CommentID='$commentId'";
    $result = $conn->query($sql);
    header("Location: ".$_SESSION['currentURL']);
  }
  //deletingan item and all of it's comments
  if (isset($_GET['v'])){
    $itemId = $_GET['v'];
    $userId = $_SESSION['userId'];
    //delete the comments first
    $sql = "DELETE FROM comment WHERE ItemID='$itemId'";
    $result = $conn->query($sql);
    //delete the item last
    $sql = "DELETE FROM item WHERE ItemID='$itemId' AND UserID='$userId'";
    $result = $conn->query($sql);
    header("Location: ../pages/student-page.php?delete=success");
  }
