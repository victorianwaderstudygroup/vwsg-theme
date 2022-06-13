<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 23/02/2019
 * Time: 4:37 PM
 */

require_once __DIR__ . '/../../../../wp-twitter-config.php';

$ch = curl_init(
    sprintf(
        '%s%s?%s',
        TWITTER_API_URL,
        'statuses/user_timeline.json',
        http_build_query([
            'screen_name' => TWITTER_USER,
            'count' => 10,
            'exclude_replies' => true,
            'trim_user' => true,
            'tweet_mode' => 'extended'
        ])
    )
);

curl_setopt_array($ch, [
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        sprintf('Authorization: Bearer %s', TWITTER_BEARER_TOKEN)
    ]
]);

$response = curl_exec($ch);
curl_close($ch);

file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . TWITTER_USER . '.json', $response);