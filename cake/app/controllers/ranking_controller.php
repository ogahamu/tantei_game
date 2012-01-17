<?php

class RankingController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->Member->findAll(null, null, 'sum_exp desc',15,0);
    $this->set('data',$data);
  }

  function self_rank(){


  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}