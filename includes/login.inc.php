<?php
	if (isset($_POST['login-user'])){ //check if the user clicked the login button
		//connect to database
		require 'dbh.inc.php';

		$mailuid = $_POST['unameid'];
		$password = $_POST['pword'];

		//check if any of the inputs were empty
		if (empty($mailuid) || empty($password)){
			//if so, send back to the same form input
			header("Location: ../pages/new-user-login.php?error=emptyfields&uname=".$mailuid);
			exit();
		}
		else {
			//set up the sql statement for execution
			$sql = "SELECT *
							FROM user
							WHERE Username=?
							OR Email=?;"; //leave the values as placeholders for now, we use prepared statements for that
			$stmt = mysqli_stmt_init($conn); //initialize the connection with the database
			//prepare the statement to catch any errors that might come about when executing
			if (!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../pages/new-user-login.php?error=sqlerror");
				exit();
			}
			else {
				//bind the user inputs to the statement for execution
				mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				//set the result from the database as an associative array, aka a "row"
				if ($row = mysqli_fetch_assoc($result)){
					//compare the two passwords for validation
					$pwdCheck = password_verify($password, $row['Pword']); //returns true or false
					if ($pwdCheck == false){
						header("Location: ../pages/new-user-login.php?error=wrongpwd&uname=".$mailuid);
						exit();
					}
					else if ($pwdCheck == true){
						//delete temp guest directory
						rmdir("../data/".$_SESSION['userId']);
						//start a session and assign _SESSION variables
						session_start();
						$_SESSION['userId'] = $row['UserID'];
						$_SESSION['uname'] = $row['Username'];
						$_SESSION['fname'] = $row['FirstName'];
						$_SESSION['lname'] = $row['LastName'];
						//send users back to home page
						header("Location: ../pages/student-page.php?login=success");
						exit();
					}
					else {
						header("Location: ../pages/new-user-login.php?error=wrongpwd");
						exit();
					}
				}
				else {
					header("Location: ../pages/new-user-login.php?error=nouser&uname=".$mailuid);
					exit();
				}
			}
		}
	}
	else {
		header("Location: ../pages/index.php");
		exit();
	}
