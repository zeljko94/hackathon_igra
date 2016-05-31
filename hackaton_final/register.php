<?php
session_start();
include_once('DB.php');

$errorMsg = "";
$errorStyle = "";
$username = "";
$password = "";
$rePassword = "";
$email = "";

if(isset($_POST['btnSubmit']))
{
	$username = htmlentities($_POST['username']);
	$password = htmlentities($_POST['password']);
	$rePassword = htmlentities($_POST['rePassword']);
	$email = htmlentities($_POST['email']);

	if($username)
	{
		if($email)
		{
			if($password)
			{
				if($rePassword)
				{
					if($password === $rePassword)
					{
						$db = new DB("hackathon_vjezba", "localhost", "root", "");
						$db->Query("SELECT * FROM user WHERE username=?", [$username]);

						if($db->getResult())
						{
							$errorMsg = "Korisnicko ime je zauzeto!";
							$errorStyle = "color: red;";
						}
						else
						{
							$db->Query("INSERT INTO user(username, password, email, score) VALUES(?, ?, ?, ?)", [$username,
																												 $password,
																												 $email,
																												 0]);
							$errorMsg = "Uspjesna registracija!";
							$errorStyle = "color: green;";
						}
					}
					else
					{
						$errorMsg = "Passwordi se ne podudaraju!";
						$errorStyle = "color: red;";
					}
				}
				else
				{
					$errorMsg = "Unesite ponovljeni password!";
					$errorStyle = "color: red;";
				}
			}
			else
			{
				$errorMsg = "Unesite password!";
				$errorStyle = "color: red;";
			}
		}
		else
		{
			$errorMsg = "Unesite email!";
			$errorStyle = "color: red;";
		}
	}
	else
	{
		$errorMsg = "Unesite korisnicko ime!";
		$errorStyle = "color: red;";
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
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
			<form method="POST" action="register.php">
			<tr>
				<td>Username: </td>
				<td><input type="text" name="username" value="<?php echo $username; ?>"/></td>
			</tr>
			<tr>
				<td>Email: </td>
				<td><input type="text" name="email" value="<?php echo $email; ?>"/></td>
			</tr>
			<tr>
				<td>Password: </td>
				<td><input type="password" name="password" value=""/></td>
			</tr>
			<tr>
				<td>Retype password: </td>
				<td><input type="password" name="rePassword" value=""/></td>
			</tr>
			<tr>
				<td><input type="submit" name="btnSubmit" value="Register"/></td>
			</tr>
			</form>
	</table>
		<div style="<?php echo $errorStyle; ?>"><?php echo $errorMsg; ?></div>
		</br>
		<a href="login.php">Vec imate account! Logirajte se ovdje!</a>
	</body>
</html>