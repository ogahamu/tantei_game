<?php
//facebook

class GachaController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];



  }

  function do_gacha(){


  }

  function exe_gacha(){


  }

  function session_manage(){
    //テスト時は下記２行を追記
    //$data['id']=1;
    //$this->Session->write("member_info",$data);

    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}