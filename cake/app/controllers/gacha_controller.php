<?php
//facebook

class GachaController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $this->Session->write('PageStepNo',1);
    $mdata = $this->Member->findById($member_id);
    $last_gacha_date = $mdata['Member']['last_gacha_date'];
    if(strlen($last_gacha_date)==0){
      $last_gacha_date = '1999-10-10';
    }
    //今日の日付を取得
    $today_date = date('Y-m-d');
    //最終更新日が昨日かどうかを比較して確認する
    $gacha_effective_flag=1;
    if (strtotime($today_date) > strtotime($last_gacha_date)) {
      $gacha_effective_flag = 0;
    }
    $this->set('gacha_effective_flag',$gacha_effective_flag);
  }

  function do_gacha(){
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>1){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->Session->write('PageStepNo',2);
  }

  function exe_gacha(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //ステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>2){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->Session->write('PageStepNo',3);
    //今日の日付をアップデートする
    $data = array(
      'id' => $member_id,
      'last_gacha_date' => date("Y-m-d H:i:s"),
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);

    //加える
    $item_code = mt_rand(0,12);
    if($item_code==1){
      $title = '回復ドリンクが出ました！';
      $item_id = 1;
      $this->update_item_count($member_id,1,1);
    }else if($item_code==2){
      $title = '回復ドリンクが出ました！';
      $item_id = 1;
      $this->update_item_count($member_id,1,1);
    }else if($item_code==3){
      $title = '推理小説が出ました！';
      $item_id = 1;
      $this->update_item_count($member_id,3,1);
    }else if($item_code==4){
      $title = '推理小説が出ました！';
      $item_id = 1;
      $this->update_item_count($member_id,3,1);
    }else{
       $title = '小銭袋が出ました!';
       $item_id = 0;
       $this->StructureSql->call_get_money($member_id,50,1);
        //何もしない
    }
    $this->set('item_title',$title);
    $this->set('item_id',$item_id);
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
      'item_star' => $item_star,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    return $item_id;
  }

  function session_manage(){
    //テスト時は下記２行を追記
    //$data['id']=1;
    //$this->Session->Session->write("member_info",$data);

    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}