<?php

// profile.php
// James Zatsiorsky
// 
// 
// Loads a user profile

require("../includes/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	// get all users
	$users = query("SELECT * FROM users");

	$sorted_users = array();
	// sort users alphabetically
	foreach ($users as $key => $row)
	{
	    $sorted_users[$key] = $row['name'];
	}
	array_multisort($sorted_users, SORT_ASC, $users);

	render("players_form.php", ["users" => $users]);
}





?>