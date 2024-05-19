<?php

class UserSignup
{

    private $firstName;
    private $lastName;
    private $email;
    private $username;
    private $password;
    private $phoneNumber;
    private $userRole;

    function __construct($firstName, $lastName, $email, $username, $password, $phoneNumber, $userRole)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;
        $this->userRole = $userRole;
    }

    public function insert_new_user()
    {
        global $conn;
        include "../includes/connectDB.inc.php";

        $firstname = mysqli_real_escape_string($conn, $this->firstName);
        $lastname = mysqli_real_escape_string($conn, $this->lastName);
        $email = mysqli_real_escape_string($conn, $this->email);
        $username = mysqli_real_escape_string($conn, $this->username);
        $password = mysqli_real_escape_string($conn, $this->password);
        $phone = mysqli_real_escape_string($conn, $this->phoneNumber);

        $query1 = "SELECT userName, userEmail FROM users";

        $result1 = $conn->query($query1);
        $row1 = mysqli_fetch_assoc($result1);

        if ($result1->num_rows > 0) {

            foreach ($result1 as $row1) {

                if ($username == $row1['userName']) {
                    header("Location: ../index.php?signup=userNameExists");
                    exit;
                } else if ($email == $row1['userEmail']) {
                    header("Location: ../index.php?signup=emailExists");
                    exit;
                }
            }


            $hashedPassw = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (userFirstName, userLastName, userEmail, userName, userPassw, userPhone) 
			VALUES ('$firstname', '$lastname', '$email', '$username', '$hashedPassw', '$phone')";

            if ($conn->query($query) == true) {
                header("Location: ../index.php?signup=succes");
                exit();
            } else {
                header("Location: ../index.php?signup=failed");
                exit();
            }
        }
    }

    public function insert_new_user_admin()
    {

        global $conn;
        include "../includes/connectDB.inc.php";

        $query1 = "SELECT userName, userEmail FROM users";

        $result1 = $conn->query($query1);
        $row1 = mysqli_fetch_assoc($result1);

        if ($result1->num_rows > 0) {

            foreach ($result1 as $row1) {
                if ($this->username == $row1['userName']) {
                    header("Location: ../index.php?signup=userNameExists");
                    exit;
                } else if ($this->email == $row1['userEmail']) {
                    header("Location: ../index.php?signup=emailExists");
                    exit;
                }
            }

            $hashedPassw = password_hash($this->password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (userFirstName, userLastName, userEmail, userName, userPassw, userPhone, role) 
		VALUES ('$this->firstName', '$this->lastName', '$this->email', '$this->username', '$hashedPassw', '$this->phoneNumber', '$this->userRole')";

            if ($conn->query($query) == true) {
                header("Location: ../addUser.php?userAdded=succes");
                exit();
            } else {
                header("Location: ../addUser.php?userAdded=failed");
                exit();
            }
        }
    }
}

if (isset($_POST['signup-submit'])) {
    $newUser = new UserSignup($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['phonenumber'], null);

    $newUser->insert_new_user();
}
