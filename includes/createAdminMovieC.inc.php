<?php

//connecting to database
global $conn;
include "includes/connectDB.inc.php";

$query = "SELECT * FROM movies";

$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);

if ($result->num_rows > 0) {

    foreach ($result as $row) {

        ?>

        <div class="card mb-3" style="max-width: 540px; margin-bottom: 20px; background-color: #181818">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <?php echo '<img src="data:image;base64,' . base64_encode($row['movieImage']) . '" class="card-img-bottom">'; ?>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title" style="color: #ffffff"><?php echo $row['movieName']; ?></h5>
                        <p class="card-text" style="color: #ffffff;"><?php echo $row['movieDescription']; ?></p>
                        <a href="createMovie.php?editMovie=<?php echo $row['movie_id']; ?>"
                           class="btn btn-info">Edit</a>
                        <a href="classes/movies.class.php?delete=<?php echo $row['movie_id']; ?>"
                           class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        </div>


        <?php
    }
} else {

    echo '<h3 style="color: white; text-align: center;">No movies</h3>';
}
