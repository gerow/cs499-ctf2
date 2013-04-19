
import nfqueue
import cracker
import thread
#from scapy.all import IP, TCP,
import socket
import time
from dpkt import ip, tcp, hexdump, udp


""" Module that will lift messages off the network
for decryption
"""
"""
def crack():
	message = "HI"

print message
	try:
		thread.start_new_thread(cracker.monoAlphabeticCrack, (message,))
	except:
		print "W"
	while 1:
		pass
"""

count = 0
def log(dummy, payload):
	global count
	print "Got packet"
	data = payload.get_data()
	packet = ip.IP(data)
	tcp = packet.data
	
	payload.set_verdict(nfqueue.NF_ACCEPT)
	

if __name__ == "__main__":
	q = None

	q = nfqueue.queue()
	q.open()
	q.bind(socket.AF_INET)
	q.set_callback(log)
	q.create_queue(0)
	try:
		q.try_run()
	except KeyboardInterrupt:
		print "Exiting"
	finally:
		q.unbind(socket.AF_INET)
		q.close()
	q.unbind(socket.AF_INET)
	q.close()



