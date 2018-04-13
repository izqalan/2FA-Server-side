<?php 

	// need to post 6 digits code

	session_start();



	include 'connection.php';

	require_once 'PHPGangsta/GoogleAuthenticator.php';



	$ga = new Authenticator();


 
	$username = $_POST['username'];
	$_SESSION['UID'] = $username;

	$code = $_POST['code'];
	$response = array();

	// get secret key from database
	$statement = mysqli_prepare($con, "SELECT username, authToken FROM users WHERE username = ? ");

    mysqli_stmt_bind_param($statement, "s", $username);

    mysqli_stmt_execute($statement);

    

    mysqli_stmt_store_result($statement);

    mysqli_stmt_bind_result($statement, $username ,$authToken);

    


    $response = array();

    $response["success"] = false;

    

    

    while(mysqli_stmt_fetch($statement)){

        $response["success"] = true;  

        $response["username"] = $username;

        // $response["password"] = $password;

        $response['authToken'] = $authToken;

    }

    $checkResult = $ga->verifyCode($authToken,  $code, 2);

    if($checkResult){
    	echo json_encode($response);
    }
    else{
    	echo json_encode("error");
    }

	







?>

