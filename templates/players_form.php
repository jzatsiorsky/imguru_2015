<!- Include navigation bar>
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

<?php include 'navigation.php';?>
<h1 style="margin:0 0 20px 0;"> Players </h1>

<div id="players">
	<input class="search" placeholder="Search" />
	<button class="sort" data-sort="name">
    Sort by name
  	</button>
  	<button class="sort" data-sort="house">
    Sort by house
  	</button>
	<table class="table" style="width: 60%;">
		<tbody class="list">
		<?php foreach($users as $user): ?>
			<tr url= "/profile.php?id=<?= $user['userid'] ?>" class="home">
				<td style="width: 25%;">
					<img src="/img/<?= strtolower($user['house']) ?>_shield.jpg" height="50"/>
				</td>
				<td style="vertical-align: middle; font-size: 16px; font-weight: bold;" class="name">
					<?= $user["name"] ?>
				</td>
				<td style="width: 25%;">
					<img style="border-radius: 25px;" src="<?= $user['photo'] ?>" height="50" width="50"/>
				</td>
				<td class="house" style="display: none;">
					<?= $user["house"] ?>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>

</div>

<script>
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
</script>
<!-- http://www.listjs.com/ -->
<script src="http://listjs.com/no-cdn/list.js"></script>
<script>
var options = {
  valueNames: [ 'name', 'house']
};
var userList = new List('players', options);
</script>





