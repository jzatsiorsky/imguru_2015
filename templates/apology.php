<!- Include navigation bar>
<?php if (isset($_SESSION["captain"])): ?>
	<?php include 'navigation.php';?>
<?php endif ?>

<h1 style="margin:20px 0 20px 0;">
    Sorry!
</h1>
<h2>
    <?= htmlspecialchars($message) ?>
<h2>

<a href="javascript:history.go(-1);">Back</a>
