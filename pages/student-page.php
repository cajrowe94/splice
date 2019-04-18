<?php include_once("../includes/headers.inc.php"); ?>
<!DOCTYPE html>
<html lang="en">
	<body>
		<header>
			<?php
				$activePage = "studentPage";
				include_once("../includes/nav.inc.php");
			?>
		</header>
		<section class="section-main">
			<div class = "student-uploads">
				<div class="uploads-heading">
					<h1 class="uploads-title">My Uploads</h1>
				</div>
				<div class="uploads-body">
					<?php
						if (isset($_SESSION['userId'])){
							//get all of current user's uploads
							require '../includes/dbh.inc.php';
							$sql = "SELECT *
											FROM item
											WHERE UserID=?;";
							$stmt = mysqli_stmt_init($conn);
							if (!mysqli_stmt_prepare($stmt, $sql)){
								header("Location: student-page.php?error=sqlerror");
								exit();
							}
							else {
								mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
								mysqli_stmt_execute($stmt);
								$result = mysqli_stmt_get_result($stmt);
								//loop through item table
								while($row = mysqli_fetch_assoc($result)){
									//convert time to a readable format
									$time = strtotime($row['UploadDate']);
									$myFormatForView = date("m/d/y", $time);
									echo '
										<div class="upload">
											<div class="link-overlay">
												<a href="data-page.php?filename='.$row['FileName'].'&user='.$_SESSION['uname'].'&title='.$row['Title'].'" class="data-page-link">Open</a>
											</div>
											<div class="title">
												<p class="name">'.$row['Title'].'</p>
												<p class="date">'.$myFormatForView.'</p>
											</div>
										</div>
									';
								}
							}

					}
					else {
						header("Location: index.php");
					}
				?>

				</div>
			</div>
		</section>
		<div class="new-upload">
			<form>

			</form>
		</div>
		<input id="student-data-upload" name="upload" type="button" value="+Upload">
		<form enctype="multipart/form-data" action="../includes/upload.inc.php" method="post" class="upload-new">
			<span>Title</span><input id="title" name="title" required>
			<input id="file" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="data">
			<input id="upload-item" type="submit" value="Upload" name="upload-data">
			<input id="cancel-upload" type="button" value="Cancel">
		</form>
	</body>
</html>
