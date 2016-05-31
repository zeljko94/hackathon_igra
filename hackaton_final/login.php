<?php
session_start();

include_once('DB.php');

$errorStyle = "";
$errorMsg = "";
$loggedIn = false;
$score = false;
$username = "";
$loggedIn = false;

if(isset($_POST['btnSubmit']))
{
	$username = htmlentities($_POST['username']);
	$password = htmlentities($_POST['password']);

	// je li uneseno korisnicko ime?
	if($username)
	{
		// je li unesen password?
		if($password)
		{
			// nadji u bazi korisnika  sa istim username-om i passwordom
			$db = new DB("hackathon_vjezba", "localhost", "root", "");
			$db->Query("SELECT * FROM user WHERE username=? AND password=?", [$username, $password]);

			// ako ima rezultata
			if($db->getResult())
			{
				$score = $db->getResult()[0]['score'];

				$errorStyle = "color: green;";
				$errorMsg = "Login successful!";
				$loggedIn = true;

				$_SESSION['username'] = $username;
			}
			else
			{
				$errorStyle = "color: red;";
				$errorMsg = "Login Failed!";
			}
		}
	}
}


if(isset($_POST['btnLoginAsGuest']))
{
	echo "<script type='text/javascript'>window.location.href='start_game.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
		<script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	</head>

	<body>
	</br>
	<table>
		<form method="POST" action="login.php" class="form-group">
		<tr>
			<td>Username: </td> 
			<td><input type="text" name="username" value="<?php echo $username; ?>"/></td>
		</tr>
		<tr>
			<td>Password: </td>
			<td><input type="password" name="password" value=""/></td>
		</tr>
		<tr>
			<td><input type="submit" name="btnSubmit" value="Log in"/></td>
			<td><input type="submit" name="btnLoginAsGuest" value="Login as guest"/></td>
		</tr>
		</form>
	</table>

		<div style="<?php echo $errorStyle; ?>"><?php echo $errorMsg; ?></div>
		<a href="register.php">Nemate account? Kliknite ovdje da biste ga napravili!</a>
		<?php if($loggedIn) echo "<script type='text/javascript'>setTimeout(function(){ window.location.href='start_game.php?score=$score';}, 2000);</script>"; ?>
	</body>
</html>