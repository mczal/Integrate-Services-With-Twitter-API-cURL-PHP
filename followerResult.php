<html>
  <head>
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bower_components/components-font-awesome/css/font-awesome.css">
  </head>

  <body>
    <div class="container">
      <div class="header" style="text-align: center">

        <h3>This is request portal for performing cURL to Twitter API</h3>
        <h5>Result : GET followers/ids</h5>
      </div>

      <div class="content">
        <div class="center-block">
            <a href="index.html"><button id="singlebutton" name="singlebutton" class="btn btn-success center-block">
                Back to Home <i class="fa fa-home" aria-hidden="true"></i>
            </button></a>
        </div>

        <?php
          include ("assets/functions.php");
          include ("assets/auth.php") ;

          echo "Hello Follower Result ! <br/>";
          $url = "https://api.twitter.com/1.1/followers/ids.json";
          if(isset($_SERVER['REQUEST_METHOD'])){
            if($_SERVER['REQUEST_METHOD']=='GET'){
              $usedParam="";
              $valueParam="";
        			if(isset($_GET['usedParam'])){
        				$usedParam=$_GET['usedParam'];
              }
              if(isset($_GET['valueParam'])){
        				$valueParam=$_GET['valueParam'];
              }
        		}
          }
          // $url .='?'.$usedParam.'='.$valueParam;
          echo "URL : $url <br/>";
          echo "Used Param : $usedParam <br/>";
          echo "Value : $valueParam <br/>";
         ?>

         <p>
           <?php
           $oauth = array(
             $usedParam => $valueParam,
             'oauth_consumer_key' => $consumer_key,
             'oauth_nonce' => time(),
             'oauth_signature_method' => 'HMAC-SHA1',
             'oauth_token' => $oauth_access_token,
             'oauth_timestamp' => time(),
             'oauth_version' => '1.0');
            //  console_log($oauth);
           $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);

             $base_info = buildBaseString($url, 'GET', $oauth);
            //  console_log("Base Info: ");
            //  console_log($base_info);
             $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
            //  console_log("Oauth Signature: ");
            //  console_log($oauth_signature);
             $oauth['oauth_signature'] = $oauth_signature;
            //  console_log("Oauth: ");
            //  console_log($oauth);

             $header = array(buildAuthorizationHeader($oauth), 'Expect:');
            //  console_log($header);
            // console_log("Header: ");
            // console_log($header);
            //  $additionalHeader = array(
            //    $usedParam => $valueParam
            //  );
            echo 'URL Passed: '.$url.'?'.$usedParam.'='.$valueParam .'<br/><br/>';
             $options = array( CURLOPT_HTTPHEADER => $header,
                               CURLOPT_HEADER => false,
                               CURLOPT_URL => $url.'?'.$usedParam.'='.$valueParam,
                               CURLOPT_RETURNTRANSFER => true,
                               CURLOPT_SSL_VERIFYPEER => false);

             $feed = curl_init();
             curl_setopt_array($feed, $options);
             $json = curl_exec($feed);
             curl_close($feed);

             $twitter_data = json_decode($json);
            //  console_log("DATA : ");
            //  console_log($json);
             echo "COUNT : ".count($twitter_data->ids). " <br/>";
             echo "Data : <br/>";
             foreach ($twitter_data->ids as $key => $value) {
               # code...
               echo "$key : $value, <br/>";
             }

            ?>
         </p>
      </div>


    </div>

    <script src="bower_components/jquery/dist/jquery.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>
  </body>

</html>
