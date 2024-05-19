<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name=viewport content="width=device-width, initial-scale=1">

    <title>Cinema</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <script src="https://kit.fontawesome.com/9f11db8bcf.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</head>

<body style="background-color: #0e0e0e;">

<header>

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #6962AD;">
        <a class="navbar-brand" href="index.php"><strong>Cinema</strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rooms.php">Rooms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mobile.php">Mobile APP</a>
                </li>
                <?php
                if (isset($_SESSION['userId'])) { //first check if someone is logged in
                    if ($_SESSION['userRole'] == "Customer") {
                        echo '<li class="nav-item">
									<a class="nav-link" href="profile.php">Profile</a>
									</li>';
                    }
                    if ($_SESSION['userRole'] == "Administrator") {
                        echo '<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							  Manage
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							  <a class="dropdown-item" href="addUser.php">Add User</a>
							  <a class="dropdown-item" href="createMovie.php">Create Movies</a>
							  <a class="dropdown-item" href="createRoom.php">Create Rooms</a>
							  <a class="dropdown-item" href="createSchedule.php">Create Schedules</a>
							  <a class="dropdown-item" href="schedules.php">Schedules</a>
							  <a class="dropdown-item" href="bookings.php">Bookings</a>
							</div>
						  </li>
							<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								History
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
								<a class="dropdown-item" href="completedBookings.php">Completed Bookings</a>
								<a class="dropdown-item" href="completedSchedules.php">Completed Schedules</a>
								<a class="dropdown-item" href="canceledBookings.php">Canceled Bookings</a>
								<a class="dropdown-item" href="canceledSchedules.php">Canceled Schedules</a>
							</div>
							</li>';
                    }
                }
                ?>
            </ul>

            <?php
            if (isset($_SESSION['userId'])) {
                echo '<span style="font-weight: bold; color: #ffffff; font-family: Lato, sans-serif">' . $_SESSION['userRole'] . ' | ' . $_SESSION['name'] . '</span> &nbsp; &nbsp;
					<form class="form-inline my-2 my-lg-0" action="includes/logout.inc.php" method="post">
							<button class="button1" type="submit">Log out</button>
							</form>';
            } else {
                echo '<form class="form-inline my-2 my-lg-0" action="classes/login.class.php" method="post">
							<input class="form-control mr-sm-2" id="boxInput" type="text" placeholder="Username" name="Lusername" required>
							<input class="form-control mr-sm-2" id="boxInput" type="password" placeholder="Password" name="Lpassword" required>
							<button class="button1" type="submit" name="login-submit">Log in</button> 
							</form> 
							
							<!-- Button trigger modal -->
							<button class="button1" type="submit" data-toggle="modal" data-target="#exampleModal">Sign up</button>';
            }
            ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #1f1f1f; color: white;">
                            <h5 class="modal-title" id="exampleModalLabel">Sign up Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    style="color: white;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background-color: #1f1f1f;
								color: white;">
                            <!-- Sign in Forum -->
                            <form action="classes/signup.class.php" method="post" id="signup-form">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputFullname">First Name</label>
                                        <input type="text" class="form-control" id="inputFullname" name="firstname"
                                               required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputFullname">Last Name</label>
                                        <input type="text" class="form-control" id="inputFullname" name="lastname"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" name="email" required>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputUsername">Username</label>
                                        <input type="text" class="form-control" id="inputUsername" name="username"
                                               required>
                                    </div>
                                    <script>
                                        //Check if the repeated password is the same with the first password
                                        $(document).ready(function () {
                                            $('#inputPassword4, #inputRpassw').on('keyup', function () {
                                                if (!$('#inputRpassw').val() && !$('#inputPassword4')
                                                    .val()) { //check if the boxes are empty
                                                    $('#message').html('');
                                                    $('#inputPassword4').css('box-shadow', 'none');
                                                    $('#inputRpassw').css('box-shadow', 'none');
                                                } else if ($('#inputPassword4').val() == $(
                                                    '#inputRpassw')
                                                    .val()) { //check if they are the same
                                                    $('#message').html('Matching').css('color',
                                                        'green');
                                                    $('#inputPassword4').css('box-shadow',
                                                        '0px 0px 8px green');
                                                    $('#inputRpassw').css('box-shadow',
                                                        '0px 0px 8px green');
                                                } else if ($('#inputPassword4').val() != $(
                                                    '#inputRpassw')
                                                    .val()) { //check if they are not matching
                                                    $('#message').html('Not Matching').css('color',
                                                        'red');
                                                    $('#inputRpassw').css('box-shadow',
                                                        '0px 0px 8px red');
                                                    $('#inputPassword4').css('box-shadow',
                                                        '0px 0px 8px red');
                                                }
                                            });
                                        });
                                    </script>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Password</label>
                                        <input type="password" class="form-control" id="inputPassword4" name="password"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputRpassw">Repeat Password</label>
                                    <input type="password" class="form-control" id="inputRpassw" name="password2"
                                           required>
                                    <span id="message"></span>
                                </div>
                                <div class="form-group">
                                    <label for="inputPhone">Phone number</label>
                                    <input type="text" class="form-control" id="inputPhone" name="phonenumber" required>
                                </div>
                                <br>
                                <button name="signup-submit" type="submit" class="btn btn-secondary"
                                        style="background-color: #404040;">Sign up
                                </button>
                            </form>
                            <!-- End of Forum -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->
        </div>
    </nav>

</header>

<div class="container-xl">