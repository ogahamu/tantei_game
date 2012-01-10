<?php
class BossQuestController extends AppController{

  var $uses = array('StructureSql','Member','Message');
  var $session_data;

  function top($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $qdata = $this->MemberQuest->findById($member_quest_id);
    $quest_id = $qdata['MemberQuest']['quest_id'];
    $this->Session->write('QuestId',$quest_id);
    //パワー増減+実績の登録
    $mdata = $this->Member->findById($member_id);
    $power = $mdata['Member']['power'];
    //power減らす
    $power -= 50;
    $data = array(
      'Member' => array(
        'id' => $member_id,
        'power' => $power,
        'rob_success_count'=>$rob_success_count,
        'rob_mistake_count'=>$rob_mistake_count,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($data);
  }

  function win(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //経験値を取得
    $this->StructureSql->call_get_bank_exp($member_id,$add_exp);
    //新しいクエストを作成
    $quest_id = $this->Session->read('QuestId');
    $quest_id+1;
    $this->build_new_quest($quest_id);
  }

  function build_new_quest($new_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //クエストIDが存在するかチェックする
    $qdata = $this->Quest->findCountById($new_quest_id);
    if($qdata==0){
      //存在しない場合はクエストがありません画面へ
      $this->redirect('/quest/no_queset/');
    }
    $q_data = $this->Quest->findById($new_quest_id);
    $data = array(
      'MemberQuest' => array(
        'quest_id' => $q_data['Quest']['id'],
        'resoluved_flag' => 0,
        'challenge_count' => 3,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->save($data);
    $data = array(
      'MemberQuestDetail' => array(
        'distance' => 0,
        'resoleved_flag' => 0,
        'quest_id' => 1,
        'member_quest_id' => 1,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuestDetail->save($data);
  }

  function lose(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}