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
    $data = $this->StructureSql->select_own_serease_detail($member_id,$series_id);

    $cdata = $this->StructureSql->select_own_serease_count($member_id,$series_id);
    $compleate_count = $cdata[0][0]['count'];
    $comp_flag =0;
    if($compleate_count == 5){
      $comp_flag =1;
    }
    //view
    $this->set('comp_flag',$comp_flag);
    $this->set('title_name',$sdata['TreasureSerie']['name']);
    $this->set('genre_id',$sdata['TreasureSerie']['id']);
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

  function map_manage(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $this->Session->write('spell_data','');
    //セッションから会員番号を取得
    $mdata = $this->Member->findById($member_id);
    //アバターがない場合は設定画面へ誘導
    $map_max_id = $mdata['Member']['map_max_id'];
    $map_id = $mdata['Member']['map_id'];
    $mm = $this->StructureSql->select_map_max_id($member_id);
    $bdata = $this->StructureSql->select_map_all_compleate_rate($member_id,$mm[0][0]['map_max_id']);
    //view
    $this->set('map_id',$map_id);
    $this->set('bdata',$bdata);
  }

  function map_change($map_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = array(
      'id' => $member_id,
      'map_id' => $map_id,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    $this->redirect('/manage/map_manage/');
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
    $enemy_thumnail_url = $emdata['Member']['thumnail_url'];
    $treasure_id = $data['MemberTreasure']['treasure_id'];
    $treasure_name = $data['MemberTreasure']['treasure_name'];
    $series_id = $data['MemberTreasure']['series_id'];
    $data['enemy_member_name'] = $enemy_member_name;
    $data['member_treasure_id'] = $member_treasure_id;
    //view
    $this->Session->write('EnemyData',$data);
    $this->set('treasure_id',$treasure_id);
    $this->set('treasure_name',$treasure_name);
    $this->set('enemy_member_name',$enemy_member_name);
    $this->set('enemy_thumnail_url',$enemy_thumnail_url);
  }

  function battle_execute(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $useragent_code = $this->return_useragent_code();
    if($useragent_code=='1'){
      //ios
      $this->render($layout='battle_execute_svg',$file='default');
    }else{
      //android,それ以外
      $this->render($layout='battle_execute_flash',$file='default');
    }
  }

  function battle_start(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $random = rand(1,3);
    //$random = 1;
    if($random == 2){
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
    //セッションデータが消えていた場合は戻る
    if(strlen($enemy_member_id)==0){
      $this->redirect('/manage/top/');
    }
    //セッションから値を取得
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
        'title' => '【バトル-成功-】'.$treasure_name.'を'.$enemy_member_name.'から奪った。',
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
        'title' => '【バトル-奪われた-】'.$treasure_name.'を'.$enemy_member_name.'から奪われた。',
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
    //リセット
    $this->Session->write('EnemyData','');
    //ユーザーエージェント判定
    $useragent_code = $this->return_useragent_code();
    if($useragent_code=='1'){
      //ios
      $this->render($layout='win_svg',$file='default');
    }else{
      //android,それ以外
      $this->render($layout='win_flash',$file='default');
    }
  }

  function lose(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //セッションから相手の情報などを取り出す
    $enemy_data = $this->Session->read('EnemyData');
    $enemy_member_id = $enemy_data['MemberTreasure']['member_id'];
    //セッションデータが消えていた場合は戻る
    if(strlen($enemy_member_id)==0){
      $this->redirect('/manage/top/');
    }
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
        'title' => '【バトル-失敗-】'.$enemy_member_name.'にバトルを仕掛けて'.$treasure_name.'を奪うつもりだったが失敗した。',
        'message_body' => '残念だ、'.$enemy_member_name.'にバトルを仕掛けて'.$treasure_name.'を奪うつもりだったが失敗した。<br>',
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
    //相手に警告メールを送る
    $this->MemberTreasure->save($tdata);
    $data = array(
      'MemberRequest' => array(
        'member_id' => $enemy_member_id,
        'title' => '【バトル-防御した-】'.$treasure_name.'を'.$enemy_member_name.'から狙われたが防御に成功した。',
        'message_body' => '注意！、'.$treasure_name.'を'.$enemy_member_name.'から狙われたが防御に成功した。',
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
    //ユーザーエージェント判定
    $useragent_code = $this->return_useragent_code();
    if($useragent_code=='1'){
      //ios
      $this->render($layout='lose_svg',$file='default');
    }else{
      //android,それ以外
      $this->render($layout='lose_flash',$file='default');
    }
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