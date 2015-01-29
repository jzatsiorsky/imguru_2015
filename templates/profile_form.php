<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js"></script>
<link href="/css/xeditable.css" rel="stylesheet">
<script src="/js/xeditable.js"></script>

<?php include("../templates/navigation.php"); ?>

<img style="display: inline-block" src="/img/<?= strtolower($user['house']) ?>_shield.jpg"/>
<h1 style="margin: 0 10px 20px 10px; display: inline-block;"><?= $user["name"] ?></h1>
<img style="display: inline-block" src="/img/<?= strtolower($user['house']) ?>_shield.jpg"/>
<div>
	<img style="margin: 0 50px 0 50px; display: inline-block; border-radius: 100px; height: 150px; width: 150px;" src="<?= $user['photo'] ?>" />
</div>


<div style="display: inline-block; width: 60%; margin-left: auto; margin-right: auto; margin-top: 20px;" ng-app="app" ng-controller="Ctrl">


<?php if ($user["userid"] == $_SESSION["id"] && $_SESSION["ref"] == 0): ?>
<h1 editable-text="user.nickname" onaftersave="updateUser()" >
<?php else: ?>
<h1 ng-show = "user.nickname.length > 0">
<?php endif ?>

{{ user.nickname || "Choose a Nickname"}} 
</h1>
	<table class = "table table-bordered" align="center">
		<tr>
			<td colspan="1"><b>House</b></td>
			<td width="50%;"> <?=$user["house"] ?> </td>
		</tr>
		<tr ng-show = "<?= count($sports) ?> > 0">
			<td vertical-align = "middle" ><b>IM Sports Played</b></td>
			<td>
			<?php
			print("<ul class = 'list-unstyled'>");
				foreach ($sports as $sport) {
					print("<li>" . $sport . "</li>");
				}
			print("</ul>");
			?>


			</td>
		</tr>

	<?php foreach($labels as $label): ?>
		<!-- can only see if same id and not a ref -->
	<?php if ($user["userid"] == $_SESSION["id"] && $_SESSION["ref"] == 0): ?>
		<tr>
	<?php else: ?>
		<tr ng-show = "user.<?= $label['type']?>.length">
	<?php endif ?>
			<td><b> <?= $label["label"] ?> </b></td>
			<!-- Can only edit if same id and NOT a ref -->
			<?php if ($user["userid"] == $_SESSION["id"] && $_SESSION["ref"] == 0): ?>
				<td editable-text="user.<?= $label['type'] ?>" onaftersave="updateUser()">
			<?php else: ?>
				<td>
			<?php endif ?>
					{{ user.<?= $label["type"] ?> || "Empty" }}
				</td>
		</tr>
	<?php endforeach ?>
	</table>
</div>



<script>
// dependencies
var app = angular.module("app", ["xeditable"]);

app.run(function(editableOptions) {
  editableOptions.theme = 'bs3';
});

app.controller('Ctrl', function($http, $scope) {

  $scope.user = {
    team: "<?=$user['team']?>",
    from: "<?=$user['hometown']?>",
    nickname: "<?=addslashes($user['nickname']) ?>",
    highschool: "<?= addslashes($user['highschool']) ?>",
    hssports: "<?=$user['hssports']?>"
  };

   $scope.updateUser = function() {
    return $http.post('/updateProfile.php', {team: $scope.user.team, from: $scope.user.from, id: <?= $user["userid"] ?>, nickname: $scope.user.nickname, highschool: $scope.user.highschool, hssports: $scope.user.hssports });
  };

});

</script>



