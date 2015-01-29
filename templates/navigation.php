
<div style="text-align:right; height: 60px;">
    <a href = "/manage_account.php"><img id="profile_pic" style="border-radius: 25px; margin-bottom: 10px;"/></a>
	<span id="welcome" style="clear: both; vertical-align: center; min-height: 50px">Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!</span>
</div>

<?php if ($_SESSION["ref"] == 0): ?>

<nav class="navbar navbar-default">
  	<div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
        <li><a href="games.php">Games</a></li>
        <li><a href="results.php">Results</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Standings<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="standings.php">Straus Cup</a></li>
            <li><a href="sports_standings.php">Individual Sports</a></li>
          </ul>
        </li>
        <li><a href="huddle.php">Huddle</a></li>
        <li><a href="league_signup.php">My Leagues</a></li>
    <?php if ($_SESSION["captain"] == 1): ?>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Captain Actions<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="schedule_game.php">Schedule Game</a></li>
            <li><a href="submit_result.php">Submit Result</a></li>
            <li><a href="captain_email.php">E-mail Players</a></li>
          </ul>
        </li>
    <?php endif ?>
        <li><a href="players.php">Players</a></li>
        </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php if ($_SESSION["dual"] == 1): ?>
    	<li><a href="dual.php">Switch Account</a></li>
    <?php endif ?>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Account<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="profile.php?id=<?= $_SESSION['id'] ?>">My Profile</a></li>
            <li><a href="manage_account.php">Settings</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
    </div>
  </div>
</nav>

<?php else: ?>
<!-- From the bootstrap documentation -->
<nav class="navbar navbar-default">
  	<div class="container-fluid">
    <div>
      <ul class="nav navbar-nav">
        <li><a href="/">Home</a></li>
        <li><a href="games.php">Games</a></li>
        <li><a href="results.php">Results</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Standings<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="standings.php">Straus Cup</a></li>
            <li><a href="sports_standings.php">Individual Sports</a></li>
          </ul>
        </li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Referee Actions<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="schedule_game.php">Schedule Game</a></li>
            <li><a href="submit_result.php">Submit Result</a></li>
            <li><a href="announcement.php">Make Announcement</a></li>
            <li><a href="create_schedule.php">Generate Schedule</a></li>
          </ul>
        </li>
        </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php if ($_SESSION["dual"] == 1): ?>
    	<li><a href="dual.php">Switch Account</a></li>
    <?php endif ?>
    	<li><a href="manage_account.php">Account Management</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
    </div>
  </div>
</nav>

<?php endif ?>
<br>

<script>

$(document).ready(function() {
    var photo = "<?= $_SESSION['photo'] ?>";
    console.log(photo);

    var smallPic = photo.split("200x200")[0];
    smallPic += "50x50/";

    $("#profile_pic").attr('src', smallPic);
    $("#profile_pic").html('Welcome, <?= htmlspecialchars($_SESSION["name"]) ?>!');
});

function changePicture(url) {
    var smallPic = url.split("200x200")[0];
    smallPic += "50x50/";
    $("#profile_pic").attr('src', smallPic);
}

</script>

