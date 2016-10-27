<?php
  $oauth_access_token = "YOUR ACCESS TOKEN";
  $oauth_access_token_secret = "YOUR SECRET ACCESS TOKEN";
  $consumer_key = "YOUR CONSUMER KEY";
  $consumer_secret = "YOUR SECRET CONSUMER KEY";

  $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
 ?>
