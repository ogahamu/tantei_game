<?php

class ConfrontController extends AppController{

  var $uses = array('MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $components = array('Pager');
  var $power_cost = 50;
  var $get_exp = 100;

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

  function battle_top($enemy_member_id){
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
    $enemy_data = $this->Member->findById($enemy_member_id);
    $enemy_name = $enemy_data['Member']['name'];
    $enemy_thumnail_url = $enemy_data['Member']['name'];
    $enemy_attack_power = $enemy_data['Member']['attack_power'];
    $enemy_defence_power = $enemy_data['Member']['defence_power'];
    $enemy_fortune_power = $enemy_data['Member']['fortune_power'];
    //自身の攻撃力>相手の防御力
    if($own_attack_power>$enemy_defence_power){
      //勝ち
      $this->set('link_url','/cake/confront/battle_exe/1/');
    }else{
      //負け
      $this->set('link_url','/cake/confront/battle_exe/2/');
    }
    $this->set('enemy_name',$enemy_name);
    $this->set('enemy_thumnail_url',$enemy_thumnail_url);
    $this->set('power',$own_power);
  }

  function battle_exe($result_code){
    if($result_code==1){
      $this->set('jump_url','/cake/confront/battle_success/'.$member_evidence_id);
    }else{
      $this->set('jump_url','/cake/confront/battle_fail/'.$member_evidence_id);
    }
  }

  function battle_success(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_power = $own_data['Member']['power'];
    //体力減少
    $this->update_member_power($member_id,$own_power-$this->power_cost);
    //経験値付与
    $this->get_money($member_id,5,$this->get_exp);
  }

  function battle_fail(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_power = $own_data['Member']['power'];
    $money = $own_data['Member']['money'];
    $mislead_count = $own_data['Member']['mislead_count'];
    $today_mislead_count = $own_data['Member']['today_mislead_count'];
    //ミス回数加算
    $mislead_count+=1;
    $today_mislead_count+=1;
    //3回以上でお金没収[1/10]
    if($today_mislead_count>=3){
      $penalty_price = ceil($money/10);
      $money = ceil($money- $penalty_price);
      $title = '１日に３回以上の間違い捜査は罰金です。＄'.$penalty_price.'没収！';
      $comment = '';
      $this->send_message($enemy_id,$title,$comment,4);
    }
    //体力減少
    $this->update_member_power($member_id,$own_power-$this->power_cost);
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
    $enemy_id = $me_data['MemeberEvidence']['member_id'];
    $evidence_id = $me_data['MemeberEvidence']['evidence_id'];
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $enemy_thumnail_url = $enemy_data['Member']['name'];
    $enemy_attack_power = $enemy_data['Member']['attack_power'];
    $enemy_defence_power = $enemy_data['Member']['defence_power'];
    $enemy_fortune_power = $enemy_data['Member']['fortune_power'];
    //自身の攻撃力>相手の防御力
    if($own_attack_power>$enemy_defence_power){
      //勝ち
      $this->set('link_url','/cake/confront/rob_exe/1/');
    }else{
      //負け
      $this->set('link_url','/cake/confront/rob_exe/2/');
    }
    $this->set('evidence_id',$evidence_id);
    $this->set('enemy_name',$enemy_name);
    $this->set('enemy_thumnail_url',$enemy_thumnail_url);
    $this->set('power',$own_power);
  }

  function rob_exe($result_code){
    if($result_code==1){
      $this->set('jump_url','/cake/confront/rob_success/'.$member_evidence_id);
    }else{
      $this->set('jump_url','/cake/confront/rob_fail/'.$member_evidence_id);
    }
  }

  function rob_success($member_evidence_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_name = $enemy_data['Member']['name'];
    $own_power = $own_data['Member']['power'];
    //体力減少
    $this->update_member_power($member_id,$own_power-$this->power_cost);
    //経験値付与
    $this->get_money($member_id,5,$this->get_exp);
    //証拠のmember_idを付け替える
    $me_data = $this->MemeberEvidence->findById($member_evidence_id);
    $enemy_id = $me_data['MemeberEvidence']['member_id'];
    //相手のデータを取得
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $evidence_id = $me_data['MemeberEvidence']['evidence_id'];
    $ev_data = $this->Evidence->findById($evidence_id);
    $quest_id = $ev_data['Evidence']['quest_id'];
    $mq_data = $this->MemberQuest->findByQuestId($quest_id);
    $member_quest_id = $mq_data['MemberQuest']['id'];
    $medata = array(
      'MemberEvidence' => array(
        'id' => $member_evidence_id,
        'evidence_id' => $ev_data[0]['evidences']['id'],
        'member_id' => $member_id,
        'member_quest_id' => $member_quest_id,
        'member_quest_detail_id' => 0,
        'update_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberEvidence->save($medata);
    $title = $enemy_name.'の犯行が'.$own_name.'により暴かれた。';
    $comment = '証拠は'.$own_name.'が没収しました。';
    //それぞれにメッセージをおくる
    $this->send_message($enemy_id,$title,$comment,4);
    $this->send_message($member_id,$title,$comment,4);
  }

  function rob_fail($member_evidence_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //自分情報
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $own_money = $own_data['Member']['money'];
    $mislead_count = $own_data['Member']['mislead_count'];
    $today_mislead_count = $own_data['Member']['today_mislead_count'];
    $today_mislead_count+=1;
    $mislead_count+=1;
    $own_power = $own_data['Member']['power'];
    //体力減少
    $this->update_member_power($member_id,$own_power-$this->power_cost);
    //敵の情報
    $me_data = $this->MemeberEvidence->findById($member_evidence_id);
    $enemy_id = $me_data['MemeberEvidence']['member_id'];
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    //失敗する
    $title = $own_name.'が疑いをかけたが'.$enemy_name.'は無実だった。';
    $comment = $enemy_name.'に対する疑いが深まった...';
    $this->send_message($enemy_id,$title,$comment,4);
    $this->send_message($member_id,$title,$comment,4);
    //３回超えた
    if($today_mislead_count>=3){
      $penalty_price = ceil($own_money/10);
      $own_money = ceil($money- $penalty_price);
      $title = '１日に３回以上の間違い捜査は罰金です。＄'.$penalty_price.'没収！';
      $comment = '';
      $this->send_message($enemy_id,$title,$comment,4);
      $today_mislead_count = 1;
    }
    //会員情報
    $data = array(
      'id' => $member_id,
      'mislead_count' => $mislead_count,
      'today_mislead_count' => 0,
      'money' => $own_money,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
  }

  function battle(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuest->findAllByMemberId($member_id);
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