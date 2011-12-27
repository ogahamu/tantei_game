<?php
//facebook

class ProductController extends AppController{

  var $uses = array('Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function power_charge(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    $power = $mdata['Member']['power'];
    $max_power = $mdata['Member']['max_power'];
    $gage_power = ceil($power/$max_power*100);
    if($money<0){
      $this->set('error_txt','お金が足りません');
      $this->set('bottan_disabled_flag',1);
    }else{
      $this->set('error_txt','');
      $this->set('bottan_disabled_flag',0);
    }
    $this->set('money',$money);
    $this->set('power',$gage_power);
    $this->set('max_power',$max_power);
  }

  function power_charge_execute(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $power = $mdata['Member']['power'];
    $max_power = $mdata['Member']['max_power'];
    $added_power = $power + 100;

    $money = $mdata['Member']['money'];
    $added_money = $money - 50;

    //状態を変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'power' => $added_power,
        'money' => $added_money,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($mdata);
    $this->redirect('/product/power_charge/');
  }

  function number_suggest(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    $power = $mdata['Member']['power'];

    $member_request_id = $mdata['Member']['member_request_id'];
    if($member_request_id==0){
      $this->redirect('/product/top/');
    }


    $mrdata = $this->MemberRequest->findById($member_request_id);
    $number_suggest_flag = $mrdata['MemberRequest']['number_suggest_flag'];
    if($number_suggest_flag==1){
      $this->set('error_txt','既に１個開いているのでこれ以上は開けません');
      $this->set('bottan_disabled_flag',1);
    }else{
      $this->set('error_txt','');
      $this->set('bottan_disabled_flag',0);
    }

    $this->set('money',$money);
    $this->set('power',$power);

    $first_spell_id = '*';
    $second_spell_id = '*';
    $third_spell_id = '*';
    $spell_id = $this->Session->read('spell_id');
    if(strlen($spell_id['open_place_id'])>0){
      $open_place_id = $spell_id['open_place_id'];
      if($open_place_id==1){
        $first_spell_id=$spell_id['first_spell_id'];
      }
      if($open_place_id==2){
        $second_spell_id=$spell_id['second_spell_id'];
      }
      if($open_place_id==3){
        $third_spell_id=$spell_id['third_spell_id'];
      }
    }
    $this->set('first_spell_id',$first_spell_id);
    $this->set('second_spell_id',$second_spell_id);
    $this->set('third_spell_id',$third_spell_id);
  }

  function number_suggest_execute(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $open_place_id = $this->params['data']['open_place_id'];

    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    $member_request_id = $mdata['Member']['member_request_id'];

    $mrdata = $this->MemberRequest->findById($member_request_id);
    $number_suggest_flag = $mrdata['MemberRequest']['number_suggest_flag'];
    if($number_suggest_flag==1){
      $this->redirect('/product/number_suggest/');
    }


    $added_money = $money - 50;
    //状態を変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'money' => $added_money,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($mdata);

    //使用した結果を保存する
    $mrdata = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'number_suggest_flag' => 1,
      )
    );
    $this->MemberRequest->save($mrdata);

    //リクエスト状態を修正
    $first_spell_id = '*';
    $second_spell_id = '*';
    $third_spell_id = '*';
    $mrdata = $this->MemberRequest->findById($member_request_id);
    if($open_place_id==1){
      $first_spell_id = $mrdata['MemberRequest']['first_spell_id'];
    }elseif($open_place_id==2){
      $second_spell_id = $mrdata['MemberRequest']['second_spell_id'];
    }elseif($open_place_id==3){
      $third_spell_id = $mrdata['MemberRequest']['third_spell_id'];
    }
    $spell_id['open_place_id']=$open_place_id;
    $spell_id['first_spell_id']=$first_spell_id;
    $spell_id['second_spell_id']=$second_spell_id;
    $spell_id['third_spell_id']=$third_spell_id;
    $this->Session->write('spell_id',$spell_id);

    $this->redirect('/product/number_suggest/');
  }

  function give_bribery(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //var_dump($mdata);
    $money = $mdata['Member']['money'];
    $power = $mdata['Member']['power'];
    $member_request_id = $mdata['Member']['member_request_id'];
    if($member_request_id==0){
      $this->redirect('/product/top/');
    }
    if($money<0){
      $this->set('error_txt','お金が足りません');
      $this->set('bottan_disabled_flag',1);
    }else{
      $this->set('error_txt','');
      $this->set('bottan_disabled_flag',0);
    }
    //リクエスト状態を修正
    $mrdata = $this->MemberRequest->findById($member_request_id);
    $challenge_count = $mrdata['MemberRequest']['challenge_count'];
    $max_challenge_count = $mrdata['MemberRequest']['max_challenge_count'];
    $nokori_challenge_count = $max_challenge_count - $challenge_count;

    $this->set('money',$money);
    $this->set('power',$power);
    $this->set('nokori_challenge_count',$nokori_challenge_count);
  }

  function give_bribery_execute(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $money = $mdata['Member']['money'];
    $member_request_id = $mdata['Member']['member_request_id'];
    $added_money = $money - 50;
    //状態を変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'money' => $added_money,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($mdata);

    //リクエスト状態を修正
    $mrdata = $this->MemberRequest->findById($member_request_id);
    $max_challenge_count = $mrdata['MemberRequest']['max_challenge_count'];
    $max_challenge_count = $max_challenge_count + 5;
    $mdata = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'max_challenge_count' => $max_challenge_count,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->save($mdata);

    $this->redirect('/product/give_bribery/');
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}