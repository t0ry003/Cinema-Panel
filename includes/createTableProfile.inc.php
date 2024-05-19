<?php

$userId = $_SESSION['userId'];

//connecting to database
include "includes/connectDB.inc.php";

//Join 5 tables to get the data we want based on user's id
$query = " SELECT schedule.startDate,
                movies.movieName,
                rooms.roomName,
                booking.booking_id, 
                booking.booked_date,
                seats.startHours, 
                reservedseats.seatName,
                reservedseats.seat_id,
                reservedseats.reservedSeat_id
            FROM users 
            INNER JOIN booking ON users.userID = booking.user_id
            INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
            INNER JOIN movies ON schedule.movie_id = movies.movie_id
            INNER JOIN rooms ON schedule.room_id = rooms.room_id
            INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
            INNER JOIN seats ON seats.seat_id = reservedseats.seat_id
            WHERE booking.user_id = '$userId'";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) {
        // create an id that will be used to complete a booking
        // $row['booking_id']; $row['roomName'];  $row['startDate'];$row['startHours'];$row['seatName'];$row['reservedSeat_id']; and make it fit in the complete booking link with id=id&startDate=startDate&roomName=roomName&seat=seatName&reSeat=reservedSeat_id
        $id = "completeBooking=" . $row['booking_id'] . "~roomName=" . $row['roomName'] . "~date=" . $row['startDate'] . "~time=" . $row['startHours'] . "~seat=" . $row['seatName'] . "~reSeat=" . $row['reservedSeat_id'];
//      prelucrate the seat name into 2 variables a row and a column (ex: 18-8)
        $seat = explode("-", $row['seatName']);
        $seat_row = $seat[0];
        $seat_column = $seat[1];

        ?>
        <tr>
            <td><?php echo $row['startDate']; ?></td>
            <td><?php echo $row['movieName']; ?></td>
            <td><?php echo $row['roomName']; ?></td>
            <td><?php echo "Row: " . $seat_row . " Col: " . $seat_column ?></td>
            <td><?php echo $row['booked_date']; ?></td>
            <td><a href="./qrcode.php?text=<?php echo $id ?>" target="_blank"><img alt="<?php echo $id ?>"
                                                                                   src="./qrcode.php?text=<?php echo $id ?>"/></a>
            </td>
        </tr>

        <?php
    }
}

?>