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
          'power' => 500,
          'max_power' => 500,
          'lv' => 1,
          'lv_up_flag' => 0,
          'exp' => 0,
          'least_next_exp' => 0,
          'sum_exp' => 0,
          'mission_count' => 0,
          'evidence_count' => 0,
          'compleate_evidence_count' => 0,
          'avater_id' => 0,
          'insert_date' => date("Y-m-d H:i:s")
        )
      );
      $this->Member->save($data);
      $member_id = $this->Member->getLastInsertID();
      //最初の依頼を生成その１
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
    $member_data = $this->Member->findById($member_id);
    $q_data = $this->Quest->findById(1);
    $data = array(
      'MemberQuest' => array(
        'member_id' => $member_id,
        'title' => '',
        'comment' => '',
        'quest_exp' => 300,
        'quest_price' => 30,
        'resolved_flag' => 0,
        'evidence_appear_rate' => 5
        'challenge_count' => 4
        'quest_id' => 1,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->save($data);
    $member_quest_id = $this->MemberQuest->getLastInsertID();
    $data = array(
      'MemberQuestDetail' => array(
        'member_quest_id' =>$member_quest_id,
        'detail_no' => 1
        'resoluved_flag' =>0,
        'member_id' =>$member_id
        'title' =>'',
        'comment' =>'',
        'exp' =>100,
        'distance' =>0,
        'all_distance' =>100,
        'last_marker_flag' =>0,
        'quest_detail_id' =>1,
        'insert_time' =>date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuestDetail->save($data);
  }
}
