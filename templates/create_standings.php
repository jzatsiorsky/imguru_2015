<?php

	require("../includes/config.php");

	if ($SERVER["REQUEST_METHOD"] == "GET")
	{
		$houses = ["Adams", "Cabot", "Currier", "Dudley", "Dunster", "Eliot", "Kirkland", "Leverett", "Lowell", "Mather", "Pforzheimer", "Quincy", "Winthrop"];
		$sport1 = "A Basketball";
		$sport2 = "Squash";
		$year = "2014-2015";

		foreach($houses as $house)
		{
			query("INSERT INTO standings (house, sport, year) VALUES (?, ?)", $house, $sport1, $year);
			query("INSERT INTO standings (house, sport, year) VALUES (?, ?)", $house, $sport2, $year);
		}

		$success = "works";
		dump($success);

	}
	else
	{
		return false;
	}

?>