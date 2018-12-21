<?php
include ("function.php");
include ("settings.php");
$token=$settings['token'];

$input2 = file_get_contents('php://input');
$mail=print_r($input2, true);
$input = json_decode($input2, true);

$sender=$input['message']['chat']['id'];
$postback=$input['callback_query']['data'];
if($postback!=NULL)
{
	$sender=$input['callback_query']['from']['id'];
}
$message=$input['message']['text'];
$url = 'https://api.telegram.org/bot'.$token.'/sendMessage?parse_mode=html';

$query=$conn->prepare('SELECT CURRENT_DATE');
$query->execute();
$query->store_result();
if($query->num_rows === 0) exit;
$query->bind_result($time_sql); 
while($query->fetch()) {
$date=$time_sql;
}
	$query= $conn->prepare("Select * FROM seed_story WHERE date=STR_TO_DATE(?, '%Y-%m-%d')");
            $query->bind_param("s", $date);
            $query->execute();
			$query->store_result();
	if($query->num_rows == 0){
	$ServerSeed=generateRandomString(64);
	$PublicSeed=rand(100000000000, 999999999999);
		$query= $conn->prepare("INSERT INTO `seed_story` (`id`, `ServerSeed`, `PublicSeed`, `date`) VALUES ('', ?, ?, CURRENT_DATE);");
            $query->bind_param("si", $ServerSeed, $PublicSeed );
            $query->execute();
			$query= $conn->prepare("UPDATE `general_info` SET `value` = '1' WHERE `id` = 2;");
$query->execute();
	}

$query= $conn->prepare('Select * FROM users WHERE user_id=?');
            $query->bind_param("i",$zmienna11);
			$zmienna11=$sender;
            $query->execute();
			$query->store_result();

			$query->fetch();
			if($query->num_rows == 0){
	$reply7=1;
	if($input['message']['chat']['last_name']==NULL)
	{
		$input['message']['chat']['last_name']=$input['message']['chat']['first_name'];
	}
			$query= $conn->prepare("INSERT INTO `users` (`id`, `nick`, `funds`, `profile_pc`, `profile_mobile`, `name`, `surname`, `language`, `user_id`, `rank`) VALUES ('', ?, 0, '', '', ?, ?, ?, ?, 1);");
           $query->bind_param("ssssi", $input['message']['chat']['username'], $input['message']['chat']['first_name'], $input['message']['chat']['last_name'], $input['message']['from']['language_code'], $sender);
            $query->execute();
}
else
{
	$reply7=0;
}


if($sender==$settings['admin'])
{
	$komenda=explode(" ", $message);
	
	if($komenda[0]=="/update")
	{
								$query= $conn->prepare('Select value FROM general_info WHERE name="CoinValue"');

            $query->execute();
			$query->store_result();
			$query->bind_result($value);
			$query->fetch();

		

		if($komenda[1]=="up")
		{
					$change=1+(intval($komenda[2])/100);

			
		}else if($komenda[1]=="down")
		{
					$change=1-(intval($komenda[2])/100);

		}else
		{
		exit();
		}
					$koniec=przelicznik(round(intval(przelicznik_back($value))*$change));
					
											$jsonData='{
  "text": "New values is '.$koniec.' now",
"chat_id": '.$sender.',


}';
			$query= $conn->prepare("INSERT INTO `ValueChange` (`id`, `ChangeValue`, `date`) VALUES ('', ?, CURRENT_TIMESTAMP);");
            $query->bind_param("s", $change);
            $query->execute();
$query= $conn->prepare("UPDATE `general_info` SET `value` = ? WHERE name='CoinValue'");
            $query->bind_param("s",  $koniec);
            $query->execute();
curl($jsonData, $url);
exit();	
	}
	
		if($komenda[0]=="/deposit")
		{
			if($komenda[1]!="all")
			{
						$query= $conn->prepare('Select * FROM await_deposit WHERE token=?');
            $query->bind_param("s",$komenda[1]);
            $query->execute();
			$query->store_result();
			$query->bind_result($id, $user_id, $amount, $token);
			$query->fetch();
if($query->num_rows()==0)
{
							$jsonData='{
  "text": "Error: code not found",
"chat_id": '.$sender.',


}';
curl($jsonData, $url);
exit();
}	
			
			$query= $conn->prepare('Select funds FROM users WHERE user_id=?');
            $query->bind_param("i",$user_id);
            $query->execute();
			$query->store_result();
			$query->bind_result($funds);
			$query->fetch();
$funds=$funds+$amount;
		
		$query= $conn->prepare("UPDATE `users` SET `funds` = ?  WHERE user_id=?;");
            $query->bind_param("ii", $funds, $user_id);
            $query->execute();

									$query= $conn->prepare('DELETE FROM await_deposit WHERE token=?');
            $query->bind_param("s",$komenda[1]);
            $query->execute();
			
						$jsonData='{
  "text": "Done",
"chat_id": '.$sender.',


}';
curl($jsonData, $url);
exit();
			}
			else
			{
										$query= $conn->prepare('SELECT `amount`, `token`, `profile_pc`, `profile_mobile`  FROM await_deposit INNER JOIN users ON await_deposit.user_id=users.user_id');
            $query->execute();
			$query->store_result();
			$query->bind_result($amount, $token, $profile_pc, $profile_mobile);
		while($query->fetch()) 
			{
										$jsonData='{
  "text": "Amount: '.$amount.',
  Token: '.$token.',
  Link: <a href=\''.$profile_mobile.'\'>[Mobile]</a>, <a href=\''.$profile_pc.'\'>[PC]</a>
  -----------------------------------------------------",
"chat_id": '.$sender.',


}';
curl($jsonData, $url);
			}

			}

		}
				if($komenda[0]=="/withdraw")
		{
			if($komenda[1]!="all")
			{
						
if($query->num_rows()==0)
{
							$jsonData='{
  "text": "Error: code not found",
"chat_id": '.$sender.',


}';
curl($jsonData, $url);
exit();
}								$query= $conn->prepare('DELETE FROM await_withdraw WHERE code=?');
            $query->execute();
			
						$jsonData='{
  "text": "Done",
"chat_id": '.$sender.',


}';
curl($jsonData, $url);
exit();

		}
		else
			{
										$query= $conn->prepare('SELECT `amount`, `code`, `profile_pc`, `profile_mobile`  FROM await_withdraw INNER JOIN users ON await_withdraw.user_id=users.user_id');
            $query->execute();
			$query->store_result();
			$query->bind_result($amount, $code, $profile_pc, $profile_mobile);
		while($query->fetch()) 
			{
										$jsonData='{
  "text": "Amount: '.$amount.',
  Token: '.$code.',
  Link:  Link: <a href=\''.$profile_mobile.'\'>[Mobile]</a>, <a href=\''.$profile_pc.'\'>[PC]</a>
  -----------------------------------------------------",
"chat_id": '.$sender.',


}';
curl($jsonData, $url);
			}

			}
		}
	
}


if($reply7==0){
	$query= $conn->prepare('Select rank FROM users WHERE user_id=?');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($rank);
			$query->fetch();
			
}

if($message=="/start" & $reply7==1)
{		
$jsonData='{
  "text": "👋 Hi,to complete register process please send me an link to your profile. It is needed for deposit/withdraw function. Remember about http/s prefix.",
"chat_id": '.$sender.',


}';
curl($jsonData, $url);
exit();
}

if($rank==1)
{

$link=hyperlink($message);
if($link=="false")
{
			$jsonData='{
  "text": "⚠️ It is not correct RR profile link, try again",
"chat_id": '.$sender.',

}';

curl($jsonData, $url);
}
else{
	$link=converter($message);
		$jsonData='{
  "text": "Profile link set",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["💲 Coin value"],
	["💎 Flip Coin"],
	[" 🏧 Deposit","💰 Withdraw"]],
	"one_time_keyboard":true
	}

}';
$query= $conn->prepare("UPDATE `users` SET `rank` = '2', `profile_pc`=?, `profile_mobile`=? WHERE `users`.`user_id` = ?;");
            $query->bind_param("ssi",  $link['pc'], $link['mobile'], $sender);
            $query->execute();
curl($jsonData, $url);
}
exit();
}

if($message=="💲 Coin value" and $rank==2)
{
		$query= $conn->prepare('Select funds FROM users WHERE user_id=?');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($funds);
			$query->fetch();
					$query= $conn->prepare('Select value FROM general_info WHERE name="CoinValue"');
            $query->execute();
			$query->store_result();
			$query->bind_result($value);
			$query->fetch();
			$jsonData='{
  "text": "💳 Currently you have: '.$funds.' coins.
With course: '.$value.' each",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["💲 Coin value"],
	["💎 Flip Coin"],
	[" 🏧 Deposit","💰 Withdraw"]],
	"one_time_keyboard":true
	}

}';
curl($jsonData, $url);

exit();
}

if($message=="🏧 Deposit" and $rank==2)
{	
							$query= $conn->prepare('Select value FROM general_info WHERE name="CoinValue"');
            $query->execute();
			$query->store_result();
			$query->bind_result($value);
			$query->fetch();
$jsonData='{
  "text": "💵How many coins do you want to buy? (1 token = '.$value.')",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["❌Cancel"]],
	"one_time_keyboard":true
	}

}';
$query= $conn->prepare("UPDATE `users` SET `rank` = '3' WHERE `users`.`user_id` = ?;");
            $query->bind_param("i", $sender);
            $query->execute();
			curl($jsonData, $url);
			exit();
}

if($message=="💎 Flip Coin" and $rank==2)
{
			$query= $conn->prepare("DELETE FROM `FlipCoin` WHERE sender_id=? AND Side IS NULL");
            $query->bind_param("i", $sender);
            $query->execute();
	$jsonData='{
  "text": "How many tokens do you want to bet?",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["❌Cancel"]],
	"one_time_keyboard":true
	}

}';
$query= $conn->prepare("UPDATE `users` SET `rank` = '30' WHERE `users`.`user_id` = ?;");
            $query->bind_param("i", $sender);
            $query->execute();
			curl($jsonData, $url);
			exit();
}
if($rank==33 & $message!=="❌Cancel")
{
	if($message=="Head" or $message=="Tail")
	{
		sleep(1);
	$query= $conn->prepare("INSERT INTO `anti_log` (`id`, `message_id`, `date`, `sender_id`) VALUES ('', ?, ?, ?);");
           $query->bind_param("iii", $input['update_id'], $input['message']['date'], $sender);
            $query->execute();
		//	$query->close();
								$query= $conn->prepare('Select * FROM anti_log WHERE date=? and sender_id=?');
			            $query->bind_param("ii", $input['message']['date'], $sender);
            $query->execute();
						$query->store_result();

			$query->fetch();
						if($query->num_rows>=2)
						{
							$test=1;
						}
sleep(1);
								$query= $conn->prepare('Select * FROM anti_log WHERE date=? and sender_id=?');
			            $query->bind_param("ii", $input['message']['date'], $sender);
            $query->execute();
						$query->store_result();

			$query->fetch();
						if($query->num_rows>=2)
						{
							$test=1;
						}
						if($test==1)
						{
				$jsonData='{
  "text": "⚠️  Error: Pick right side",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["Head"],
	["Tail"],
	["❌Cancel"]],
	"one_time_keyboard":true
	}

}';
									$query= $conn->prepare('DELETE FROM anti_log WHERE date=? and sender_id=?');
			            $query->bind_param("ii", $input['message']['date'], $sender);
            $query->execute();
	curl($jsonData, $url);
		exit;
			}

					$query= $conn->prepare('Select value AS Bet FROM FlipCoin WHERE sender_id=? AND Side IS NULL');
			            $query->bind_param("i", $sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($Bet);
			$query->fetch();
			if($query->num_rows==0)
			{
				exit;
			}
		$query= $conn->prepare('Select ServerSeed, PublicSeed FROM seed_story WHERE date=CURRENT_DATE');
            $query->execute();
			$query->store_result();
			$query->bind_result($ServerSeed, $PublicSeed);
			$query->fetch();
			
					$query= $conn->prepare('Select value FROM general_info WHERE id=2');
            $query->execute();
			$query->store_result();
			$query->bind_result($value);
			$query->fetch();

			if($message==FlipCoin($ServerSeed, $PublicSeed, $value))
			{ $wynik=$Bet*2;
		$result="won".$value;
//
								$jsonData='{
  "text": "You won +'.$wynik.' coins",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["💲 Coin value"],
	["💎 Flip Coin"],
	[" 🏧 Deposit","💰 Withdraw"]],
	"one_time_keyboard":true
	}

}';
$query= $conn->prepare('Select funds FROM users WHERE user_id=?');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($funds);
			$query->fetch();
$funds=$funds+$wynik;
		
		$query= $conn->prepare("UPDATE `users` SET `funds` = ?  WHERE user_id=?;");
            $query->bind_param("ii", $funds, $sender);
            $query->execute();	
			}
			else
			{ $wynik="-".$Bet;
						$result="lost".$value;
												$jsonData='{
  "text": "You lost '.$wynik.' coins",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["💲 Coin value"],
	["💎 Flip Coin"],
	[" 🏧 Deposit","💰 Withdraw"]],
	"one_time_keyboard":true
	}

}';
			}
												$query= $conn->prepare('DELETE FROM anti_log WHERE date=? and sender_id=?');
			            $query->bind_param("ii", $input['message']['date'], $sender);
            $query->execute();
						$query= $conn->prepare("UPDATE `FlipCoin` SET `Side`=?, `value` = ?, `result`=?, `Ch`=? WHERE `sender_id` = ? AND Side IS NULL;");
            $query->bind_param("sssss", $message, $Bet, $result, $wynik, $sender);
            $query->execute();
			$value=$value+1;
			$query= $conn->prepare("UPDATE `users` SET `rank` = '2' WHERE `users`.`user_id` = ?;");
            $query->bind_param("i", $sender);
            $query->execute();
			$query= $conn->prepare("UPDATE `general_info` SET `value` = ? WHERE id=2;");
            $query->bind_param("s", $value);
            $query->execute();
	}
	else
	{
				$jsonData='{
  "text": "⚠️  Error: Pick right side",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["Head"],
	["Tail"],
	["❌Cancel"]],
	"one_time_keyboard":true
	}

}';
	}
	curl($jsonData, $url);
		exit;
}
if($rank==30 & $message!=="❌Cancel")
{
	$message=intval($message);
	if($message<0)
	{
		$message=$message*(-1);
	}
	$query= $conn->prepare('Select funds FROM users WHERE user_id=?');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($token);
			$query->fetch();
			if($message>$token)
			{
				$jsonData='{
  "text": "⚠️  Error: not enough funds, try smaller amount",
"chat_id": '.$sender.',

}'; $kontrol=1;
			}
if($message!=NULL & $kontrol!=1 )
{

		$jsonData='{
  "text": "Choose a side:",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["Head"],
	["Tail"],
	["❌Cancel"]],
	"one_time_keyboard":true
	}

}';
$wynik=$token-$message;
$query= $conn->prepare("UPDATE `users` SET `rank` = '33', funds=? WHERE `users`.`user_id` = ?;");
            $query->bind_param("ii", $wynik, $sender);
            $query->execute();
			
					$query= $conn->prepare("INSERT INTO `FlipCoin` (`id`, `DateSeed`, `Date`, `sender_id`, `value`) VALUES ('', CURRENT_DATE, CURRENT_TIMESTAMP, ?, ?);");
            $query->bind_param("ii", $sender, $message);
            $query->execute();
			
			
}
else
{
if($kontrol!=1)
			$jsonData='{
  "text": "⚠️ Error: Value is not correct integer, try again",
"chat_id": '.$sender.',

}';
}
		curl($jsonData, $url);
		exit;
}
if($message=="💰 Withdraw" and $rank==2)
{		

	$query= $conn->prepare('Select funds FROM users WHERE user_id=?');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($token);
			$query->fetch();
	
$jsonData='{
  "text": "💳 Currently you have: '.$token.' coins.
Enter desired amount to withdraw",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["❌Cancel"]],
	"one_time_keyboard":true
	}

}';
$query= $conn->prepare("UPDATE `users` SET `rank` = '4' WHERE `users`.`user_id` = ?;");
            $query->bind_param("i", $sender);
            $query->execute();
			curl($jsonData, $url);
			exit();
}

if($message=="❌Cancel")
{

			$jsonData='{
  "text": "⚡Action cancelled.",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["💲 Coin value"],
	["💎 Flip Coin"],
	[" 🏧 Deposit","💰 Withdraw"]],
	"one_time_keyboard":true
	}

}';
if($rank==33)
{
		$query= $conn->prepare('Select value FROM FlipCoin WHERE sender_id=? AND SIDE IS NULL');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($value);
			$query->fetch();
	
		$query= $conn->prepare('Select funds FROM users WHERE user_id=?');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($funds);
			$query->fetch();
$funds=$funds+$value;
		
		$query= $conn->prepare("UPDATE `users` SET `funds` = ?  WHERE user_id=?;");
            $query->bind_param("ii", $funds, $sender);
            $query->execute();		
	
		$query= $conn->prepare("DELETE FROM `FlipCoin` WHERE sender_id=? AND Side IS NULL");
            $query->bind_param("i", $sender);
            $query->execute();

}
	$query= $conn->prepare("UPDATE `users` SET `rank` = '2' WHERE `users`.`user_id` = ?;");
            $query->bind_param("i", $sender);
            $query->execute();
	
			curl($jsonData, $url);
			exit();
}
if($rank==3 & $message!=="❌Cancel")
{
	$message=intval($message);
	if($message<0)
	{
		$message=$message*(-1);
	}
if($message!=NULL )
{
	$seed=generateRandomString();
		$jsonData='{
  "text": "Contact @'.$settings['owner'].' with that code: '.$seed.'",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["💲 Coin value"],
	["💎 Flip Coin"],
	[" 🏧 Deposit","💰 Withdraw"]],
	"one_time_keyboard":true
	}

}';
$query= $conn->prepare("UPDATE `users` SET `rank` = '2' WHERE `users`.`user_id` = ?;");
            $query->bind_param("i", $sender);
            $query->execute();
			
					$query= $conn->prepare("INSERT INTO `await_deposit` (`id`, `user_id`, `amount`, `token`) VALUES ('', ?, ?, ?);");
            $query->bind_param("iis", $sender, $message, $seed);
            $query->execute();
							$query= $conn->prepare("INSERT INTO `logs` (`id`, `sender_id`, `action`, `code`, `time`, `value`) VALUES ('', ?, 'deposit', ?, CURRENT_TIMESTAMP, ?);");
            $query->bind_param("iss", $sender, $seed, $message);
            $query->execute();	
}
else
{
			$jsonData='{
  "text": "⚠️ Error: Value is not correct integer, try again",
"chat_id": '.$sender.',

}';
}
		curl($jsonData, $url);
		exit;
}
if($rank==4 & $message!=="❌Cancel")
{
	$message=intval($message);
	if($message<0)
	{
		$message=$message*(-1);
	}
	$query= $conn->prepare('Select funds FROM users WHERE user_id=?');
            $query->bind_param("i",$sender);
            $query->execute();
			$query->store_result();
			$query->bind_result($token);
			$query->fetch();
			if($message>$token)
			{
				$jsonData='{
  "text": "⚠️  Error: not enough funds, try smaller amount",
"chat_id": '.$sender.',

}'; $kontrol=1;
			}
if($message!=NULL & $kontrol!=1 )
{

		$jsonData='{
  "text": "Done, your payment will be send as fast as possbile. If you wait more than 24 hours contact @'.$settings['owner'].'",
"chat_id": '.$sender.',
"reply_markup":{
	"resize_keyboard": true,
	"keyboard":[["💲 Coin value"],
	["💎 Flip Coin"],
	[" 🏧 Deposit","💰 Withdraw"]],
	"one_time_keyboard":true
	}

}';
$wynik=$token-$message;
$query= $conn->prepare("UPDATE `users` SET `rank` = '2', `funds`= ? WHERE `users`.`user_id` = ?;");
            $query->bind_param("ii", $wynik, $sender);
            $query->execute();
			$token=generateRandomString();
					$query= $conn->prepare("INSERT INTO `await_withdraw` (`id`, `user_id`, `amount`, `code`) VALUES ('', ?, ?, ?);");
            $query->bind_param("iis", $sender, $message, $token);
            $query->execute();
						$query= $conn->prepare("INSERT INTO `logs` (`id`, `sender_id`, `action`, `code`, `time`, `value`) VALUES ('', ?, 'withdraw', ?, CURRENT_TIMESTAMP, ?);");
            $query->bind_param("iss", $sender, $token, $message);
            $query->execute();	
			
}
else
{
if($kontrol!=1)
			$jsonData='{
  "text": "⚠️ Error: Value is not correct integer, try again",
"chat_id": '.$sender.',

}';
}
		curl($jsonData, $url);
		exit;
}
?>