<html>
<body>

<?php

$user = $_GET["user"];
$pass = $_GET["pass"];
$choice = $_GET["drop"];
$amount = $_GET["amount"];

$link = mysql_connect('localhost', 'root', 'rootmysql');
if (!$link) 
   {
   die('Could not connect: ' . mysql_error());
   }
   $db_selected = mysql_select_db('ctf2', $link);
   if (!$db_selected) 
   {
   die ('Can\'t use ctf2 : ' . mysql_error());
   }
   if ($choice == 'register')
   {
   $query = "insert into users (user,pass) values ('$user', '$pass')";
   $result = mysql_query($query);
   }
   else if ($choice == 'balance')
   {
   $query = "select * from transfers where user='$user'";
   $result = mysql_query($query);
   $sum = 0;
   print "<H1>Balance and transfer history</H1><P>";
   print "<table border=1><tr><th>Action</th><th>Amount</th></tr>";
   while ($row = mysql_fetch_assoc($result))
   {
   $amount = $row['amount'];
   if ($amount < 0)
   {
       $action = "Withdrawal";
   }
   else
   {
       $action = "Deposit";
   }
   print "<tr><td>" . $action . "</td><td>" . $amount . "</td></tr>";
   $sum += $amount;
   }
   print "<tr><td>Total</td><td>" . $sum . "</td></tr></table>";
   }
   else if ($choice == 'deposit')
   {
   $query = "insert into transfers (user,amount) values ('$user', '$amount')";
   $result = mysql_query($query);
   }
   else
   {
   $query = "insert into transfers (user,amount) values ('$user', -'$amount')";
   $result = mysql_query($query);
   }


?>

</body>
</html>
