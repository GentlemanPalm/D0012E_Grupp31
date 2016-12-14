<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["user_ID"])) {
	echo "Du måste vara inloggad för att komma åt denna funktion!";
	die();
}

if (isset($_POST["title"])) {

	$title = sanitizeString($_POST["title"]);
	$content = sanitizeString($_POST["content"]);
	$pid = sanitizeString($_POST["pid"]);
	$par = NULL;
	if (isset($_POST["parent"])) {
		$par = sanitizeString($_POST["parent"]);
	} else {
		$par = "NULL";
	}
	querySQL("INSERT INTO Comments (title, description, parent, product_ID, user_ID, approved)
		VALUES ('$title','$content',$par,'$pid','$_SESSION[user_ID]', false)");
} else {
	$cid = isset($_GET["par"]) ? "commentform".sanitizeString($_GET["par"]) : "commentform";
?>
	<form action="addcomment.php" method="POST" id="<?=$cid?>">
		<input type="text" class="form-control" name="title" placeholder="Titel..." /><br />
		<textarea class="form-control" name="content" placeholder="Din kommentar här, max 500 tecken." style="resize: none;" rows="10"></textarea><br />
		<input type="hidden" value="<?=$_GET["pid"]?>" name="pid"/>
		<?php
		if (isset($_GET["par"])) {
			?>
			<input type="hidden" value="<?=$_GET["par"]?>" name="parent">
			<?php
		}
		?>
		<button class="btn btn-success form-control" id="comment" name="submit" type="submit" value="1">Kommentera!</button>
	</form>
	<script type="text/javascript">
	$("#<?=$cid?>").submit(function(ev) {
	
	ev.preventDefault(ev);
	$.ajax({
		url: $("#<?=$cid?>").attr("action"),
		type: $("#<?=$cid?>").attr("method"),
		data: $("#<?=$cid?>").serialize(),
		success: function(data) {
			$("#addcomment<?=$_GET["par"]?>").html("Du har nu lagt upp en kommentar. Grattis.");
			updateComments();
		}
	});
	return false;
});
	</script>
<?php	
}
