<?php

require_once(BASE_DIR.'/cake/app/controllers/components/opensocial_get_user.php');
require_once(BASE_DIR.'/cake/app/controllers/components/JSON.php');

class LoginController extends AppController{

  var $uses = array('MemberTreasure','TreasureSerie','Bank','Treasure','Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell','StructureSql');

  function mixi_login(){
    $mixi_account_id = $this->params['form']['id'];
    if(strlen($mixi_account_id)==0){
      self::s_t_out();
    }
    $this->Session->write("RefleshImgFlag",1);
    $user_data = $this->oauth_get_user_account($mixi_account_id);
    $mixi_name = $user_data['nickname'];
    $mixi_name = mysql_escape_string($mixi_name);
    $mixi_thumbnail = $user_data['thumbnailUrl'];
    $this->Session->write("after_login_flag",1);
    $this->Session->write("mixi_name",$mixi_name);
    $this->Session->write("mixi_account_id",$mixi_account_id);
    $this->Session->write("mixi_thumbnail",$user_data['thumbnailUrl']);
    $count = $this->Member->findCount(array('mixi_account_id'=>$mixi_account_id));
    if($count == 0){
      $data = array(
        'Member' => array(
          'mixi_account_id' => $mixi_account_id,
          'thumnail_url' => $mixi_thumbnail,
          'name' => $mixi_name,
          'mail' => '',
          'pass' => '',
          'money' => '100',
          'member_request_id' => 0,
          'power' => 500,
          'max_power' => 500,
          'member_request_id' => 0,
          'lv' => 1,
          'exp' => 0,
          'least_next_exp' => 0,
          'sum_exp' => 0,
          'mission_count' => 0,
          'success_count' => 0,
          'mistake_count' => 0,
          'rob_success_count' => 0,
          'rob_mistake_count' => 0,
          'insert_date' => date("Y-m-d H:i:s")
        )
      );
      $this->Member->save($data);
      $member_id = $this->Member->getLastInsertID();
      //最初の依頼を生成その１
      $this->insert_request($member_id);
      //最初の依頼を生成その２
      $this->insert_request($member_id);
      self::login_f_mixi();
    }else{
      if(strlen($mixi_name)>0){
        $mdata = $this->Member->findByMixiAccountId($mixi_account_id);
        $id = $mdata['Member']['id'];
        $data = array(
          'id' => $id,
          'mixi_account_id' => $mixi_account_id,
          'thumnail_url' => $mixi_thumbnail,
          'name' => $mixi_name,
          'update_date' => date("Y-m-d H:i:s")
        );
        $this->Member->save($data);
      }
      $data = $this->Member->find("first",array("mixi_account_id" => $mixi_account_id));
      if(strlen($data['Member']['id'])==0){
        self::login_failed();
      }else{
        $this->Session->write("member_info",$data['Member']);
        self::login_success();
      }
    }
  }

  function oauth_get_user_account($mixi_account_code){
    $api = new OpensocialGetUserRestfulAPI($mixi_account_code);
    $data = $api->get();
    $json = new Services_JSON;
    $decode_data = $json->decode($data,true);
    $user_data['nickname'] = $decode_data->entry->nickname;
    $user_data['thumbnailUrl']= $decode_data->entry->thumbnailUrl;
    $user_data['platformUserId']= $decode_data->entry->platformUserId;
    return $user_data;
  }

  function oauth_get_user_account_id($mixi_account_id){
    $api = new OpensocialGetUserRestfulAPI($mixi_account_id);
    $data = $api->get();
    $json = new Services_JSON;
    $decode_data = $json->decode($data,true);
    $user_data['nickname'] = $decode_data->entry->nickname;
    $user_data['thumbnailUrl']= $decode_data->entry->thumbnailUrl;
    return $user_data;
  }

  function login_failed(){
    $this->redirect('/login/login/');
  }

  function login_success(){
    $this->Session->write('img_refresh_flag',1);
    $this->redirect('/top/top/');
  }

  function s_t_out(){
    $this->redirect('/login/session_timeout/');
  }

  function session_timeout(){
  }

  function login_f_mixi(){
    $this->redirect("/login/login_first_mixi");
  }

  function login_first_mixi(){
    $error_txt = $this->Session->read("error_txt");
    //$this->set('error_txt',$error_txt);
    //$this->Session->write("RefleshImgFlag",1);
    $mixi_account_id = $this->Session->read("mixi_account_id");
    $this->set('mixi_account_id',$mixi_account_id);
    $mixi_name = $this->Session->read("mixi_name");
    $this->set('mixi_name',$mixi_name);
  }

  function log_out(){
    $this->Session->write("user_genre_code","");
    $this->Session->write("member_info","");
    $this->member_id = 1;
  }

  function insert_request($member_id){
    //自分のlv以下のbankを選択
    $member_data = $this->Member->findById($member_id);
    $lv = $member_data['Member']['lv'];
    if (empty($lv)){
      $lv = 1;
    }
    $bank_data = $this->StructureSql->select_rand_banks(1);
    $bank_id = $bank_data[0]['banks']['id'];
    $bank_name = $bank_data[0]['banks']['name'];
    $bank_lv = $bank_data[0]['banks']['lv'];
    $bank_country = $bank_data[0]['banks']['country_name'];
    $bank_max_spell = $bank_data[0]['banks']['max_spell'];
    $bank_max_count = $bank_data[0]['banks']['max_count'];
    //自分が選択した地図のマップIDからアイテムをランダムで選択する
    $treasure_data = $this->StructureSql->select_rand_treasures_by_map_id(1);
    $treasure_id = $treasure_data[0]['treasures']['id'];
    $treasure_name = $treasure_data[0]['treasures']['name'];
    $treasure_lv = $treasure_data[0]['treasures']['lv'];
    $series_id = $treasure_data[0]['treasures']['series_id'];
    //シリーズを取得
    $series_data = $this->TreasureSerie->findById($series_id);
    $series_name = $series_data['TreasureSerie']['name'];
    //報酬を設定する
    $reward_price = (($bank_lv * 8)+($treasure_lv*100));
    //期限を決める
    $now_time = date("Y-m-d H:i:s");
    $limit_hour = rand(1,20);
    $limit_second = $limit_hour * 3600;
    $limit_time = date("Y-m-d H:i:s", strtotime($now_time." +$limit_second sec"));
    //メール内容を生成
    $request_title = '【所在情報】'.$treasure_name.'['.$series_name.']の在処がわかった..';
    $star_txt = '';
    for($i=0;$i<$bank_lv;$i++){
      $star_txt.='★';
    }
    $request_txt = '長年探していた「'.$treasure_name.'」の在処を発見したので連絡する。<br><br>場所:'.$bank_name.'の遺跡。<br>期限：'.$limit_hour.'時間後['.$limit_time.']<br>難易度:'.$star_txt.'(Lv'.$bank_lv.')<br>[開錠コード:'.$bank_max_spell.'桁/回数:'.$bank_max_count.']<br>報酬：＄'.$reward_price.'/'.$reward_exp.'Exp<br> By 情報屋のMr.jornson ';
    //キーワードを生成
    $rand_number = $this->keyword_maker($bank_max_spell);
    $first_spell_id = $rand_number[0];
    $second_spell_id = $rand_number[1];
    $third_spell_id = $rand_number[2];
    $data = array(
      'MemberRequest' => array(
        'member_id' => $member_id,
        'title' => $request_title,
        'message_body' => $request_txt,
        'bank_id' => $bank_id,
        'all_distance' => 100,
        'process_status' => 0,
        'read_flag' => 0,
        'challenge_count' => 0,
        'max_challenge_count' => $bank_max_count,
        'max_spell' => $bank_max_spell,
        'first_spell_id' => $first_spell_id,
        'second_spell_id' => $second_spell_id,
        'third_spell_id' => $third_spell_id,
        'treasure_id' => $treasure_id,
        'treasure_name' => $treasure_name,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s"),
        'information_flag' => 0,
        'limit_time' => "$limit_time",
        'limit_hour' => $limit_hour,
        'number_suggest_flag' => 0,
        'reward_price' => $reward_price
      )
    );
    $this->MemberRequest->save($data);
  }

  function keyword_maker($max_spell){
    $rand_number = array();
    for ($i=0; $i<$max_spell; $i++) $nums[$i] = $i+1;
      for ($i=0; $i<$max_spell; $i++) {
        $j = mt_rand(0,$max_spell-1);
        $tmp = $nums[$j];
        $nums[$j] = $nums[$i];
        $nums[$i] = $tmp;
      }
      for ($i=0; $i<3; $i++) {
        $num = $nums[$i];
        $rand_number[$i] = $num-1;
      }
    return $rand_number;
  }

}
