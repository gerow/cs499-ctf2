#!/bin/sh

if [ -z "$1" ]
then
  echo "usage: $0 deterlab_username"
  exit 1
fi

mkdir ctf2_deploy
cp index_original.php ctf2_deploy/index.php
cp process_original.php ctf2_deploy/process.php
scp -r ctf2_deploy $1@users.deterlab.net:~/

ssh -t -t $1@users.deterlab.net "ssh server.CTF2Test.CISC499 \"sudo cp ~/ctf2_deploy/*.php /var/www; rm -r ~/ctf2_deploy\""

rm -r ctf2_deploy
