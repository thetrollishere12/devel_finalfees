<?php

$clientID = 'Finalfee-Finalfee-PRD-3d8c7c7a2-cb66ef44';
$clientSecret = 'PRD-d8c7c7a29149-4570-4f7a-a9c3-4df2';
$ruName = 'Finalfees-Finalfee-Finalf-wwngpfs';
$authCode = urldecode($_GET['code']);

$url = 'https://api.ebay.com/identity/v1/oauth2/token';

$headers = [
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic '.base64_encode($clientID.':'.$clientSecret)
];
//print_r($headers);
$body = http_build_query([
    'grant_type'   => 'authorization_code',
    'code'         => $authCode,
     'redirect_uri' => $ruName
    // 'scope'=>'https://api.ebay.com/oauth/api_scope'
]);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_POSTFIELDS     => $body,
    CURLOPT_HTTPHEADER     => $headers
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response."\n";
     // $json_decode=json_decode($response);

     // print_r($json_decode->access_token);
}