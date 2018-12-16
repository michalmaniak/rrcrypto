<?php

function curl($jsonData, $curl)
{
	$ch = curl_init($curl);
$senderd="ok";
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
if($senderd!=NULL){
    $result = curl_exec($ch);
}
}
function przelicznik($source)
{
$string=strrev($source);
$string=wordwrap($string, 3 , ' ' , true );
$tablica=explode(" ", $string);
$kontrolna=count($tablica);
$controll=0;
$null="0";
$wynik="";
while($controll<$kontrolna)
{
if($tablica[$controll]=="000" and $null!="1")
{
	$wynik=$wynik."k";
}
else
{
	$null="1";
}
if($null=="1")
{
		$wynik=$wynik.$tablica[$controll];
}
$controll++;
}
return strrev($wynik);
}
function przelicznik_back($source)
{
	$bodytag = str_ireplace("k", "000", $source);
	return $bodytag;
}

function hyperlink($message)
{
		//$wynik=array();
$findme   = 'https://rivalregions.com/#slide/profile/';
$pos1 = strpos($message, $findme);
$findme   = 'http://rivalregions.com/#slide/profile/';
$pos2 = strpos($message, $findme);
$findme   = 'https://m.rivalregions.com/#slide/profile/';
$pos3 = strpos($message, $findme);
$findme   = 'http://m.rivalregions.com/#slide/profile/';
$pos4 = strpos($message, $findme);

if($pos1!==False || $pos2!==False || $pos3!==False || $pos4!==False ){
	return "true";
}else
{
	return "false";
}
}

function converter($message)
{
	$wynik=array();
$findme   = 'm.';

$pos = strpos($message, $findme);

if ($pos != true) {
$pc=$message;

$mobile=str_replace("rival","m.rival",$message);
} else {
$mobile=$message;
$pc=str_replace("m.rival","rival",$message);
}

$wynik['pc']=$pc;
$wynik['mobile']=$mobile;
return $wynik;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function FlipCoin($server_seed, $public_seed, $round)
{
$hash = hash('sha256', $server_seed . "-" . $public_seed . "-" . $round);
$roll = hexdec(substr($hash, 0, 8)) % 2;
if ($roll == 0)
{
	$roll_colour = 'Head';
}
else
{
	$roll_colour = 'Tail';
}
return $roll_colour;
}

?>