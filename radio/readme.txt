System requirements

1. Install Ices-0.4
2. Install Icecast
3. python
4. mysql


1. Create new channel 
	To create new channel run script
	createchannel.php 
	args 
	1. channel name
	2. etc..
	3. channel Id, should be present in database.
	Will pull programs from db using the channel ID

2. stop channel.
	args
	channel id.
	will stop currently playing channel

3. start channel
	args
	channel id.
	will start or restart existing channel