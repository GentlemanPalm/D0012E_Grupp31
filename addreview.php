<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["user_ID"])) {
	echo "Du måste vara inloggad för att komma åt denna funktion!";
	die();
}
echo "Inloggad. ";
if (isset($_POST["grade"])) {
	echo "Recencerat. ";
	$grade = sanitizeString($_POST["grade"]);
	$uid = sanitizeString($_SESSION["user_ID"]);
	$pid = sanitizeString($_POST["pid"]);

	$par = "NULL";
	$cid = "NULL";
	if (isset($_POST["writtenreview"])) { 
		echo "Skrivet. ";
		$title = sanitizeString($_POST["title"]);
		$content = sanitizeString($_POST["content"]);
		querySQL("INSERT INTO Comments (title, description, parent, product_ID, user_ID, approved)
		VALUES ('$title','$content',$par,'$pid','$uid',false)");
		global $connection;
		$cid = mysqli_insert_id($connection);
	}
	echo $pid;
	querySQL("INSERT INTO Grades (grade, product_ID, user_ID, comment_ID)
		VALUES ('$grade', '$pid', $uid, $cid)");
	querySQL("UPDATE Products SET avg_grade = (SELECT AVG(grade) FROM Grades WHERE product_ID='$pid') WHERE ID = '$pid'");
	echo "Infört. ";
} else {
	$cid = "reviewform";
?>
	<form action="addreview.php" method="POST" id="<?=$cid?>">
		<input type="number" class="form-control" id="grade" name="grade" placeholder="Betyg på en skala mellan 1 och 10"><br />
		<input type="checkbox" class="form-control" id="writtenreview" name="writtenreview">Jag vill skriva en recension</input><br />
		<input type="text" class="form-control written" name="title" placeholder="Titel..." disabled="disabled"/><br />
		<textarea class="form-control written" name="content" placeholder="Din kommentar här, max 500 tecken." style="resize: none;" rows="10" disabled="disabled"></textarea><br />
		<input type="hidden" value="<?=$_GET["pid"]?>" name="pid"/>
		<button class="btn btn-success form-control" id="comment" name="submit" type="submit" value="1">Recencera!</button>
	</form>
	<script type="text/javascript">
		$("#writtenreview").click(function () {
			var isChecked = this.checked;
			$(".written").each(function () {
				$(this).prop("disabled", !isChecked);
		}); // http://stackoverflow.com/questions/24689636/enable-inputs-from-bootstrap-checkbox
	});

	$("#<?=$cid?>").submit(function(ev) {
	
	ev.preventDefault(ev);
	$.ajax({
		url: $("#<?=$cid?>").attr("action"),
		type: $("#<?=$cid?>").attr("method"),
		data: $("#<?=$cid?>").serialize(),
		success: function(data) {
			$("#addreview").html("Du har nu lagt upp en recesion. Grattis."+data);
			updateReviews();
		}
	});
	return false;
});
	</script>
<?php	
}