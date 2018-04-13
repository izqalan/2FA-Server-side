<?php 

	session_start();

	

	require_once 'PHPGangsta/GoogleAuthenticator.php';

	include 'connection.php';



	$ga = new Authenticator();

	$username = $_POST['username'];

	$_SESSION['UID'] = $username;


	// dont want to use session also can
	$query = "select authToken from users where username = '".$_SESSION['UID']."'";

	$result = mysqli_query($con, $query);



	$response = array();

    $response["success"] = false;

	// create secret key if user dont have one
	$row = mysqli_fetch_array($result, MYSQLI_BOTH);

    if ($row["authToken"] == null)
    {

    	$authToken = $ga->generateRandomSecret();

    	$query = "update users set authToken = '".$authToken."' where Username = '".$_SESSION["UID"]."'";

    	$result = mysqli_query($con, $query);

    	// $qrCodeUrl = $ga->getQR('Android demo', $authToken);
		// echo "<img src='$qrCodeUrl'><br><br>";
    	// $response["success"] = true;

   	}

   	

   	$query = "select authToken from users where username = '".$_SESSION['UID']."'";
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_array($result, MYSQLI_BOTH);

   	// dont make secret key 

	if ($row['authToken'] != null)
	{

		$result = mysqli_prepare($con, "SELECT username, authToken FROM users WHERE username = ?");

    	mysqli_stmt_bind_param($result, "s", $username);

   	 	mysqli_stmt_execute($result);

    
    	mysqli_stmt_store_result($result);

   	 	mysqli_stmt_bind_result($result, $username, $authToken);

   	 	   	 	// 

		while(mysqli_stmt_fetch($result))
		{
			$qrCodeUrl = $ga->getQR('Demo', $authToken);
		    $response["success"] = true;
		    $response["username"] = $username;
        	$response["authToken"] = $authToken;
        	$response["qrCodeUrl"] = $qrCodeUrl;

    	}

  		//echo "OK -- Your Secret Key  is {$row['auth']}";

   	}

   	echo json_encode($response);

	

?>

