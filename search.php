<?php
require_once "functions.php";
global $connection;
$search = sanitizeString($_GET['q']);
require_once "template/header.php";
require_once "template/footer.php";
generateHeader("Sök");
$con = $connection;
		if ($search == ""){}
		else{
		if (!$con){
			die('Could not connect: ' . mysqli_error($con));
		}else{
			$sql = "SELECT * FROM Products WHERE name LIKE '%$search%'";
			$result = mysqli_query($con,$sql);?>
			    <table class="table table-hover">
        <thead>
        <tr>
            <th>Produktnamn</th>
            <th>Betyg</th>
            <th>Pris</th>
							<?php
				if($_SESSION['access'] == "3"){
                echo "<th>Redigera</th>";
				}
				?>
           
        </tr>
        </thead>
        <tbody>
			
		<?php	while($row = mysqli_fetch_array($result)) {
				echo"<option onClick=gohere($row[ID])>$row[name]</option>";
			}
			}
		}




generateFooter();
?>