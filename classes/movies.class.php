<?php

class Movie
{
    private $movie_id;
    private $movieName;
    private $movieDescription;
    private $movieImage;

    function __construct($movie_id, $movieName, $movieDescription, $movieImage)
    {
        $this->movie_id = $movie_id;
        $this->movieName = $movieName;
        $this->movieDescription = $movieDescription;
        $this->movieImage = $movieImage;
    }

    public function addMovie()
    {

        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "INSERT INTO movies 
                  VALUES (NULL, '$this->movieName', '$this->movieImage', '$this->movieDescription')";

        if ($conn->query($query)) {
            header("Location: ../createMovie.php?movieCreated=success");
            exit();
        } else {
            header("Location: ../createMovie.php?movieCreated=failed");
            exit();
        }
    }

    public function deleteMovie()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "DELETE FROM movies WHERE movie_id = $this->movie_id ";

        if ($conn->query($query) == true) {
            header("Location: ../createMovie.php?movieDeleted=success");
            exit();
        } else {
            header("Location: ../createMovie.php?movieDeleted=failed");
            exit();
        }
    }

    public function editMovie()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $query = "UPDATE movies
                    SET movieName = '$this->movieName',
                        movieDescription = '$this->movieDescription',
                        movieImage = '$this->movieImage'
                    WHERE movie_id = $this->movie_id
                    ";

        if ($conn->query($query) == true) {
            header("Location: ../createMovie.php?movieEdited=success");
            exit();
        } else {
            header("Location: ../createMovie.php?movieEdited=failed");
            exit();
        }
    }
}

if (isset($_POST['submit-movieCr'])) {

    $image = addslashes(file_get_contents($_FILES['movieImage']['tmp_name']));

    $newMovie = new Movie(null, $_POST['movieName'], $_POST['movieDescription'], $image);

    $newMovie->addMovie();
}

if (isset($_GET['delete'])) {

    $deleteMovie = new Movie($_GET['delete'], null, null, null);

    $deleteMovie->deleteMovie();
}

if (isset($_POST['submit-movieUP'])) {

    $image = addslashes(file_get_contents($_FILES['movieImage']['tmp_name']));

    $updateMovie = new Movie($_POST['movie_idH'], $_POST['movieName'], $_POST['movieDescription'], $image);

    $updateMovie->editMovie();
}
