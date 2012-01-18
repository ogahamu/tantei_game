<?php
//facebook

class HelpController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;

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

      $data = array(
        'Member' => array(
          'name' => 'AA',
          'insert_date' => date("Y-m-d H:i:s")
        )
      );
      $this->Member->create();
      $this->Member->save($data);




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