<?php include 'navigation.php';?>
<head>
    <script src="/js/jquery-2.1.1.js"></script> 
    <script src="/js/scripts.js"></script>
</head>
<body>
	<h1 style="margin:0 0 20px 0;">Individual Sport Standings</h1>
	<label>See standings for &nbsp</label>
	<select class='form-control' id='sport' name='sport' style='display: inline-block;' >
		<?php foreach ($sports as $sport): ?>
			<option value="<?= $sport ?>"><?= $sport ?></option>
		<?php endforeach ?>
	</select>
	<label>&nbsp from school year &nbsp</label>
	<select class='form-control' id='year' name='year' style='display: inline-block;' >
		<?php foreach ($years as $year): ?>
			<option value="<?= $year ?>"><?= $year ?></option>
		<?php endforeach ?>
	</select>
	<div id="loader_gif" style='display: inline-block; position: absolute;'></div>
	<br>
	<div id='standings_table' style="margin-top: 15px;">
	</div>
</body>
<script>
	
	function loadstandings(parameters) {
		// show the ajax loader
		$( "#loader_gif" ).html("<img src='/img/ajax-loader.gif' />");
		var search = $.getJSON("search_standings.php", parameters);
		search.done (function(data) {
			// hide the ajax loader
			$( "#loader_gif" ).html("");
			var standings = "";
			if (data.length == 0)
			{
				standings += "<h3> Sorry, there are currently no standings for this sport </h3>";
			}
			else
				standings += "<table class = 'table table-striped' style='margin: auto; table-layout: fixed;'>" + 
								"<thead>" +
									"<th>Rank</th>" +
									"<th>House</th>" +
									"<th>Record</th>" +
									"<th>Points</th>" +
									"<th>PCT</th>" +
									"<th>Forfeits</th>" +
								"</thead>" +
								"<tbody>";

				// wasn't working so I rewrote it below 

				/*
				var place = 1;
				for (var i = 0, n = data.length; i < n; i++)
				{
					if (i != 0) {
						place = i + 1;
						var j = i;
						while (data[j].points == data[i].points) {
							if (k == 0) {
								k--;
								place--;
							}
							else {
								break;
							}
						}
					}
					standings += "<tr>" +
									"<td><b>" + place + "</b></td>" +
									"<td>" + data[i].house + "</td>" +
									"<td>" + data[i].points + "</td>" +
									"<td>" + data[i].wins + "</td>" +
									"<td>" + data[i].losses + "</td>" +
									"<td>" + data[i].ties + "</td>" +
									"<td>" + data[i].forfeits + "</td>" +
							 	 "</tr>";
				}
				standings += "</tbody>";
				$("#standings_table").html(standings);
				*/

				// sort by points
				var array = data;
				array.sort(function(a,b) {
				    return b.points - a.points;
				});

				// assign a place to each member of object array
				for (var i = 0, length = array.length; i < length; i++) {

					if (i != 0) {
						// if two adjacent teams have the same points, equate their places
						if (array[i]["points"] == array[i - 1]["points"]) {
							array[i]["place"] = array[i - 1]["place"];
						}
						else {
							// by default, the place is one more than the index
							array[i]["place"] = i + 1;
						}
					}
					else {
						// by default, the place is one more than the index
						array[i]["place"] = i + 1;
					}

					if ((array[i].wins + array[i].losses + array[i].ties) == 0) {
						var winPCT = "-";
					}
					else {
						var winPCT = array[i].wins/(array[i].wins + array[i].losses + array[i].ties);
						winPCT = winPCT.toFixed(3);
					}

					if (array[i].house == "<?= $_SESSION['house'] ?>") {
						standings += "<tr style = 'font-weight: bold;'>";
					}
					else {
						standings += "<tr>"
					}
					standings +=
								"<td>" + array[i].place + "</td>" +
								"<td>" + array[i].house + "</td>";
								if (array[i].ties != 0) {
									standings += "<td>" + array[i].wins + " - " + array[i].losses + " - " + array[i].ties + "</td>";
								}
								else {
									standings += "<td>" + array[i].wins + " - " + array[i].losses + "</td>";
								}
								standings += 

											"<td>" + array[i].points + "</td>" +

											"<td>" + winPCT + "</td>" +
								
											"<td>" + array[i].forfeits + "</td>" +

										 	"</tr>";
				}

				standings += "</tbody></table>";
				$("#standings_table").html(standings);



		});
	};

	$(document).ready( function() {
			$("select.form-control").change( function() {
			var sport = $("#sport option:selected").val();
			var year = $("#year option:selected").val();
			var parameters = {
				sport: sport,
				year: year
			};
			if (sport != "") {
				loadstandings(parameters);
			}
		});
		var startvals = {
			sport: "<?= $sports[0] ?>",
			year: "<?= $years[0] ?>"
		};
		loadstandings(startvals);
	});

</script>