<?php
//facebook

class TopController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
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
    $star_count = $mdata['Member']['star_count'];
    //ランク情報
    $ranking_data = $this->StructureSql->select_member_ranking_count($member_id);
    //$all_member_count = $this->Member->find('count');
    $all_member_count = 1000;
    $max_power = $mdata['Member']['max_power'];
    $gage_power = ceil($power/$max_power*100);
    //パワー回復までの時間表示
    $least_power = ($max_power-$power);
    $least_hour = ceil($least_power/60);
    $least_minits = ceil($least_power%60);
    //各種メッセージの表示
    $message_txt = '';
    if($power<=50){
      $message_txt .= '●体力がなくなりました。<a href="/cake/item/item_power_top/">栄養ドリンクを飲む</a>か休憩してください。<br>';
    }
    //読んでないリクエストの件数を表示
    $no_read_count = $this->Message->find('count',array("member_id"=>$member_id,"read_flag"=>0));
    if($no_read_count>0){
      $message_txt .= '<a href="/cake/message/top/">●'.$no_read_count.'件の未読メールがあります。</a><br>';
    }
    //ステータスの更新情報を表示する
    if($star_count>=1){
      $message_txt .= '●推理小説を読んでステータスUPできます。<a href="/cake/top/status/">図書室</a>へ入って下さい。<br>';
    }
    //view
    $this->set('least_time',$least_hour.'時間'.$least_minits.'分');
    $this->set('message_txt',$message_txt);
    $this->set('mdata',$mdata);
    $this->set('ranking_txt',$ranking_data[0][0]['count'].'/'.$all_member_count);
    $this->set('avater_id',$avater_id);
    $this->set('power',$gage_power);
    $this->Session->write('ActionFlag',0);
  }

  function status(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->Member->find("all",array('conditions'=>array("id"=>$member_id)));
    $this->set('data',$data);
  }

  function lost_way(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function status_up($genre_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->Member->findById($member_id);
    $star_count = $data['Member']['star_count'];
    if($star_count>0){
      $star_count-=1;
      $max_power = $data['Member']['max_power'];
      $attack_power = $data['Member']['attack_power'];
      $defence_power = $data['Member']['defence_power'];
      $fortune_power = $data['Member']['fortune_power'];
      /*
      power
      attack_power
      defence_power
      fortune_power
      */
      if($genre_id==1){
        $max_power+=5;
      }elseif($genre_id==2){
        $attack_power+=1;
      }elseif($genre_id==3){
        $defence_power+=1;
      }elseif($genre_id==4){
        $fortune_power+=1;
      }
      $data = array(
        'id' => $member_id,
        'max_power' => $max_power,
        'star_count' => $star_count,
        'attack_power' => $attack_power,
        'defence_power' => $defence_power,
        'fortune_power' => $fortune_power,
        'update_date' => date("Y-m-d H:i:s")
      );
      $this->Member->save($data);
    }
    $this->redirect('/top/status/');
  }


  function profile(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //会員情報を分解
    $power = $mdata['Member']['power'];
    $max_power = $mdata['Member']['power'];
    //ランク情報
    $compleate_count = $mdata['Member']['compleate_evidence_count'];
    $ranking_data = $this->StructureSql->select_member_ranking_count($member_id);
    $all_member_count = 1000;
    //view
    $this->set('compleate_count',$compleate_count);
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
    //テスト時は下記２行を追記
    $data['id']=1;
    $this->Session->write("member_info",$data);

    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}