<?php
/**
 * Created by PhpStorm.
 * User: palm
 * Date: 2016-11-16
 * Time: 10:25
 */

/*
 * Syftet med denna fil är att ha en gemensam header för alla sidor. Denna ska sedan inkluderas i samtliga
 * PHP-dokument. Just nu får denna dock vara tom.
 * */

function generateFooter() {
    ?>
    <!-- TODO: Lägg till paneler och slut på andra taggar som eventuellt startas i en framtida version av headern. -->
    </div>
    <div class="col-sm-3">
        <h2>Kundvagn</h2>
        <table class="table table-responsive table-hover" id="cart">
        </table>
        <script src="cart.js"></script>
        <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-shopping-cart"></span>Kassa</button>
    </div>
    </div>
    </div>
    </body>
    </html>
    <?php
}