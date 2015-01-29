<head>
    <!-- http://keith-wood.name/datepick.HTML -->
    <link rel="stylesheet" type="text/css" href="css/jquery.datepick.css"> 
    <script type="text/javascript" src="js/jquery.plugin.js"></script> 
    <script type="text/javascript" src="js/jquery.datepick.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
    <script src="http://listjs.com/no-cdn/list.js"></script>
    <script>
        $(function() {
            $('#mindate').datepick();
            $('#maxdate').datepick();
        });
    </script>
</head>
<style>
.list {
  font-family:sans-serif;
}
td {
  padding:10px; 
  border:solid 1px #eee;
}

input {
  border:solid 1px #ccc;
  border-radius: 5px;
  padding:7px 14px;
  margin-bottom:10px
}
input:focus {
  outline:none;
  border-color:#aaa;
}
.sort {
  padding:8px 30px;
  border-radius: 6px;
  border:none;
  display:inline-block;
  color:#fff;
  text-decoration: none;
  background-color: #28a8e0;
  height:30px;
}
.sort:hover {
  text-decoration: none;
  background-color:#1b8aba;
}
.sort:focus {
  outline:none;
}
.sort:after {
  display:inline-block;
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid transparent;
  content:"";
  position: relative;
  top:-10px;
  right:-5px;
}
.sort.asc:after {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #fff;
  content:"";
  position: relative;
  top:4px;
  right:-5px;
}
.sort.desc:after {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid #fff;
  content:"";
  position: relative;
  top:-4px;
  right:-5px;
}
</style>
<body>
<?php include 'navigation.php';?>
<div>
    <h3>
        Welcome to the games page, where you can find all of <?= htmlspecialchars($_SESSION["house"]) ?>'s 
        upcoming IM events!
    </h3>
</div>
<form action="games.php" method="get">
    <div class="form-group">
        <select class="form-control" name="sport" id="sport">
            <option value = "all">All sports</option>
            <?php
                foreach($sports as $sport)
                {
                    print("<option value = '{$sport}'>{$sport}</option>");
                }
            ?>
        </select>
        <input class="form-control" type="text" id="mindate" class="is-pickdate" autocomplete="off" placeholder="Earliest Date">
        <input class="form-control" type="text" id="maxdate" class="is-pickdate" autocomplete="off" placeholder="Latest Date">
        <button id = "filter" class = "form-control" type = "button">Filter Games</button>
    </div>
</form>

    <!-- Button to subscribe to all upcoming games for a particular sport -->
<div id="sign_up">
</div>

<div id="gamestablefilter">
    <input class="search" placeholder="Search" />
    <table id="upcoming_games" class="table table-default">
    </table>
</div>

<?php if ($_SESSION["ref"] == 0): ?>
<script>
    $(document).ready( function() {
        var sport = "all";
        $("#sign_up").html("<label>Sign up for all games </label>&nbsp; <button type='button' class='form-control' onClick='signUp(sport.value);'>Sign up</button>");
        var parameters = {
                sport: "all",
                mindate: "",
                maxdate: "",
                house: '<?php echo $_SESSION["house"]; ?>'
        };
        gamestable(document.getElementById("upcoming_games"), parameters, function() {
            var options = {
                valueNames: [ 'opponent', 'sport']
            };

            var userList = new List('gamestablefilter', options);

        });


        $("#upcoming_games").tablesorter( 
            {sortList: [[0,0], [1,0]]} );  
    
        
   
    }); 
    
    $("#filter").click( function() {
                // if the sport selected is not "all sports", then give the option to sign up for all games
        if ($("#sport").val() != "all")
        {
            $("#sign_up").html("<label>Sign up for all " + $('#sport').val() + " games </label>&nbsp; <button type='button' class='form-control' onClick='signUp(sport.value);'>Sign up</button>");
        }
        else
        {
            $("#sign_up").html("<label>Sign up for all games </label>&nbsp; <button type='button' class='form-control' onClick='signUp(sport.value);'>Sign up</button>");
        }
        var parameters = {
            sport: $("#sport").val(),
            mindate: $("#mindate").val(),
            maxdate: $("#maxdate").val(),
            house: '<?php echo $_SESSION["house"]; ?>'
        };
        // show the ajax loader
        $("#upcoming_games").html("<img src='/img/ajax-loader.gif'>");
        gamestable(document.getElementById("upcoming_games"), parameters);
        $("#upcoming_games").tablesorter();
    });

// http://stackoverflow.com/questions/1460958/html-table-row-like-a-link
$('body').on('mousedown', 'tr[url]', function(e){
    var click = e.which;
    var url = $(this).attr('url');
    if(url){
        if(click == 1){
            window.location.href = url;
        }
        else if(click == 2){
            window.open(url, '_blank');
            window.focus();
        }
        return true;
    }
});

//right click to sign up for a game
$("#upcoming_games").on('contextmenu', 'tr[value]', 'tr[att]', function(e){
    var gamenum = $(this).attr('value');
    var attending = 0;
    if ($(this).attr('att') == "Yes") {
        attending = 1;
    }
    $.ajax({
        data: {
            gameid: gamenum,
            attending: attending
        },
        url: 'roster_update.php',
        method: 'POST',
        async: false
    });
        var parameters = {
            sport: $("#sport").val(),
            mindate: $("#mindate").val(),
            maxdate: $("#maxdate").val(),
            house: '<?php echo $_SESSION["house"]; ?>'
        };
        gamestable(document.getElementById("upcoming_games"), parameters);
        return false;
});
</script>
<?php else: ?>
<script>
    $(document).ready( function() {
        var parameters = {
            sport: "all",
            mindate: "",
            maxdate: ""
        };
        // show the ajax loader
        $("#upcoming_games").html("<img src='/img/ajax-loader.gif'>");
        gamestable(document.getElementById("upcoming_games"), parameters);
    });
    $("#filter").click( function() {
        var parameters = {
            sport: $("#sport").val(),
            mindate: $("#mindate").val(),
            maxdate: $("#maxdate").val(),
        };
        // show the ajax loader
        $("#upcoming_games").html("<img src='/img/ajax-loader.gif'>");
        gamestable(document.getElementById("upcoming_games"), parameters);
        $(function(){
    $("#upcoming_games").tablesorter();
    });
    });

// http://stackoverflow.com/questions/1460958/html-table-row-like-a-link
$('body').on('mousedown', 'tr[url]', function(e){
    var click = e.which;
    var url = $(this).attr('url');
    if(url){
        if(click == 1){
            window.location.href = url;
        }
        else if(click == 2){
            window.open(url, '_blank');
            window.focus();
        }
        return true;
    }
});

//right click to sign up for a game
$("#upcoming_games").on('contextmenu', 'tr[value]', 'tr[att]', function(e){
    var gamenum = $(this).attr('value');
    var attending = 0;
    if ($(this).attr('att') == "Yes") {
        attending = 1;
    }
    $.ajax({
        data: {
            gameid: gamenum,
            attending: attending
        },
        url: 'roster_update.php',
        method: 'POST',
        async: false
    });
        var parameters = {
            sport: $("#sport").val(),
            mindate: $("#mindate").val(),
            maxdate: $("#maxdate").val(),
            house: '<?php echo $_SESSION["house"]; ?>'
        };
        // show the ajax loader
        $("#upcoming_games").html("<img src='/img/ajax-loader.gif'>");
        gamestable(document.getElementById("upcoming_games"), parameters);
        return false;
});
</script>
<?php endif ?>
</body>
