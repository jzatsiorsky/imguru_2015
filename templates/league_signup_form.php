<head>
	<script src="/js/jquery-2.1.1.js"></script> 
    <script src="/js/scripts.js"></script> 
</head>
<!-- Include navigation bar-->
<?php include 'navigation.php'; ?>
	<h1 style="margin: 0 0 0 0;"> My Leagues</h1>
	<h3> Specify your sign-up preferences.</h3>
	<h5><span style="text-decoration: underline;">Emails:</span> Receive e-mails concerning that sport.</h5>
	<h5><span style="text-decoration: underline;">Emails and Games:</span> Receive e-mails, and be added to the rosters for that sport.</h5>
	<p><p>
	<div class="boxed" style="padding: 10px 20px; min-height: 500px">
		<fieldset>
			<div class="form-group">
				<!-- <h3 style="margin:0 0 20px 0; color:white"> Choose a season of sports to update your league preferences </h3> -->
				<select class="form-control" id="season" style="margin-bottom: 20px; margin-top: 10px;">
					<option value="fall">Fall Sports</option>
					<option value="winter">Winter Sports</option>
					<option value="spring">Spring Sports</option>
				</select>
				<p><p><p>
				<div id="signups">
				
				</div>
			</div>
		</fieldset>
	</div>
<script>
	$(document).ready( function() {
		signupform("fall");
		$("#season").change( function() {
			var season = $("select option:selected").val();
			signupform(season);
		});
		$("#signups").on('click', 'button[sport]', 'button[value]', function(e){
			var sport = $(this).attr('sport');
			var pref = $(this).attr('value');
			$.ajax({
		        data: {
		            sport: sport,
		            preference: pref
		        },
		        url: 'signups_update.php',
		        method: 'POST',
		        async: false
	    	});
			var season = $("select option:selected").val();
			signupform(season); 
		});
	});

	function signupform(input) {
		parameters = {
			season: input
		}
		var search = $.getJSON("search_signups.php", parameters);
		search.fail (function() {
			alert("Failed to access database.");
		});
		search.done (function(data) {
			var buttons = "";
			for (var i = 0, length = data.length; i < length; i++) {
				buttons += "<h4 style='color:white'>" + data[i].sport + "</h4>";
				buttons += "<div class='btn-group' role='group' aria-label='...'>";
				if (data[i].pref == "none") {
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='none' type='button' class='btn btn-default active'>None</button>";
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='email' type='button' class='btn btn-default'>Emails</button>";
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='all' type='button' class='btn btn-default'>Emails and Games</button></div><br><br>";
				}
				else if (data[i].pref == "email") {
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='none' type='button' class='btn btn-default'>None</button>";
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='email' type='button' class='btn btn-default active'>Emails</button>";
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='all' type='button' class='btn btn-default'>Emails and Games</button></div><br><br>";
				}
				else if (data[i].pref == "all") {
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='none' type='button' class='btn btn-default'>None</button>";
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='email' type='button' class='btn btn-default'>Emails</button>";
					buttons += "<button id='sportbutton' sport='" + data[i].sport + "' value='all' type='button' class='btn btn-default active'>Emails and Games</button></div><br><br>";
				}
			}
			//document.getElementById("signups").innerHTML = buttons;
			$("#signups").html(buttons);
		});
		}
</script>