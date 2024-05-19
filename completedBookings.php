<?php
require "header.php";
?>


    <main>

        <div class="container-xl">
            <div class="jumbotron" style="background-color: #0e0e0e; margin-bottom: -45px;">
                <h1 class="title">Customers Completed Bookings</h1>
            </div>

            <table class="table table-bordered border-primary"
                   style="color: white; border-color: #ff6600; margin-bottom: 150px; font-size: smaller;">
                <tr>
                    <td><strong>ID</strong></td>
                    <td><strong>CUSTOMER</strong></td>
                    <td><strong>MOVIE</strong></td>
                    <td><strong>ROOM & SEATS</strong></td>
                    <td><strong>SCHEDULE DATE</strong></td>
                </tr>

                <?php

                include "includes/createCompleBookTable.inc.php";

                ?>

            </table>

        </div>

    </main>

<?php
require "footer.php";
?>