<?php
//facebook

class RequestController extends AppController{

  var $uses = array('Treasure','MemberTreasure','StructureSql','Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell');
  var $session_data;

  function top($mail_no){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //未読件数を取得
    $r_c = $this->StructureSql->count_no_read($member_id,0);
    $i_c = $this->StructureSql->count_no_read($member_id,9);
    if(strlen($mail_no)==0){
      $mail_no = 0;
    }
    switch ($mail_no) {
      case 0:
        $datas = $this->MemberRequest->findAll(array('member_id'=>$member_id), null, 'insert_time desc',100,1);
        break;
      case 1:
        $datas = $this->MemberRequest->findAll(array('member_id'=>$member_id,'information_flag'=>0), null, 'insert_time desc',100,1);
        break;
      case 2:
        $datas = $this->MemberRequest->findAll(array('member_id'=>$member_id,'information_flag'=>1), null, 'insert_time desc',100,1);
        break;
      default:
    }
    //view
    $this->Session->write('MailNo',$mail_no);
    $this->set('datas',$datas);
    $this->set('all_count',$r_c[0][0]['count']+$i_c[0][0]['count']);
    $this->set('request_count',$r_c[0][0]['count']);
    $this->set('info_count',$i_c[0][0]['count']);
  }

  function detail($member_request_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $datas = $this->MemberRequest->findById($member_request_id);
    //情報をばらす
    $request_id = $datas['MemberRequest']['request_id'];
    $bank_id = $datas['MemberRequest']['bank_id'];
    $treasure_id = $datas['MemberRequest']['treasure_id'];
    $information_flag = $datas['MemberRequest']['information_flag'];
    $detail_data =  $this->Request->findById($request_id);
    $tdata = $this->Treasure->findById($treasure_id);
    $series_id = $tdata['Treasure']['series_id'];
    //既に持っているか確認する
    $treasure_count = $this->MemberTreasure->find('count', array('conditions' => array('treasure_id' => $treasure_id,'member_id'=>$member_id)));
    $already_txt = '';
    if($treasure_count>0 and $information_flag==0){
      $already_txt = '既に所持しています。';
    }
    //読んだフラグを立てる
    $mreqdata = array(
      'MemberRequest' => array(
        'id' => $member_request_id,
        'read_flag' => 1,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->MemberRequest->save($mreqdata);
    //戻る時のリストナンバー保管
    $mail_no = $this->Session->read('MailNo');
    //view
    $this->set('already_txt',$already_txt);
    $this->set('mail_no',$mail_no);
    $this->set('series_id',$series_id);
    $this->set('datas',$datas);
  }

  function treasure_detail($treasure_id){
    $this->session_manage();
  }

  function regist_confirm($member_request_id){
    $this->set('member_request_id',$member_request_id);
  }

  function regist($member_request_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $old_member_request_id = $mdata['Member']['member_request_id'];
    $avater_id = $mdata['Member']['avater_id'];
    $data = array(
      'Member' => array(
        'id' => $member_id,
        'member_request_id' => $member_request_id,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($data);
    $this->set('avater_id',$avater_id);
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}