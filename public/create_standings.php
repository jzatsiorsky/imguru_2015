<?php

	require("../includes/config.php");

	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$houses = ["Adams", "Cabot", "Currier", "Dudley", "Dunster", "Eliot", "Kirkland", "Leverett", "Lowell", "Mather", "Pforzheimer", "Quincy", "Winthrop"];
		$sport1 = "B Basketball";
		$sport2 = "Softball";
		$year = "2011-2012";

		foreach($houses as $house)
		{
			query("INSERT INTO standings (house, sport, year) VALUES (?, ?, ?)", $house, $sport1, $year);
			query("INSERT INTO standings (house, sport, year) VALUES (?, ?, ?)", $house, $sport2, $year);
		}

		$success = "works";
		dump($success);

	}
	else
	{
		return false;
	}

?>