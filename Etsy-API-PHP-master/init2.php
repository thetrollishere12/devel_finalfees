<?php


//phpinfo();
$OAUTH_CONSUMER_KEY='vfe4uh6h10umw6bx1m457sty';
$OAUTH_CONSUMER_SECRET='ftt27s55mp';
//define(OAUTH_CONSUMER_KEY, 'vfe4uh6h10umw6bx1m457sty');
//define(OAUTH_CONSUMER_SECRET, 'ftt27s55mp');
$oauth = new OAuth($OAUTH_CONSUMER_KEY, $OAUTH_CONSUMER_SECRET);

// get the verifier from the url
$verifier = isset($_GET['oauth_verifier']) ? $_GET['oauth_verifier'] : null;

$oauth->setToken($OAUTH_CONSUMER_KEY, $OAUTH_CONSUMER_SECRET);

try {
    // set the verifier and request Etsy's token credentials url
    $acc_token = $oauth->getAccessToken("https://openapi.etsy.com/v2/oauth/access_token", null, $verifier, "GET");
    print_r($acc_token);
} catch (OAuthException $e) {
    error_log($e->getMessage());
}

/*$req_token = $oauth->getRequestToken("http://openapi.etsy.com/v2/sandbox/oauth/request_token", 'oob');
$login_url = sprintf(
  "%s?oauth_consumer_key=%s&oauth_token=%s",
  $req_token['login_url'],
  $req_token['oauth_consumer_key'],
  $req_token['oauth_token']
);

print_r($req_token);

print "go to this url".$login_url;
// print "then tell me what the verifier code you get back is: \n\n";
$handle = fopen("php://stdin","r");
$line = fgets($handle);
$request_token = $req_token['oauth_token'];
$request_token_secret = $req_token['oauth_token_secret'];
$verifier = trim($line);
print "you said {$verifier}\n\n";
print "now let's see what we can get back from Etsy...\n\n";
$oauth->setToken($request_token, $request_token_secret);
try {
  $access_token = $oauth->getAccessToken("http://openapi.etsy.com/v2/sandbox/oauth/access_token", null, $verifier);
} catch (OAuthException $e) {
  print_r($e->getMessage());
}
$oauth_token = $access_token['oauth_token'];
$oauth_token_secret = $access_token['oauth_token_secret'];
$oauth->setToken($oauth_token, $oauth_token_secret);
try {
  $data = $oauth->fetch("http://openapi.etsy.com/v2/sandbox/private/users/__SELF__");
  $json = $oauth->getLastResponse();
  print_r(json_decode($json, true));
} catch (OAuthException $e) {
  error_log($e->getMessage());
  error_log(print_r($oauth->getLastResponse(), true));
  error_log(print_r($oauth->getLastResponseInfo(), true));
  exit;
}*/