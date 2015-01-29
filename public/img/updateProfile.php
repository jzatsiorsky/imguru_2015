<?php

// James Zatsiorsky
// January 14, 2015
// Add profile picture to database

// configuration
require("../includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$team = $_POST["team"];
	$from = $_POST["from"];
	
}
else{
	apologize("Sorry, I think you're lost.");
}

?>