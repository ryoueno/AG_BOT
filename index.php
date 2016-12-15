<?php
require_once __DIR__ . '/vendor/autoload.php';

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\Constant\HTTPHeader;
use \LINE\LINEBot\Event\MessageEvent;
use \LINE\LINEBot\Event\MessageEvent\TextMessage;

$httpClient = new CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new LINEBot(
    $httpClient,
    [
        'channelSecret' => getenv('CHANNEL_SECRET'),
    ]
);
$sign   = $_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $sign);

foreach ($events as $event) {
    if (!($event instanceof MessageEvent) || !($event instanceof TextMessage)) {
        continue;
    }
    $bot->replyText($event->getReplyToken(), $event->getText());
}
