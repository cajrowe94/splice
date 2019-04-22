<?php
  require 'dbh.inc.php';

  function setComment($conn) {
    if (isset($_POST['commentSubmit'])){
      $id = $_POST['uId'];
      $date = $_POST['date'];
      $message = $_POST['message'];
      $itemid = $_POST['itemId'];
      $rowid = $_POST['rowId'];

      $sql = "INSERT INTO comment (CommentDate, CommentText, UserID, ItemID, RowID)
              VALUES ('$date', '$message', '$id', '$itemid', '$rowid')";
      $result = $conn->query($sql);
    }

  }

  function getComments($conn, $rowid){
    $currentItem = $_GET['v'];
    $sql = "SELECT * FROM comment
            WHERE ItemID = '$currentItem'
            AND RowID = '$rowid'";
    $result = $conn->query($sql);
    //$row = $result->fetch_assoc();
    while($row = $result->fetch_assoc()){
      $userid = $row['UserID'];
      $usersql = "SELECT *
                  FROM user
                  WHERE UserID = '$userid'";
      $userresult = $conn->query($usersql);
      $userrow = $userresult->fetch_assoc();
      echo '
        <div class="comment">
          <p class="comment-message">'.$row['CommentText'].'</p>
          <p class="comment-author">'.$userrow['FirstName'].' '.$userrow['LastName'].'</p>
        </div>
          ';
    }
  }
