<?php
//facebook

class ItemController extends AppController{

  var $uses = array('Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $datas = $this->MemberItem->findByMemberId();
    $this->set('datas',$datas);
  }

  function detail($member_item_id){

    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

    $datas = $this->MemberItem->findById($member_item_id);
    $this->set('datas',$datas);

  }

  function use_item($member_item_id){
    if($member_item_id==1){


    }
    if($member_item_id==2){


    }
    if($member_item_id==3){


    }
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}