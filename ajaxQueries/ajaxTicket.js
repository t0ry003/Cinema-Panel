$(document).ready(function () {
    function updateElement(url, elementToUpdate) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", url, false);
        xmlhttp.send();
        $(elementToUpdate).html(xmlhttp.responseText);
    }

    $("#inputGroupSelectMovie").change(function () {
        var movieName = $(this).val();
        updateElement(
            "/cinema/ajaxQueries/selectRoom.php?movie=" + movieName,
            "#inputGroupSelectRoom"
        );

        var roomName = $("#inputGroupSelectRoom").val();
        var scheduleDate = $("#inputGroupSelectDate").val();
        var scheduleTime = $("#inputGroupSelectTime").val();
        updateElement(
            "/cinema/ajaxQueries/selectDate.php?movie=" +
            movieName +
            "&room=" +
            roomName,
            "#inputGroupSelectDate"
        );
        updateElement(
            "/cinema/ajaxQueries/selectTime.php?movie=" +
            movieName +
            "&room=" +
            roomName +
            "&date=" +
            scheduleDate,
            "#inputGroupSelectTime"
        );
        updateElement(
            "/cinema/ajaxQueries/selectSeats.php?room=" +
            roomName +
            "&date=" +
            scheduleDate +
            "&time=" +
            scheduleTime,
            "#createSeats"
        );
    });

    $("#inputGroupSelectRoom").change(function () {
        var movieName = $("#inputGroupSelectMovie").val();
        var roomName = $(this).val();
        var scheduleDate = $("#inputGroupSelectDate").val();
        var scheduleTime = $("#inputGroupSelectTime").val();
        updateElement(
            "/cinema/ajaxQueries/selectDate.php?movie=" +
            movieName +
            "&room=" +
            roomName,
            "#inputGroupSelectDate"
        );
        updateElement(
            "/cinema/ajaxQueries/selectTime.php?movie=" +
            movieName +
            "&room=" +
            roomName +
            "&date=" +
            scheduleDate,
            "#inputGroupSelectTime"
        );
        updateElement(
            "/cinema/ajaxQueries/selectSeats.php?room=" +
            roomName +
            "&date=" +
            scheduleDate +
            "&time=" +
            scheduleTime,
            "#createSeats"
        );
    });

    $("#inputGroupSelectDate").change(function () {
        var movieName = $("#inputGroupSelectMovie").val();
        var roomName = $("#inputGroupSelectRoom").val();
        var scheduleDate = $(this).val();
        var scheduleTime = $("#inputGroupSelectTime").val();
        updateElement(
            "/cinema/ajaxQueries/selectTime.php?movie=" +
            movieName +
            "&room=" +
            roomName +
            "&date=" +
            scheduleDate,
            "#inputGroupSelectTime"
        );
        updateElement(
            "/cinema/ajaxQueries/selectSeats.php?movie=" +
            movieName +
            "&room=" +
            roomName +
            "&date=" +
            scheduleDate +
            "&time=" +
            scheduleTime,
            "#createSeats"
        );
    });

    $("#inputGroupSelectTime").change(function () {
        var roomName = $("#inputGroupSelectRoom").val();
        var scheduleDate = $("#inputGroupSelectDate").val();
        var scheduleTime = $(this).val();
        updateElement(
            "/cinema/ajaxQueries/selectSeats.php?room=" +
            roomName +
            "&date=" +
            scheduleDate +
            "&time=" +
            scheduleTime,
            "#createSeats"
        );
    });

    $("#inputGroupSelectMovie").trigger("change");
});
