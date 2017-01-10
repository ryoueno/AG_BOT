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
use \LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use \LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;


$httpClient = new CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new LINEBot(
    $httpClient,
    [
        'channelSecret' => getenv('CHANNEL_SECRET'),
    ]
);
$sign   = $_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $sign);

$columns = []; // カルーセル型カラムを5つ追加する配列
$action = new UriTemplateActionBuilder("クリックしてね", "https://www.yahoo.co.jp");
// カルーセルのカラムを作成する
$column = new CarouselColumnTemplateBuilder("Yahoo Japan", "これは追加メッセージです", "https://k.yimg.jp/images/top/sp2/cmn/logo-ns-131205.png", [$action]);
$columns[] = $column;
$action = new UriTemplateActionBuilder("クリックしてね", "https://www.yahoo.co.jp");
// カルーセルのカラムを作成する
$column = new CarouselColumnTemplateBuilder("Yahoo Japan", "これは追加メッセージです", "https://k.yimg.jp/images/top/sp2/cmn/logo-ns-131205.png", [$action]);
$columns[] = $column;
// カラムの配列を組み合わせてカルーセルを作成する
$carousel = new CarouselTemplateBuilder($columns);
// カルーセルを追加してメッセージを作る
$carousel_message = new TemplateMessageBuilder("メッセージのタイトル", $carousel);
$message = new MultiMessageBuilder();
$message->add($carousel_message);

foreach ($events as $event) {
    if (!($event instanceof MessageEvent) || !($event instanceof TextMessage)) {
        continue;
    }
    error_log($bot->getProfile($event->getUserId())->getJSONDecodedBody()['pictureUrl']);
    //$bot->replyText($event->getReplyToken(), $event->getText());
    $bot->replyMessage($event->getReplyToken(), $message);
}
