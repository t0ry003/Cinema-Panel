<?php
require "header.php";
?>

    <style>
        .custom-table {
            color: white;
            font-family: "Lato", sans-serif;
            text-align: center;
            border: 1px solid #96E9C6;
            width: 70%;
            margin: 0 auto;
        }

        .custom-table th, .custom-table td {
            vertical-align: middle;
            border: 1px solid #96E9C6;
            padding-bottom: 4px;
            padding-top: 4px;
            padding-left: 2px;
            padding-right: 2px;
        }
    </style>

    <main>
        <div class="container-xl">
            <div class="jumbotron" style="background-color: #0e0e0e; margin-top: -30px;">
                <h1 class="title" style="text-align: center;">Previous bookings</h1>
            </div>

            <div class="table-responsive">
                <table class="table custom-table"
                       style="color: white; margin-bottom: 100px;">
                    <tr>
                        <th scope="col"><strong>PLAYING DATE</strong></th>
                        <th scope="col"><strong>MOVIE</strong></th>
                        <th scope="col"><strong>ROOM</strong></th>
                        <th scope="col"><strong>SEAT</strong></th>
                        <th scope="col"><strong>BOOKED DATE</strong></th>
                        <th scope="col"><strong>CODE TO PROVIDE</strong></th>
                    </tr>
                    <?php

                    include "includes/createTableProfile.inc.php";

                    ?>

                </table>
            </div>
        </div>

    </main>

<?php
require "footer.php";
?>