<?php
    $con = mysqli_connect("localhost", "id3219967_root", "123456", "id3219967_twofa");
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $statement = mysqli_prepare($con, "INSERT INTO users (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($statement, "ss", $username, $password);
    mysqli_stmt_execute($statement);
    
    $response = array();
    $response["success"] = true;  
    
    echo json_encode($response);
?>