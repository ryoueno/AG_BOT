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

foreach ($events as $event) {
    if (!($event instanceof MessageEvent) || !($event instanceof TextMessage)) {
        continue;
    }
    //error_log($bot->getProfile($event->getUserId())->getJSONDecodedBody()['pictureUrl']);
    $line_id = $event->getUserId();
    $rep = agbot($line_id, $event->getText());
    $bot->replyText($event->getReplyToken(), $rep);
    //$bot->replyMessage($event->getReplyToken(), $message);
}

function agbot($line_id, $message)
{
    $status = getStatus($line_id);
    error_log($line_id);

    if (false && empty($status)) {
        $rep = "席についてもっかいやってみ";
    } else if (empty($status)  && ctype_digit($message) || $status === 1 && ctype_digit($message)) {
        if (empty($stauts)) addStudent($message, $line_id);
        $rep = "出席できたばい";
        attend($message);
        changeStatus($line_id, 2);
    } else if (empty($status) || $status === 1 && !ctype_digit($message)) {
        $rep = "学籍番号ば入力せんね";
    } else if ($status === 2 && preg_match("/資料/", $message)) {
        $rep = "これが今日の資料たい\nダウンロードしなっせ\nhttp://www.civil.kyutech.ac.jp/pub/hibino/experi/group7.pdf";
    } else if ($status === 2 && preg_match("/先生/", $message)) {
        call($line_id);
        $rep = "先生呼んだばい";
    } else {
        $rep = "授業に集中せんね";
    }
    return $rep;
    //changeStatus($line_id, 2000);
}


/*
 * 指定されたLINE IDのステータスを取得する
 * @param string $line_id
 */
function getStatus($line_id)
{
    $get_status_url = 'http://agbot-admin-dev.ap-northeast-1.elasticbeanstalk.com/student/status/' . $line_id;

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $get_status_url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

    $response = curl_exec($curl);
    $result = json_decode($response, true);
    curl_close($curl);
    return $result;
}

/*
 * 指定されたLINE IDのステータスを変更する
 * @param string $line_id
 * @param int $status
 */
function changeStatus($line_id, $status)
{
    $change_status_url = "http://agbot-admin-dev.ap-northeast-1.elasticbeanstalk.com/student/set";
    $POST_DATA = [
        'line_id' => $line_id,
        'status'  => $status,
    ];

    $curl = curl_init($change_status_url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
    curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡

    $output= curl_exec($curl);
    return $output;
}

function attend($student_id)
{
    $change_status_url = "http://agbot-admin-dev.ap-northeast-1.elasticbeanstalk.com/attendance";
    $POST_DATA = [
        'student_id'  => $student_id,
    ];

    $curl = curl_init($change_status_url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
    curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡

    $output= curl_exec($curl);
    return $output;
}

function addStudent($student_id, $line_id)
{
    $change_status_url = "http://agbot-admin-dev.ap-northeast-1.elasticbeanstalk.com/student";
    $POST_DATA = [
        'id'  => $student_id,
        'line_id' => $line_id,
        'name' => 'hoge',
        'img' => 'hoge',
        'status' => 1,
    ];

    $curl = curl_init($change_status_url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
    curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡

    $output= curl_exec($curl);
    return $output;
}

function call($line_id)
{
    $change_status_url = "http://agbot-admin-dev.ap-northeast-1.elasticbeanstalk.com/call";
    $POST_DATA = [
        'line_id'  => $line_id,
    ];

    $curl = curl_init($change_status_url);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl,CURLOPT_COOKIEJAR,      'cookie');
    curl_setopt($curl,CURLOPT_COOKIEFILE,     'tmp');
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION, TRUE); // Locationヘッダを追跡

    $output= curl_exec($curl);
    return $output;
}

