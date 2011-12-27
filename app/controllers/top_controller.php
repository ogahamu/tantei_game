<?php
//facebook

class TopController extends AppController{

  var $uses = array('MemberTreasure','StructureSql','Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $this->Session->write('spell_data','');
    //セッションから会員番号を取得
    $mdata = $this->Member->findById($member_id);
    //アバターがない場合は設定画面へ誘導
    $avater_id = $mdata['Member']['avater_id'];
    if($avater_id == 0){
      $this->redirect('/top/change_avatar/');
    }
    //各条件設定
    $power = $mdata['Member']['power'];
    $mission_count = $mdata['Member']['mission_count'];
    $success_count = $mdata['Member']['success_count'];
    $mistake_count = $mdata['Member']['mistake_count'];
    $this->set('mdata',$mdata);
    //ランク情報
    $srrdata = $this->StructureSql->select_result_rank($member_id);
    $this->set('srrdata',$srrdata);
    $ranking_data = $this->StructureSql->select_member_ranking_count($member_id);
    $all_member_count = $this->Member->findCount();
    $this->set('ranking_txt',$ranking_data[0][0]['count'].'/'.$all_member_count);
    $cdata = $this->StructureSql->select_count_compleate_treasure($member_id);
    $compleate_count = $cdata[0][0]['count'];
    $this->set('compleate_count',$compleate_count);
    $treasure_count = $this->MemberTreasure->find('count', array('conditions' => array('member_id' => $member_id)));
    $this->set('treasure_count',$treasure_count);
    $max_power = $mdata['Member']['power'];
    $member_request_id = $mdata['Member']['member_request_id'];
    if($power==0){
      $message = 'no power';
    }
    if($member_request_id ==0){
      $message = 'no request,please select';
    }
    $gage_power = ceil($power/$max_power*100);
    $this->set('avater_id',$avater_id);
    $this->set('power',$gage_power);
    $this->set('message',$message);
    $this->Session->write('ActionFlag',0);
    //読んでないリクエストの件数を表示
    $no_read_count = $this->MemberRequest->findCount(array("member_id"=>$member_id,"read_flag"=>0));
    if($no_read_count>0){
      $this->set('no_read','<a href="/cake/request/top/">'.$no_read_count.'件の新着があります。</a>');
    }else{
      $this->set('no_read','');
    }
  }

  function profile(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $this->Session->write('spell_data','');
    //セッションから会員番号を取得
    $mdata = $this->Member->findById($member_id);
    $power = $mdata['Member']['power'];
    $mission_count = $mdata['Member']['mission_count'];
    $success_count = $mdata['Member']['success_count'];
    $mistake_count = $mdata['Member']['mistake_count'];
    $this->set('mdata',$mdata);
    //ランク情報
    $srrdata = $this->StructureSql->select_result_rank($member_id);
    $this->set('srrdata',$srrdata);
    $cdata = $this->StructureSql->select_count_compleate_treasure($member_id);
    $compleate_count = $cdata[0][0]['count'];
    $this->set('compleate_count',$compleate_count);
    $treasure_count = $this->MemberTreasure->find('count', array('conditions' => array('member_id' => $member_id)));
    $this->set('treasure_count',$treasure_count);
    $max_power = $mdata['Member']['power'];
    $member_request_id = $mdata['Member']['member_request_id'];
    if($power==0){
      $message = 'no power';
    }
    if($member_request_id ==0){
      $message = 'no request,please select';
    }
    $ranking_data = $this->StructureSql->select_member_ranking_count($member_id);
    $all_member_count = $this->Member->findCount();
    $this->set('ranking_txt',$ranking_data[0][0]['count'].'/'.$all_member_count);

    $this->set('power',ceil($power/$max_power*100));
    $this->set('message',$message);
    $this->Session->write('ActionFlag',0);
    //読んでないリクエストの件数を表示
    $no_read_count = $this->MemberRequest->findCount(array("member_id"=>$member_id,"read_flag"=>0));
    if($no_read_count>0){
      $this->set('no_read','<a href="/cake/request/top/">'.$no_read_count.'件の新着があります。</a>');
    }else{
      $this->set('no_read','');
    }
  }

  function enemy_list(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function go(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById();
    $power = $mdata['Member']['power'];
    $power -= 100;
  }

  function change_avatar(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function change_avatar_execute(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $avater_id = $this->params['data']['avater_id'];
    $data = array(
      'id' => $member_id,
      'avater_id' => $avater_id,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    $this->redirect('/top/top/');
  }

  function help(){


  }

  function help2(){


  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}