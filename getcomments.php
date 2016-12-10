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

print_children($pid, NULL);

