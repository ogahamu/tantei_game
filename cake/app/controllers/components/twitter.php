<?php
// twitterOAuth を読み込む
require_once(BASE_DIR.'/cake/app/controllers/components/twitteroauth.php');

//twitter用のkey
//define(_CONSUMER_KEY_, '3FcSRidmA83HkqoBv2xM0A');
//define(_CONSUMER_SECRET_, 'EehI3ZTFQby0bGkBmIMjCKiM63v82HILsm1XFMf16RE');

class TwitterComponent
{
  var $components = array('Session');
/*ログイン用*/
  function login(){
    $consumer_key = '3FcSRidmA83HkqoBv2xM0A';
    $consumer_secret = 'EehI3ZTFQby0bGkBmIMjCKiM63v82HILsm1XFMf16RE';
    $to = new TwitterOAuth($consumer_key, $consumer_secret);
    $tok = $to->getRequestToken();
    /* Tokenをセッションに格納 */
    $_SESSION['oauth_request_token'] = $token = $tok['oauth_token'];
    $_SESSION['oauth_request_token_secret'] = $tok['oauth_token_secret'];
    $_SESSION['oauth_state'] = "start";
    /* authorization URL を生成*/
    $request_link = $to->getAuthorizeURL($token);
    echo $request_link;
    return $request_link;
  }

  /*アカウント情報を返す*/
  function return_account_data($oauth_access_token,$oauth_access_token_secret){
    $to = new TwitterOAuth(_CONSUMER_KEY_,_CONSUMER_SECRET_,$oauth_access_token,$oauth_access_token_secret);
    $tok = $to->getAccessToken();
    $data['oauth_access_token']= $tok['oauth_token'];
    $data['oauth_access_token_secret']= $tok['oauth_token_secret'];
    $data['user_name'] = $tok['screen_name'];
    return $data;
  }

  /*tweetのリストを返す*/
  function return_tweet_list($oauth_access_token,$oauth_access_token_secret){
    $to = new TwitterOAuth(_CONSUMER_KEY_,_CONSUMER_SECRET_,$oauth_access_token,$oauth_access_token_secret);
    //list取得
    $req = $to->OAuthRequest("http://api.twitter.com/1/statuses/home_timeline.xml","GET",array("count"=>"50"));
    $xml = simplexml_load_string($req);
    return $xml;
  }

  /*つぶやく*/
  function do_tweet($oauth_access_token,$oauth_access_token_secret,$comment){
    $to = new TwitterOAuth(_CONSUMER_KEY_,_CONSUMER_SECRET_,$oauth_access_token,$oauth_access_token_secret);
    //投稿
    $req = $to->OAuthRequest("http://api.twitter.com/1/statuses/update.xml","POST",array("status"=>$comment));
    return $req;
  }
}
?>