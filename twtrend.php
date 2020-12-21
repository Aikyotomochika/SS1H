<?php
// twitteroauth の読み込み
require_once 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

// OAuth認証
$consumer_key = 'AUMuf0GBKhGrXi4dDPwxDLIrv';
$consumer_secret = 'ipiULRCYk9XvqndZhc87F1BwaC2209g3F574jW9sDDHevFYFiv';
$access_token = '1328513190037049347-xNRtuq6673iOJu0rTC2p8t326xOCLR';
$access_token_secret = 'A3calfNREYz3a3m9nUPhf6muBwUPF2241IuTNfnANgchF';

$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);


//トレンド検索
$trend = $connection->get('trends/place', ['id' => '2345896']);
$json = json_encode($trend);
$arr = json_decode($json,true);
$arr = $arr["0"]["trends"];
$i = 0;
$trend = array();
foreach($arr as $data){
    
    $tw = $data["name"];

    
    $trend[] = $tw;
    $i++;
    
}
