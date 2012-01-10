<?php
class QuestController extends AppController{

  var $uses = array('StructureSql','Member','Message','QuestDetail','MemberQuestDetail');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_member_quests_list($member_id);
    $this->set('data',$data);
  }

  function datalist($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_member_quest_list($quest_id,$member_id);
    var_dump($data);
    //クエスト内で、最終行フラグのあるデータを持っているか？
    $last_stage = $this->MemberQuestDetail->find(array("quest_id"=>$quest_id,"last_quest_detail_flag"=>1,"member_id"=>$member_id));
    $last_stage_count = count($last_stage);
    $last_stage_link_flag=0;
    //最終面リンク表示
    if($last_stage_count >= 1){
      $resoluved_flag = $last_stage['QuestDetail']['resoluved_flag'];
      if($resoluved_flag==1){
        $last_stage_link_flag=1;
      }
    }
    //view
    $this->set('last_stage_link_flag',$last_stage_link_flag);
    $this->set('data',$data);
  }

  function detail($member_quest_detail_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_member_detail($member_quest_detail_id);
    $this->set('data',$data);
  }

  function exe_quest($member_quest_detail_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_member_detail($member_quest_detail_id);
    //var_dump($data);
    $quest_id = $data[0]['member_quests']['quest_id'];
    $quest_detail_id = $data[0]['member_quest_details']['quest_detail_id'];
    $all_distance = $data[0]['quest_details']['all_distance'];
    $distance = $data[0]['member_quest_details']['distance'];
    //距離を加算
    $distance += 50;
    $resoleved_flag = 0;
    //未解決の場合のみ
    if($resoleved_flag==0){
      if($distance >= $all_distance){
        //距離を保存
        $data = array(
          'MemberQuestDetail' => array(
            'id' => $member_quest_detail_id,
            'distance' => $all_distance,
            'resoluved_flag' => 1,
            'update_time' => date("Y-m-d H:i:s")
           )
        );
        $this->MemberQuestDetail->save($data);
        $this->next_quest_detail($member_quest_detail_id);
      }else{
        //距離を保存
        $data = array(
          'MemberQuestDetail' => array(
            'id' => $member_quest_detail_id,
            'distance' => $distance,
            'resoluved_flag' => 0,
            'update_time' => date("Y-m-d H:i:s")
           )
        );
        $this->MemberQuestDetail->save($data);
      }
    }else{
      //resoleved_flag==1のときはアイテムのみ
      echo 'aaa';
    }
    //ある確率で証拠を取得
    $rand_no = mt_rand(0,5);
    if($rand_no == 1){
      //$this->give_evidence($quest_id);
    }
    $this->redirect('/quest/detail/'.$member_quest_detail_id);
  }

  function next_quest_detail($member_quest_detail_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //最終問の場合は作らない
    $mq_data = $this->MemberQuestDetail->findById($member_quest_detail_id);
    $quest_id = $mq_data['MemberQuestDetail']['quest_id'];
    $quest_detail_id = $mq_data['MemberQuestDetail']['quest_detail_id'];
    $member_quest_id = $mq_data['MemberQuestDetail']['member_quest_id'];
    $quest_detail_no = $mq_data['MemberQuestDetail']['quest_detail_no'];
    $last_quest_detail_flag = $mq_data['MemberQuestDetail']['last_quest_detail_flag'];

    //既にあったら作らない
    $qd_count = $this->QuestDetail->findCount(array("quest_id"=>$quest_id,"quest_detail_no"=>$quest_detail_no));
    if(($last_quest_detail_flag==0)&&($qd_count==0)){
      $quest_detail_no+=1;
      $qd_data = $this->QuestDetail->find(array("quest_id"=>$quest_id,"quest_detail_no"=>$quest_detail_no));
      //var_dump($qd_data);
      $data = array(
        'MemberQuestDetail' => array(
          'distance' => 0,
          'resoleved_flag' => 0,
          'quest_id' => $quest_id,
          'member_quest_id' => $member_quest_id,
          'quest_detail_id' => $qd_data['QuestDetail']['id'],
          'member_id' => $member_id,
          'quest_detail_no' => $qd_data['QuestDetail']['quest_detail_no'],
          'last_quest_detail_flag' => $qd_data['QuestDetail']['last_quest_detail_flag'],
          'insert_time' => date("Y-m-d H:i:s")
         )
      );
      $this->MemberQuestDetail->create();
      $this->MemberQuestDetail->save($data);
    }else{
      $this->redirect('/quest/datalist/'.$quest_id);
    }
  }


  function give_evidence($quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->StructureSql->select_evidence_by_rand($quest_id);
    $medata = array(
      'MemberEvidence' => array(
        'evidence_id' => 0,
        'member_id' => $member_id,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->MemberEvidence->save($medata);
  }

  function give_evidence_exe($quest_id){


  }


  function finish_quest(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];

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