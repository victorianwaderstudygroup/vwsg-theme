<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 23/02/2019
 * Time: 4:37 PM
 */


define('TWITTER_BEARER_TOKEN', 'AAAAAAAAAAAAAAAAAAAAAAEe9gAAAAAAyXXvW1LhcVRB1fCvIAUzExbDfAA%3DhQCppugfuFBDr0qgGsgK6GTPgVYI8uR2DTs3MITOcMRXVONTlT');
define('TWITTER_USER', 'vwsg_web');
define('TWITTER_API_URL', 'https://api.twitter.com/1.1/');


$ch = curl_init(
    sprintf(
        '%s%s?%s',
        TWITTER_API_URL,
        'statuses/user_timeline.json',
        http_build_query([
            'screen_name' => TWITTER_USER,
            'count' => 3,
            'exclude_replies' => true,
//            'include_rts' => false,
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

/*$ids = [];
$response = json_decode($response);

foreach ($response as $tweet) {
    $ids[] = $tweet->id;
}

$ch = curl_init(
    sprintf(
        '%s%s?%s',
        TWITTER_API_URL,
        'statuses/lookup.json',
        http_build_query([
            'id' => implode(',', $ids)
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
curl_close($ch);*/


file_put_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.TWITTER_USER.'.json', $response);