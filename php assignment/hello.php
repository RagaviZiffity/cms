<?php
    $servername = "localhost";
    $username = "root";
    $password = "Admin@123";

    //create connection
    $conn = new mysqli($servername, $username, $password);

    // check connection
    if($conn->connect_error){
        die("Connection failed: {$conn->connect_error}");
    }
    else{
        echo "connected successfuly";
    }

    $sql = "drop DATABASE PHP";
    if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
    } else {
    echo "Error creating database: " . $conn->error;
    }
?>