<?php

    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] != "GET")
    {
        return false;
    }
    else
    {
        // make sure the user is not a ref
    	if ($_SESSION["ref"] == 1)
    	{
    		apologize("Only peasant players can use this page.");
    	}

        // list the sports by season so they will be printed in those groups
    	$fall = ["Flag Football", "Soccer", "A Volleyball", "B Volleyball", "Ultimate Frisbee", "Tennis"];
    	$winter = ["Ice Hockey", "A Basketball", "B Basketball", "C Basketball", "Squash"];
    	$spring = ["A Crew - Men", "A Crew - Women", "B Crew - Men", "B Crew - Women", "Softball", "A Volleyball", "B Volleyball"];
        $seasons["fall"] = $fall;
        $seasons["winter"] = $winter;
        $seasons["spring"] = $spring;
        // load the form
    	render("league_signup_form.php", ["seasons" => $seasons]);
    }
?>