<?php
class AttackController extends AppController{

  var $uses = array('MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $attack_cost=50;
  var $add_exp=50;

  function top($member_quest_id){
    //ページステップ管理
    $this->Session->write('PageStepNo',1);
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    $power = $mdata['Member']['power'];
    if($power < $this->attack_cost){
      $this->redirect('/item/item_power_top/');
    }
    //power減らす
    $power -= $this->attack_cost;
    $data = array(
      'Member' => array(
        'id' => $member_id,
        'power' => $power,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($data);
    $mqdata = $this->MemberQuest->findById($member_quest_id);
    $quest_id = $mqdata['MemberQuest']['quest_id'];
    //犯人の残した証拠数
    $challenge_count = $mqdata['MemberQuest']['challenge_count'];
    //自分が集めた証拠数
    $ev_c_data = $this->StructureSql->count_evidence_by_member_quest($member_quest_id);
    $ev_count = $ev_c_data[0][0]['count'];
    //最大証拠数(ただしhtml5ゲームの内容により９が最大)
    $max_challenge_count = $challenge_count + $ev_count;
    if($max_challenge_count>=9){
      $max_challenge_count=9;
    }
    $this->set('challenge_count',$challenge_count);
    $this->set('me_count',$ev_count);
    $this->set('max_challenge_count',$max_challenge_count);
    $resolved_flag = $mqdata['MemberQuest']['resolved_flag'];
    if($resolved_flag==1){
      $this->redirect('/attack/already_end/');
    }
    $this->set('quest_id',$quest_id);
    //答えとなるキーワードを作成する
    $keyword_num = $this->keyword_maker(8);
    $num_0=0;
    $num_1=0;
    $num_2=0;
    $num_3=0;
    $num_4=0;
    $num_5=0;
    $num_6=0;
    $num_7=0;
    $num_8=0;
    ${'num_'.$keyword_num[0]}=1;
    ${'num_'.$keyword_num[1]}=2;
    ${'num_'.$keyword_num[2]}=3;
    $this->set('num_0',$num_0);
    $this->set('num_1',$num_1);
    $this->set('num_2',$num_2);
    $this->set('num_3',$num_3);
    $this->set('num_4',$num_4);
    $this->set('num_5',$num_5);
    $this->set('num_6',$num_6);
    $this->set('num_7',$num_7);
    $this->set('num_8',$num_8);
  }

  function already_end(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function win($quest_id){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>1){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->Session->write('PageStepNo',2);
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //quest_idがうまく受け取れない場合はエラー
    if(strlen($quest_id)==0){
      $this->redirect('/quest/no_queset/');
    }
    //今のクエスト情報を取得し、加算する経験値とお金を取得
    $mq_data = $this->MemberQuest->find(array("quest_id"=>$quest_id,"member_id"=>$member_id));
    $member_quest_id = $mq_data['MemberQuest']['id'];
    $quest_exp = $mq_data['MemberQuest']['quest_exp'];
    $quest_price = $mq_data['MemberQuest']['quest_price'];
    //次のクエストIDを確認
    $next_quest_id = $quest_id + 1;
    //クエストIDが存在するかチェックする
    $qdata = $this->Quest->findById($next_quest_id);
    if(count($qdata)==0){
      $this->redirect('/quest/no_queset/');
    }
    //transaction開始
    $this->StructureSql->begin();
    $this->MemberQuest->begin();
    $this->MemberQuestDetail->begin();
    //今のクエストを済にする
    $data = array(
      'MemberQuest' => array(
        'id' => $member_quest_id,
        'resolved_flag' => 1,
        'update_time' => date("Y-m-d H:i:s")
       )
    );
    $mq_result_u = $this->MemberQuest->save($data);
    $data = array(
      'MemberQuest' => array(
        'member_id' => $member_id,
        'title' => $qdata['Quest']['title'],
        'comment' => $qdata['Quest']['comment'],
        'quest_exp' => $qdata['Quest']['quest_exp'],
        'quest_price' => $qdata['Quest']['quest_price'],
        'resolved_flag' => 0,
        'evidence_appear_rate' => $qdata['Quest']['evidence_appear_rate'],
        'challenge_count' => $qdata['Quest']['challenge_count'],
        'quest_id' => $next_quest_id,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->create();
    $mq_result_i = $this->MemberQuest->save($data);
    $member_quest_id = $this->MemberQuest->getLastInsertID();
    $qd_data = $this->QuestDetail->find(array("quest_id"=>$next_quest_id,"detail_no"=>1));
    $data = array(
      'MemberQuestDetail' => array(
        'member_quest_id' =>$member_quest_id,
        'detail_no' => 1,
        'resoluved_flag' =>0,
        'member_id' =>$member_id,
        'title' =>$qd_data['QuestDetail']['title'],
        'comment' =>$qd_data['QuestDetail']['comment'],
        'exp' =>$qd_data['QuestDetail']['exp'],
        'distance' =>0,
        'all_distance' =>$qd_data['QuestDetail']['all_distance'],
        'last_marker_flag' =>$qd_data['QuestDetail']['last_marker_flag'],
        'quest_detail_id' =>$qd_data['QuestDetail']['id'],
        'insert_time' =>date("Y-m-d H:i:s")
       )
    );
    $mqd_result = $this->MemberQuestDetail->save($data);
    //ご褒美
    $call_exp_result = $this->StructureSql->call_get_bank_exp($member_id,$this->add_exp);
    $call_money_result = $this->StructureSql->call_get_money($member_id,$quest_price,1);
    //transaction終了
    if($mq_result_u!==false&&$mq_result_i!==false&&$call_exp_result!==false&&$call_money_result!==false){
      $this->StructureSql->commit();
      $this->MemberQuest->commit();
      $this->MemberQuestDetail->commit();
    }else{
      $this->StructureSql->rollback();
      $this->MemberQuest->rollback();
      $this->MemberQuestDetail->rollback();
      $this->redirect('/login/session_timeout/');
    }
    //メッセージ送信（次の事件について）
    $title = '「'.$qdata['Quest']['title'].'」が追加されました。';
    $comment = '';
    $this->send_message($member_id,$title,$comment,2);
    //メッセージ送信
    $title = '事件解決！経験値'.$quest_exp.'Exp,お金 $'.$quest_price.',ステータス上昇ポイント×1を得ました';
    $comment = '';
    $this->send_message($member_id,$title,$comment,3);
    $display_message_1 = "経験＋".$quest_exp."↑/お金＋".$quest_price."↑";
    $display_message_2 = "推理小説+1↑..をゲット";
    $this->set('display_message_1',$display_message_1);
    $this->set('display_message_2',$display_message_2);
  }

  function send_message($member_id,$title,$comment,$genre_id){
    //メッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => $genre_id,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
  }

  function lose($quest_id){
    //ページステップ管理
    $page_step_no = $this->Session->read('PageStepNo');
    if($page_step_no<>1){
      $this->redirect('/top/lost_way#header-menu');
    }
    $this->Session->write('PageStepNo',2);
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //quest_idがうまく受け取れない場合はエラー
    if(strlen($quest_id)==0){
      $this->redirect('/quest/no_queset/');
    }
    //今のクエスト情報を取得し、加算する経験値とお金を取得
    $mq_data = $this->MemberQuest->find(array("quest_id"=>$quest_id,"member_id"=>$member_id));
    $member_quest_id = $mq_data['MemberQuest']['id'];
    $this->set('member_quest_id',$member_quest_id);
    $display_message_1 = "推理に失敗しました...";
    $display_message_2 = "体力 -100↓";
    $this->set('display_message_1',$display_message_1);
    $this->set('display_message_2',$display_message_2);
  }

  function no_queset(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }


  function keyword_maker($max_spell){
    $rand_number = array();
    for ($i=0; $i<$max_spell; $i++) $nums[$i] = $i+1;
      for ($i=0; $i<$max_spell; $i++) {
        $j = mt_rand(0,$max_spell-1);
        $tmp = $nums[$j];
        $nums[$j] = $nums[$i];
        $nums[$i] = $tmp;
      }
      for ($i=0; $i<3; $i++) {
        $num = $nums[$i];
        $rand_number[$i] = $num-1;
      }
    return $rand_number;
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}