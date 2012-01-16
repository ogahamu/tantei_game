<?php

///usr/bin/php /var/www/html/test4/cake/cake/console/cake.php daily_batch -app /var/www/html/test4/cake/app

class DailyBatchShell extends Shell {

  var $uses = array('MemberTreasure','TreasureSerie','Bank','Treasure','Member','MemberItem','MemberRequest','MemberSpell','Request','StructureSql');

  function main(){
    echo "start";
    //全会員を取得
    $all_member_data = $this->Member->findAll();
    foreach($all_member_data as $mdata){
      $this->update_member_hp($mdata['Member']['id'],$mdata['Member']['power'],$mdata['Member']['max_power']);
    }
    echo "end";
  }

  function update_member_hp($member_id,$power,$max_power){
    $added_power = $power + 10;
    if($added_power >= $max_power){
      $added_power = $max_power;
    }
    //ステータスを変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'power'=>$added_power,
        'update_date' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($mdata);
  }
}