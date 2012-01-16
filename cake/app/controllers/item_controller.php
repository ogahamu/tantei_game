<?php
//facebook

class ItemController extends AppController{

  var $uses = array('Evidence','MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $item_challenge_get_price=100;

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
    $money = $mdata['Member']['money'];
    //現在の挑戦回数を出す
    $mqdata = $this->MemberQuest->findById($member_quest_id);
    $quest_id = $mqdata['MemberQuest']['quest_id'];
    //犯人が残した証拠
    $challenge_count = $mqdata['MemberQuest']['challenge_count'];
    //自分が集めた証拠
    $ev_c_data = $this->StructureSql->count_evidence_by_member_quest($member_quest_id);
    $ev_count = $ev_c_data[0][0]['count'];
    //足した証拠の数
    $max_challenge_count = $challenge_count + $ev_count;
    $this->set('ev_count',$ev_count);
    $this->set('challenge_count',$challenge_count);
    $this->set('max_challenge_count',$max_challenge_count);
    //アイテムがない場合は購入画面のリンクを出す
    $item_challenge = $mdata['Member']['item_challenge'];
    $no_item_flag = 0;
    if($item_challenge<=0){
      $no_item_flag=1;
    }
    $this->set('money',$money);
    $this->set('member_quest_id',$member_quest_id);
    $this->set('member_id',$member_id);
    $this->set('amount',$challenge_count);
    $this->set('no_item_flag',$no_item_flag);
  }

  function item_challenge_top(){

  }


  function item_challenge_get(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    $money = $money - $this->item_challenge_get_price;
    //お金を減らす
    $id = $mdata['Member']['id'];
    $data = array(
      'id' => $id,
      'money' => $mixi_account_id,
      'thumnail_url' => $mixi_thumbnail,
      'name' => $mixi_name,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    //ゲットする
    $this->insert_item(2);
    $this->redirect('/item/item_challenge_top/');
  }

  function insert_item($item_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    if(strlen($item_id)==0){
      $item_id = mt_rand(1,3);
    }
    $item_power = $mdata['Member']['item_power'];
    $item_challenge = $mdata['Member']['item_challenge'];
    $item_star = $mdata['Member']['item_star'];
    if($item_id==1){
      $item_power+=1;
    }elseif($item_id==2){
      $item_challenge+=1;
    }elseif($item_id==2){
      $item_star+=1;
    }
    $id = $mdata['Member']['id'];
    $data = array(
      'id' => $member_id,
      'item_power' => $item_power,
      'item_challenge' => $item_challenge,
      'item_star' => $item_star,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    return $item_id;
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
    $power = $mdata['Member']['power'];
    $max_power = $mdata['Member']['max_power'];
    $money = $mdata['Member']['money'];
    //パワーがあるかないかで表示を変える
    $no_power_flag=0;
    $least_time='';
    if($power<50){
      $no_power_flag=1;
      //パワー回復までの時間表示
      $least_power = ($max_power-$power);
      $least_hour = ceil($least_power/60);
      $least_minits = ceil($least_power%60);
      $least_time = $least_hour.'時間'.$least_minits.'分';
    }
    $this->set('no_power_flag',$no_power_flag);
    $this->set('least_time',$least_time);
    //アイテムがない場合は購入画面のリンクを出す
    $item_power = $mdata['Member']['item_power'];
    $no_itme_flag = 0;
    if($item_power<=0){
      $no_itme_flag=1;
    }
    $this->set('money',$money);
    $this->set('member_id',$member_id);
    $this->set('amount',$item_power);
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
    $money = $mdata['Member']['money'];
    $this->set('money',$money);

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