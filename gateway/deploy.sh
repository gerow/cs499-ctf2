#!/bin/sh

if [ -z "$1" ]
then
  echo "usage: $0 deterlab_username"
  exit 1
fi

mkdir ctf2_deploy
cp firewall.sh ctf2_deploy
scp -r ctf2_deploy $1@users.deterlab.net:~/

ssh -t -t $1@users.deterlab.net "ssh gateway.CTF2Test.CISC499 \"sudo cp ~/ctf2_deploy/* ~/; rm -r ~/ctf2_deploy\""

rm -r ctf2_deploy
