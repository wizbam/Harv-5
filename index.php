<?php
 
set_time_limit(0);
 
$socket = fsockopen("irc.freenode.net", 6667);

$steamid = array( "Harv-5" => "Wizbam" );
 
fputs($socket,"USER Harv-5 arcanetheory.net Harv-5 : Harv-5\n");
fputs($socket,"NICK Harv-5\n");
 
fputs($socket,"JOIN #digitalgames\n");
 
while(1) {
 
	while($data = fgets($socket, 128)) {
 
		echo nl2br($data);
		flush();
 
		$ex = explode(' ', $data);
 
		if($ex[0] == "PING"){
			fputs($socket, "PONG ".$ex[1]."\n");
		}
 
		$command = str_replace(array(chr(10), chr(13)), '', $ex[3]);
		$command2 = str_replace(array(chr(10)), '', $ex[3]);
		if ($command == ":!report") {
			fputs($socket, "PRIVMSG ".$ex[2]." :Harv-5 Reporting for duty!\n");
		}
		if ($command == ":!turntable") {
			fputs($socket, "PRIVMSG ".$ex[2]." :TurnTable.fm: http://goo.gl/t0ck8 \n");
		}
		
		$read = file_get_contents('http://dl.dropbox.com/u/10458699/ign.txt');
		
		if ($command == ":!read") {
			fputs($socket, "PRIVMSG ".$ex[2]." $read \n");
		}
		
		if ($command == ":!steam") {
			fputs($socket, "PRIVMSG ".$ex[2]." :I can't...exactly do that yet.\n");
		}
		
		if ($command2 == ":!link") {
			fputs($socket, "PRIVMSG ".$ex[2]." :Welllll, sorry folks. Still workin' on that function.\n");
		}
		
		if ($command2 == ":!steam") {
			fputs($socket, "PRIVMSG ".$ex[2]." :Yeeeaah. I'm not ready to do that one yet.\n");
		}
 
	}
 
}
 
?>