<?php
    
    // configuration
    require("../includes/config.php");
    
    
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
		// referee account
		if ($_SESSION["ref"] == 1)
		{
			// get all games that have occurred in the past
			if (($games = query("SELECT * FROM games WHERE result = 0 AND date <= CURDATE() ORDER BY date, time DESC")) == false)
				apologize("All games have been submitted.");
    		// render form
   	 		render("submit_result_form.php", ["title" => "Submit Result", "games" => $games]);
		}
		// not a referee account
		else 
		{
			if ($_SESSION["captain"] == 1)
			{
				// get all games that the user's house is in that have occurred in the past
				if (($games = query("SELECT * FROM games WHERE (team1 = ? OR team2 = ?) AND result = 0 AND date <= CURDATE() ORDER BY date DESC", $_SESSION["house"], $_SESSION["house"])) == false)
					apologize("All games have been submitted.");
        		// render form
       	 		render("submit_result_form.php", ["title" => "Submit Result", "games" => $games]);
			}
			else
			{
				apologize("You don't have privileges to view this page.");
			}
		}
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
    	// apologize if empty fields
    	if (!isset($_POST["forfeit"]) && !isset($_POST["team1score"]) && !isset($_POST["team2score"])) {
    		apologize("No fields completed.");
    	}

    	// pull out the info for submitted game
    	if (($gameinfos = query("SELECT * FROM games WHERE gameid = ?", $_POST["gameid"])) === false)
    	{
    		apologize("Sorry, this game does not exist.");
    	}

    	$gameinfo = $gameinfos[0];

    	$month = date('n');
    	$year;

    	if ($month == '1' || $month == '2' || $month == '3' || $month == '4' || $month == '5')
    	{
    		$thisyear = date('Y');
    		$lastyear = date('Y', strtotime('-1 years'));
    		$year = $lastyear . '-' . $thisyear;
    	}
    	else
    	{
    		$thisyear = date('Y');
    		$nextyear = date('Y', strtotime('+1 years'));
    		$year = $thisyear . '-' . $nextyear;
    	}

		// insert rows into the standings table if they do not exist
		query("INSERT IGNORE INTO standings SET house = ?, sport = ?, year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);
		query("INSERT IGNORE INTO standings SET house = ?, sport = ?, year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);

    	// the game was a forfeit 
    	if (isset($_POST["forfeit"])) {
    		switch ($_POST["forfeit"]) {
    			case "team1forfeit":
    				if (query("UPDATE games SET team1score = 0, team2score = 0, result = TRUE, forfeit = 1, team1forfeit = 1, team2forfeit = 0 WHERE gameid = ?", $_POST["gameid"]) === false)
					{
						apologize("Error submitting result.");
						
					}
					else
					{
						query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);
					}
					break;
    			case "team2forfeit":
    				if (query("UPDATE games SET team1score = 0, team2score = 0, result = TRUE, forfeit = 1, team1forfeit = 0, team2forfeit = 1 WHERE gameid = ?", $_POST["gameid"]) === false)
					{
						apologize("Error submitting result.");
					}
					else
					{
						query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);

					}
					break;
    			case "both";
    				if (query("UPDATE games SET team1score = 0, team2score = 0, result = TRUE, forfeit = 1, team1forfeit = 1, team2forfeit = 1 WHERE gameid = ?", $_POST["gameid"]) === false)
					{
						apologize("Error submitting result.");
					}
					else
					{
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);
						query("UPDATE standings SET forfeits = (forfeits + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);

					}
					break;
				default:
					apologize("Error. Please try again.");
    		}
    	}
    	else {
			// apologize if empty field
	        if (is_blank($_POST["team1score"]) || is_blank($_POST["team2score"]))
	        {
	            apologize("Make sure you fill in all fields.");
	        }

			$team1score = $_POST["team1score"];
			$team2score = $_POST["team2score"];

			

		    // insert result into table
		    if (query("UPDATE games SET team1score = ?, team2score = ?, result = TRUE WHERE gameid = ?", $team1score, $team2score, $_POST["gameid"]) === false)
			{
				apologize("Error submitting result.");
			}

			// adjust standings
			if ($team1score > $team2score)
			{
				query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);
				query("UPDATE standings SET losses = (losses + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);
			}
			elseif ($team1score < $team2score)
			{
				query("UPDATE standings SET wins = (wins + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);
				query("UPDATE standings SET losses = (losses + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);
			}
			elseif ($team1score == $team2score)
			{
				query("UPDATE standings SET ties = (ties + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);
				query("UPDATE standings SET ties = (ties + 1) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);
			}
		}
		// adjust the points column
		$team1 = query("UPDATE standings SET points = (20*wins + 10*losses - 15*forfeits) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team1"], $gameinfo["sport"], $year);
		$team2 = query("UPDATE standings SET points = (20*wins + 10*losses - 15*forfeits) WHERE house = ? AND sport = ? AND year = ?", $gameinfo["team2"], $gameinfo["sport"], $year);


		// return to submit result
	    redirect("/submit_result.php");
		
    }

// http://php.net/manual/en/function.empty.php steven@nevvix.com 
function is_blank($value) {
    return empty($value) && !is_numeric($value);
}
?>