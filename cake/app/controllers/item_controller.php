<?php
//facebook

class ItemController extends AppController{

  var $uses = array('StructureSql','Member','Message');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $datas = $this->MemberItem->findByMemberId();
    $this->set('datas',$datas);
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}