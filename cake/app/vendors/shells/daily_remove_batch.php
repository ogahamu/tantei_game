<?php

///usr/bin/php /var/www/html/test4/cake/cake/console/cake.php daily_batch -app /var/www/html/test4/cake/app

class DailyRemoveBatchShell extends Shell {

  var $uses = array('Member','Message');

  function main(){
    echo "start";
    //全会員を取得
    $all_member_data = $this->Member->find('all');
    foreach($all_member_data as $mdata){
      $this->delete_messages_over_one_week($mdata['Member']['id']);
    }
    echo "end";
  }

  function delete_messages_over_one_week($member_id){
    $one_week_ago = date("Ymd",strtotime("-1 week")); //１週間前
    $this->Message->delete('all',array('conditions'=>array("member_id"=>$member_id,'insert_time<='=>$one_week_ago)));
  }
}