<?php

    // configuration
    require("../includes/config.php");
    
    // make sure user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] != "GET")
    {
    	return false;
    }
    else
    {
    	$sport = $_GET["sport"];
        $year = $_GET["year"];
        
    	$standings = query("SELECT * FROM standings WHERE sport = ? AND year = ? ORDER BY points DESC", $sport, $year);

    	// output places as JSON (pretty-printed for debugging convenience)
	    header("Content-type: application/json");
	    print(json_encode($standings, JSON_PRETTY_PRINT));
    }

?>