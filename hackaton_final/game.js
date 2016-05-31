var player;
var enemies = [];
var upgrades = [];


// klasa za rukovanje igrom
var Game = 
{
	canvas: document.createElement("canvas"),
	start: function()
	{
		this.canvas.width = 1250;
		this.canvas.height = 598;
		this.canvas.id = "Mapa";
		this.canvas.className = "Mapa";
		this.context = this.canvas.getContext("2d");
		document.body.insertBefore(this.canvas, document.body.childNodes[0]);
		this.interval = setInterval(updateGameArea, 20);
		window.addEventListener('keypress', function(e)
		{
			switch(e.keyCode)
			{
				case 97: // a pressed - pomakni se lijevo
				if(player.x - player.speedX >= 0) player.x -= player.speedX;
				else player.x = 0;
				break;

				case 115: // s pressed - pomakni se dolje
				break;

				case 100: // d pressed - pomakni se desno
				player.x += player.speedX;
				if(player.x > 1100) player.x = 1100;
				break;

				case 119: // w pressed - pomakni se gore
				player.y -= player.jumpSpeed;
				if(player.y < -100) player.y = -100;
				break;

				case 32: // space pressed - skoci
				player.y -= player.jumpSpeed;
				break;


				default:
				break;
			}
		})
	},

	applyGravity: function()
	{
		if(player.y + player.speedY <= 298) player.y += player.speedY;
		else player.y = 298;
	},

	clear: function()
	{
		this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
	}
}


// klasa za rukovanje igračem
function Player(width, height, x, y)
{
	this.width = width;
	this.height = height;
	this.x = x;
	this.y = y;
	this.speedX = 25;
	this.speedY = 5;
	this.name = "player";
	this.jumpSpeed = 50;
	this.image = new Image();
	this.image.src = 'slike/lik.gif';
	ctx = Game.context;
	ctx.drawImage(this.image, this.x, this.y);

	this.update = function()
	{
		ctx = Game.context;
		ctx.drawImage(this.image, this.x, this.y);
	}
}

// klasa za rukovanje neprijateljima
function Enemy(width, height, x, y, type)
{
	this.width = width;
	this.height = height;
	this.x = x;
	this.y = y;
	this.type = type;
	this.name="enemy";
	this.speedX = 3;
	this.speedY = 5;
	this.image = new Image();

	switch(this.type)
	{
		case 1:
		this.image.src = "slike/enemies1.png";
		break;

		case 2:
		this.image.src = "slike/enemies2.png";
		break;

		case 3:
		this.image.src = "slike/enemies3.png";
		break;

		default:
		break;
	}

	ctx = Game.context;
	ctx.drawImage(this.image, this.x, this.y);

	this.update = function()
	{
		this.x -= this.speedX;

		if(this.x < -150)
		{
			var index = enemies.indexOf(this);
			enemies.splice(index, 1);
		}
		ctx = Game.context;
		ctx.drawImage(this.image, this.x, this.y);
	}
}


// clasa za rukovanje upgrade-ovima
function Upgrade(width, height, x, y, type)
{
	this.width = width;
	this.height = height;
	this.x = x;
	this.y = y;
	this.type = type;
	this.name = "upgrade";
	this.image = new Image();
	switch(this.type)
	{
		case 1:
		this.image.src = "slike/upgrade1.png";
		break;

		case 2:
		this.image.src = "slike/upgrade2.png";
		break;

	 	case 3:
	 	this.image.src = "slike/upgrade3.png";
		break;

		case 4:
		this.image.src = "slike/upgrade4.png";
		break;

		case 5:
		this.image.src = "slike/upgrade5.png";
		break;

		default:
		break;
	}

	ctx = Game.context;
	ctx.drawImage(this.image, this.x, this.y);

	this.update = function()
	{
			ctx = Game.context;
			ctx.drawImage(this.image, this.x, this.y);
	}
}


// metoda otkriva je li doslo do kolizije
function detectCollision(obj)
{
	if(player.x < (obj.x + obj.width) &&
	(player.x + player.width) > obj.x &&
	player.y< (obj.y + obj.height) &&
	(player.height + player.y) > obj.y)
	{
		var objType = obj.image.src;
		objType = objType.replace("http://localhost/hackaton_final/slike/", "");
		objType = objType.replace(".png", "");

		switch(objType)
		{
			case "enemies1":
			gameOver();
			break;


			case "enemies2":
			gameOver();
			break;

			case "enemies3":
			gameOver();
			break;


			case "upgrade1":
			addToScore(50);
			break;

			case "upgrade2":
			addToScore(50);
			break;

			case "upgrade3":
			addToScore(50);
			break;

			case "upgrade4":
			addToScore(50);

			break;

			case "upgrade5":
			addToScore(50);
			break;

			default:
			break;
		}

	}
}

// dohvati score u obliku integera
function getScore()
{
	var score = document.getElementById("score").innerHTML;
	var score = parseInt(score.replace("SCORE: ", ""));
	return score;
}


// dodaj bodove
function addToScore(pts)
{
	var score = getScore();
	score += pts;
	document.getElementById("score").innerHTML = "SCORE: " + score;
}

function gameOver()
{
	/*var gameOverDiv = document.createElement("div");
	document.body.appendChild(gameOverDiv);
	gameOverDiv.setAttribute("id", "gameOver");
	gameOverDiv.setAttribute("class", "gameOverDiv");
	gameOverDiv.innerHTML = "GAME OVER</br>";
	gameOverDiv.innerHTML += "Vas rezultat je: " + score + "</br>";
	gameOverDiv.innerHTML += "<a href='start_game.php'>Nova igra</a> &nbsp;&nbsp;";
	gameOverDiv.innerHTML += "<a href='high_scores.php'>High scores</a>";*/

}

function updateGameArea()
{
	Game.clear();
	Game.applyGravity();
	player.update();
	for(var i=0; i<enemies.length; i++)
	{
		enemies[i].update();
		detectCollision(enemies[i]);
	}

	for(var i=0; i<upgrades.length; i++)
	{
		upgrades[i].update();
		detectCollision(upgrades[i]);
	}
}

function main()
{
	Game.start();
	player = new Player(50, 50, 100, 100);

	// spawnaj neprijatelja svakih 4 sec
	setInterval(function(){
		var enemyType = Math.floor((Math.random()*3)+1);
		var enemy = new Enemy(50, 50, 1100, 298, enemyType);
		enemies.push(enemy);
	},4000);

	// spawnaj upgrade svakih 6 sec
	setInterval(function(){
		var upgradeType = Math.floor((Math.random()*5)+1);
		var upgradeX = Math.floor((Math.random()*1000)+1);
		var upgradeY = Math.floor((Math.random()*200)+1);
		var upgrade = new Upgrade(50, 50, upgradeX, upgradeY, upgradeType);
		upgrades.push(upgrade);
		if(upgrades.length > 1) upgrades.splice(0, 1);
	},6000);
}

main();