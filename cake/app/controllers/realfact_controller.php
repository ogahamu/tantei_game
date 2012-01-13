<?php
class RealfactController extends AppController{

  var $uses = array('MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $attack_cost=50;

  function top($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function already_end(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function win($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function lose($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function send_message($member_id,$title,$comment){
    //メッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => 1,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}