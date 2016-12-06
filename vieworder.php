<?php
/**
 * Created by PhpStorm.
 * User: palm
 * Date: 2016-11-16
 * Time: 10:24
 */

/*
 * Detta program ska läsa in produkter från databasen och sammanställa dem till en lista.
 * Preliminärt kommer det att generera statisk HTML, men om allt är klart till den sista sprinten så
 * ska detta omvandlas till JSON för att skickas via AJAJ.
 *
 * TODO: Testa detta program när en webbserver är tillgänglig
 */

require_once 'functions.php';
require 'template/header.php';
require 'template/footer.php';

generateHeader("Beställningar");
$products = NULL;
$id = "";
if (isset($_GET["id"])) {
    $id = sanitizeString($_GET["id"]);
    $products = querySQL("SELECT * FROM Orders WHERE user_ID = $id");
} else {
    header("Location: index.php");
    die("Ni ska inte se det här :P");
}

//echo $products;
?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Produktnamn</th>
            <th>Betyg</th>
            <th>Pris</th>
            <th>Redigera</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($prod = $products->fetch_assoc()) {
            $org_price = $prod["price"] + $prod["price"] * $prod["vat"]; // Beräkna egentligt pris
            $curr_price = $prod["current_price"] + $prod["current_price"] * $prod["vat"];
            $grade = ($prod["avg_grade"] == NULL) ? 0 : $prod["avg_grade"]; // Se till att betyg inte är NULL
            if ($curr_price < $org_price) { // Markera rea :P
                $curr_price = "<span class=\"text-danger\">".$curr_price."</span>";
            }
            ?>
            <tr>
            <td><a href="viewproduct.php?id=<?=$prod["ID"]?>"><?=$prod["name"]?></a></td>
            <td><?=$grade?></td>
            <td><?=$curr_price?></td>
            <td><a href="editproduct.php?id=<?=$prod["ID"]?>">Redigera</a></td>
            </tr><?php
        }?>
        </tbody>
    </table>
<?php
generateFooter();