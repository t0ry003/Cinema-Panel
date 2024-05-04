$(document).ready(function () {
    // Function to perform AJAX request and update element
    function updateElement(url, elementToUpdate) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", url, false);
        xmlhttp.send();
        $(elementToUpdate).html(xmlhttp.responseText);
    }

    // Function to update room, date, time, and seats based on movie selection
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

    // Function to update date, time, and seats based on room selection
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

    // Function to update time and seats based on date selection
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

    // Function to update seats based on time selection
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

    // Update seats based on default selected values
    $("#inputGroupSelectMovie").trigger("change");
});
