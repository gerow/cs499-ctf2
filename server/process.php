<html>
<body>

<?php
$user = $_POST["user"];
$pass = $_POST["pass"];
$choice = $_POST["drop"];
$amount = $_POST["amount"];
$link = mysql_connect('localhost', 'root', 'rootmysql');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$db_selected = mysql_select_db('ctf2', $link);
if (!$db_selected) {
    die ('Can\'t use ctf2 : ' . mysql_error());
}
if ($choice == 'balance')
{
   $query="select * from transfers where user='$user'\n";
   $result=mysql_query($query);
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
   $query="insert into users (user, pass) values ('$user','$pass')";
   $result=mysql_query($query);
   print "Registered user $user\n";
}
else if ($choice == 'deposit')
{
   $query="insert into transfers (user, amount) values ('$user','$amount')";
   $result=mysql_query($query);
   print "Deposited $amount dollars\n";
}
else
{
   $query="insert into transfers (user, amount) values ('$user', -'$amount')";
   $result=mysql_query($query);
   print "Withdrawn $amount dollars\n";
}
mysql_close($link);
?>



</body>
</html>
