<?php
//facebook

class ShopController extends AppController{

  var $uses = array('Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $datas = $this->Item->findAll();
    //var_dump($datas);
    $this->set('money',10000);
    $this->set('data',$datas);
  }

  function buy_confirm(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

    $item_id = $this->params['data']['submit'];
    $this->Session->write('ItemId',$item_id);
    $data = $this->Item->findById($item_id);

    var_dump($data);

    $this->set('item_id',$item_id);
    $this->set('data',$data);

    //$this->set('before_price',$m_data['0']['mura_member']['kome_amount']);
    //$after_price = $m_data['0']['mura_member']['kome_amount'] - $data[0]['m_item']['item_price'];
    //if($after_price < 0){
    //  echo 'お金が足りません';
    //}
    //$this->set('after_price',$after_price);

    $this->set('datas',$datas);
  }

  function buy($item_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $item_id = $this->Session->read('ItemId');
    $datas = $this->Item->findById($item_id);
    $mdata = array(
      'MemberItem' => array(
        'member_id' => $member_id,
        'item_id' => $item_id,
        'item_name' => '',
        'item_genre_id' => 1,
        'used_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberItem->save($datas);
    $this->set('data',$datas);
  }

  function enemy_list(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

  }

  function go(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById();
    $power = $mdata['Member']['power'];
    $power -= 100;

  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}