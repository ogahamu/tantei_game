<?php

///usr/bin/php /var/www/html/test4/cake/cake/console/cake.php daily_batch -app /var/www/html/test4/cake/app

class DailyBatchShell extends Shell {

  var $uses = array('MemberTreasure','TreasureSerie','Bank','Treasure','Member','MemberItem','MemberRequest','MemberSpell','Request','StructureSql');

  function main(){
    echo "start";

    //全会員を取得
    $all_member_data = $this->Member->findAll();
    foreach($all_member_data as $mdata){
      $this->update_member_hp($mdata['Member']['id']);
    }
    //一部選択
    $member_data = $this->StructureSql->select_send_mail_member();
    foreach($member_data as $mdata){
      $this->insert_request($mdata['target']['id']);
    }

    $this->StructureSql->already_read_flag();

    echo "end";
  }

  function update_member_hp($member_id){
    $member_data = $this->Member->findById($member_id);
    $power = $member_data['Member']['power'];
    $max_power = $member_data['Member']['max_power'];
    $added_power = $power + 100;
    if($added_power >= $max_power){
      $added_power = $max_power;
    }
    $mt_count = $this->MemberTreasure->find('count', array('conditions' => array('member_id' => $member_id)));
    $comp_data = $this->StructureSql->count_compleate_series($member_id);
    $comp_count = $comp_data[0][0]['count'];
    //ステータスを変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'power'=>$added_power,
        'update_date' => date("Y-m-d H:i:s"),
        'treasure_count' => $mt_count,
        'compleate_treasure_count' => $comp_count
      )
    );
    $this->Member->save($mdata);
  }

  function insert_request($member_id){
    //自分のlv以下のbankを選択
    $member_data = $this->Member->findById($member_id);
    $lv = $member_data['Member']['lv'];
    if (empty($lv)){
      $lv = 1;
    }
    $bank_data = $this->StructureSql->select_rand_banks(ceil($lv/10+1));
    $bank_id = $bank_data[0]['banks']['id'];
    $bank_name = $bank_data[0]['banks']['name'];
    $bank_lv = $bank_data[0]['banks']['lv'];
    $bank_country = $bank_data[0]['banks']['country_name'];
    $bank_max_spell = $bank_data[0]['banks']['max_spell'];
    $bank_max_count = $bank_data[0]['banks']['max_count'];
    //自分のlv以上のtreasureを選択
    $treasure_data = $this->StructureSql->select_rand_treasures($lv);
    $treasure_id = $treasure_data[0]['treasures']['id'];
    $treasure_name = $treasure_data[0]['treasures']['name'];
    $treasure_lv = $treasure_data[0]['treasures']['lv'];
    $series_id = $treasure_data[0]['treasures']['series_id'];
    //シリーズを取得
    $series_data = $this->TreasureSerie->findById($series_id);
    $series_name = $series_data['TreasureSerie']['name'];
    //報酬を設定する
    $reward_exp = ceil(38.7755102*$treasure_lv+61.224489)+$bank_lv*10;
    $reward_price = ceil($reward_exp/4.5);

    //期限を決める
    $now_time = date("Y-m-d H:i:s");
    $limit_hour = rand(1,20);
    $limit_second = $limit_hour * 3600;
    $limit_time = date("Y-m-d H:i:s", strtotime($now_time." +$limit_second sec"));
    //メール内容を生成
    $request_title = '【情報】'.$treasure_name.'['.$series_name.']の在処がわかった..';
    $star_txt = '';
    for($i=0;$i<$bank_lv;$i++){
      $star_txt.='★';
    }
    $request_txt = '長年探していた「'.$treasure_name.'」の在処を発見したので連絡する。<br><br>場所:'.$bank_name.'の金庫。<br>保管期限：'.$limit_hour.'時間後['.$limit_time.']<br>セキュリティレベル:'.$star_txt.'(Lv'.$bank_lv.')<br>[開錠コード:'.$bank_max_spell.'桁/回数:'.$bank_max_count.']<br>最大報酬：＄'.$reward_price.'/'.$reward_exp.'Exp<br> By mr.jornson ';
    //キーワードを生成
    $rand_number = $this->keyword_maker($bank_max_spell);
    $first_spell_id = $rand_number[0];
    $second_spell_id = $rand_number[1];
    $third_spell_id = $rand_number[2];
    $data = array(
      'MemberRequest' => array(
        'member_id' => $member_id,
        'title' => $request_title,
        'message_body' => $request_txt,
        'bank_id' => $bank_id,
        'all_distance' => 100,
        'process_status' => 0,
        'read_flag' => 0,
        'challenge_count' => 0,
        'max_challenge_count' => $bank_max_count,
        'max_spell' => $bank_max_spell,
        'first_spell_id' => $first_spell_id,
        'second_spell_id' => $second_spell_id,
        'third_spell_id' => $third_spell_id,
        'treasure_id' => $treasure_id,
        'treasure_name' => $treasure_name,
        'insert_time' => date("Y-m-d H:i:s"),
        'update_time' => date("Y-m-d H:i:s"),
        'information_flag' => 0,
        'limit_time' => "$limit_time",
        'limit_hour' => $limit_hour,
        'number_suggest_flag' => 0,
        'reward_price' => $reward_price,
        'reward_exp' => $reward_exp
      )
    );
    $this->MemberRequest->save($data);
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

}