<?php
require_once './vendor/autoload.php';
use Twilio\Rest\Client;
$sid = "ACCOUNT_SID";
$token = "AUTH_TOKEN";
$serviceId = "SERVICE_SID";
$twilio = new Client($sid, $token);
$err_message = '';
$message = '';
// Change this to your connection info.
define('DBHOST', 'localhost'); //define your website host
define('DBUSER', 'root');//define your database username
define('DBPASS', '');//define your database password leave if no password is set
define('DBNAME', 'voice_otp');// database name
// Try and connect using the info above.
try {
	$pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
// If there is an error with the connection, stop the script and display the error.
	catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}
// Functions hides part of the user inputed number
function mask_no($number)
{
    return substr($number, 0, 4) . '************' . substr($number, -4);
}
?>
