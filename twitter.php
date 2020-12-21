<?php
$key = $_SESSION['text'];
// TwitterOAuthを利用するためComposerのautoload.phpを読み込み
require __DIR__ . '/vendor/autoload.php';
// TwitterOAuthクラスをインポート
use Abraham\TwitterOAuth\TwitterOAuth;

// Twitter APIを利用する認証情報。xxxxxxxxの箇所にそれぞれの情報を指定
$CK = 'ZFlr4ki4W0ftPWJbD0m4kqKEC'; // Consumer Keyをセット
$CS = 'LfvoSkdmLnKv9E1dxnBZispY9DWgciFHiVk4Z7r7vnrLNnRfmU'; // Consumer Secretをセット
$AT = '1331498597985107970-7CRHwp01Ngab9fJmr2LMxuxSplRaJ8'; // Access Tokenをセット
$AS = 'XkQCXuEaicrY525oQ8kIWhEhTAH1Y8vU0EdGBQDRfNCQM'; // Access Token Secretをセット

// TwitterOAuthクラスのインスタンスを作成
$connect = new TwitterOAuth( $CK, $CS, $AT, $AS );


$prams = array(
    'q' => $key, // 検索したいキーワード
    'count' => '10', // 取得数
    'result_type' => 'mixed' // 取得するツイートの種類
  );

  // Search tweets
  $statuses = $connect->get('search/tweets', $prams)->statuses;
$tweet = array();
  foreach ($statuses as $status) {
    $text = htmlspecialchars($status->text, ENT_QUOTES, 'UTF-8');
    $tweet[] = $text;
} 
?>