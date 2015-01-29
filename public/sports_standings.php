<?php

    // configuration
    require("../includes/config.php"); 

    if ($_SERVER["REQUEST_METHOD"] != "GET")
    {
    	return false;
    }
    else
    {
    	// pull out the sports for which there are updated standings
    	query("START TRANSACTION");
    	$rows = query("SELECT sport FROM standings");
        $dates = query("SELECT year FROM standings");
    	query("COMMIT");

    	$sports = [];
    	foreach ($rows as $row)
    	{
    		array_push($sports, $row["sport"]);
    	}

        $years = [];
        foreach ($dates as $date)
        {
            array_push($years, $date["year"]);
        }

    	$sports = array_unique($sports);
        $years = array_unique($years);

    	render("sports_standings_form.php", ["sports" => $sports, "years" => $years]);

    }

?>