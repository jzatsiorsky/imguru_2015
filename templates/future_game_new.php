<?php include 'navigation.php';?>
<head>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script src="/js/scripts.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1','packages':['gauge']}]}"></script>
    <link href="/css/bootstrap-switch.css" rel="stylesheet">
    <script src="/js/bootstrap-switch.js"></script>

</head>
<div id = "scrollTo">
</div>
<?php if ($gameinfo["team1"] == $_SESSION["house"] || $gameinfo["team2"] == $_SESSION["house"] ): ?>
    <div style="position: relative; top:15px; ">
         <h4 style=""> Attending: </h4>
         <input type="checkbox" id="switch" name="my-checkbox" checked>
    </div>
<?php endif ?>
<div style="height: 50px;"></div>
<div style="display: block-inline; width: 50%; height: 200px; float: left;">
<table class = "table table-striped" style="width: 90%; outline: 2px solid black;">
            <caption><h3>Game Information</h3></caption>
            <tr>
                <td><strong>Sport</strong></td>
                <td><?php print($gameinfo["sport"]);?></td>
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td><?php $date = date_create($gameinfo["date"]);
                 print(date_format($date, 'F d, Y'));?></td>
            </tr>
            <tr>
                <td><strong>Time</strong></td>
                <td><?php $time = date_create($gameinfo["time"]);
                $timepretty = print(date_format($time, 'g:i A'));?></td>
            </tr>
            <tr>
                <td id = "location"><strong>Location</strong></td>
                <td><?php print($gameinfo["location"]);?></td>
            </tr>
        </table>
</div>
<div style="height:204px; width: 50%; display: inline-block; float: left;"> 
    <div id = "map-canvas" style="height:204px; width: 90%; margin: 0 auto; border: 2px solid black;">
    </div>
</div>



<div class = "shieldbox" style="clear: both;">

    <figure class = "shieldleft">
        <figcaption><h1><?php print($gameinfo['team1']); ?> </h1></figcaption>
        <img src = "img/<?php print(htmlspecialchars(strtolower($gameinfo['team1']))); ?>_shield.jpg" alt = "team 1 logo" height = "120" width = "90">
    </figure>
    <div class = "shieldcenter" style="margin: 0 60px;">
        <h2>vs.</vs>
    </div>
    <figure class = "shieldright">
        <figcaption><h1><?php print($gameinfo['team2']); ?></h1></figcaption>
        <img src = "img/<?php print(htmlspecialchars(strtolower($gameinfo['team2']))); ?>_shield.jpg" alt = "team 2 logo" height = "120" width = "90">
    </figure>
</div>
    <div style="display: inline-block; min-height: 100px; width: 40%;">
        <div id = "roster" style="display: inline-block; width: 100%;">
        </div>
    </div>
    <div style="display: inline-block; vertical-align: top; min-height: 100px; width: 40%;">
        <div id = "roster2" style="display: inline-block; width: 100%;">
        </div>
    </div>
<! Email team if captain >
        <?php if($_SESSION["captain"] == 1 && $roster == true): ?>
        <div id="emailbox" style="width: 30%; margin: 10px auto;">
            <h3>Email your team announcements about this game</h3>
            <textarea class="form-control" rows="8" style="resize:none; width:100%;text-align:left;" id="emailmsg"></textarea>
            <button class ="form-control" id="captainemail">Email your team</button>
        </div>
        <?php endif ?>

<script>
    var mapinfo = {
        lat: <?php echo $location['latitude']; ?>,
        long: <?php echo $location['longitude']; ?>
        };

        var parameters_roster = {
            gameid: <?php echo $gameinfo["gameid"]; ?>,
            house: '<?php echo $gameinfo["team1"]; ?>',
            captain: <?php echo $_SESSION["captain"]?>,
            attending : <?php echo $attending; ?>
        };
        var parameters_roster2 = {
            gameid: <?php echo $gameinfo["gameid"]; ?>,
            house: '<?php echo $gameinfo["team2"]; ?>',
            captain: <?php echo $_SESSION["captain"]?>,
            attending : <?php echo $attending; ?>
        };

        if (parameters_roster.house == "<?=$_SESSION['house'] ?>") {
            var myroster = parameters_roster;
            var rosternumber = "roster";
        }
        else {
            var myroster = parameters_roster2;
            var rosternumber = "roster2";
        }

    $(document).ready( function () {
        // initialize bootstrap switch
        if (parameters_roster.attending == 0) {
           $( "#switch" ).bootstrapSwitch('state', false, true);
        }
        else {
             $( "#switch" ).bootstrapSwitch('state', true, true);
        }

        $( "#scrollTo" ).goTo();
        loadroster(document.getElementById('roster'), parameters_roster);
        loadroster(document.getElementById('roster2'), parameters_roster2);
        addgooglemap(document.getElementById('map-canvas'), mapinfo);
        // add listener to player roster
        $('#switch').on('switchChange.bootstrapSwitch', function () {
            rosterupdate(myroster, rosternumber);
        });


           $("#captainemail").click( function () {
            var message = $('#emailmsg').val();
            $.ajax({
                type: "POST",
                url: "game_email.php/",
                data: {
                    message: message,
                    gameid: parameters_roster.gameid
                }
            });
            $("#emailbox").html("<h3>Your team should recieve your email shortly.</h3>");
        });
    });

    // switch options
    $.fn.bootstrapSwitch.defaults.size = 'large';
    $.fn.bootstrapSwitch.defaults.onText = 'Yes';
    $.fn.bootstrapSwitch.defaults.offText = 'No';
    $.fn.bootstrapSwitch.defaults.onColor = 'success';
    $.fn.bootstrapSwitch.defaults.offColor = 'danger';

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
    /*
    setInterval( function() {
        loadtrashtalk(parameters_trashtalk);
    }, 5000);
*/  
    (function($) {
    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top + 'px'
        }, 'fast');
        return this; // for chaining...
    }
    })(jQuery);

    google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Big Game', 80]
        ]);

        var options = {
          width: 400, height: 120,
          redFrom: 70, redTo: 100,
          yellowFrom:40, yellowTo: 70,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, 80 + Math.round(5 * Math.random()));
          chart.draw(data, options);
        }, 800);
      }

</script>
