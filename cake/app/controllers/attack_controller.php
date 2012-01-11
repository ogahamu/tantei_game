<?php
class AttackController extends AppController{

  var $uses = array('MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function top($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mqdata = $this->MemberQuest->findById($member_quest_id);
    $quest_id = $mqdata['MemberQuest']['quest_id'];

    //最大のチャレンジ可能数を決定する
    $challenge_count = $mqdata['MemberQuest']['challenge_count'];
    //集めた証拠の数
    $me_count = $this->StructureSql->select_count_group_evidence_id($member_id,$member_quest_id);
    $max_challenge_count = $challenge_count + $me_count[0][0]['count'];
    $this->set('challenge_count',$challenge_count);
    $this->set('me_count',$me_count[0][0]['count']);
    $this->set('max_challenge_count',$max_challenge_count);

    $resolved_flag = $mqdata['MemberQuest']['resolved_flag'];
    if($resolved_flag==1){
      $this->redirect('/attack/already_end/');
    }
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
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($data);
    $this->set('quest_id',$quest_id);
  }



  function already_end(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

  }

  function win($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //quest_idがうまく受け取れない場合はエラー
    if(strlen($quest_id)==0){
      $this->redirect('/quest/no_queset/');
    }
    //経験値を取得
    $add_exp = 100;
    //$this->StructureSql->call_get_bank_exp($member_id,$add_exp);
    //新しいクエストを作成
    //$quest_id = $this->Session->read('QuestId');
    //今のクエストを済にする
    $data = array(
      'MemberQuest' => array(
        'id' => $member_id,
        'resolved_flag' => 1,
        'update_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->save($data);
    //次のクエストID
    $next_quest_id = $quest_id + 1;
    //クエストIDが存在するかチェックする
    $qdata = $this->Quest->findById($next_quest_id);
    if(count($qdata)==0){
      //存在しない場合はクエストがありません画面へ
      $this->redirect('/quest/no_queset/');
    }
    //既にこのクエストIDを持っていないか検査する
    $mq_data = $this->MemberQuest->findCount(array("quest_id"=>$next_quest_id));
    if($mq_data==0){
      //$q_data = $this->Quest->findById($next_quest_id);
      $data = array(
        'MemberQuest' => array(
          'member_id' => $member_id,
          'title' => $qdata['Quest']['title'],
          'comment' => $qdata['Quest']['comment'],
          'quest_exp' => $qdata['Quest']['quest_exp'],
          'quest_price' => $qdata['Quest']['quest_price'],
          'resolved_flag' => 0,
          'evidence_appear_rate' => $qdata['Quest']['evidence_appear_rate'],
          'challenge_count' => $qdata['Quest']['challenge_count'],
          'quest_id' => $next_quest_id,
          'insert_time' => date("Y-m-d H:i:s")
         )
      );
      $this->MemberQuest->create();
      $this->MemberQuest->save($data);
      $member_quest_id = $this->MemberQuest->getLastInsertID();
      $qd_data = $this->QuestDetail->find(array("quest_id"=>$next_quest_id,"detail_no"=>1));
      $data = array(
        'MemberQuestDetail' => array(
          'member_quest_id' =>$member_quest_id,
          'detail_no' => 1,
          'resoluved_flag' =>0,
          'member_id' =>$member_id,
          'title' =>$qd_data['QuestDetail']['title'],
          'comment' =>$qd_data['QuestDetail']['comment'],
          'exp' =>$qd_data['QuestDetail']['exp'],
          'distance' =>0,
          'all_distance' =>$qd_data['QuestDetail']['all_distance'],
          'last_marker_flag' =>$qd_data['QuestDetail']['last_marker_flag'],
          'quest_detail_id' =>$qd_data['QuestDetail']['id'],
          'insert_time' =>date("Y-m-d H:i:s")
         )
      );
      $this->MemberQuestDetail->save($data);
    }
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