<?php

global $conn;
include "includes/connectDB.inc.php";

$query = "SELECT * FROM canceledbookings";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) {

        ?>


        <tr>
            <td><?php echo $row['canceled_bookingID']; ?></td>
            <td><?php echo $row['c_Email']; ?></td>
            <td><?php echo $row['movie']; ?></td>
            <td><?php echo $row['room']; ?> , <?php echo $row['seat']; ?></td>
            <td><?php echo $row['s_date']; ?> , <?php echo $row['s_time']; ?></td>
            <td><?php echo $row['cancelDate']; ?></td>
        </tr>


        <?php
    }
}
?>