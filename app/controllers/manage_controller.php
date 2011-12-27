<?php

class ManageController extends AppController{

  var $uses = array('StructureSql','TreasureSerie','MemberTreasure','Member','MemberRequest');
  var $session_data;
  var $components = array('Pager');

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_own_treasure_list($member_id);
    $this->set('data',$data);
  }

  function detail($series_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $sdata = $this->TreasureSerie->findById($series_id);
    $this->set('title_name',$sdata['TreasureSerie']['name']);
    $this->set('genre_id',$sdata['TreasureSerie']['id']);
    $data = $this->StructureSql->select_own_serease_detail($member_id,$series_id);
    $this->set('data',$data);
  }

  function series($order_code){
    $this->session_manage();
    //セッションから会員番号を取得
    if(strlen($order_code)==0){
      $order_code = 1;
    }
    $member_id = $this->session_data['id'];
    if($order_code==1){
      $data = $this->StructureSql->select_own_serease_list($member_id);
    }else{
      $data = $this->StructureSql->select_own_serease_list_order_insert_time($member_id);
    }
    $cdata = $this->StructureSql->select_count_compleate_treasure($member_id);
    $compleate_count = $cdata[0][0]['count'];
    $this->set('compleate_count',$compleate_count);

    $this->set('data',$data);
  }

  function bank_map(){



  }

  function treasure_list(){
    $data = $this->StructureSql->select_treasure_series_list();
    $this->set('data',$data);
  }

  function item_own_user($treasure_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_list_treasure_own_user($treasure_id);
    $this->set('data',$data);
  }

  function battle_top($member_treasure_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberTreasure->findById($member_treasure_id);
    $enemy_member_id = $data['MemberTreasure']['member_id'];
    //最終奪取時間
    $mdata = $this->Member->findById($member_id);
    $last_rob_date = $mdata['Member']['last_rob_date'];
    $emdata = $this->Member->findById($enemy_member_id);
    $enemy_member_name = $emdata['Member']['name'];
    $treasure_id = $data['MemberTreasure']['treasure_id'];
    $treasure_name = $data['MemberTreasure']['treasure_name'];
    $series_id = $data['MemberTreasure']['series_id'];
    $data['enemy_member_name'] = $enemy_member_name;
    $data['member_treasure_id'] = $member_treasure_id;
    $this->Session->write('EnemyData',$data);
    //View
    $this->set('treasure_id',$treasure_id);
    $this->set('treasure_name',$treasure_name);
    $this->set('enemy_member_name',$enemy_member_name);
  }

  function battle_execute(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $random = rand(1,3);
    $random = 1;
    if($random == 1){
      $this->redirect('/manage/win/');
    }else{
      $this->redirect('/manage/lose/');
    }
  }

  function win(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

    //セッションから相手の情報などを取り出す
    $enemy_data = $this->Session->read('EnemyData');
    $enemy_member_id = $enemy_data['MemberTreasure']['member_id'];
    $treasure_id = $enemy_data['MemberTreasure']['treasure_id'];
    $treasure_name = $enemy_data['MemberTreasure']['treasure_name'];
    $series_id = $enemy_data['MemberTreasure']['series_id'];
    $enemy_member_name = $enemy_data['enemy_member_name'];
    $member_treasure_id = $enemy_data['member_treasure_id'];
    //★自分の勝利を伝える
    $data = array(
      'id' => $member_id,
      'last_rob_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    //依頼に紐付いた宝を入手
    $tdata = array(
      'MemberTreasure' => array(
        'member_id' => $member_id,
        'treasure_id' => $treasure_id,
        'treasure_name' => $treasure_name,
        'series_id' => $series_id,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberTreasure->create();
    $this->MemberTreasure->save($tdata);
    $data = array(
      'MemberRequest' => array(
        'member_id' => $member_id,
        'title' => '【奪取成功】'.$treasure_name.'を'.$enemy_member_name.'から奪った。',
        'message_body' => 'おめでとう、遂に'.$treasure_name.'を手にいれることができたな。<br>まだこのシリーズの宝が残っているから、コンプリート目指していこう。<br>引き続き情報を提供する。本当におめでとう！',
        'bank_id' => 0,
        'all_distance' => 0,
        'process_status' => 9,
        'read_flag' => 0,
        'challenge_count' => 0,
        'max_challenge_count' => 0,
        'max_spell' => 0,
        'first_spell_id' => 0,
        'second_spell_id' => 0,
        'third_spell_id' => 0,
        'treasure_id' => $treasure_id,
        'treasure_name' => $treasure_name,
        'information_flag' => 1,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->create();
    $this->MemberRequest->save($data);
    $this->StructureSql->call_check_compleate_series($member_id);
    //★相手に奪われたことを伝える
    //依頼に紐付いた宝を削除
    $this->MemberTreasure->delete($member_treasure_id);
    $data = array(
      'MemberRequest' => array(
        'member_id' => $enemy_member_id,
        'title' => '【奪取された】'.$treasure_name.'を'.$enemy_member_name.'から奪われた。',
        'message_body' => '残念だ、'.$treasure_name.'を'.$enemy_member_name.'から奪われてしまった。<br>まだ相手がコンプリートしていない場合は奪い返せ！',
        'bank_id' => 0,
        'all_distance' => 0,
        'process_status' => 9,
        'read_flag' => 0,
        'challenge_count' => 0,
        'max_challenge_count' => 0,
        'max_spell' => 0,
        'first_spell_id' => 0,
        'second_spell_id' => 0,
        'third_spell_id' => 0,
        'treasure_id' => $treasure_id,
        'treasure_name' => $treasure_name,
        'information_flag' => 1,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->create();
    $this->MemberRequest->save($data);
    //$this->StructureSql->call_check_compleate_series($enemy_member_id);
  }

  function lose(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

    //セッションから相手の情報などを取り出す
    $enemy_data = $this->Session->read('EnemyData');
    $enemy_member_id = $enemy_data['MemberTreasure']['member_id'];
    $treasure_id = $enemy_data['MemberTreasure']['treasure_id'];
    $treasure_name = $enemy_data['MemberTreasure']['treasure_name'];
    $series_id = $enemy_data['MemberTreasure']['series_id'];
    $enemy_member_name = $enemy_data['enemy_member_name'];
    $member_treasure_id = $enemy_data['member_treasure_id'];
    //会員
    $data = array(
      'id' => $member_id,
      'last_rob_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    //自分が負けたことを伝える
    $data = array(
      'MemberRequest' => array(
        'member_id' => $member_id,
        'title' => '【奪取失敗】'.$treasure_name.'を'.$enemy_member_name.'から奪うつもりだったが失敗した。',
        'message_body' => '残念だ、'.$treasure_name.'を'.$enemy_member_name.'から奪うつもりだったが失敗した。<br>一定時間「奪取」はできなくなった。',
        'bank_id' => 0,
        'all_distance' => 0,
        'process_status' => 9,
        'read_flag' => 0,
        'challenge_count' => 0,
        'max_challenge_count' => 0,
        'max_spell' => 0,
        'first_spell_id' => 0,
        'second_spell_id' => 0,
        'third_spell_id' => 0,
        'treasure_id' => $treasure_id,
        'treasure_name' => $treasure_name,
        'information_flag' => 1,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->create();
    $this->MemberRequest->save($data);

    //相手に奪われたことを伝える
    $this->MemberTreasure->save($tdata);
    $data = array(
      'MemberRequest' => array(
        'member_id' => $enemy_member_id,
        'title' => '【警告】'.$treasure_name.'を'.$enemy_member_name.'から狙われている。',
        'message_body' => '警告、'.$treasure_name.'を'.$enemy_member_name.'から狙われている。<br>危険なので罠をかけることを薦める！',
        'bank_id' => 0,
        'all_distance' => 0,
        'process_status' => 9,
        'read_flag' => 0,
        'challenge_count' => 0,
        'max_challenge_count' => 0,
        'max_spell' => 0,
        'first_spell_id' => 0,
        'second_spell_id' => 0,
        'third_spell_id' => 0,
        'treasure_id' => $treasure_id,
        'treasure_name' => $treasure_name,
        'information_flag' => 1,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->create();
    $this->MemberRequest->save($data);
  }
  //奪い返す
  function retry(){
    //まだ該当の宝がコンプリートされていないか確認する





  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}