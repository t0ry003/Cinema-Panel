<?php

class Schedule
{
    private $sch_id;
    private $sch_movieName;
    private $schRoom;
    private $schDate;
    private $schTime;
    private $oldSchRoom;
    private $oldSchDate;
    private $oldSchTime;

    public function __construct($id, $movie, $room, $date, $time, $oldSchRoom, $oldSchDate, $oldSchTime)
    {
        $this->sch_id = $id;
        $this->sch_movieName = $movie;
        $this->schRoom = $room;
        $this->schDate = $date;
        $this->schTime = $time;
        $this->oldSchRoom = $oldSchRoom;
        $this->oldSchDate = $oldSchDate;
        $this->oldSchTime = $oldSchTime;
    }

    public function addSchedule()
    {

        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "  INSERT INTO schedule (movie_id, room_id, startDate, startHours) 
                    SELECT movies.movie_id, rooms.room_id, '$this->schDate', '$this->schTime'
                    FROM movies, rooms
                    WHERE movies.movie_id = (SELECT movie_id FROM movies WHERE movieName = '$this->sch_movieName')
                    AND rooms.room_id = (SELECT room_id FROM rooms WHERE roomName = '$this->schRoom')
                ";

        if ($conn->query($query) == true) {

            $query2 = "SELECT seat_column, seat_row FROM rooms WHERE roomName = '$this->schRoom'";

            $result2 = $conn->query($query2);
            $row2 = mysqli_fetch_assoc($result2);

            if ($result2->num_rows > 0) {
                for ($i = 1; $i <= $row2['seat_row']; $i++) {

                    for ($j = 1; $j <= $row2['seat_column']; $j++) {

                        $query1 = "INSERT INTO seats (seatName, roomName, startDate, startHours, movieName) VALUES ('$i-$j', '$this->schRoom', '$this->schDate', '$this->schTime', '$this->sch_movieName')";

                        $result = $conn->query($query1);

                        if ($result == false) {
                            echo "Error occurred!";
                        }
                    }
                }
                header("Location: ../createSchedule.php?scheduleCreated=success");
                exit();
            } else {
                header("Location: ../createSchedule.php?scheduleCreated=failed");
                exit();
            }
        }
    }


    public function cancelSchedule()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO canceledschedules (movieName, roomName, startDate, startHours, schedule_id)
                    SELECT movies.movieName, rooms.roomName, schedule.startDate, schedule.startHours, schedule.schedule_id 
                    FROM movies
                    INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                    INNER JOIN rooms ON schedule.room_id = rooms.room_id
                    WHERE schedule_id = '$this->sch_id' ";

        if ($conn->query($query) == true) {

            $query3 = "DELETE FROM seats WHERE roomName = '$this->schRoom' AND startDate= '$this->schDate' AND startHours= '$this->schTime' ";

            if ($conn->query($query3) == true) {

                $query1 = "DELETE FROM schedule WHERE schedule_id = '$this->sch_id' ";

                if ($conn->query($query1) == true) {
                    header("Location: ../schedules.php?scheduleCanceled=success");
                    exit();
                } else {
                    $query2 = "DELETE FROM canceledschedules WHERE canceledschedules.schedule_id = '$this->sch_id' ";

                    if ($conn->query($query2) == true) {
                        header("Location: ../schedules.php?scheduleCanceled=failed");
                        exit();
                    }
                }
            } else {
                header("Location: ../schedules.php?scheduleCanceled=failed");
                exit();
            }
        }
    }

    public function editSchedule()
    {

        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "UPDATE schedule 
                  SET schedule.movie_id = (SELECT movie_id FROM movies WHERE movieName = '$this->sch_movieName'), 
                    schedule.room_id = (SELECT rooms.room_id FROM rooms WHERE roomName = '$this->schRoom'),
                    schedule.startDate = '$this->schDate',
                    schedule.startHours = '$this->schTime'
                   WHERE schedule_id = $this->sch_id";

        if ($conn->query($query) == true) {

            $query2 = "DELETE FROM seats WHERE roomName = '$this->oldSchRoom'
                        AND startDate = '$this->oldSchDate'
                        AND startHours = '$this->oldSchTime' ";

            if ($conn->query($query2) == true) {

                $query3 = "SELECT seat_column, seat_row FROM rooms WHERE roomName = '$this->schRoom'";

                $result3 = $conn->query($query3);
                $row3 = mysqli_fetch_assoc($result3);

                if ($result3->num_rows > 0) {

                    for ($i = 1; $i <= $row3['seat_row']; $i++) {

                        for ($j = 1; $j <= $row3['seat_column']; $j++) {

                            $query4 = "INSERT INTO seats (seatName, roomName, startDate, startHours) VALUES ('$i-$j', '$this->schRoom', '$this->schDate', '$this->schTime')";

                            $result = $conn->query($query4);

                            if ($result == false) {
                                echo "Error occurred!";
                            }
                        }
                    }
                }
                header("Location: ../schedules.php?scheduleEdited=success");
                exit();
            } else {
                header("Location: ../schedules.php?scheduleEdited=failed");
                exit();
            }
        }
    }


    public function completeSchedule()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO completed_schedule (movieName, roomName, startDate, startHours, schedule_id)
                    SELECT movies.movieName, rooms.roomName, schedule.startDate, schedule.startHours, schedule.schedule_id 
                    FROM movies
                    INNER JOIN schedule ON schedule.movie_id = movies.movie_id
                    INNER JOIN rooms ON schedule.room_id = rooms.room_id
                    WHERE schedule_id = '$this->sch_id' ";

        if ($conn->query($query) == true) {

            $query3 = "DELETE FROM seats WHERE roomName = '$this->schRoom' AND startDate= '$this->schDate' AND startHours= '$this->schTime' ";

            if ($conn->query($query3) == true) {

                $query1 = "DELETE FROM schedule WHERE schedule_id = '$this->sch_id' ";

                if ($conn->query($query1) == true) {
                    header("Location: ../schedules.php?scheduleCompleted=success");
                    exit();
                } else {
                    $query2 = "DELETE FROM completed_schedule WHERE completed_schedule.schedule_id = '$this->sch_id' ";

                    if ($conn->query($query2) == true) {
                        header("Location: ../schedules.php?scheduleCompleted=failed");
                        exit();
                    }
                }
            } else {
                header("Location: ../schedules.php?scheduleCompleted=failed");
                exit();
            }
        }
    }
}

if (isset($_POST['submit-scheduleCr'])) {
    $date = date('Y-m-d', strtotime($_POST['sch_movieDate']));
    $hour = date('H:i:s', strtotime($_POST['sch_movieTime']));

    $newSchedule = new Schedule(null, $_POST['sch_movieName'], $_POST['sch_movieRoom'], $date, $hour, null, null, null);

    $newSchedule->addSchedule();
}

if (isset($_GET['cancelSchedule'])) {

    $date = date('Y-m-d', strtotime($_GET['date']));
    $hour = date('H:i:s', strtotime($_GET['time']));

    $cancelSchedule = new Schedule($_GET['cancelSchedule'], null, $_GET['room'], $date, $hour, null, null, null);

    $cancelSchedule->cancelSchedule();
}

if (isset($_POST['submit-scheduleUp'])) {

    $date = date('Y-m-d', strtotime($_POST['sch_movieDate']));
    $hour = date('H:i:s', strtotime($_POST['sch_movieTime']));

    $oldDate = date('Y-m-d', strtotime($_POST['oldScheduleDate_H']));
    $oldTime = date('H:i:s', strtotime($_POST['oldScheduleTime_H']));

    $editSchedule = new Schedule($_POST['schedule_idH'], $_POST['sch_movieName'], $_POST['sch_movieRoom'], $date, $hour, $_POST['oldScheduleRoom_H'], $oldDate, $oldTime);

    $editSchedule->editSchedule();
}

if (isset($_GET['completeSchedule'])) {

    $date = date('Y-m-d', strtotime($_GET['date']));
    $hour = date('H:i:s', strtotime($_GET['time']));

    $completeSchedule = new Schedule($_GET['completeSchedule'], null, $_GET['room'], $date, $hour, null, null, null);

    $completeSchedule->completeSchedule();
}
