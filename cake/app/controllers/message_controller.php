<?php

class MessageController extends AppController{

  var $uses = array('StructureSql','Member','Message');
  var $session_data;
  var $components = array('Pager');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //$data = $this->StructureSql->select_own_treasure_list($member_id);
    $this->Message->findAllByMemberId($member_id,null,'id desc');
    $this->set('data',$data);
  }

  function return_useragent_code(){
    $isiPhone = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPhone');
    $isiPod = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPod');
    $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');
    $isAndroid = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Android');
    if($isiPad){return 1;}
    else if($isiPod){return 1;}
    else if($isiPhone){return 1;}
    else if($isAndroid){return 2;}
    else{return 2;}
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}