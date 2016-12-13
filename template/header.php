<?php
/**
 * Created by PhpStorm.
 * User: palm
 * Date: 2016-11-16
 * Time: 10:25
 */

/*
 * Syftet med denna fil är att ha en gemensam header för alla sidor. Denna ska sedan inkluderas i samtliga
 * PHP-dokument. Just nu får denna dock vara ganska så bare-bones.
 * */

	session_start();
        $user_ID = $session_ID = "";
        if(isset($_SESSION['user_ID'])){
            $user_ID = $_SESSION['user_ID'];
        }else{
            $session_ID = session_ID();
        }
function generateCategories() {
    $categories = querySQL("SELECT ID, title FROM Categories");
    while($category = $categories->fetch_assoc()) {
        $id = $category["ID"];
        $items = querySQL("SELECT ID FROM Products WHERE category_ID = $id")->num_rows;
        ?>
            <li class="list-group-item"><a href="browseproducts.php?id=<?=$id?>"><?=$category["title"]?></a><span class="badge"><?=$items?></span></li>
        <?php
    }
}   

function generateBootstrap() {
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <?php
}

function generateHeader ($title, $gen_head = true, $gen_bootstrap = true)
{
    if ($gen_head) { ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8"/>
            <title><?= $title ?></title>
            <?php
            if ($gen_bootstrap) {
                generateBootstrap();
            }
            ?>
        </head>
        <?php
    } ?>
    <body onload="loadCart(<?php echo $_SESSION['user_ID'];?>);">
    <div class="jumbotron" stype="margin-left:10pt;">
        <h1>Kontorsshoppen.se - <?=$title?></h1>
        <p>Kontorsvaror för den prisblinde kunden</p>
    
    <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">kontorsshoppen.se</a>
                </div>
               <ul class="nav navbar-nav">
                    <li><a href="index.php">Start</a></li>
                    <li><a href="browseproducts.php">Shop</a></li>
					<?php
					if(@$_SESSION['access'] == "3"){
					echo "<li><a href='addproduct.php'>Skapa produkter</a></li>
                    <li><a href='createcategory.php'>Skapa kategori</a></li>
					<li><a href='registerworker.php'>Lägg till anställd</a></li>";
					}
					?>
                    
                </ul>

				<script src = "search.js"></script>
				<script src = "jquery-3.1.1.min.js"></script>
				<script>function gohere(site){
					if (window.XMLHttpRequest) {
						xmlhttp = new XMLHttpRequest();
					}else{
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function(){
						if(this.readyState == 4 && this.status == 200){
							document.location.href = (this.responseText);
						}
					};
					xmlhttp.open("GET", "getpath.php?q="+site,true);
					xmlhttp.send();
					}			
				</script>
				<form class="navbar-form navbar-right">
					<input list = "lista"onkeyup="myFunction(this.value)" onselect="gohere(this.value)" class="form-control" id = "q" placeholder="Sök...">
					  
	            </form>
  <datalist id="lista">

  </datalist>
                <ul class="nav navbar-nav navbar-right" id="usrnav">
                    <!-- Detta bör förgöras av .ajax... -->
                </ul>
                <script type="text/javascript" src="usrnav.js" onload="usrnav();"></script>
            </div>
	
        </nav></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h3>Kategorier</h3>
                <ul class="list-group"><!-- Lägg till så att man kan få fram kategorierna -->
		<?php
		$total_items = querySQL("SELECT ID FROM Products")->num_rows; ?>
            <li class="list-group-item"><a href="browseproducts.php">Alla kategorier</a><span class="badge"><?=$total_items?></span></li>
                    <?php  generateCategories(); ?>
                </ul>
            </div>
            <div class="col-sm-7">


    <!-- TODO: Lägg till paneler och sådant. Kundvagn kan vara mycket viktigt i detta fall. -->
<?php
}
