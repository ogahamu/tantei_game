<?php
//facebook

class StoryController extends AppController{

  var $uses = array('Member','Item','MemberItem','MemberRequest','MemberSpell','Request','Spell');
  var $session_data;

  function top(){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
  }

  function story1(){

  }

  function story2(){


  }

  function select_character(){

/*
 * 1.体力多め
 * 2.１個目が分る
 * 3.
 *
 *
 */

  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}