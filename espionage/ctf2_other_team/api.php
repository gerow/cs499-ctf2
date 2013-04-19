<?php

$SALT_PREFIX = "#*@R874jj12mS(*#J@#(J(*MGk9jfoij2#*(Jjf2983#*(J";

function hashed_password($username, $password) {
  //return crypt($password, "$2a$07$" . $SALT_PREFIX . $username . "$");
  return crypt($password, '$2y$07$' . $SALT_PREFIX . $username . '$');
}

function is_alphanumeric($string) {
  return ctype_alnum($string);
}

function is_valid_credentials($link, $user, $hashed_pass) {
  try {
    $st = $link->prepare('select * from users where user=:user');
    $st->bindParam(':user', $user);
    $st->execute();
    $row = $st->fetch();
    return $row != NULL && $row['pass'] == $hashed_pass;
  } catch (PDOException $e) {
    print $e->getMessage();
    return false;
  }
}

function do_balance($link, $user) {
  try {
    $st = $link->prepare('select * from transfers where user=:user');
    $st->bindParam(':user', $user);
    $st->execute();

    $sum = 0;
    print "<TABLE BORDER=1>";
    print "<TH>User</TH><TH>Amount</TH>\n";
    while ($db_field = $st->fetch()) {
      $db_user = $db_field['user'];
      $db_amount = $db_field['amount'];
      print "<TR><TD>$db_user</TD><TD>$db_amount</TD></TR>";
      $sum += $db_amount;
    }
    print "<TR><TD>Total</TD><TD>$sum</TD></TR>\n";
    print "</TABLE>";
  } catch (PDOException $e) {
    print $e->getMessage();
  }
}

function do_register($link, $user, $hashed_pass) {
  try {
    $st = $link->prepare('insert into users (user, pass) values (:user, :pass)');
    $st->bindParam(':user', $user);
    $st->bindParam(':pass', $hashed_pass);
    $st->execute();
    print "Registered user $user\n";
  } catch (PDOException $e) {
    print "Could not register user=$user pass=$pass";
    print $e->getMessage();
  }
}

function do_deposit($link, $user, $amount) {
  if ($amount <= 0) {
    print "ERROR: Cannot deposit negative amounts";
  } else {
    try {
      $st = $link->prepare('insert into transfers (user, amount) values (:user, :amount)');
      $st->bindParam(':user', $user);
      $st->bindParam(':amount', $amount);
      $st->execute();
      print "Deposited $amount dollars\n";
    } catch (PDOException $e) {
      print "Could not deposit user=$user amount=$amount";
      print $e->getMessage();
    }
  }
}

function do_withdraw($link, $user, $amount) {
  if ($amount <= 0) {
    print "ERROR: Cannot withdraw negative amounts";
  } else {
    try {
      $st = $link->prepare('insert into transfers (user, amount) values (:user, :amount)');
      $st->bindParam(':user', $user);
      $st->bindParam(':amount', -$amount);
      $st->execute();
      print "Withdrawn $amount dollars\n";
    } catch (PDOException $e) {
      print "Could not withdraw user=$user amount=$amount";
      print $e->getMessage();
    }
  }
}
?>


