<form>
	<?php include 'navigation.php';?>
	<h1 style="margin:0 0 20px 0;"> The Huddle </h1>
	<div class="form-group" style="clear:both;">
		<span>See posts for:</span>
		<select class="form-control" name="sport" id="thr class='post_break'eads">
			<option value = "general"> General</option>
			<option value = "A Basketball">A Basketball</option>
		        <option value = "B Basketball">B Basketball</option>
		        <option value = "C Basketball">C Basketball</option>
		        <option value = "A Crew - Men">A Crew - Men</option>
		        <option value = "B Crew - Men">B Crew - Men</option>
		        <option value = "A Crew - Women">A Crew - Women</option>
		        <option value = "B Crew - Women">B Crew - Women</option>
		        <option value = "Flag Football">Flag Football</option>
		        <option value = "Ice Hockey">Ice Hockey</option>
		        <option value = "Soccer">Soccer</option>
		        <option value = "Softball">Softball</option>
		        <option value = "Tennis">Tennis</option>
		        <option value = "A Volleyball">A Volleyball</option>
		        <option value = "B Volleyball">B Volleyball</option>
		</select>
	</div>

	<div id="posts_container">
		<div id="past_posts" userid="<?= $_SESSION['id'] ?>">
		</div>
	</div>
	
	<!- Create a post>
	<h3>Create a post.</h3>
	<div class="chat">
		<fieldset>
			<div class="form-group">
			   <textarea class="form-control" rows="3" style="resize:none; width:85%;text-align:left;" name="message" id="msg"></textarea>
			</div>
			<div class="form-group">
				<button type="button" class="button-login" id="create" style="width: 120px;" onclick="createPost();">Create</button>
			</div>
		</fieldset>
	</div>

	
	

</form>

<!-- Javascript -->
<script src="/js/huddle_form.js"></script>








