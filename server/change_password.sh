#!/bin/sh
user="root"
db="ctf2"
host="localhost"
mysql -uroot -p -e"
 use ctf2;
 UPDATE users SET pass='3X4T5V6789asd' WHERE pass='abcdef';
"
