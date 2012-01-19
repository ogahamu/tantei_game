<?php

class MessageController extends AppController{

  var $uses = array('StructureSql','Member','Message');
  var $session_data;
  var $components = array('Pager');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data1 = $this->Message->find('all',array('conditions'=>array("member_id"=>$member_id,"genre_id"=>1),'order'=>array('id desc'),'limit'=>3,'page'=>0));
    $data2 = $this->Message->find('all',array('conditions'=>array("member_id"=>$member_id,"genre_id"=>2),'order'=>array('id desc'),'limit'=>3,'page'=>0));
    $data3 = $this->Message->find('all',array('conditions'=>array("member_id"=>$member_id,"genre_id"=>3),'order'=>array('id desc'),'limit'=>3,'page'=>0));
    $data4 = $this->Message->find('all',array('conditions'=>array("member_id"=>$member_id,"genre_id"=>4),'order'=>array('id desc'),'limit'=>3,'page'=>0));
    $this->StructureSql->update_message_read_flag($member_id);
    $this->set('data1',$data1);
    $this->set('data2',$data2);
    $this->set('data3',$data3);
    $this->set('data4',$data4);
  }

  function detail($genre_id){
    $data = $this->Message->find('all',array("member_id"=>$member_id,"genre_id"=>$genre_id),null,'id desc',10);
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