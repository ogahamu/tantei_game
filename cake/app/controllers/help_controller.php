<?php
//facebook

class HelpController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $components = array('Transaction');

  function top(){
    $this->session_manage();
  }

  function page1(){

  }

  function page2(){
    //$this->session_manage();
  }

  function page3(){
    //$this->session_manage();
  }

  function page4(){
    //$this->session_manage();
  }

  function page5(){
    //$this->session_manage();
  }

  function page6(){
    //$this->session_manage();
  }

  function page7(){
    //$this->session_manage();
  }

  function page8(){
    //$this->session_manage();
  }

  function transaction_test(){

      //$this->Transaction->begin(array($this->Member,$this->MemberQuest));

      $this->Member->begin();
      $this->MemberQuest->begin();
      $this->StructureSql->begin();



      $data = array(
        'Member' => array(
          'name' => 'AA',
          'insert_date' => date("Y-m-d H:i:s")
        )
      );
      $this->Member->create();
      $member_result = $this->Member->save($data);

      $mq_data = array(
        'MemberQuest' => array(
          'member_id' => '99'
        )
      );
      $this->MemberQuest->create();
      $mq_result =$this->MemberQuest->save($mq_data);

      $this->StructureSql->call_get_money(99,9999,0);




      $this->Member->commit();
      $this->MemberQuest->commit();
      $this->StructureSql->commit();


/*
      if($member_result !==false && $mq_result!==false){
        echo 'commit!!!';
        $this->Member->commit();
        $this->MemberQuest->commit();
      }else{
        echo 'rollback!!!';
        $this->Member->rollback();
        $this->MemberQuest->rollback();
      }
*/


/*
      $mq_data = array(
        'MemberQuest' => array(
          'id' => 'AA',
          'member_id' => 99,
          'insert_date' => date("Y-m-d H:i:s")
        )
      );
      $this->MemberQuest->create();
      $member_quest_result = $this->MemberQuest->save($mq_data);
*/
      /*
      $this->StructureSql->call_get_money(99,99999,100)
      */

      //var_dump($member);
      //var_dump($member_quest);
/*
      if($member_result !== false && $member_quest_result !== false){
        $this->Transaction->commit();
      }else{
        $this->Transaction->rollback();
      }
*/
  }

  function test1(){
  }
  function test2(){
  }
  function test3(){
  }
  function test4(){
  }
  function test5(){
  }
  function test6(){
  }
  function test7(){
  }
  function test8(){
  }
  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}