<?php

class ConfrontController extends AppController{

  var $uses = array('MemeberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $components = array('Pager');


  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuest->findAllByMemberId($member_id);
    $this->set('data',$data);
  }

  function rob_evidence($member_evidence_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $me_data = $this->MemeberEvidence->findById($member_evidence_id);
    $this->set('data',$me_data);
  }

  function rob_battle($member_evidence_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //自分のデータを取得
    $own_data = $this->Member->findById($enemy_id);
    $own_name = $own_data['Member']['name'];
    $own_thumnail_url = $own_data['Member']['name'];
    $own_attack_power = $own_data['Member']['attack_power'];
    $own_defence_power = $own_data['Member']['defence_power'];
    $own_fortune_power = $own_data['Member']['fortune_power'];
    //相手のデータを取得
    $me_data = $this->MemeberEvidence->findById($member_evidence_id);
    $enemy_id = $me_data['MemeberEvidence']['member_id'];
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    $enemy_thumnail_url = $enemy_data['Member']['name'];
    $enemy_attack_power = $enemy_data['Member']['attack_power'];
    $enemy_defence_power = $enemy_data['Member']['defence_power'];
    $enemy_fortune_power = $enemy_data['Member']['fortune_power'];
    //自身の攻撃力>相手の防御力
    if($own_attack_power>$enemy_defence_power){
      //勝ち
    }else{
      //負け
    }
  }

  function rob_success($member_evidence_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_name = $enemy_data['Member']['name'];
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
    //それぞれにメッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $enemy_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => $member_quest_id,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => '',
        'genre_id' => $member_quest_id,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
  }

  function rob_fail($member_evidence_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $own_data = $this->Member->findById($member_id);
    $own_name = $own_data['Member']['name'];
    $today_mislead_count = $own_data['Member']['today_mislead_count'];
    $today_mislead_count+=1;


    $me_data = $this->MemeberEvidence->findById($member_evidence_id);
    $enemy_id = $me_data['MemeberEvidence']['member_id'];
    $enemy_data = $this->Member->findById($enemy_id);
    $enemy_name = $enemy_data['Member']['name'];
    //失敗する
    $title = $own_name.'が疑いをかけた'.$enemy_name.'は無実だった。';
    $comment = $enemy_name.'に対する疑いが深まった...';
    //それぞれにメッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $enemy_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => $member_quest_id,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => '',
        'genre_id' => $member_quest_id,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);

    //３回超えた
    if($today_mislead_count>=3){



    }
  }

  function battle(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuest->findAllByMemberId($member_id);
  }

  function success(){
    $data = array(
      'Messages' => array(
        'member_id' => $member_id,
        'title' => '',
        'comment' => '',
        'genre_id' => 1,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->create();
    $this->MemberQuest->save($data);
  }

  function miss(){
    $data = array(
      'Messages' => array(
        'member_id' => $member_id,
        'title' => '',
        'comment' => '',
        'genre_id' => 1,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->create();
    $this->MemberQuest->save($data);
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