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
use \LINE\LINEBot\TemplateActionBuilder\TemplateActionBuilder\PostbackTemplateActionBuilder;


$httpClient = new CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new LINEBot(
    $httpClient,
    [
        'channelSecret' => getenv('CHANNEL_SECRET'),
    ]
);
$sign   = $_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $sign);

/* コンファームテスト */
// 「はい」ボタン
$yes_post = new PostbackTemplateActionBuilder("はい", "page={$page}");
// 「いいえ」ボタン
$no_post = new PostbackTemplateActionBuilder("いいえ", "page=-1");
// Confirmテンプレートを作る
$confirm = new ConfirmTemplateBuilder("メッセージ", [$yes_post, $no_post]);
// Confirmメッセージを作る
$confirm_message = new TemplateMessageBuilder("メッセージのタイトル", $confirm);
/* コンファームテスト */

$message = new MultiMessageBuilder();
$message->add($carousel_message);

foreach ($events as $event) {
    if (!($event instanceof MessageEvent) || !($event instanceof TextMessage)) {
        continue;
    }
    //$bot->replyText($event->getReplyToken(), $event->getText());
    $bot->replyText($event->getReplyToken(), $message);
}
