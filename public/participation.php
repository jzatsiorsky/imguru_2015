<?php
/* participation.php
 * James Zatsiorsky
 * 01/19/15
 * Testing out the Google API to display pie chart for participation
 *
 *
*/ 

// config file
require("../includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {

	// get the participation
	$houses = query("SELECT * FROM houses");

	// initialize the total participation
	$total = 0;

	// array for individual house participation
	$house_total = array();

	foreach ($houses as $house) {

		// select all of the users from the house
		$house_users = query("SELECT * FROM users WHERE house = ?", $house["name"]);

		// number of users from particular house
		$house_count = count($house_users);

		// keep track of total number of users
		$total += $house_count;

		// add to house total array
		$array = array( $house["name"] => $house_count );

		array_push($house_total, $array);
	}

	// get the total number of games played
	$total_games = query("SELECT * FROM games WHERE RESULT = TRUE");
	$count_games = count($total_games);

	// render the form
	render("participation_form.php", ["total" => $total, "house_total" => $house_total, "count_games" => $count_games]);

}


?>