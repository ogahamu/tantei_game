<?php

///usr/bin/php /var/www/html/test4/cake/cake/console/cake.php daily_batch -app /var/www/html/test4/cake/app

class DailyRankingBatchShell extends Shell {

  var $uses = array('Member');

  function main(){
    echo "start";
    //全会員数を取得
    $total_members = $this->Member->find('count');
    //全会員を取得
    $all_member_data = $this->Member->find('all',array(null,'order'=>array('mission_count desc,sum_exp desc'),null,null));
    $rank_no=1;
    foreach($all_member_data as $mdata){
      $this->update_member_ranking($mdata['Member']['id'],$rank_no,$total_members);
      $rank_no+=1;
    }
    echo $rank_no.'/'.$total_members.'finish...';
    echo "end";
  }

  function update_member_ranking($member_id,$rank_no,$total_members){
    //ステータスを変更
    $mdata = array(
      'Member' => array(
        'id' => $member_id,
        'rank_no'=>$rank_no,
        'total_members'=>$total_members,
        'update_date' => date("Y-m-d H:i:s")
      )
    );
    $this->Member->save($mdata);
    echo '['.$member_id.']'.$rank_no.'/'.$total_members;
  }
}