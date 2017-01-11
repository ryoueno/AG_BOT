<?php

$t = $argv[0];
$line_id = "adskfads2222";

agbot($line_id, $argv[0]);
/*
* 1 作りたてアカウント
* 2 出席中
start => 番号を入力してください。
# getStatus -> なければユーザ登録
if status === 1 && "number" in message
//学籍番号が入力された
    if syusseki:
        $rep = "かしこまりました。" + に出席しました。
        setStatus(2);
    else :
        $rep = "席についてからもう一度お願いします。"
else if status === 1 && "number" not in message
    //学籍番号を入力してください

else if status === 2 && "資料" in message && get_siryo not empty
    //これが今日の資料たい
    //url
    //ダウンロードしなっせ

else if status === 2 && "資料" in message && get_siryo empty
    //今日は資料はなんもなかよ

else if status === 2 && "先生" in message
    //先生ば呼ぶとね？　yes or no
    setStatus(3)
else if status === 3
    if message == yes :
        //先生呼んだばい
    else message == no :
        //あら、よかとね
    setStatus(2)
else
    rand(length)
    //授業に集中せんね
    //なんばいいよっと？

*/
function agbot($line_id, $message)
{
    print_r(getStatus($line_id));
    changeStatus($line_id, 2000);
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
