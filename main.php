<?php

$accessToken = 'H2E4tOgm3X4DT4Ad1ryHdMFfiEYq+9gmU5gbr8Oynu9Sjl2Al5EirLeNABNCCXot5OllZ+owmib+GVp9mSq9RKi4O31tDXGydtu0Gi+8bncVdlP2UM3EhNR9aSBTXkUmfnwniR50ohO+vQFuHBLQ8wdB04t89/1O/w1cDnyilFU=';
 
//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$json_object = json_decode($json_string);
 
//取得データ
$replyToken = $json_object->{"events"}[0]->{"replyToken"};        //返信用トークン
$message_type = $json_object->{"events"}[0]->{"message"}->{"type"};    //メッセージタイプ
$message_text = $json_object->{"events"}[0]->{"message"}->{"text"};    //メッセージ内容
 
//メッセージタイプが「text」以外のときは何も返さず終了
if($message_type != "text") exit;
 
//返信メッセージ
if($message_text == "人気のトレンド"){
require "twtrend.php";

$return_message_text = "人気のトレンドは\n「" . $trend[0] . "」\n「". $trend[1] ."」\n「" . $trend[2] ."」\n「" . $trend[3] ."」\n「" . $trend[4] ."」\nです";

	}
else if($message_text == "おすすめのトレンド"){
require "twtrend.php";
shuffle($trend);
$return_message_text = "おすすめのトレンドは\n「" . $trend[0] . "」\n「". $trend[1] ."」\n「" . $trend[2] ."」\n「" . $trend[3] ."」\n「" . $trend[4] ."」\nです";

			 }else if($message_text == "話題のニュース"){
				$return_message_text = "こんな「" . $message_text . "」どうですか";
					}else{
//session_start();
$_SESSION['text'] = $message_text;
require "twitter.php";
$messageData = [
"type" => 'text',
"text"=> $tweet[0]
];

$messageData2 = [
"type" => 'text',
"text" => $tweet[1]
];

$messageData3 = [
"type" => 'text',
"text" => $tweet[2]
];

$messageData4 = [
"type" => 'text',
"text" => $tweet[3]
];

$messageData5 = [
"type" => 'text',
"text" => $tweet[4]
];
$response = [
    'replyToken' => $replyToken,
    'messages' => [$messageData,$messageData2,$messageData3,$messageData4,$messageData5]
];
// error_log(json_encode($response));

$ch = curl_init('https://api.line.me/v2/bot/message/reply');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response,JSON_UNESCAPED_UNICODE));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
));
$result = curl_exec($ch);
error_log($result);
curl_close($ch);

unset($_SESSION[‘text’] );
}
//返信実行
sending_messages($accessToken, $replyToken, $message_type, $return_message_text);

//メッセージの送信
function sending_messages($accessToken, $replyToken, $message_type, $return_message_text){
    //レスポンスフォーマット
    $response_format_text = [
        "type" => $message_type,
        "text" => $return_message_text
    ];
 
    //ポストデータ
    $post_data = [
        "replyToken" => $replyToken,
        "messages" => [$response_format_text]
    ];
 
    //curl実行
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}
?>