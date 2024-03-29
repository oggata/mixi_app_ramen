<?php
require_once('./OAuth.php');

// Establish an OAuth consumer based on our admin 'credentials'
$CONSUMER_KEY = 'e845dfb2fa0b1f1afec4';
$CONSUMER_SECRET = '64b1357051a8570137972da07b83c409575f8858';
$consumer = new OAuthConsumer($CONSUMER_KEY, $CONSUMER_SECRET, NULL);

// Setup OAuth request based our previous credentials and query
$user= '445075';
$base_feed = 'http://api.mixi-platform.com/os/0.8/people/@me/@self';
$params = array('xoauth_requestor_id' => $user);
$request = OAuthRequest::from_consumer_and_token($consumer, NULL, 'GET', $base_feed, $params);

// Sign the constructed OAuth request using HMAC-SHA1
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);

// Make signed OAuth request to the Contacts API server
$url = $base_feed . '?' . implode_assoc('=', '&', $params);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FAILONERROR, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_ENCODING, 'gzip');

//$auth_header = $request->to_header();
$auth_header = $request->to_header('api.mixi-platform.com');
if ($auth_header) {
    curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header));
}

$response = curl_exec($curl);
if (!$response) {
    $response = curl_error($curl);
}
curl_close($curl);

var_dump($response);

/**
 * Joins key:value pairs by inner_glue and each pair together by outer_glue
 * @param string $inner_glue The HTTP method (GET, POST, PUT, DELETE)
 * @param string $outer_glue Full URL of the resource to access
 * @param array $array Associative array of query parameters
 * @return string Urlencoded string of query parameters
 */
function implode_assoc($inner_glue, $outer_glue, $array) {
    $output = array();
    foreach($array as $key => $item) {
        $output[] = $key . $inner_glue . urlencode($item);
    }
    return implode($outer_glue, $output);
}
?>