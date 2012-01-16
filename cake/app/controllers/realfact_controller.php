<?php
class RealfactController extends AppController{

  var $uses = array('MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $attack_cost=50;

  function top($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

    //最大証拠数
    $this->set('challenge_count',0);
    $this->set('me_count',5);
    $this->set('max_challenge_count',5);

    //パワー増減+実績の登録
    $mdata = $this->Member->findById($member_id);
    $power = $mdata['Member']['power'];
    //power減らす
    $power -= $attack_cost;
    $data = array(
      'Member' => array(
        'id' => $member_id,
        'power' => $power,
        'update_time' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($data);

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
    ${'num_'.$keyword_num[3]}=4;
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
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //真相フラグを追記する
    $data = array(
      'MemberQuest' => array(
        'id' => $member_quest_id,
        'real_fact_resolved_flag' => 1,
        'update_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberQuest->save($data);
  }

  function lose($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function send_message($member_id,$title,$comment){
    //メッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => 1,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
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
      for ($i=0; $i<4; $i++) {
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