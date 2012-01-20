<?php

///usr/bin/php /var/www/html/test4/cake/cake/console/cake.php daily_batch -app /var/www/html/test4/cake/app
/*
create table tests(
id int NOT NULL auto_increment,
text varchar(10),
PRIMARY KEY(`id`)
)TYPE=InnoDB AUTO_INCREMENT=1;
*/
class TransactionCheckShell extends Shell {
  var $uses = array('Test');
  function main(){
    echo "start\r\n";
    $this->_commit();
    $this->_rollback();
    $this->_nouse_transaction();
    echo "end\r\n";
  }

  function _commit(){
    $this->Test->begin();
    $data = array('Test' => array('text'=>'AAA'));
    $this->Test->create();
    $commit_result = $this->Test->save($data);
    if($commit_result!=false){
      $test_id = $this->Test->getLastInsertID();
      $this->Test->commit();
    }else{
      $this->Test->rollback();
    }
    $data = $this->Test->findById($test_id);
    if($data!==false){
      echo 'コミットOK'."\r\n";
    }else{
      echo 'コミットNG'."\r\n";
    }
  }

  function _rollback(){
    $this->Test->begin();
    $data = array('Test' => array('text'=>'AAA'));
    $this->Test->create();
    $rollback_result = $this->Test->save($data);
    if($rollback_result!=false){
      $test_id = $this->Test->getLastInsertID();
      $this->Test->rollback();
    }else{
      $this->Test->rollback();
    }
    $data = $this->Test->findById($test_id);
    if($data!==false){
      echo 'ロールバックNG'."\r\n";
    }else{
      echo 'ロールバックOK'."\r\n";
    }
  }

  function _nouse_transaction(){
    $data = array('Test' => array('text'=>'AAA'));
    $this->Test->create();
    $commit_result = $this->Test->save($data);
    $test_id = $this->Test->getLastInsertID();
    $data = $this->Test->findById($test_id);
    if($data!==false){
      echo 'トランザクション記載なし_OK'."\r\n";
    }else{
      echo 'トランザクション記載なし_NG'."\r\n";
    }
  }
}