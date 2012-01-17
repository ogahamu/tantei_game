<?php
//facebook

class GachaController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $this->write('PageStepNo',1);
  }

  function do_gacha(){
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>1){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',2);
  }

  function exe_gacha(){
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>2){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->write('PageStepNo',3);
    //今日の日付をアップデートする


    //加える

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
    }elseif($item_id==2){
      $item_star+=$add_count;
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

  function session_manage(){
    //テスト時は下記２行を追記
    //$data['id']=1;
    //$this->Session->write("member_info",$data);

    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}