<?php
	include_once("../includes/headers.inc.php");
	include '../includes/comment.inc.php';
	include '../includes/dbh.inc.php';
	date_default_timezone_set('America/Indianapolis');
?>
<!DOCTYPE html>
<html lang="en">
<body>
	<header>
		<?php
			$activePage = "dataPage";
			include_once("../includes/nav.inc.php");
		?>
	</header>
	<section class="section-main">
    <div class="data-main">
      <div class="data-title">
        <h2 id="title">Title</h2>
      </div>
      <div class="data-body">
        <div id="data-table">
        </div>
      </div>
    </div>
	</section>
	<?php
		if (isset($_SESSION['userId'])){
			if (isset($_GET['user'])){
				if ($_SESSION['uname'] == $_GET['user']){
					echo '
					<section class="buttons">
						<button id="save-table" onclick="saveTable();">Save</button>
						<button id="save-export-table" onclick="exportTable();">Save and Export</button>
					</section>
					';
				}
			}
		}
	 ?>
	<div class="comment-box">
		<div class="comment-box-title" id="move-me">
			<h3>Comments</h3>
			<ion-icon name='chatboxes'></ion-icon>
			<a href="#" id="close-comments"><ion-icon name="close"></ion-icon></a>
			<p>Select a row to see it's comments</p>
			<div class="row-info">
				<div class="col-info">
					<p class="col-name">Accession</p>
					<p class="acc-cell">...</p>
				</div>
				<div class="col-info">
					<p class="col-name">% identity</p>
					<p class="id-cell">...</p>
				</div>
				<div class="col-info">
					<p class="col-name">Size</p>
					<p class="size-cell">...</p>
				</div>
				<div class="col-info">
					<p class="col-name">E score</p>
					<p class="score-cell">...</p>
				</div>
				<div class="col-info">
					<p class="col-name">Confirm</p>
					<p class="confirm-cell">...</p>
				</div>
			</div>
		</div>
		<div class="comment-box-body">
			<?php
			//get all comments for this item
		  //query for all comments
			if (isset($_GET['v'])){
				$itemid = $_GET['v'];
				$sql = "SELECT * FROM comment
			          WHERE ItemID = '$itemid'";
			  $result = $conn->query($sql);
			  //$row = $result->fetch_assoc();
			  //assign all data to session variables
			  while($row = $result->fetch_assoc()){
					$id = $row['UserID'];
					$time = strtotime($row['CommentDate']);
					$dateFormat = date("m/d/y", $time);
					$timeFormat = date("g:i A", $time);
					$usersql = "SELECT * FROM user
				          WHERE UserID = '$id'";
					$userresult = $conn->query($usersql);
				  $userrow = $userresult->fetch_assoc();
					echo '<div class="comment '.$row['RowID'].'">
						<p class="comment-message">'.$row['CommentText'].'</p>
						<span class="comment-author">'.$userrow['FirstName'].' '.$userrow['LastName'].'</span>
						<span class="comment-date">'.$dateFormat.' @ '.$timeFormat.'</span>
					</div>';
			  }
			}

			?>
		</div>
		<?php
			if (isset($_SESSION['userId'])){
				if (isset($_GET['v'])){
					echo '
					<form class="comment-box-footer" method="POST" action="'.setComment($conn).'">
						<input type="hidden" name="uId" value="'.$_SESSION['userId'].'">
						<input type="hidden" name="itemId" value="'.$_GET['v'].'">
						<input type="hidden" name="rowId" value="">
						<input type="hidden" name="date" value="'.date('Y-m-d H:i:s').'">
						<textarea class="comment-text" wrap="physical" name="message"></textarea>
						<input name="commentSubmit" type="submit" id="submit-comment"></input>
					</form>
					';
				}
			}
		 ?>
	</div>
</body>
</html>
