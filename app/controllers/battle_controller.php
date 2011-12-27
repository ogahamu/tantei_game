<?php
//facebook
//http://test4.blamestitch.com/cake/top/top/
class BattleController extends AppController{

  var $uses = array('SpellLog','StructureSql','Bank','Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell','Treasure','MemberTreasure');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $member_request_id = $mdata['Member']['member_request_id'];
    //リクエストコードが未登録の場合はトップ画面へ
    if($member_request_id==0){
      $this->redirect('/battle/no_battle/');
    }
    $MRequest = $this->MemberRequest->findById($member_request_id);
    //0:道中 1:発見 2:戦闘 3:勝利 4:中断
    if($MRequest['MemberRequest']['process_status']==0){
      //道中
      $this->redirect('/battle/load/');
    }elseif($MRequest['MemberRequest']['process_status']==1){
      //発見
      $this->redirect('/battle/find_enemy/');
    }elseif($MRequest['MemberRequest']['process_status']==2){
      //作業開始
      $this->redirect('/battle/make_spell/');
    }elseif($MRequest['MemberRequest']['process_status']==3){
      //勝利
      $this->redirect('/battle/next_enemy/');
    }else{
      //中断
      $this->redirect('/battle/next_enemy/');
    }
  }

  function no_battle(){


  }

  function next_enemy(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $enemy_id = $this->findByMemberId();
    $enemy_data = $this->Enemy->findById($enemy_id);
    //保存
    $data = array(
      'Result' => array(
        'member_id' => $member_id,
        'enemy_id' => $enemy_id,
        'enemy_data' => $enemy_data['Enemy']['name'],
        'distance' => 0,
        'all_distance' => $enemy_data['Enemy']['all_distance'],
        'win_flag' => 0,
        'challenge_count' => 0,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Result->save($data);
    $this->render($layout='next_enemy',$file='no_menu_default');
  }

  function load(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $member_request_id = $mdata['Member']['member_request_id'];
    $MRequest = $this->MemberRequest->findById($member_request_id);
    $distance = $MRequest['MemberRequest']['distance'];
    $all_distance = $MRequest['MemberRequest']['all_distance'];
    $process = $distance.'/'.$all_distance;
    $bank_id = $MRequest['MemberRequest']['bank_id'];
    $this->set('bank_id',$bank_id);
    $this->render($layout='load',$file='no_menu_default');
  }

  function goto(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $member_request_id = $mdata['Member']['member_request_id'];
    $power = $mdata['Member']['power'];
    $MRequest = $this->MemberRequest->findById($member_request_id);
    $distance = $MRequest['MemberRequest']['distance'];
    $all_distance = $MRequest['MemberRequest']['all_distance'];
    $added_distance = $distance + 100;
    $process_status = 0;
    if($added_distance>=$all_distance){
      $added_distance = $all_distance;
      $process_status = 1;
    }
    $data = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'distance' => $added_distance,
        'process_status' => $process_status,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->save($data);
    if($process_status ==0){
      $this->redirect('/battle/load/');
    }elseif($process_status ==1){
      $this->redirect('/battle/find_enemy/');
    }
  }

  function find_enemy(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $member_request_id = $mdata['Member']['member_request_id'];
    //プロセスを作業開始にする
    $data = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'process_status' => 2,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->save($data);
  }

  function make_spell(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //会員情報
    $mdata = $this->Member->findById($member_id);
    $power = $mdata['Member']['power'];
    $max_power = $mdata['Member']['max_power'];
    $member_request_id = $mdata['Member']['member_request_id'];
    //リクエストを受け取る
    $result_data = $this->MemberRequest->findById($member_request_id);
    $challenge_count = $result_data['MemberRequest']['challenge_count'];
    $max_challenge_count = $result_data['MemberRequest']['max_challenge_count'];
    $request_id = $result_data['MemberRequest']['request_id'];
    $max_spell = $result_data['MemberRequest']['max_spell'];
    $rdata = $this->Request->findById($request_id);
    //銀行名を取得する
    $bank_id = $result_data['MemberRequest']['bank_id'];
    $bankdata = $this->Bank->findById($bank_id);
    $this->set('bank_name',$bankdata['Bank']['name']);
    $this->set('bank_lv',$bankdata['Bank']['lv']);
    $this->set('max_spell',$max_spell);
    //スペルログを取得
    $splog = $this->SpellLog->findByMemberRequestId($member_request_id);
    $this->set('splog',$splog);
    //パワーが０以下
    if($power<=0){
      $this->redirect('/battle/no_power/');
    }
    //挑戦回数が0以下
    if($challenge_count>$max_challenge_count){
      $this->redirect('/battle/broken/');
    }
    //前回選択したスペルの配列を読み込み
    $spell_data = $this->Session->read('spell_data');
    $this->Session->read('hit_count');
    $this->Session->read('critical_count');
    //初回の場合は全部0
    $jscode = '';
    if(strlen($spell_data)==0){
      $spell_data['first_spell']=99;
      $spell_data['second_spell']=99;
      $spell_data['third_spell']=99;
      $jscode .= "reset_spell();";
      //$this->set("jscode",$jscode);
      $info = '';
    }else{
      //１個前のキーに入力する
      $jscode .= "old_first_spell = ".$spell_data['first_spell'].";";
      $jscode .= "old_second_spell = ".$spell_data['second_spell'].";";
      $jscode .= "old_third_spell = ".$spell_data['third_spell'].";";
      //選択された箇所以外を選択不可にする
      $jscode .= "document.getElementById('second_spell_".$spell_data['first_spell']."').disabled=true; ";
      $jscode .= "document.getElementById('third_spell_".$spell_data['first_spell']."').disabled=true; ";
      $jscode .= "document.getElementById('first_spell_".$spell_data['second_spell']."').disabled=true; ";
      $jscode .= "document.getElementById('third_spell_".$spell_data['second_spell']."').disabled=true; ";
      $jscode .= "document.getElementById('first_spell_".$spell_data['third_spell']."').disabled=true; ";
      $jscode .= "document.getElementById('second_spell_".$spell_data['third_spell']."').disabled=true; ";
      $this->set("jscode",$jscode);
      $info = $spell_data['hit_count'].'Hit/'.$spell_data['critical_count'].'Critical';
    }
    $this->set('info',$info);

    $action_flag = $this->Session->read('ActionFlag');
    if($action_flag == 1){
      $this->set('action_flag',1);
      $this->Session->write('ActionFlag',1);
    }else{
      $this->set('action_flag',0);
      $this->Session->write('ActionFlag',1);
    }
    $this->set('power',$power);
    $this->set('max_power',$max_power);
    $this->set('challenge_count',$result_data['MemberRequest']['challenge_count']);
    $this->set('max_challenge_count',$result_data['MemberRequest']['max_challenge_count']);
    $this->set('hit_count',$spell_data['hit_count']);
    $this->set('critical_count',$spell_data['critical_count']);
    $this->set('target_first_spell',$spell_data['first_spell']);
    $this->set('target_second_spell',$spell_data['second_spell']);
    $this->set('target_third_spell',$spell_data['third_spell']);
    $this->render($layout='make_spell',$file='no_menu_default');
  }

  function broken(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $member_request_id = $mdata['Member']['member_request_id'];
    $mission_count = $mdata['Member']['mission_count'];
    $mistake_count = $mdata['Member']['mistake_count'];
    $power = $mdata['Member']['power'];
    $money = $mdata['Member']['money'];
    $add_money = ceil($money/10);
    $added_moeny = $money - $add_money;
    //ステータスを変更
    $data = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'process_status' => 3,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->save($data);
    //ステータスを変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'member_request_id' => 0,
        'money' => $added_moeny,
        'mission_count'=>$mission_count+1,
        'mistake_count'=>$mistake_count+1,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($mdata);
    $data = array(
      'MemberRequest' => array(
        'member_id' => $member_id,
        'title' => '【逮捕】君は逮捕された..保釈金＄'.$add_money.'',
        'message_body' => '非常に残念だ。保釈金＄'.$add_money.'を支払った。<br>また次回頑張ってくれることを期待している。',
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
        'treasure_id' => 0,
        'treasure_name' => 0,
        'information_flag' => 1,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->save($data);
    $this->render($layout='broken',$file='no_menu_default');
  }

  function no_power(){
    $this->render($layout='no_power',$file='no_menu_default');
  }
  //0:未発見 1:未解決 2:解決 3:不可能
  function success(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $member_request_id = $mdata['Member']['member_request_id'];
    $power = $mdata['Member']['power'];
    $this->set('power',$power);
    //挑戦回数及び、目標挑戦回数の取得
    $rdata = $this->MemberRequest->findById($member_request_id);
    $challenge_count = $rdata['MemberRequest']['challenge_count'];
    $max_challenge_count = $rdata['MemberRequest']['max_challenge_count'];
    $treasure_id = $rdata['MemberRequest']['treasure_id'];
    $reward_price = $rdata['MemberRequest']['reward_price'];
    $reward_exp = $rdata['MemberRequest']['reward_exp'];
    $this->set('treasure_id',$treasure_id);
    $treasure_name = $rdata['MemberRequest']['treasure_name'];
    $this->set('challenge_count',$rdata['MemberRequest']['challenge_count']);
    $this->set('max_challenge_count',$rdata['MemberRequest']['max_challenge_count']);
    $tdata = $this->Treasure->findById($treasure_id);
    $series_id = $tdata['Treasure']['series_id'];
    //解決率を計算
    $resolve_rate = ceil($challenge_count/$max_challenge_count*100);
    if($resolve_rate > 90){
      $rank = 'E';
      $money_rate = 0.1;
    }else if($resolve_rate > 70){
      $rank = 'D';
      $money_rate = 0.3;
    }else if($resolve_rate > 50){
      $rank = 'C';
      $money_rate = 0.5;
    }else if($resolve_rate > 40){
      $rank = 'B';
      $money_rate = 0.7;
    }else if($resolve_rate < 30){
      $rank = 'A';
      $money_rate = 0.9;
    }else{
      $rank = 'S';
      $money_rate = 1;
    }
    $this->set('rank',$rank);
    //報酬などの計算
    $power = $mdata['Member']['power'];
    $max_power = $mdata['Member']['max_power'];
    $money = $mdata['Member']['money'];
    $mission_count = $mdata['Member']['mission_count'];
    $success_count = $mdata['Member']['success_count'];
    $add_money = $reward_price*$money_rate;
    $add_exp = $reward_exp * $money_rate;
    $added_money = $money + $add_money;
    //exp
    $add_exp = $reward_price*$money_rate;
    $this->StructureSql->call_get_bank_exp($member_id,$add_exp);
    $gain_txt  = '開錠ランク：'.$rank.'<br>';
    $gain_txt .= '報酬額'.$reward_price.'×ランク='.$rank.'=>'.$add_money.'を得た。<br>';
    $gain_txt .= '経験値'.$reward_exp.'×ランク='.$rank.'=>'.$add_exp.'Expが加算。<br>';
    $this->set('gain_txt',$gain_txt);
    $this->set('treasure_name',$treasure_name);
    //ステータスを変更
    $data = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'process_status' => 2,
        'update_time' => date("Y-m-d H:i:s"),
        'result_rank' => $rank
      )
    );
    $this->MemberRequest->save($data);
    //ステータスを変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'power'=>$max_power,
        'money'=>$added_money,
        'member_request_id' => 0,
        'mission_count'=>$mission_count+1,
        'success_count'=>$success_count+1,
        'update_date' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($mdata);
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
        'title' => '【成功】'.$treasure_name.'を手に入れた。'.$rank.'でクリア。',
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
    $this->render($layout='success',$file='no_menu_default');
  }

  function get_item(){




  }
  /*解答処理*/
  function battle_start(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $member_request_id = $mdata['Member']['member_request_id'];
    $power = $mdata['Member']['power'];

    //作成したデッキを取得する
    $first_spell = $this->params['data']['first_spell'];
    $second_spell = $this->params['data']['second_spell'];
    $third_spell = $this->params['data']['third_spell'];
    //echo 'input=>'.$first_spell.$second_spell.$third_spell.'<br>';

    //全てのスペルが違う場合はエラー
    if(($first_spell == $second_spell)or($first_spell == $third_spell)or($second_spell == $third_spell)){
      $this->Session->write('error_txt','開錠キーは３つとも違う数字です。');
      $this->redirect('/battle/make_spell/');
    }
    $spell_data['first_spell']=$first_spell;
    $spell_data['second_spell']=$second_spell;
    $spell_data['third_spell']=$third_spell;

    //当たりのスペルを取得する
    $result_data = $this->MemberRequest->findById($member_request_id);
    $challenge_count = $result_data['MemberRequest']['challenge_count'];
    $correct_first_spell = $result_data['MemberRequest']['first_spell_id'];
    $correct_second_spell = $result_data['MemberRequest']['second_spell_id'];
    $correct_third_spell = $result_data['MemberRequest']['third_spell_id'];
    //1:防御 2:ヒット 3:クリティカル
    $critical_count=0;
    $hit_count=0;
    if($first_spell == $correct_first_spell){
      $critical_count+=1;
    }elseif(($first_spell == $correct_second_spell)or($first_spell == $correct_third_spell)){
      $hit_count+=1;
    }
    if($second_spell == $correct_second_spell){
      $critical_count+=1;
    }elseif(($second_spell == $correct_first_spell)or($second_spell == $correct_third_spell)){
      $hit_count+=1;
    }
    if($third_spell == $correct_third_spell){
      $critical_count+=1;
    }elseif(($third_spell == $correct_first_spell) or ($third_spell == $correct_second_spell)){
      $hit_count+=1;
    }
    //回数を減らす
    $challenge_count += 1;
    $data = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'challenge_count' => $challenge_count,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->save($data);
    //power減らす
    $power -= 30;
    $data = array(
      'Member' => array(
        'id' => $member_id,
        'power' => $power,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($data);
    $spell_data['hit_count']=$hit_count;
    $spell_data['critical_count']=$critical_count;
    $this->Session->write('spell_data',$spell_data);

    //スペルの履歴を入れる
    $data = array(
      'SpellLog' => array(
        'member_id' => $member_id,
        'spell_txt' => $first_spell.'/'.$second_spell.'/'.$third_spell,
        'result_txt'=>$critical_count.'Critical/'.$hit_count.'Hit',
        'member_request_id' => $member_request_id,
        'insert_time' => date("Y-m-d H:i:s"),
      )
    );
    $this->SpellLog->save($data);

    if($critical_count==3){
      $this->redirect('/battle/success/');
    }else{
      $this->redirect('/battle/make_spell/');
    }
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}