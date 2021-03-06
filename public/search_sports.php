<?php

    require(__DIR__ . "/../includes/config.php");
	
	if (empty($_GET["sport"]) == TRUE)
	{
		return false;   
	}
    // numerically indexed array of messages matching sport
    $messages = [];

    $messages = query("SELECT * FROM huddle INNER JOIN users ON huddle.userid=users.userid WHERE users.house = ? AND huddle.sport = ? ORDER BY messageid ASC", $_SESSION["house"], $_GET["sport"]);
    
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($messages, JSON_PRETTY_PRINT));

?>
