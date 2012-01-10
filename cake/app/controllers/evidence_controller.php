<?php

class EvidenceController extends AppController{

  var $uses = array('StructureSql','Member','Message');
  var $session_data;
  var $components = array('Pager');


  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_own_evidence_list($member_id);
    $this->set('data',$data);
  }

  function detail($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $qdata = $this->Quest->findById($quest_id);
    $data = $this->StructureSql->select_own_evidence_detail($member_id,$quest_id);

    $cdata = $this->StructureSql->select_own_evidence_count($member_id,$quest_id);
    $compleate_count = $cdata[0][0]['count'];
    $comp_flag =0;
    if($compleate_count == 5){
      $comp_flag =1;
    }
    //view
    $this->set('comp_flag',$comp_flag);
    $this->set('title_name',$qdata['Quest']['quest_title']);
    //$this->set('genre_id',$qdata['Quest']['id']);
    $this->set('data',$data);
  }

  function series($order_code){
    $this->session_manage();
    //セッションから会員番号を取得
    if(strlen($order_code)==0){
      $order_code = 1;
    }
    $member_id = $this->session_data['id'];
    if($order_code==1){
      $data = $this->StructureSql->select_own_queset_list($member_id);
    }else{
      $data = $this->StructureSql->select_own_queset_list($member_id);
      //$data = $this->StructureSql->select_own_queset_list_order_insert_time($member_id);
    }
    $cdata = $this->StructureSql->select_count_compleate_quest($member_id);
    $compleate_count = $cdata[0][0]['count'];
    $this->set('compleate_count',$compleate_count);
    $this->set('data',$data);
  }

  function treasure_list(){
    $data = $this->StructureSql->select_treasure_series_list();
    $this->set('data',$data);
  }

  function item_own_user($treasure_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_list_treasure_own_user($treasure_id);
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