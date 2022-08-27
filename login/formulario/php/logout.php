<?php
        include('control.php');
        include('connection.php');

        $username = $_SESSION['username'];
        $psw = $_SESSION['password'];

        $stmt = "UPDATE customer SET active = '0' WHERE username = '$username' AND psw = '$psw'";
        mysqli_query($con, $stmt) or die(mysqli_error($con));
        mysqli_close($con);
        session_destroy();
        echo true;
?>