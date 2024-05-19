<?php

session_start();

class Booking
{
    private $booking_id;
    private $movie;
    private $date;
    private $hour;
    private $room;
    private $seats;
    private $datePrevious;
    private $hourPrevious;
    private $roomPrevious;
    private $seatsPrevious;
    private $seatID;
    private $reSeatID;

    function __construct($booking_id, $movie, $date, $hour, $room, $seats, $datePrevious, $hourPrevious, $roomPrevious, $seatsPrevious, $seatID, $reSeatID)
    {
        $this->booking_id = $booking_id;
        $this->movie = $movie;
        $this->date = $date;
        $this->hour = $hour;
        $this->room = $room;
        $this->seats = $seats;
        $this->datePrevious = $datePrevious;
        $this->hourPrevious = $hourPrevious;
        $this->roomPrevious = $roomPrevious;
        $this->seatsPrevious = $seatsPrevious;
        $this->seatID = $seatID;
        $this->reSeatID = $reSeatID;
    }

    public function addBooking($userId)
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO booking (user_id, schedule_id) 
                SELECT userID, schedule_id  FROM users, schedule 
                WHERE movie_id = (SELECT movie_id FROM movies WHERE movieName='$this->movie') 
                AND room_id = (SELECT room_id FROM rooms WHERE roomName='$this->room') 
                AND startDate = '$this->date'
                AND startHours = '$this->hour' 
                AND userID = '$userId'";

        if ($conn->query($query)) {

            foreach ($this->seats as $row) {

                $query2 = "INSERT INTO reservedseats (booking_id, seatName, seat_id)
                        SELECT booking.booking_id, seats.seatName, seats.seat_id FROM booking
                        INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
                        INNER JOIN rooms ON schedule.room_id = rooms.room_id
                        INNER JOIN seats ON rooms.roomName = seats.roomName
                        WHERE booking.user_id = '$userId'
                        AND schedule.room_id = (SELECT room_id FROM rooms WHERE roomName = '$this->room')
                        AND seats.seatName = '$row'
                        AND seats.startDate = '$this->date'
                        AND seats.startHours = '$this->hour' ";

                $result = $conn->query($query2);

                if (!$result) {
                    echo "Error occurred!";
                } else {

                    $query3 = "UPDATE seats SET seatStatus = 'Booked'
                                        WHERE seatName = '$row' 
                                        AND roomName = '$this->room'
                                        AND startDate = '$this->date'
                                        AND startHours = '$this->hour' ";

                    $result = $conn->query($query3);

                    if (!$result) {
                        echo "Error occurred!";
                    }
                }
            }

            header("Location: ../booking.php?TicketBooked=success");
            exit();
        } else {
            header("Location: ../booking.php?TicketBooked=failed");
            exit();
        }
    }

    public function cancelBooking()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO `canceledbookings` (c_Email, movie, room, seat, s_date, s_time)
                    SELECT users.userEmail, movies.movieName, rooms.roomName, reservedseats.seatName, schedule.startDate, schedule.startHours
                    FROM users
                    INNER JOIN booking ON users.userID = booking.user_id
                    INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
                    INNER JOIN movies ON schedule.movie_id = movies.movie_id
                    INNER JOIN rooms ON schedule.room_id = rooms.room_id
                    INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
                    INNER JOIN seats ON seats.roomName = rooms.roomName
                    WHERE booking.booking_id = '$this->booking_id'
                    AND seats.roomName = '$this->room'
                    AND seats.startDate = '$this->date'
                    AND seats.startHours = '$this->hour'
                    AND seats.seatName = '$this->seats'
                    AND reservedseats.reservedSeat_id = '$this->reSeatID' ";

        if ($conn->query($query) == true) {

            $query1 = "UPDATE seats SET seatStatus = 'Not booked' 
                        WHERE seatName = '$this->seats'
                        AND seats.roomName = '$this->room'
                        AND seats.startDate = '$this->date'
                        AND seats.startHours = '$this->hour' ";

            if ($conn->query($query1) == true) {

                $query2 = "DELETE FROM reservedseats WHERE booking_id = '$this->booking_id' AND seatName = '$this->seats' ";

                if ($conn->query($query2) == true) {

                    $query3 = "DELETE FROM booking WHERE booking_id = '$this->booking_id'";

                    if ($conn->query($query3) == true) {
                        header("Location: ../bookings.php?bookingCanceled=success");
                        exit();
                    } else {
                        header("Location: ../bookings.php?bookingCanceled=success");
                        exit();
                    }
                }
            }
        } else {
            header("Location: ../bookings.php?bookingCanceled=failed");
            exit();
        }
    }

    public function editBooking()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "UPDATE booking 
                    SET booking.schedule_id = 
                    (
                        SELECT schedule.schedule_id FROM schedule 
                        WHERE schedule.movie_id = (SELECT movies.movie_id FROM movies WHERE movieName = '$this->movie')
                        AND schedule.room_id = (SELECT rooms.room_id FROM rooms WHERE roomName = '$this->room' )
                        AND schedule.startDate = '$this->date'
                        AND schedule.startHours = '$this->hour'
                    )
                    WHERE booking_id = '$this->booking_id' ";

        if ($conn->query($query)) {

            $query1 = "UPDATE seats SET seatStatus = 'Not booked' 
                        WHERE seatName = '$this->seatsPrevious'
                        AND seats.roomName = '$this->roomPrevious'
                        AND seats.startDate = '$this->datePrevious'
                        AND seats.startHours = '$this->hourPrevious'";

            if ($conn->query($query1)) {


                $query12 = "DELETE FROM reservedseats WHERE booking_id = '$this->booking_id' AND seatName = '$this->seatsPrevious' AND seat_id = '$this->seatID' ";

                if ($conn->query($query12)) {

                    foreach ($this->seats as $row) {

                        $query2 = "INSERT INTO reservedseats (booking_id, seatName, seat_id) 
                        SELECT '$this->booking_id', seats.seatName, seat_id FROM booking, seats
                        WHERE seats.roomName = '$this->room'
                        AND seats.seatName = '$row'
                        AND seats.startDate = '$this->date'
                        AND seats.startHours = '$this->hour'
                        LIMIT 1 ";

                        $result = $conn->query($query2);

                        if ($result == false) {
                            echo "Error occurred!";
                        } else {

                            $query3 = "UPDATE seats SET seatStatus = 'Booked' WHERE seatName = '$row' 
                            AND roomName = '$this->room' 
                            AND seats.startDate = '$this->date'
                            AND seats.startHours = '$this->hour'";

                            $result = $conn->query($query3);

                            if ($result == false) {
                                echo "Error occurred!";
                            }
                        }
                    }
                }
            }

            header("Location: ../bookings.php?bookingEdited=success");
            exit();
        } else {
            header("Location: ../bookings.php?bookingEdited=failed");
            exit();
        }
    }

    public function completeBooking()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO completed_bookings (userEmail, movieName, roomName, seatName, startDate, startHours)
            SELECT users.userEmail, movies.movieName, rooms.roomName, reservedseats.seatName, schedule.startDate, schedule.startHours
            FROM users
            INNER JOIN booking ON users.userID = booking.user_id
            INNER JOIN schedule ON schedule.schedule_id = booking.schedule_id
            INNER JOIN movies ON schedule.movie_id = movies.movie_id
            INNER JOIN rooms ON schedule.room_id = rooms.room_id
            INNER JOIN reservedseats ON reservedseats.booking_id = booking.booking_id
            INNER JOIN seats ON seats.roomName = rooms.roomName
            WHERE reservedseats.booking_id = '$this->booking_id'
            AND seats.roomName = '$this->room'
            AND seats.startDate = '$this->date'
            AND seats.startHours = '$this->hour'
            AND seats.seatName = '$this->seats'
            AND reservedseats.reservedSeat_id = '$this->reSeatID' ";

        if ($conn->query($query) === TRUE) {

            $query1 = "DELETE FROM reservedseats 
                   WHERE booking_id = '$this->booking_id' 
                   AND seatName = '$this->seats'";

            if ($conn->query($query1) === TRUE) {
                $query2 = "DELETE FROM booking 
                       WHERE booking_id = '$this->booking_id' 
                       AND NOT EXISTS (SELECT * FROM reservedseats WHERE booking_id = '$this->booking_id')";

                if ($conn->query($query2) === TRUE) {
                    $query3 = "UPDATE seats SET seatStatus = 'Not booked' 
                    WHERE roomName = '$this->room'
                    AND startDate = '$this->date'
                    AND startHours = '$this->hour'
                    AND seatName = '$this->seats'";

                    if ($conn->query($query3) === TRUE) {
                        header("Location: ../bookings.php?bookingCompleted=success");
                        exit();
                    } else {
                        header("Location: ../bookings.php?bookingCompleted=failed");
                        exit();
                    }
                } else {
                    header("Location: ../bookings.php?bookingCompleted=failed");
                    exit();
                }
            } else {
                header("Location: ../bookings.php?bookingCompleted=failed");
                exit();
            }
        } else {
            header("Location: ../bookings.php?bookingCompleted=failed");
            exit();
        }
    }
}

if (isset($_POST['submit-booking'])) {

    $date = date('Y-m-d', strtotime($_POST['date']));
    $hour = date('H:i:s', strtotime($_POST['hours']));

    if ($_POST['seats'] == null) {
        header("Location: ../booking.php?TicketBooked=null");
        exit;
    }

    $newBooking = new Booking(null, $_POST['movie'], $date, $hour, $_POST['room'], $_POST['seats'], null, null, null, null, null, null);

    $newBooking->addBooking($_SESSION['userId']);

}

if (isset($_POST['submit-booking-admin'])) {

    $date = date('Y-m-d', strtotime($_POST['date']));
    $hour = date('H:i:s', strtotime($_POST['hours']));

    if ($_POST['seats'] == null) {
        header("Location: ../booking.php?TicketBooked=null");
        exit;
    }

    $newBooking = new Booking(null, $_POST['movie'], $date, $hour, $_POST['room'], $_POST['seats'], null, null, null, null, null, null);

    $newBooking->addBooking($_POST['customer']);

}

if (isset($_GET['cancelBooking'])) {

    $date = date('Y-m-d', strtotime($_GET['date']));
    $hour = date('H:i:s', strtotime($_GET['time']));

    $deleteBooking = new Booking($_GET['cancelBooking'], null, $date, $hour, $_GET['roomName'], $_GET['seat'], null, null, null, null, null, $_GET['reSeat']);

    $deleteBooking->cancelBooking();
}

if (isset($_POST['submit-bookingUp'])) {

    $date = date('Y-m-d', strtotime($_POST['date']));
    $hour = date('H:i:s', strtotime($_POST['hours']));

    $datePrev = date('Y-m-d', strtotime($_POST['oldDate_H']));
    $hourPrev = date('H:i:s', strtotime($_POST['oldTime_H']));

    if ($_POST['seats'] == null) {
        header("Location: ../bookings.php?bookingEdited=null");
        exit;
    }

    $editBooking = new Booking($_POST['booking_idH'], $_POST['movie'], $date, $hour, $_POST['room'], $_POST['seats'], $datePrev, $hourPrev, $_POST['oldRoom_H'], $_POST['oldSeat_H'], $_POST['oldSeatID_H'], null);

    $editBooking->editBooking();
}

if (isset($_GET['completeBooking'])) {

    $date = date('Y-m-d', strtotime($_GET['date']));
    $hour = date('H:i:s', strtotime($_GET['time']));

    $completeBooking = new Booking($_GET['completeBooking'], null, $date, $hour, $_GET['roomName'], $_GET['seat'], null, null, null, null, null, $_GET['reSeat']);

    $completeBooking->completeBooking();
}
