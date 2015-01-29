<?php

// James Zatsiorsky
// January 14, 2015
// Add profile picture to database

// configuration
require("../includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$data = json_decode(file_get_contents("php://input"), true);

	$team = $data["team"];
	$from = $data["from"];
	$id = $data["id"];
	$nickname = $data["nickname"];
	$highschool = $data["highschool"];
	$hssports = $data["hssports"];

	$result = query("UPDATE users SET hometown = ?, team = ?, nickname = ?, highschool = ?, hssports = ? WHERE userid = ?", $from, $team, $nickname, $highschool, $hssports, $id);
	
}
else{
	apologize("Sorry, I think you're lost.");
}

?>