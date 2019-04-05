<?php
	//check to see if that button has been pressed and has a post method in the form
	 if (isset($_POST['register-user'])) {
		 //if it has, run this code
		 //link the database for this page, you'll need it to insert new users
		 require 'dbh.inc.php';

		 //assign each forms input to a variable
		 //the post method gets the value from the input element
		 $firstname = $_POST['fname'];
		 $lastname = $_POST['lname'];
		 $email = $_POST['email'];
		 $username = $_POST['uname'];
		 $password = $_POST['pword'];
		 $passwordrepeat = $_POST['pwordrepeat'];

		 //*************************************************************************************//
		 //**********************CHECK FOR MISSING OR INVALID FORM INPUTS***********************//
		 //*************************************************************************************//

		 //check if any of the input are empty
		 if (empty($firstname) || empty($lastname) || empty($email) || empty($username) || empty($password) ||empty($passwordrepeat)){
			 //create an error message if any are empty
			 //inside the url, send back information that has been filled out correctly
			 header("Location: ../pages/register-student.php?error=emptyfields&uname=".$username."&mail=".$email."&fname=".$firstname."&lname=".$lastname);
			 //stop this entire script if user enters this conditional
			 exit();
		 }
		 //check for both invalid email and username
		 else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
			 //send back nothing
			 header("Location: ../pages/register-student.php?error=invalidemailusername&fname=".$firstname."&lname=".$lastname."&uname=".$username."&mail=".$email);
			 //stop this entire script if user enters this conditional
			 exit();
		 }
		 //check if the email is valid
		 //FILTER_VALID_EMAIL just checks if the email is valid
		 //returns true or false
		 else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			 //send back just the username
			 header("Location: ../pages/register-student.php?error=invalidemail&uname=".$username."&fname=".$firstname."&lname=".$lastname."&mail=".$email);
			 //stop this entire script if user enters this conditional
			 exit();
		 }
		 //check if the username is valid
		 //preg_match scans the uname for any of these charactes, if one isn't valid, error is thrown
		 else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
			 //send back just the email
			 header("Location: ../pages/register-student.php?error=invalidusername&mail=".$email."&uname=".$username."&fname=".$firstname."&lname=".$lastname);
			 //stop this entire script if user enters this conditional
			 exit();
		 }
		 //check if passwords match
		 else if ($password !== $passwordrepeat) {
			 //send back username and password
			 header("Location: ../pages/register-student.php?error=passwordcheck&mail=".$email."&uname=".$username."&fname=".$firstname."&lname=".$lastname);
			 //stop this entire script if user enters this conditional
			 exit();
		 }

		 //*************************************************************************************//
		 //***************ALL INPUTS ARE VALID, NOW CHECK FOR TAKEN USERNAME********************//
		 //*************************************************************************************//

		 //check if username has been taken
		 else {
			 //create a query to scan the database for matching username
			 //use prepared statements to avoid any injections
			 $sql = "SELECT Username
			 				 FROM user
							 WHERE Username=?"; // use ? as a placeholder
			 //this is a prepared statement
			 //make a connection to the database to use as a variable
			 $statement = mysqli_stmt_init($conn);
			 //try and prepare the sql statement, if theres no error then proceed
			 if (!mysqli_stmt_prepare($statement, $sql)){
				 //display the error
				 header("Location: ../pages/register-student.php?error=sqlerror");
				 exit();
			 }
			 else { //if theres no error from the prepare statement
				mysqli_stmt_bind_param($statement, "s", $username); //bind the parameters to the statment
				mysqli_stmt_execute($statement); //execute the new statement
				mysqli_stmt_store_result($statement); //returns true or false
				$resultCheck = mysqli_stmt_num_rows($statement); //stores the number of occurences of that username
				//if there is a match, it will be greater than 0
				 if ($resultCheck > 0){
					 //send back the email with a username taken error
					header("Location: ../pages/register-student.php?error=usertaken&mail=".$email);
				 	exit();
				 }

				 //*************************************************************************************//
				 //**********************USERNAME IS FREE, NOW EXECUTE SQL STATEMENT********************//
				 //*************************************************************************************//

				 else { //insert new user into database
					 $sql = "INSERT INTO user (
						 Username,
						 Email,
						 Pword,
						 FirstName,
						 LastName
					 ) VALUES (?,?,?,?,?)"; //insert into users, use placeholders for now
					 $statement = mysqli_stmt_init($conn);
					 //check if the statement will execute properly
					 if (!mysqli_stmt_prepare($statement, $sql)) { //returns true or false
						 //display the error
						 header("Location: ../pages/register-student.php?error=sqlerror");
						 exit();
					 }
					 else { //if theres no error from the prepare statement
						 $hashedpwd = password_hash($password, PASSWORD_DEFAULT); //hash the password before binding
						 //bind all the params to the statement
						 mysqli_stmt_bind_param($statement, "sssss",
							 $username,
							 $email,
							 $hashedpwd,
							 $firstname,
							 $lastname
						 );
						 mysqli_stmt_execute($statement); //execute the new statement
						 //make new directory for this user
						 mkdir("../data/".$username);
						 header("Location: ../pages/new-user-login.php?signup=success");
						 exit();
					}
				 }
		 	}
		 }

		 //*************************************************************************************//
		 //**********************USER SUCCESSFULLY CREATED, END CONNECTION**********************//
		 //*************************************************************************************//

		 mysqli_stmt_close($statement);
		 mysqli_close($conn);
	 }
	 else {
		 header("Location: ../pages/register-student.php");
	 }
