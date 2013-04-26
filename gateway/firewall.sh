ROUTER_ETH="eth1"
sudo iptables -F
sudo iptables -X
sudo iptables -A FORWARD -p tcp --dport 80 -m limit --limit 65/minute --limit-burst 100 -j ACCEPT
sudo iptables -A FORWARD -i $ROUTER_ETH -j DROP
sudo iptables -A INPUT -i $ROUTER_ETH -j DROP
