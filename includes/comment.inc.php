<?php
  require 'dbh.inc.php';

  function setComment() {
    if (isset($_POST['commentSubmit'])){
      $id = $_POST['uId'];
      $date = $_POST['date'];
      $message = $_POST['message'];

      $sql = "INSERT INTO comment (CommentDate, CommentText, UserID, ItemID) VALUES ()";
    }

  }
