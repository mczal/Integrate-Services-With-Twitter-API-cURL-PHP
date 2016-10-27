<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>Hello World !</h1>

    <?php
    // function httpGet($url){
    //     $ch = curl_init();
    //
    //     curl_setopt($ch,CURLOPT_URL,$url);
    //     curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //     curl_setopt($ch,CURLOPT_HEADER, true);
    //
    //     $output=curl_exec($ch);
    //
    //     curl_close($ch);
    //     return $output;
    // }
    //
    // echo httpGet("http://localhost:3000/sideAPIkeek/getCities");


        function buildBaseString($baseURI, $method, $params){
          $r = array();
          ksort($params);
          foreach($params as $key=>$value){
              $r[] = "$key=" . rawurlencode($value);
          }
          return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
        }

        function buildAuthorizationHeader($oauth){
          $r = 'Authorization: OAuth ';
          $values = array();
          foreach($oauth as $key=>$value)
              $values[] = "$key="" . rawurlencode($value) . """;
          $r .= implode(', ', $values);
          return $r;
        }

        $url = "http://api.twitter.com/1/account/totals.json";

        $oauth_access_token = "YOUR TOKEN HERE";
        $oauth_access_token_secret = "YOUR TOKEN SECRET HERE";
        $consumer_key = "YOUR KEY HERE";
        $consumer_secret = "YOUR SECRET HERE";

        $oauth = array( 'oauth_consumer_key' => $consumer_key,
                        'oauth_nonce' => time(),
                        'oauth_signature_method' => 'HMAC-SHA1',
                        'oauth_token' => $oauth_access_token,
                        'oauth_timestamp' => time(),
                        'oauth_version' => '1.0');
        $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);


        $base_info = buildBaseString($url, 'GET', $oauth);

        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $header = array(buildAuthorizationHeader($oauth), 'Expect:');

        $options = array( CURLOPT_HTTPHEADER => $header,
                          CURLOPT_HEADER => false,
                          CURLOPT_URL => $url,
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_SSL_VERIFYPEER => false);

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        $twitter_data = json_decode($json);

     ?>

  </body>
</html>
