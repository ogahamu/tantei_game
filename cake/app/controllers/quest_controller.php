<?php
class QuestController extends AppController{

  var $uses = array('MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuest->findAllByMemberId($member_id);
    $this->set('data',$data);
  }

  function datalist($member_quest_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuestDetail->findAllByMemberQuestId($member_quest_id);

    $member_quest_id = $data[0]['MemberQuestDetail']['member_quest_id'];
    $mq_data = $this->MemberQuest->findById($member_quest_id);
    $quest_resolved_flag = $mq_data['MemberQuest']['resolved_flag'];
    $quest_id = $mq_data['MemberQuest']['quest_id'];

    //証拠
    $ev_data = $this->StructureSql->select_own_evidence_list($quest_id);
    $this->set('ev_data',$ev_data);

    //var_dump($data);
    //最終面リンク表示(最後の詳細ミッションが終了になっていたら上げる)
    $last_stage = $this->MemberQuestDetail->find(array("member_quest_id"=>$member_quest_id,"last_marker_flag"=>1,"resoluved_flag"=>1,"member_id"=>$member_id));
    $last_stage_count = count($last_stage);
    $last_stage_link_flag=0;
    if($last_stage_count >= 1){
      $resoluved_flag = $last_stage['MemberQuestDetail']['resoluved_flag'];
      if($resoluved_flag==1){
        $last_stage_link_flag=1;
      }
    }
    //大項目が終了してる場合は、リンクを削除する
    if($quest_resolved_flag==1){
      $last_stage_link_flag=0;
    }
    //view
    $this->set('quest_resolved_flag',$quest_resolved_flag);
    $this->set('last_stage_link_flag',$last_stage_link_flag);
    $this->set('member_quest_id',$member_quest_id);
    $this->set('data',$data);
  }

  function detail($member_quest_detail_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuestDetail->findAllById($member_quest_detail_id);
    $this->set('data',$data);
    $mdata = $this->Member->findAllById($member_id);
    $this->set('mdata',$mdata);
  }

  function exe_quest($member_quest_detail_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //パワーが無ければアイテム画面へ飛ばす
    $mdata = $this->Member->findById($member_id);
    //アイテムがない場合は購入画面のリンクを出す
    $power = $mdata['Member']['power'];
    if($power<=20){
      $this->redirect('/item/item_power_top/');
    }
    //パワーを減らす
    $power-=20;
    $data = array(
      'id' => $member_id,
      'power' => $power,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    //expを付与する
    $add_point = 50;
    $this->StructureSql->call_get_bank_exp($member_id,$add_point);

    //ここから本編の実行
    $data = $this->MemberQuestDetail->findById($member_quest_detail_id);
    $member_quest_id = $data['MemberQuestDetail']['member_quest_id'];
    $detail_no = $data['MemberQuestDetail']['detail_no'];
    $last_marker_flag = $data['MemberQuestDetail']['last_marker_flag'];
    $resoluved_flag = $data['MemberQuestDetail']['resoluved_flag'];
    $all_distance = $data['MemberQuestDetail']['all_distance'];
    $distance = $data['MemberQuestDetail']['distance'];
    $detail_no = $data['MemberQuestDetail']['detail_no'];
    $mq_data = $this->MemberQuest->findById($member_quest_id);
    $quest_id = $mq_data['MemberQuest']['quest_id'];
    if(strlen($distance)==0){$distance=0;}
    $after_distance=$distance + 50;
    $resoluved_flag = 0;
    $first_resolved_flag =0;
    if($after_distance>=$all_distance){
      $after_distance = $all_distance;
      $resoluved_flag = 1;
      //超えた場合+最終行でない場合
      if($last_marker_flag == 0){
        $next_detail_no=$detail_no+1;
        $next_stage_count = $this->MemberQuestDetail->findCount(array("member_quest_id"=>$member_quest_id,"detail_no"=>$next_detail_no));
        if($next_stage_count==0){
          //追加処理
          $qd_data = $this->QuestDetail->find(array("quest_id"=>$quest_id,"detail_no"=>$next_detail_no));
          $mqd_data = array(
            'MemberQuestDetail' => array(
              'member_quest_id' =>$member_quest_id,
              'detail_no' => $next_detail_no,
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
          $this->MemberQuestDetail->create();
          $this->MemberQuestDetail->save($mqd_data);
          $first_resolved_flag =1;
        }
      }elseif($last_marker_flag == 1){
        echo '既にあります';
      }
    }
    //距離の更新処理は必要
    $mqd_data = array(
      'MemberQuestDetail' => array(
        'id' =>$member_quest_detail_id,
        'resoluved_flag' =>$resoluved_flag,
        'distance' =>$after_distance,
        'update_time' =>date("Y-m-d H:i:s")
      )
    );
    $this->MemberQuestDetail->save($mqd_data);
    //ある確率で証拠を取得
    $rand_no = mt_rand(0,5);
    $rand_no = 1;
    if($rand_no == 1){
      $ev_data = $this->StructureSql->select_evidence_by_rand($quest_id);
      $medata = array(
        'MemberEvidence' => array(
          'evidence_id' => $ev_data[0]['evidences']['id'],
          'member_id' => $member_id,
          'name' => $ev_data[0]['evidences']['name'],
          'img_id' => $ev_data[0]['evidences']['img_id'],
          'member_quest_id' => $member_quest_id,
          'member_quest_detail_id' => $member_quest_detail_id,
          'insert_time' => date("Y-m-d H:i:s")
         )
      );
      $this->MemberEvidence->save($medata);
    }
    //初回クリア直後
    if($first_resolved_flag==1){
      $this->redirect('/quest/quest_clear/'.$member_quest_id);
    }
    $this->redirect('/quest/detail/'.$member_quest_detail_id);
  }

  function quest_clear($member_quest_id){
      $this->set('member_quest_id',$member_quest_id);
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