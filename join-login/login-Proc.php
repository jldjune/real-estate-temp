<?php

    session_start();

    // check if username & password combo entered into login form has ONE match in the members table of the database.
    require_once("../conn/connApts.php");

    // grab the form vars
    $user = $_POST['user']; // Joey1
    $pswd = $_POST['pswd']; // abc123 is NOT hashed

    // step 1: query the database for just the user
    $query = "SELECT * FROM members WHERE user='$user'";
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    // step 2: see if the user's loaded pswd matches the pswd entered into the form
    if(password_verify($pswd, $row['pswd'])) {
        // user is verified!
        
        // ##**## MAKE SESSION VARIABLES ##**## 
        $_SESSION['user'] = $row['user'];
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['IDmbr'] = $row['IDmbr'];
        $_SESSION['isAdmin'] = $row['isAdmin'];
		
        
        // login successful! Redirect immediately to profile.php
        header("Location:profile.php");

    } else { // login failed
        // intruder alert ! -- redirect to login page to try again
        echo '<h3 align="center">Login Failed! Try again! Redirecting!</h3>';
        header("Refresh:5; url='member-Join-Login.php?tryagain=yes'", true, 303);
    }

?>
