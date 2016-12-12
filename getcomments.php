<?php
session_start();
require 'functions.php';

function print_children($pid, $parent, $depth=0) {
	$kw = "=";
	if ($parent == NULL) {
		$kw = "IS";
		$parent = "NULL";
	}
	$comments = querySQL("SELECT c.*, u.first_name, g.grade FROM Comments c INNER JOIN Users u ON u.ID = c.user_ID LEFT JOIN Grades g ON g.user_ID = c.user_ID AND g.product_ID = c.product_ID WHERE parent $kw $parent AND c.product_ID = '$pid'");
	while ($com = $comments->fetch_assoc()) {
		?>
			<div id="com<?=$com["ID"]?>" class="comment <?=$com["approved"] ? "" : "text-muted"?>" style="margin-left: 10px; margin-bottom: 10px;">
			<h4><?=$com["title"]?> <small>av <?=$com["first_name"]?> <?php
			if(isset($com["grade"])) {
				?>som gav betyget <?=$com["grade"]?> av 10<?php
				}?></small></h4>
			<p>
				<?=nl2br($com["description"])?>
			</p>
			<p id="addcomment<?=$com["ID"]?>"><small><a href="" onclick="addCommentField(<?=$com["ID"]?>); return false;">Svara</a> 
			<?php
				if ($_SESSION["access"] > 1) {
					?>
					<a href="approvecomment.php?id=<?=$com["ID"]?>&pid=<?=$_GET["pid"]?>" style="margin-left: 10px">Approve</a>
					<?php
				}
			?></small></p>
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

