<?php
//facebook

class ItemController extends AppController{

  var $uses = array('Evidence','MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $item_challenge_price=100;
  var $item_power_price=100;
  var $item_star_price=100;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    $this->set('money',$money);
  }

  //回復＿トップ
  function item_power_top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $power = $mdata['Member']['power'];
    $max_power = $mdata['Member']['max_power'];
    $money = $mdata['Member']['money'];
    $after_money = $money-$this->item_power_price;
    //パワーがあるかないかで表示を変える
    $no_power_flag=0;
    $least_time='';
    if($power<50){
      $no_power_flag=1;
    }
    //パワー回復までの時間表示
    $least_power = ($max_power-$power);
    $least_hour = ceil($least_power/60);
    $least_minits = ceil($least_power%60);
    $least_time = $least_hour.'時間'.$least_minits.'分';
    //アイテムがない場合は購入画面のリンクを出す
    $item_power = $mdata['Member']['item_power'];
    $no_itme_flag = 0;
    if($item_power<=0){
      $no_itme_flag=1;
    }
    $this->set('least_time',$least_time);
    $this->set('no_power_flag',$no_power_flag);
    $this->set('power',$power);
    $this->set('max_power',$max_power);
    $this->set('money',$money);
    $this->set('after_money',$after_money);
    $this->set('member_id',$member_id);
    $this->set('amount',$item_power);
    $this->set('no_itme_flag',$no_itme_flag);
  }

  //回復_購入
  function item_power_get(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    //残高チェック
    $item_power_price = $this->item_power_price;
    if($money>=$item_power_price){
      $money = $money-$this->item_power_price;
      //ゲットする member,item(1.回復 2.武器 3.本),count
      $this->update_item_count($member_id,1,1);
      //お金を減らす
      $this->pay_money($member_id,$money);
    }
    $this->redirect('/item/item_power_top/');
  }

  //回復＿使用
  function item_power_exe(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //下記操作はパワーが満タンの場合は弾く
    $power = $mdata['Member']['power'];
    $item_power = $mdata['Member']['item_power'];
    $max_power = $mdata['Member']['max_power'];
    if(($max_power>$power)&&($item_power>0)){
      //全回復＋１個減らす
      $max_power = $mdata['Member']['max_power'];
      $data = array(
        'id' => $member_id,
        'power' => $max_power,
        'update_date' => date("Y-m-d H:i:s")
      );
      $this->Member->save($data);
      //アイテムを使用し、減らす member,item(1.回復 2.武器 3.本),count
      $this->update_item_count($member_id,1,-1);
    }
    $this->redirect('/item/item_power_top/');
  }

  //武器_トップ
  function item_challenge_top($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    $item_challenge = $mdata['Member']['item_challenge'];
    $after_money = $money-$this->item_challenge_price;
    if(strlen($member_quest_id)>0){
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
    }
    $this->set('money',$money);
    $this->set('after_money',$after_money);
    $this->set('member_quest_id',$member_quest_id);
    $this->set('member_id',$member_id);
    $this->set('amount',$challenge_count);
    $this->set('item_challenge',$item_challenge);
    $this->set('no_item_flag',$no_item_flag);
  }

  //武器_購入
  function item_challenge_get(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    //残高チェック
    if($money>=$this->item_challenge_price){
      $money = $money-$this->item_challenge_price;
      //ゲットする member,item(1.回復 2.武器 3.本),count
      $this->update_item_count($member_id,2,1);
      //お金を減らす
      $this->pay_money($member_id,$money);
    }
    $this->redirect('/item/item_challenge_top/');
  }

  //武器_使用
  function item_challenge_exe($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    if(strlen($member_quest_id)==0){
      $this->redirect('/item/item_challenge_top/');
    }
    //挑戦回数を１個増やす
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
    //アイテムを使用し、減らす member,item(1.回復 2.武器 3.本),count
    $this->update_item_count($member_id,2,-1);
    $this->redirect('/item/item_challenge_top/'.$member_quest_id);
  }

  //本＿トップ
  function item_star_top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //アバターがない場合は設定画面へ誘導
    $avater_id = $mdata['Member']['avater_id'];
    $money = $mdata['Member']['money'];
    $item_star = $mdata['Member']['star_count'];
    $after_money = $money-$this->item_star_price;
    $this->set('money',$money);
    $this->set('item_star',$item_star);
    $this->set('after_money',$after_money);
  }

  //本＿購入
  function item_star_get(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    //残高チェック
    if($money>=$this->item_challenge_price){
      $money = $money-$this->item_star_price;
      //ゲットする member,item(1.回復 2.武器 3.本),count
      $this->update_item_count($member_id,3,1);
      //お金を減らす
      $this->pay_money($member_id,$money);
    }
    $this->redirect('/item/item_star_top/');
  }

  //本＿使用
  function item_star_exe(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //ゲットする member,item(1.回復 2.武器 3.本),count
    $this->update_item_count($member_id,3,-1);
  }

  //支払に使用。moneyは計算後の残高
  private function pay_money($member_id,$money){
    $data = array(
      'id' => $member_id,
      'money' => $money,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
  }

  //アイテム追加＆使用 $add_count:変更個数[1で１個追加、-1で１個減らす]
  private function update_item_count($member_id,$item_id,$add_count){
    $mdata = $this->Member->findById($member_id);
    if(strlen($item_id)==0){
      $item_id = mt_rand(1,3);
    }
    $item_power = $mdata['Member']['item_power'];
    $item_challenge = $mdata['Member']['item_challenge'];
    $item_star = $mdata['Member']['item_star'];
    if($item_id==1){
      $item_power+=$add_count;
    }elseif($item_id==2){
      $item_challenge+=$add_count;
    }elseif($item_id==3){
      $item_star+=$add_count;
    }
    $id = $mdata['Member']['id'];
    $data = array(
      'id' => $member_id,
      'item_power' => $item_power,
      'item_challenge' => $item_challenge,
      'star_count' => $item_star,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    return $item_id;
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}