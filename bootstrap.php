<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

if (!empty($_POST['user']) && !empty($_POST['password'])) {
	    require __DIR__ . '/config.php';
    	//var_dump($_POST);exit;
    	if ($params['user'] == $_POST['user'] && $params['password'] == sha1($_POST['password'])) {
    		$_SESSION['m5_admin_sid'] = true;
        //array_map('unlink', array_filter((array) glob(__DIR__ . '/_files/cache/images/*')));
    	} else {
    		echo '<span style="color:red"> Fail to log in!</span>';
    	}
}
//echo sha1('yMWqOD5ZdFQnJ123');//aea9953cbe97e81f695a84e2d643128953858339

//var_dump($_SESSION);

if (!isset($_SESSION['m5_admin_sid'])) {
    echo '<form style="border: 3px solid #f1f1f1;" action="' . $_SERVER["PHP_SELF"] . '?' .  $_SERVER["QUERY_STRING"] . '" method="post">
  <div class="container" style="padding: 16px;">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="user" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button style="background-color: #04AA6D; color: white; padding: 14px 20px; margin: 8px 0; border: none; cursor: pointer; width: 100%;" type="submit">Login</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
  </div>
</form><style>input[type=text], input[type=password] {  width: 100%;  padding: 12px 20px;  margin: 8px 0;  display: inline-block;  border: 1px solid #ccc;  box-sizing: border-box;}button:hover { opacity: 0.8;}</style>';
die();
} else {
	/*
	require __DIR__ . '/../config/local.php';

	try {
	  $conn = new PDO('mysql:dbname='. $parameters['db_name'] . ';host=' . $parameters['db_host'], $parameters['db_user'], $parameters['db_password']);
	} catch(PDOException $e) {
	  echo "Connection failed: " . $e->getMessage(); die();
	}
	*/

}