<?php
require "header.php";
?>

    <main>

        <script>
            // Function to get query parameter from URL
            function getQueryParam(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

            // Function to display dynamic alerts based on query parameters
            function displayAlerts() {
                const loginStatus = getQueryParam('login');
                const signupStatus = getQueryParam('signup');

                if (loginStatus === 'success') {
                    alert("Welcome to Cinema!");
                } else if (loginStatus === 'failed') {
                    alert("Wrong username or password!");
                } else if (loginStatus === 'notExists') {
                    alert("This user does not exist!");
                }

                if (signupStatus === 'success') {
                    alert("Sign up successfully, log in to our site!");
                } else if (signupStatus === 'failed') {
                    alert("Unknown error occurred!");
                } else if (signupStatus === 'userNameExists') {
                    alert("The username exists, please enter a different username!");
                } else if (signupStatus === 'emailExists') {
                    alert("The email exists, please enter a different email!");
                }
            }

            displayAlerts();
        </script>

        <div class="jumbotron" style="background-color: #0e0e0e; margin-top: -30px;">
            <div class="jumbotron" style="background-color: #0e0e0e; margin-top: -30px; margin-bottom: -40px;">
                <h1 class="title" style="text-align: center;">Scheduled Movies</h1>
            </div>

            <div class="container-xl">
                <div class="jumbotron" style="background-color: #0e0e0e; margin-bottom: -15px;">

                    <!-- Start cards -->
                    <div class="row row-cols-1 row-cols-md-3">

                        <?php

                        include "includes/createIndexMovieCards.inc.php";

                        ?>

                    </div>
                    <!-- End cards -->

                </div>

            </div>
        </div>

    </main>

<?php
require "footer.php";
?>