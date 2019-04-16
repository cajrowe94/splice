<?php
	include_once("../includes/headers.inc.php");
	include_once("../includes/get-data.php");
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
						<button id="save-export-table">Save and Export</button>
					</section>
					';
				}
			}
		}
	 ?>
	<div class="comment-box">
		<div class="comment-box-title">
			<h3>Comments</h3>
			<ion-icon name='chatboxes'></ion-icon>
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

		</div>
		<div class="comment-box-footer">
			<textarea class="comment-text" wrap="physical" name="comments"></textarea>
			<button id="submit-comment" onClick="postComment();">Submit</button>
		</div>
	</div>
</body>
</html>
