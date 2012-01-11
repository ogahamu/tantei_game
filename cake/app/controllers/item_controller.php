<?php
//facebook

class ItemController extends AppController{

  var $uses = array('StructureSql','Member','Message','MemberItem');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $datas = $this->MemberItem->findByMemberId($member_id);
    $this->set('datas',$datas);
  }

  function item_challenge_top($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //現在の挑戦回数を出す
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

    //アイテムがない場合は購入画面のリンクを出す
    $item_challenge = $mdata['Member']['item_challenge'];
    $no_itme_flag = 0;
    if($item_challenge==0){
      $no_itme_flag=1;
    }
    $this->set('member_id',$member_id);
    $this->set('no_itme_flag',$no_itme_flag);
  }

  function item_challenge_exe($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //１個増やす
    $mq_data = $this->MemberQuest->findById($member_quest_id);
    $challenge_count = $mq_data['MemberQuest']['challenge_count'];
    $challenge_count+=1;
    $data = array(
      'MemberQuest' => array(
        'id' => $member_quest_id,
        'challenge_count' => $challenge_count,
        'update_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->save($data);

    //１個減らす
    $mdata = $this->Member->findById($member_id);
    $item_challenge = $mdata['Member']['item_challenge'];
    $item_challenge-=1;
    $id = $mdata['Member']['id'];
    $data = array(
      'id' => $member_id,
      'item_challenge' => $item_challenge,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    $this->redirect('/item/item_challenge_top/');
  }

  function item_power_top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //アイテムがない場合は購入画面のリンクを出す
    $item_power = $mdata['Member']['item_power'];
    $no_itme_flag = 0;
    if($item_power==0){
      $no_itme_flag=1;
    }
    $this->set('member_id',$member_id);
    $this->set('no_itme_flag',$no_itme_flag);
  }

  function item_power_exe(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //全回復＋１個減らす
    $max_power = $mdata['Member']['max_power'];
    $item_power = $mdata['Member']['item_power'];
    $item_power-=1;
    $id = $mdata['Member']['id'];
    $data = array(
      'id' => $id,
      'power' => $max_power,
      'item_power' => $item_power,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    $this->redirect('/item/item_power_top/');
  }

  function item_star_top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //アバターがない場合は設定画面へ誘導
    $avater_id = $mdata['Member']['avater_id'];
  }

  function item_star_exe(){
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