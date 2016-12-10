<?php
session_start();
require 'functions.php';

function print_children($pid, $parent, $depth=0) {
	$kw = "=";
	if ($parent == NULL) {
		$kw = "IS";
		$parent = "NULL";
	}
	$comments = querySQL("SELECT * FROM Comments WHERE parent $kw $parent AND product_ID = '$pid'");
	while ($com = $comments->fetch_assoc()) {
		?>
			<div id="com<?=$com["ID"]?>" class="comment" style="margin-left: 10px; margin-bottom: 10px;">
			<h4><?=$com["title"]?></h4>
			<p>
				<?=nl2br($com["description"])?>
			</p>
			<p id="addcomment<?=$com["ID"]?>"><small><a href="" onclick="addCommentField(<?=$com["ID"]?>); return false;">Svara</a></small></p>
			<div id="comments<?=$com["ID"]?>"></div>
			<?php
				print_children($pid, $com["ID"]);
			?>
			</div>
		<?php
	}
}

if (!isset($_GET["pid"])) {
	die("Kan inte ladda kommentarer för denna produkt.");
}

$pid = sanitizeString($_GET["pid"]);
$reviews = querySQL("SELECT c.title, c.description, u.first_name, g.grade
	FROM Grades g
	INNER JOIN Comments c ON g.comment_ID = c.ID
	INNER JOIN Users u ON u.ID = g.user_ID
	WHERE g.product_ID = $pid");

if ($reviews->num_rows < 1) {
	die("Det finns inga recensioner... Du kan bli den första!");
}

while ($rev = $reviews->fetch_assoc()) {
	$txtclass = "";
	if ($rev["grade"] < 5) {
		$txtclass = "text-danger";
	} elseif ($rev["grade"] < 8) {
		$txtclass = "text-warning";
	} else {
		$txtclass = "text-success";
	}
	?>
	<div style="margin-bottom: 10px">
		<h4 class="<?=$txtclass?>"><?=$rev["grade"]?>/10 - <?=$rev["title"]?> <small>av <?=$rev["first_name"]?></small></h4>
		<p><?=nl2br($rev["description"])?></p>
	</div>
	<?php
}

