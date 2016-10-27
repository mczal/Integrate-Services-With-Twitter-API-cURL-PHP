<html>
  <head>
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bower_components/components-font-awesome/css/font-awesome.css">
  </head>

  <body>
    <div class="container">
      <div class="header" style="text-align: center">

        <h3>This is request portal for performing cURL to Twitter API</h3>
        <h5>Result : Search API</h5>
      </div>

      <div class="content">
        <div class="center-block">
            <a href="index.html"><button id="singlebutton" name="singlebutton" class="btn btn-success center-block">
                Back to Home <i class="fa fa-home" aria-hidden="true"></i>
            </button></a>
        </div>

        <?php
          include ("assets/functions.php") ;
          include ("assets/auth.php") ;
          echo "Hello Friend Result ! <br/>";

          $url = "https://api.twitter.com/1.1/search/tweets.json";
          if(isset($_SERVER['REQUEST_METHOD'])){
            if($_SERVER['REQUEST_METHOD']=='GET'){
              $valueQuery="";
              if(isset($_GET['query'])){
                $valueQuery=$_GET['query'];
              }
              // $url .='?q='.$valueQuery;
              echo "URL : $url <br/>";
              echo "Query : $valueQuery <br/>";
         ?>
         <p>
           <?php
           $oauth = array(
             'q' => $valueQuery,
             'oauth_consumer_key' => $consumer_key,
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

             echo 'URL Passed: '.$url.'?q='.$valueQuery .'<br/><br/>';
             $options = array( CURLOPT_HTTPHEADER => $header,
                               CURLOPT_HEADER => false,
                               CURLOPT_URL => $url.'?q='.$valueQuery,
                               CURLOPT_RETURNTRANSFER => true,
                               CURLOPT_SSL_VERIFYPEER => false);

             $feed = curl_init();
             curl_setopt_array($feed, $options);
             $json = curl_exec($feed);
             curl_close($feed);

             $twitter_data = json_decode($json);
            //  echo "COUNT : ".count($twitter_data->users). " <br/>";
            console_log($twitter_data);
             echo "$json <br/>";
           }
         }
            ?>
         </p>
      </div>


    </div>

    <script src="bower_components/jquery/dist/jquery.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
  </body>

</html>
