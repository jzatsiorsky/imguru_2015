<?php

    require(__DIR__ . "/../includes/config.php");


	$results = query("SELECT * FROM games WHERE result = 1 ORDER BY date ASC, sport DESC");
	
	
	// pretty-print the dates for the user
	for ($i = 0, $length = count($results); $i < $length; $i++)
	{
		$results[$i]["date"] = date_format(date_create($results[$i]["date"]), "F d, Y");
	}
	
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($results, JSON_PRETTY_PRINT));

?>
