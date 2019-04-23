<?php
require 'dbh.inc.php';

function setComment($conn){
  if (isset($_POST['commentSubmit'])){
    $id = $_POST['uId'];
    $date = $_POST['date'];
    $message = $_POST['message'];
    $itemid = $_POST['itemId'];
    $rowid = $_POST['rowId'];

    $sql = "INSERT INTO comment (CommentDate, CommentText, UserID, ItemID, RowID)
            VALUES ('$date', '$message', '$id', '$itemid', '$rowid')";
    $result = $conn->query($sql);
    echo "<meta http-equiv='refresh' content='0'>";
  }
}
