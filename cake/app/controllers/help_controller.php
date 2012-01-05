<?php
//facebook

class HelpController extends AppController{

  var $uses = array('Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell');
  var $session_data;

  function top(){
    $this->session_manage();
  }

  function page1(){
    $this->session_manage();
  }

  function page2(){
    $this->session_manage();
  }

  function page3(){
    $this->session_manage();
  }

  function page4(){
    $this->session_manage();
  }

  function page5(){
    $this->session_manage();
  }

  function page6(){
    $this->session_manage();
  }

  function page7(){
    $this->session_manage();
  }

  function page8(){
    $this->session_manage();
  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}