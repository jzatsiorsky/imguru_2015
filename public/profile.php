<?php

// profile.php
// James Zatsiorsky
// 
// 
// Loads a user profile

require("../includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	
	$user = query("SELECT * FROM users WHERE userid = ?", $_GET["id"]);
	if ($user == false) {
		apologize("No user with that id.");
	}

	// array of user's games
	$mygames = query("SELECT * FROM mygames INNER JOIN games ON mygames.gameid = games.gameid WHERE mygames.userid = ?", $_GET["id"]);

	// array to hold sports played by user
	$sports = array();

	foreach ($mygames as $game) {
		array_push($sports, $game["sport"]);
	}


	// make the array of sports unique
	$sports = array_unique($sports);
	

	// sort the sports alphabetically
	sort($sports);


	$labels = [
		[
		"label" => "Favorite Team",
		"type" => "team"
		],
		[
		"label" => "Hometown",
		"type" => "from"
		],
		[
		"label" => "High School",
		"type" => "highschool"
		],
		[
		"label" => "High School Sports Played",
		"type" => "hssports"
		]
	];

	render("profile_form.php", ["user" => $user[0], "sports" => $sports, "labels" => $labels]);

}





?>