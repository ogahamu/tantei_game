<?php
class QuestController extends AppController{

  var $uses = array('Evidence','MemberEvidence','StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $quest_cost=20;
  var $quest_distance=20;
  var $once_quest_exp = 10;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuest->findAllByMemberId($member_id,null,'id desc');
    $this->set('data',$data);
  }

  function datalist($member_quest_id){
    $this->session_manage();
    if(strlen($member_quest_id)==0){
      $this->redirect('/top/lost_way/');
    }
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    //アイテムの個数を取得
    $item_challenge = $mdata['Member']['item_challenge'];
    $this->set('item_challenge',$item_challenge);
    $data = $this->MemberQuestDetail->findAllByMemberQuestId($member_quest_id,null,'id desc');
    $mq_data = $this->MemberQuest->findById($member_quest_id);
    $quest_resolved_flag = $mq_data['MemberQuest']['resolved_flag'];
    $quest_id = $mq_data['MemberQuest']['quest_id'];
    $member_quest_title = $mq_data['MemberQuest']['title'];
    $real_fact_resolved_flag = $mq_data['MemberQuest']['real_fact_resolved_flag'];
    //犯人が残した証拠数
    $challenge_count = $mq_data['MemberQuest']['challenge_count'];
    //自分が集めた証拠
    $ev_data = $this->StructureSql->select_own_evidence_list($quest_id,$member_id);
    $this->set('ev_data',$ev_data);
    //自分が集めた証拠数
    $ev_c_data = $this->StructureSql->count_evidence_by_member_quest($member_quest_id);
    $ev_count = $ev_c_data[0][0]['count'];
    //結果、最大の証拠数
    $max_challenge_count = $challenge_count + $ev_count;
    $this->set('ev_count',$ev_count);
    $this->set('challenge_count',$challenge_count);
    $this->set('max_challenge_count',$max_challenge_count);
    //証拠のコンプリート状況
    $evidence_compleate_flag = $mq_data['MemberQuest']['evidence_compleate_flag'];
    $this->set('evidence_compleate_flag',$evidence_compleate_flag);
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
    $this->set('real_fact_resolved_flag',$real_fact_resolved_flag);
    $this->set('quest_resolved_flag',$quest_resolved_flag);
    $this->set('last_stage_link_flag',$last_stage_link_flag);
    $this->set('member_quest_id',$member_quest_id);
    $this->set('member_quest_title',$member_quest_title);
    $this->set('data',$data);
  }

  function detail($member_quest_detail_id){
    $this->session_manage();
    if(strlen($member_quest_detail_id)==0){
      $this->redirect('/top/lost_way/');
    }
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $data = $this->MemberQuestDetail->findAllById($member_quest_detail_id);
    $this->set('data',$data);

    $member_quest_id= $data[0]['MemberQuestDetail']['member_quest_id'];
    $q_data = $this->MemberQuest->findById($member_quest_id);
    $quest_title = $q_data['MemberQuest']['title'];
    $this->set('member_quest_id',$member_quest_id);
    $this->set('member_quest_detail_id',$member_quest_detail_id);
    $this->set('quest_title',$quest_title);

    $mdata = $this->Member->findAllById($member_id);
    $this->set('mdata',$mdata);
  }

  function exe_quest($member_quest_detail_id){
    $this->session_manage();
    if(strlen($member_quest_detail_id)==0){
      $this->redirect('/top/lost_way/');
    }
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //パワーが無ければアイテム画面へ飛ばす
    $mdata = $this->Member->findById($member_id);
    //アイテムがない場合は購入画面のリンクを出す
    $power = $mdata['Member']['power'];
    if($power<$this->quest_cost){
      $this->redirect('/item/item_power_top/');
    }
    //パワーを減らす
    $power-=$this->quest_cost;
    $data = array(
      'id' => $member_id,
      'power' => $power,
      'update_date' => date("Y-m-d H:i:s")
    );
    $this->Member->save($data);
    //expを付与する
    $add_point = $this->once_quest_exp;
    $this->StructureSql->call_get_bank_exp($member_id,$add_point);
    //ここから本編の実行
    $data = $this->MemberQuestDetail->findById($member_quest_detail_id);
    $member_quest_id = $data['MemberQuestDetail']['member_quest_id'];
    $detail_no = $data['MemberQuestDetail']['detail_no'];
    $member_quest_detail_title = $data['MemberQuestDetail']['title'];
    $last_marker_flag = $data['MemberQuestDetail']['last_marker_flag'];
    $resoluved_flag = $data['MemberQuestDetail']['resoluved_flag'];
    $all_distance = $data['MemberQuestDetail']['all_distance'];
    $distance = $data['MemberQuestDetail']['distance'];
    $detail_no = $data['MemberQuestDetail']['detail_no'];
    $mq_data = $this->MemberQuest->findById($member_quest_id);
    $quest_id = $mq_data['MemberQuest']['quest_id'];
    $evidence_appear_rate = $data['MemberQuest']['evidence_appear_rate'];
    if(strlen($distance)==0){$distance=0;}
    $after_distance=$distance + $this->quest_distance;
    $resoluved_flag = 0;
    $first_resolved_flag =0;
    $return_datalist_flag=0;
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
          //メールを送る
          $title = '「'.$member_quest_detail_title.'」の捜査が完了しました！';
          $comment = '';
          //メッセージ送信
          $this->send_message($member_id,$title,$comment);
          //$this->redirect('/quest/datalist/'.$member_quest_id);
        }
      }elseif($last_marker_flag == 1){
         $return_datalist_flag=1;
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
    //ある確率で証拠を取得(ただし画面遷移するため解決時は除く)基本的には4前後が望ましい
    $rand_no = mt_rand(0,$evidence_appear_rate);
    //$rand_no = 1;
    if(($first_resolved_flag==0)&&($rand_no == 1)){
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
      //コンプリートチェック
      //$this->check_evidence_compleate($member_id,$ev_data[0]['evidences']['id']);
      $this->redirect('/quest/get_evidence/mqd_i:'.$member_quest_detail_id.'/evi_i:'.$ev_data[0]['evidences']['id']);
    }
    //ある確率でアイテムゲット(ただし画面遷移するため解決時は除く)
    $rand_no_2 = mt_rand(0,20);
    if(($first_resolved_flag==0)&&($rand_no_2 == 1)){
      $item_id = $this->insert_item();
      $this->redirect('/quest/get_item/mqd_i:'.$member_quest_detail_id.'/item_i:'.$item_id);
    }
    //初回クリア直後
    if($first_resolved_flag==1){
      $this->redirect('/quest/quest_clear/'.$member_quest_id);
    }
    //最終捜査終了後
    if($return_datalist_flag==1){
      $this->redirect('/quest/datalist/'.$member_quest_id);
    }
    $this->redirect('/quest/detail/'.$member_quest_detail_id);
  }

  function quest_clear($member_quest_id){
    $this->set('member_quest_id',$member_quest_id);
  }

  function get_item(){
    $member_quest_detail_id = $this->params['named']['mqd_i'];
    $item_id = $this->params['named']['item_i'];
    //$e_data = $this->Item->findById($evidence_id);
    //$evidence_name = $e_data['Evidence']['name'];
    $this->set('item_id',$item_id);
    $this->set('item_name','回復剤');
    $this->set('member_quest_detail_id',$member_quest_detail_id);
  }

  function get_evidence(){
    $member_quest_detail_id = $this->params['named']['mqd_i'];
    $evidence_id = $this->params['named']['evi_i'];
    $e_data = $this->Evidence->findById($evidence_id);
    $evidence_name = $e_data['Evidence']['name'];
    $evidence_img_id = $e_data['Evidence']['img_id'];

    $this->set('evidence_id',$evidence_id);
    $this->set('evidence_name',$evidence_name);
    $this->set('evidence_img_id',$evidence_img_id);
    $this->set('member_quest_detail_id',$member_quest_detail_id);
  }

  function send_message($member_id,$title,$comment){
    //メッセージを入れる
    $msdata = array(
      'Message' => array(
        'member_id' => $member_id,
        'title' => $title,
        'comment' => $comment,
        'genre_id' => 3,
        'read_flag' => 0,
        'insert_time' => date("Y-m-d H:i:s")
       )
    );
    $this->Message->create();
    $this->Message->save($msdata);
  }

  function check_evidence_compleate($member_id,$evidence_id){
    $ev_data = $this->Evidence->findById($evidence_id);
    $quest_id = $ev_data['Evidence']['quest_id'];
    $compleate_count = $ev_data['Evidence']['compleate_count'];
    $member_quest_id = $this->MemeberQuest->findByQuestId($quest_id);
    //自分が集めた証拠数
    $ev_c_data = $this->StructureSql->count_evidence_by_member_quest($member_quest_id);
    $ev_count = $ev_c_data[0][0]['count'];
    //最大数を超えていた場合には発動
    if($ev_count>=$compleate_count){
      //update_evidence
      $this->StructureSql->update_evidence_compleate_flag($member_quest_id);
      //member_quests
      $mq_data = array(
        'MemberQuest' => array(
          'id' =>$member_quest_id,
          'evidence_compleate_flag' =>1,
          'update_time' =>date("Y-m-d H:i:s")
        )
      );
      $this->MemberQuest->save($mq_data);
      //コンプリートにリダイレクト？
    }

  }

  function insert_item($item_id){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    $mdata = $this->Member->findById($member_id);
    if(strlen($item_id)==0){
      $item_id = mt_rand(1,3);
    }
    $item_power = $mdata['Member']['item_power'];
    $item_challenge = $mdata['Member']['item_challenge'];
    $item_star = $mdata['Member']['item_star'];
    if($item_id==1){
      $item_power+=1;
    }elseif($item_id==2){
      $item_challenge+=1;
    }elseif($item_id==2){
      $item_star+=1;
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