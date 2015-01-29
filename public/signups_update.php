<?php

    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] != "POST")
    {
    	return false;
    }

    if (empty($_POST["sport"] || empty($_POST["preference"])))
    {
    	return false;
    }

    $pref = $_POST['preference'];
    $sport = $_POST['sport'];

    query("START TRANSACTION");

    $oldpref = query("SELECT * FROM mysports WHERE userid = ? AND sport = ?", $_SESSION["id"], $sport);
    // if they do not have preferences for the sport:
    if (empty($oldpref))
    {
        // if the player wants to be added to a league, put their info in the myleagues table
        if ($pref != "none")
        {
            // add the new preference into the mysports table
            query("INSERT INTO mysports(userid, sport, pref) VALUES (?, ?, ?)", $_SESSION["id"], $sport, $pref);

            // if they signed up for all rosters, add them to the roster for all of those upcoming games
            if ($pref == "all")
            {
                $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
                foreach ($gameids as $gameid)
                {
                    query("INSERT INTO mygames (userid, gameid) VALUES (?, ?)", $_SESSION["id"], $gameid["gameid"]);
                }
            }
        }
        // otherwise delete them being signed up for any of the games for that sport
        else
        {
            $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
            foreach ($gameids as $gameid)
            {
                query("DELETE FROM mygames WHERE userid = ? and gameid = ?", $_SESSION["id"], $gameid["gameid"]);
            }
        }
    }
    // but if they do already have preferences for the sport:
    else
    {
        if ($pref != "none")
        {
            // update the new preference into the mysports table
            query("UPDATE mysports SET pref = ? WHERE userid = ? AND sport = ?", $pref, $_SESSION["id"], $sport);

            // if they changed to sign up for all rosters, add them to the roster for all of those upcoming games
            if ($pref == "all")
            {
                $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
                foreach ($gameids as $gameid)
                {
                    query("INSERT INTO mygames (userid, gameid) VALUES (?, ?)", $_SESSION["id"], $gameid["gameid"]);
                }
            }
        }
        // otherwise delete that sport from their mysports table and the user from any rosters for that sport
        else
        {
            query("DELETE FROM mysports WHERE userid = ? AND sport = ?", $_SESSION["id"], $sport);
            $gameids = query("SELECT gameid FROM games WHERE (team1 = ? OR team2 = ?) AND sport = ? and date >= CURDATE()", $_SESSION["house"], $_SESSION["house"], $sport);
            foreach ($gameids as $gameid)
            {
                query("DELETE FROM mygames WHERE userid = ? and gameid = ?", $_SESSION["id"], $gameid["gameid"]);
            }
        }
    }

    return true;
?>