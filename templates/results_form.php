<head>
 	<script src="http://listjs.com/no-cdn/list.js"></script>
    <script src="http://listjs.com/no-cdn/list.pagination.js"></script>
    <link href="/css/table.css" rel="stylesheet">
    <?php if ($_SESSION["ref"] == 1): ?>
    	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js"></script>
		<link href="/css/xeditable.css" rel="stylesheet">
		<script src="/js/xeditable.js"></script>
	<?php endif ?>
</head>

<?php include 'navigation.php';?>
<h1 style="margin:0 0 20px 0;"> Results </h1>

<div id="results_filter">
	<div id="results">
	</div>
</div>

<script>

	// on the page's load, show all results
	$( document ).ready(function() {
		var check = $('#checkbox').is(':checked');
		var parameters = {
        	sport: "all",
			check: check
    		};
    	// show the ajax loader
    	document.getElementById('results').innerHTML = "<img src='/img/ajax-loader.gif'>";
		var messages = $.getJSON("search_results.php", parameters)
		messages.done(function(data) {
			var length = data.length;
			// no articles received
			if (length == 0)
			{
				document.getElementById('results').innerHTML = "<h3>No results posted yet.</h3>";
			}
			else
			{
			
				var HTML = "<input class='search' placeholder='Search' /><table class='table' style='table-layout: fixed;'><thead><tr><th class='sort' data-sort='date_sec'>Date</th><th>Score</th><th class='sort' data-sort='sport'>Sport</th></tr></thead><tbody class='list'>"; // start table
				// for loop through each message
				for (var i = length-1; i >= 0; i--)
				{
					// add a new row for each game
					HTML += "<tr class='result_row'>" + 
					"<td class='date' style='vertical-align: middle;'>" + data[i].date + "</td>" +
					"<td class='date_sec' style='display: none'>" + (-1* Date.parse(data[i].date)) + "</td>"+ 
					"<td class='result_item'>" +
						"<table style='width: 100%; height: 100%;' >" + 
			
							"<tr>" + 
								"<th style='width: 50%'>" +
									data[i].team1 +
								"</th>" +
								"<th style='width: 50%'>" +
									data[i].team2 +
								"</th>" +
							"</tr>" + 
				
						"<tbody>";

						// player color coding for their house
						/*
						<?php if ($_SESSION["ref"] == 0): ?>
						if (data[i].team1 == "<?=$_SESSION['house'] ?>" || data[i].team2 == "<?=$_SESSION['house'] ?>") {
							if (data[i].team1 == "<?=$_SESSION['house'] ?>" && data[i].team1score > data[i].team2score) {
								HTML += "<tr style='background-color: green; color: white;'>";
							}
							else if (data[i].team1 == "<?=$_SESSION['house'] ?>" && data[i].team1score < data[i].team2score) {
								HTML += "<tr style='background-color: #A41034; color: white;' >";
							}
							else if (data[i].team2 == "<?=$_SESSION['house'] ?>" && data[i].team2score > data[i].team1score) {
								HTML += "<tr style='background-color: green; color: white;'>";
							}
							else if (data[i].team2 == "<?=$_SESSION['house'] ?>" && data[i].team2score < data[i].team1score) {
								HTML += "<tr style='background-color: #A41034; color: white;'>";
							}
							else {
								HTML += "<tr style='background-color: gray; color: white;'>";
							}
						} 
						<?php endif ?>
						*/
							
						HTML+=	"<tr><td style='z-index: 1; height: fixed;' class='edit'>" +
									data[i].team1score + 
								"</td>" +
								"<td style='z-index: 1; height: fixed;' class='edit'>" +
									data[i].team2score + 
								"</td>" +
							"</tr>" + 
						"</tbody>" +
						"</table>" + 
					"</td>" + 
					"<td class='sport' style='vertical-align: middle;'>" + data[i].sport + "</td>" + 
					
					"<td class='team1' style='display:none'>" + data[i].team1 + "</td>" + 
					"<td style='display:none' class='team2'>" + data[i].team2 + "</td></tr>";
				}

				HTML += "</tbody></table><ul class='pagination'></ul>";
				$("#results").html(HTML).promise().done(function() {
					var options = {
						valueNames: [ 'date', 'sport', 'team1', 'team2', 'date_sec'],
						page: 8,
                		plugins: [ ListPagination({}) ] 
					};
					var userList = new List('results', options);
					userList.sort('date_sec', { order: "asc" });
				});
		
			}
			// $(" td.edit ").click(tdClick);
		});



		
			
	});	

	
	/* function tdClick() {
		var td = $(this);
		var currentScore = td.text();
		console.log(currentScore);
		var input = "<input type='text' class='form-control' style='height: 20px; width: 60px; margin: auto;' value = " + currentScore + ">";
		td.html(input).promise().done(function () {
			td.off('click');
		});
		
		$("html").keypress(function (e) {
		 var key = e.which;
		 if(key == 13)  // the enter key code
		  {
		  	var newScore = td.children(" input ").val();
		  	td.html(newScore);
		    td.on('click', tdClick);
		  }

		});
	}
	*/
	
	
	</script>







