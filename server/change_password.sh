#!/bin/sh
user="root"
pass="rootmysql"
db="users"
host="localhost"
mysql -u "$user" -p "$pass" -h $host -D $db -e "UPDATE 'users' SET 'pass'='3X4T5V6789asd' WHERE pass='abcdef'" | while read pass; do
	echo "changing password:"
done
	