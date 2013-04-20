<html>
<body>

<?php
$user = $_GET["user"];
$pass = $_GET["pass"];
$choice = $_GET["drop"];
$amount = $_GET["amount"];
$link = mysql_connect('localhost', 'root', 'rootmysql');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
if (!isset($choice))
{
	die('Choice not set');
}
$db_selected = mysql_select_db('ctf2', $link);
if (!$db_selected) {
    die ('Can\'t use ctf2 : ' . mysql_error());
}
if ($choice == 'balance')
{
   $query=sprintf("select * from users where user='%s' and pass='%s'",mysql_real_escape_string($user),mysql_real_escape_string($pass));
   $result=mysql_query($query);
   if(mysql_num_rows($result) == 0){
	die('incorrect user / password combo');
   }  
   $query=sprintf("select * from transfers where user='%s'\n", mysql_real_escape_string($user));
   $result=mysql_query($query);
   if(!$result){
		die('Invalid query: ' . mysql_error());
	}
	$sum = 0;
   print "<TABLE BORDER=1><TH>User</TH><TH>Amount</TH>\n";
   while ( $db_field = mysql_fetch_assoc($result) ) {
   print "<TR>";
   print "<TD>" .$db_field['user'] . "</TD><TD>";
   print $db_field['amount'] . "</TD></TR>\n";
   $sum += $db_field['amount'];
   }
   print "<TR><TD>Total</TD><TD>$sum</TD></TR>\n";
   print "<TABLE>";
}
else if ($choice == 'register')
{
	if(!isset($user) || !isset($pass)){
		die('User or password not set');
	}
   $query=sprintf("insert into users (user, pass) values ('%s','%s')"
		, mysql_real_escape_string($user), mysql_real_escape_string($pass));
   $result=mysql_query($query);
   if(!$result){
      die('Failed to register user');
   }
   else print "Registered user $user\n";
}
else if ($choice == 'deposit')
{
	if(!isset($amount) || $amount <= 0){
		die('Improper amount');		
	}

   $query=sprintf("insert into transfers (user, amount) values ('%s','%s')", mysql_real_escape_string($user), mysql_real_escape_string($amount));
   $result=mysql_query($query);
   print "Deposited $amount dollars\n";
}
else if($choice == 'withdraw')
{
   if(!isset($amount) || $amount <= 0){
		die('Improper amount');
   }
   $query=sprintf("select * from users where user='%s' and pass='%s'",mysql_real_escape_string($user),mysql_real_escape_string($pass));
   $result=mysql_query($query);
   if(mysql_num_rows($result) == 0){
	die('incorrect user / password combo');
   }  
   $query=sprintf("insert into transfers (user, amount) values ('%s', -'%s')",mysql_real_escape_string($user),mysql_real_escape_string($amount));
   $result=mysql_query($query);
   print "Withdrawn $amount dollars\n";
}
mysql_close($link);
?>



</body>
</html>
