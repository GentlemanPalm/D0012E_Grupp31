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

generateHeader("Produktlista");
global $connection;
$products = querySQL("SELECT (name, price, current_price, vat, avg_grade) FROM Products");
?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Produktnamn</th>
            <th>Betyg</th>
            <th>Pris</th>
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
                <td><?=$prod["name"]?></td>
                <td><?=$prod["avg_grade"]?></td>
                <td><?=$curr_price?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
<?php
generateFooter();