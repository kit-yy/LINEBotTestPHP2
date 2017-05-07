<?php

$access_token = '(cPI4+7rufy3C1SfXfETCHquFRidmex3yyJq/sHgNecBoCqoN+EJ1dZI3gzEDGEPAqP/8F4rlVi/xAO//NNXpRQfF+Pabkez5KyE3r2Tcx+EMwVYha3C2UW3ThjCtFoltvo1tdjFh2DE7u3GKAaupPgdB04t89/1O/w1cDnyilFU=)';

//APIから送信されてきたイベントオブジェクトを取得
$json_string = file_get_contents('php://input');
$json_obj = json_decode($json_string);

//イベントオブジェクトから必要な情報を抽出
$message = $json_obj->{"events"}[0]->{"message"};
$reply_token = $json_obj->{"events"}[0]->{"replyToken"};

//ユーザーからのメッセージに対し、オウム返しをする
$post_data = [
  "replyToken" => $reply_token,
  "messages" => [
    [
      "type" => "text",
      "text" => $message->{"text"}
    ]
  ]
];

//curlを使用してメッセージを返信する
$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $access_token
));
$result = curl_exec($ch);
curl_close($ch);