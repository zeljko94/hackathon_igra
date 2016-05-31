<?php 
include_once('DB.php');

class User
{
	private $username;
	private $score;
	private $email;

	public function __construct($username, $email, $score)
	{
		$this->username = $username;
		$this->email = $email;
		$this->score = $score;
	}

	// GETTERS
	public function getUsername(){return $this->username; }
	public function getEmail(){return $this->email; }
	public function getScore(){return $this->score; }

	// SETTERS
	public function setUsername($username){$this->username = $username; }
	public function setEmail($email){$this->email = $email; }
	public function setScore($score){$this->score = $score; }


	public static function getAll()
	{
		$db = new DB("hackathon_vjezba", "localhost", "root", "");
		$db->Query("SELECT * FROM user ORDER BY score DESC", []);

		$result = [];
		if(!$db->getResult()) return false;

		foreach ($db->getResult() as $user) {
			$novi = new User($user['username'], $user['email'], $user['score']);
			array_push($result, $novi);
		}
		return $result;
	}
}/* ---------------- class end ---------------------------*/



$users = User::getAll();

?>

<!DOCTYPE html>
<html>
<head>
	<title>High scores</title>
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
<h1 align="center">HIGH SCORES</h1>
	<table border="1px" cellpadding="0" cellspacing="0" align="center" id="highScoreTable" class="table table-bordered">
		<thead align="center" style="background-color: silver;">
			<td width="30px">#</td>
			<td width="150px">Username</td>
			<td width="150px">Email</td>
			<td width="150px">Score</td>
		</thead>

		<?php
		$counter = 1;
		foreach($users as $user)
		{
			echo "<tr align='center'>";
				echo "<td>" . $counter . "</td>";
				echo "<td>" . $user->getUsername() . "</td>";
				echo "<td>" . $user->getEmail() . "</td>";
				echo "<td>" . $user->getScore() . "</td>";
			echo "</tr>";
			$counter++;
		}
		?>
	</table>

	<hr>
	<a href="start_game.php">Back to game</a></br>
	<a href="login.php">Back to login</a>
</body>
</html>