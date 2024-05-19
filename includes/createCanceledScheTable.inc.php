<?php

global $conn;
include "includes/connectDB.inc.php";

$query = "SELECT * FROM canceledschedules ";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) {

        ?>


        <tr>
            <td><?php echo $row['cS_id']; ?></td>
            <td><?php echo $row['movieName']; ?></td>
            <td><?php echo $row['roomName']; ?></td>
            <td><?php echo $row['startDate']; ?> , <?php echo $row['startHours']; ?></td>
            <td><?php echo $row['cancelDate']; ?></td>
        </tr>


        <?php
    }
}
?>