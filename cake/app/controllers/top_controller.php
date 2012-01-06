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
    //LVアップのときは画面遷移する
    $lv_up_flag = $mdata['Member']['lv_up_flag'];
    if($lv_up_flag == 1){
      $this->redirect('/top/lv_up/');
    }
    //各条件設定
    $power = $mdata['Member']['power'];
    //ランク情報
    $ranking_data = $this->StructureSql->select_member_ranking_count($member_id);
    $all_member_count = $this->Member->findCount();
    $max_power = $mdata['Member']['power'];
    $member_request_id = $mdata['Member']['member_request_id'];
    $gage_power = ceil($power/$max_power*100);
    //各種メッセージの表示
    $message_txt = '';
    if($power<=50){
      $message_txt .= '●体力がなくなりました。<a href="/cake/product/power_charge/">栄養ドリンクを飲む</a>か１５分程待って下さい。<br>';
    }
    if($member_request_id ==0){
      $message_txt .= '●<a href="/cake/request/top/">メール</a>を読んでミッションを決定しましょう。<br>';
    }
    //読んでないリクエストの件数を表示
    $no_read_count = $this->MemberRequest->findCount(array("member_id"=>$member_id,"read_flag"=>0));
    if($no_read_count>0){
      $message_txt .= '<a href="/cake/request/top/">●'.$no_read_count.'件の未読メールがあります。</a><br>';
    }
    //view
    $this->set('message_txt',$message_txt);
    $this->set('mdata',$mdata);
    $this->set('ranking_txt',$ranking_data[0][0]['count'].'/'.$all_member_count);
    $this->set('avater_id',$avater_id);
    $this->set('power',$gage_power);
    $this->Session->write('ActionFlag',0);
  }

  function profile(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //会員情報を分解
    $power = $mdata['Member']['power'];
    $mission_count = $mdata['Member']['mission_count'];
    $success_count = $mdata['Member']['success_count'];
    $mistake_count = $mdata['Member']['mistake_count'];
    $max_power = $mdata['Member']['power'];
    $member_request_id = $mdata['Member']['member_request_id'];
    //ランク情報
    $srrdata = $this->StructureSql->select_result_rank($member_id);
    $cdata = $this->StructureSql->select_count_compleate_treasure($member_id);
    $compleate_count = $cdata[0][0]['count'];
    $treasure_count = $this->MemberTreasure->find('count', array('conditions' => array('member_id' => $member_id)));
    $ranking_data = $this->StructureSql->select_member_ranking_count($member_id);
    $all_member_count = $this->Member->findCount();
    //アベレージ
    $ave_data = $this->StructureSql->select_average_point($member_id);
    $average_point = $ave_data[0][0]['average_point'];
    //view
    $this->set('srrdata',$srrdata);
    $this->set('average_point',$average_point);
    $this->set('compleate_count',$compleate_count);
    $this->set('treasure_count',$treasure_count);
    $this->set('ranking_txt',$ranking_data[0][0]['count'].'/'.$all_member_count);
    $this->set('power',ceil($power/$max_power*100));
    $this->set('mdata',$mdata);
  }

  function lv_up(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = array(
      'id' => $member_id,
      'lv_up_flag' => 0,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);

    //ユーザーエージェント判定
    $useragent_code = $this->return_useragent_code();
    if($useragent_code=='1'){
      //ios
      $this->render($layout='lv_up_svg',$file='default');
    }else{
      //android,それ以外
      $this->render($layout='lv_up_flash',$file='default');
    }
  }

  function change_avatar(){
    $this->session_manage();
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