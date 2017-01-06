<?php
require_once __DIR__ . '/vendor/autoload.php';

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\Constant\HTTPHeader;
use \LINE\LINEBot\Event\MessageEvent;
use \LINE\LINEBot\Event\MessageEvent\TextMessage;
use \LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;


$httpClient = new CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new LINEBot(
    $httpClient,
    [
        'channelSecret' => getenv('CHANNEL_SECRET'),
    ]
);
$sign   = $_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $sign);

/* カルーセルテスト */
$columns = []; // カルーセル型カラムを5つ追加する配列
$lists = [0,1,2,3,4];
foreach ($lists as $list) {
    // カルーセルに付与するボタンを作る
    $action = new UriTemplateActionBuilder("クリックしてね", "https://www.yahoo.co.jp");
    // カルーセルのカラムを作成する
    $column = new CarouselColumnTemplateBuilder("Yahoo Japan", "これは追加メッセージです", "", [$action]);
    $columns[] = $column;
}
// カラムの配列を組み合わせてカルーセルを作成する
$carousel = new CarouselTemplateBuilder($columns);
// カルーセルを追加してメッセージを作る
$carousel_message = new TemplateMessageBuilder("メッセージのタイトル", $carousel);
$message = new MultiMessageBuilder();
$message->add($carousel_message);
//$message->add($confirm_message);
/* カルーセルテスト */

foreach ($events as $event) {
    if (!($event instanceof MessageEvent) || !($event instanceof TextMessage)) {
        continue;
    }
    //$bot->replyText($event->getReplyToken(), $event->getText());
    $bot->replyText($event->getReplyToken(), $message);
}
