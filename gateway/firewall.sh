sudo iptables -F
sudo iptables -X
sudo iptables -A FORWARD -p tcp --dport 80 -m limit --limit 65/minute --limit-burst 100 -j ACCEPT
sudo iptables -A FORWARD -p tcp --sport 80 -j ACCEPT
sudo iptables -A INPUT -i eth1 -p tcp --dport 22 -m state --state NEW,ESTABLISHED -j ACCEPT
sudo iptables -A OUTPUT -o eth1 -p tcp --sport 22 -m state --state ESTABLISHED -j ACCEPT
sudo iptables -A INPUT -i lo -j ACCEPT
sudo iptables -A OUTPUT -o lo -j ACCEPT
