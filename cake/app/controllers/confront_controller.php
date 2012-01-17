<?php

class ConfrontController extends AppController{

  var $uses = array('Evidence','MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $components = array('Pager');
  var $power_cost = 50;
  var $get_exp = 100;
  var $battle_get_exp = 70;
  var $battle_get_money = 15;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //$data = $this->MemberQuest->findAllByMemberId($member_id);
    $this->set('data',$data);
  }

  function battle_list(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $lv = $mdata['Member']['lv'];
    $start_lv = $lv - 5;
    $end_lv = $lv + 5;
    //レベルの近い人を選ぶ
    $data = $this->StructureSql->select_nealy_lv_members($member_id,$start_lv,$end_lv);
    $this->set('data',$data);
  }

  function battle_top($enemy_id){
    //ページステップ管理
    $this->write('PageStepNo',1);
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $own_power = $own_data['Member']['power'];
    $own_thumnail_url = $own_data['Member']['name'];
    $own_attack_power = $own_data['Member']['attack_power'];
    $own_defence_power = $own_data['Member']['defence_power'];
    $own_fortune_power = $own_data['Member']['fortune_power'];
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $enemy_thumnail_url = $enemy_data['Member']['name'];
    $enemy_attack_power = $enemy_data['Member']['attack_power'];
    $enemy_defence_power = $enemy_data['Member']['defence_power'];
    $enemy_fortune_power = $enemy_data['Member']['fortune_power'];
    //自身の攻撃力>相手の防御力
    if($own_attack_power>$enemy_defence_power){
      //勝ち
      $this->set('link_url','/cake/confront/battle_exe/result_code:1/m_e_i:/enemy_id:'.$enemy_id.'/');
    }else{
      //負け
      $this->set('link_url','/cake/confront/battle_exe/result_code:2/m_e_i:/enemy_id:'.$enemy_id.'/');
    }
    $this->set('enemy_name',$enemy_name);
    $this->set('enemy_thumnail_url',$enemy_thumnail_url);
    $this->set('power',$own_power);
  }

  function battle_exe(){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>1){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',2);

    $result_code = $this->params['named']['result_code'];
    $enemy_id = $this->params['named']['enemy_id'];
    $member_evidence_id = '';
    if($result_code==1){
      $this->set('jump_url','/cake/confront/battle_success/m_e_i:'.$member_evidence_id.'/enemy_id:'.$enemy_id);
    }else{
      $this->set('jump_url','/cake/confront/battle_fail/m_e_i:'.$member_evidence_id.'/enemy_id:'.$enemy_id);
    }
  }

  function battle_success(){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>2){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',3);

    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $own_power = $own_data['Member']['power'];
    //パラメータ取得
    $member_evidence_id = $this->params['named']['m_e_i'];
    $enemy_id = $this->params['named']['enemy_id'];
    //体力減少
    $this->update_member_power($member_id,$own_power-$this->power_cost);
    //お金&経験値付与
    $this->StructureSql->call_get_money($member_id,$this->battle_get_money,0);
    $this->StructureSql->call_get_bank_exp($member_id,$this->battle_get_exp);
    //敵の情報
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $m_title = $enemy_name.'の犯行が'.$own_name.'により暴かれた。'.$this->battle_get_exp.'Expゲット!体力：'.$own_power.'->'.$own_power-$this->power_cost;
    $e_title = $enemy_name.'の犯行が'.$own_name.'により暴かれた。';
    //それぞれにメッセージをおくる
    $this->send_message($member_id,$m_title,'',4);
    $this->send_message($enemy_id,$e_title,'',4);
    //それぞれの勝率管理
    $result_txt = $this->win_and_lose_manage($member_id,1);
    $this->win_and_lose_manage($enemy_id,2);
    $m_title .= $result_txt;
    $this->set('display_message',$m_title);
  }

  function battle_fail(){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>2){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',3);

    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $own_power = $own_data['Member']['power'];
    //パラメータ取得
    $member_evidence_id = $this->params['named']['m_e_i'];
    $enemy_id = $this->params['named']['enemy_id'];
    //敵の情報
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $added_power = $own_power-$this->power_cost;
    $m_title = $own_name.'が'.$enemy_name.'の犯行を疑ったが無実だった。体力'.$own_power.'->'.$added_power.'減少';
    $e_title = $own_name.'が'.$enemy_name.'の犯行を疑ったが無実だった。';
    //それぞれにメッセージをおくる
    $this->send_message($member_id,$m_title,'',4);
    $this->send_message($enemy_id,$e_title,'',4);
    //体力減少
    $this->update_member_power($member_id,$own_power-$this->power_cost);
    //それぞれの勝率管理
    $result_txt = $this->win_and_lose_manage($member_id,2);
    $this->win_and_lose_manage($enemy_id,1);
    $m_title .= $result_txt;
    $this->set('display_message',$m_title);
  }

  function rob_evidence(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $member_evidence_id = $this->params['named']['member_evidence_id'];
    $enemy_member_id = $this->params['named']['enemy_member_id'];
    //自分のデータを取得
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $power = $own_data['Member']['power'];
    //敵のデータを取得
    $enemy_data = $this->Member->findById($enemy_member_id);
    $enemy_thumnail_url = $enemy_data['Member']['thumnail_url'];
    $enemy_member_name = $enemy_data['Member']['name'];
    //$me_data = $this->MemberEvidence->find(array("id"=>$member_evidence_id,"member_id <>"=>$member_id));
    //$this->set('data',$me_data);
    $this->set('enemy_thumnail_url',$enemy_thumnail_url);
    $this->set('enemy_member_name',$enemy_member_name);
    $this->set('power',$power);
  }

  function rob_battle(){
    //ページステップ管理
    $this->write('PageStepNo',1);
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //パラメータを取得
    $member_evidence_id = $this->params['named']['member_evidence_id'];
    $enemy_member_id = $this->params['named']['enemy_member_id'];
    //自分のデータを取得
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $own_thumnail_url = $own_data['Member']['name'];
    $own_attack_power = $own_data['Member']['attack_power'];
    $own_defence_power = $own_data['Member']['defence_power'];
    $own_fortune_power = $own_data['Member']['fortune_power'];
    $own_power = $own_data['Member']['power'];
    //相手のデータを取得
    $me_data = $this->MemberEvidence->findById($member_evidence_id);
    $enemy_id = $me_data['MemberEvidence']['member_id'];
    $evidence_id = $me_data['MemberEvidence']['evidence_id'];
    $evidence_img_id = $me_data['MemberEvidence']['img_id'];
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $enemy_thumnail_url = $enemy_data['Member']['name'];
    $enemy_attack_power = $enemy_data['Member']['attack_power'];
    $enemy_defence_power = $enemy_data['Member']['defence_power'];
    $enemy_fortune_power = $enemy_data['Member']['fortune_power'];
    //自身の攻撃力>相手の防御力
    if($own_attack_power>$enemy_defence_power){
      //勝ち
      $this->set('link_url','/cake/confront/rob_exe/result_code:1/m_e_i:'.$member_evidence_id);
    }else{
      //負け
      $this->set('link_url','/cake/confront/rob_exe/result_code:2/m_e_i:'.$member_evidence_id);
    }
    $this->set('evidence_id',$evidence_id);
    $this->set('evidence_img_id',$evidence_img_id);
    $this->set('enemy_name',$enemy_name);
    $this->set('enemy_thumnail_url',$enemy_thumnail_url);
    $this->set('power',$own_power);
  }

  function rob_exe($result_code){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>1){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',2);
    $result_code = $this->params['named']['result_code'];
    $member_evidence_id = $this->params['named']['m_e_i'];
    if($result_code==1){
      $this->set('jump_url','/cake/confront/rob_success/'.$member_evidence_id);
    }else{
      $this->set('jump_url','/cake/confront/rob_fail/'.$member_evidence_id);
    }
  }

  function rob_success($member_evidence_id){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>2){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',3);
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_name = $enemy_data['Member']['name'];
    $own_power = $own_data['Member']['power'];
    //体力減少
    $this->update_member_power($member_id,$own_power-$this->power_cost);
    //お金&経験値付与
    $this->StructureSql->call_get_money($member_id,$this->battle_get_money,0);
    $this->StructureSql->call_get_bank_exp($member_id,$this->battle_get_exp);
    //証拠のmember_idを付け替える
    $me_data = $this->MemberEvidence->findById($member_evidence_id);
    $enemy_id = $me_data['MemberEvidence']['member_id'];
    //相手のデータを取得
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $evidence_id = $me_data['MemberEvidence']['evidence_id'];
    $ev_data = $this->Evidence->findById($evidence_id);
    $quest_id = $ev_data['Evidence']['quest_id'];
    $evidence_name = $ev_data['Evidence']['name'];
    $mq_data = $this->MemberQuest->findByQuestId($quest_id);
    $member_quest_id = $mq_data['MemberQuest']['id'];
    $medata = array(
      'MemberEvidence' => array(
        'id' => $member_evidence_id,
        'evidence_id' => $ev_data['Evidence']['id'],
        'member_id' => $member_id,
        'member_quest_id' => $member_quest_id,
        'member_quest_detail_id' => 0,
        'update_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberEvidence->save($medata);
    $m_title = $enemy_name.'の犯行が'.$own_name.'により暴かれた。'.$evidence_name.'は没収した。';
    $e_title = $enemy_name.'の犯行が'.$own_name.'により暴かれた。'.$evidence_name.'は没収された。';
    $comment = '';
    //それぞれにメッセージをおくる
    $this->send_message($member_id,$m_title,$comment,4);
    $this->send_message($enemy_id,$e_title,$comment,4);
    //それぞれの勝率管理
    $result_txt = $this->win_and_lose_manage($member_id,1);
    $this->win_and_lose_manage($enemy_id,2);
    $m_title .= $result_txt;
    $this->set('member_quest_id',$member_quest_id);
    $this->set('display_message',$m_title);
  }

  function rob_fail($member_evidence_id){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>2){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',3);
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //自分情報
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $own_money = $own_data['Member']['money'];
    $own_power = $own_data['Member']['power'];
    //体力減少
    $added_power = $own_power-$this->power_cost;
    $this->update_member_power($member_id,$own_power-$this->power_cost);
    //敵の情報
    $me_data = $this->MemberEvidence->findById($member_evidence_id);
    $evidence_id = $me_data['MemberEvidence']['evidence_id'];
    $enemy_id = $me_data['MemberEvidence']['member_id'];
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    //失敗する
    $m_title = $own_name.'が疑いをかけたが'.$enemy_name.'は無実だった。体力:'.$own_power.'->'.$added_power;
    $e_title = $own_name.'が疑いをかけたが'.$enemy_name.'は無実だった。';
    $this->send_message($member_id,$m_title,'',4);
    $this->send_message($enemy_id,$e_title,'',4);
    //それぞれの勝率管理
    $result_txt = $this->win_and_lose_manage($member_id,2);
    $title .= $result_txt;
    $this->win_and_lose_manage($enemy_id,1);
    $this->set('display_message',$m_title);
    $this->set('evidence_id',$evidence_id);
  }

  function battle(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuest->findAllByMemberId($member_id);
  }

  //1:勝利 2:敗北 3:失敗
  private function win_and_lose_manage($member_id,$genre_id){
    $m_data = $this->Member->findById($member_id);
    $win_count = $m_data['Member']['win_count'];
    $lose_count = $m_data['Member']['lose_count'];
    $mislead_count = $m_data['Member']['mislead_count'];
    $today_mislead_count = $m_data['Member']['today_mislead_count'];
    if($genre_id==1){
      $win_count+=1;
    }
    if($genre_id==2){
      $lose_count+=1;
      $mislead_count+1;
      $today_mislead_count+1;
    }
    if($genre_id==3){
      $mislead_count+=1;
      $today_mislead_count+=1;
    }
    $data = array(
      'id' => $member_id,
      'win_count' => $win_count,
      'lose_count' => $lose_count,
      'mislead_count' => $mislead_count,
      'today_mislead_count' => $today_mislead_count,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    return $win_count.'勝'.$lose_count.'敗';
  }

  private function update_member_power($member_id,$power){
    //体力減少
    $data = array(
      'id' => $member_id,
      'power' => $power,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
  }

  private function send_message($member_id,$title,$comment,$genre_id){
    //メッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => $genre_id,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
  }

  //コンプリートチェック
  private function check_evidence_compleate($member_id,$evidence_id){
    $ev_data = $this->Evidence->findById($evidence_id);
    $quest_id = $ev_data['Evidence']['quest_id'];
    $compleate_count = $ev_data['Evidence']['compleate_count'];
    $member_quest_id = $this->MemeberQuest->findByQuestId($quest_id);
    //自分が集めた証拠数
    $ev_c_data = $this->StructureSql->count_evidence_by_member_quest($member_quest_id);
    $ev_count = $ev_c_data[0][0]['count'];
    //最大数を超えていた場合には発動
    if($ev_count>=$compleate_count){
      //update_evidence
      $this->StructureSql->update_evidence_compleate_flag($member_quest_id);
      $evidence_compleate_flag=1;
    }else{
      $evidence_compleate_flag=0;
    }
    //個数をアップデート
    $mq_data = array(
      'MemberQuest' => array(
        'id' => $member_quest_id,
        'evidence_count' => $ev_count,
        'evidence_compleate_flag' => $evidence_compleate_flag,
        'update_time' =>date("Y-m-d H:i:s")
      )
    );
    $this->MemberQuest->save($mq_data);
  }

  private function return_useragent_code(){
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