<html>
<body>

<?php
include_once "api.php";

$dbname = 'ctf2';
$host = 'localhost';
$username = 'root';
$password = '98j20jf8(#J*(j893jrijio32jf982j*#(*(J28jf2';

$user = $_POST["user"];
$pass = $_POST["pass"];
$choice = $_POST["drop"];
$amount = $_POST["amount"];

# TODO: Input validation, XSRF?

$link = NULL;
try {
  $link = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('Could not connect: ' . $e->getMessage());
}

$hashed_pass = hashed_password($user, $pass);
if (is_valid_credentials($link, $user, $hashed_pass)) {
  if ($choice == 'balance') {
    do_balance($link, $user);
  } else if ($choice == 'register') {
    do_register($link, $user, $hashed_pass);
  } else if ($choice == 'deposit') {
    do_deposit($link, $user, $amount);
  } else if ($choice == 'withdraw') {
    do_withdraw($link, $user, $amount);
  }
} else {
  print "Invalid credentials";
}
?>

</body>
</html>
