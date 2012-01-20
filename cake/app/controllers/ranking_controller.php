<?php

class RankingController extends AppController{

  var $uses = array('StructureSql','Member','Message','Quest','QuestDetail','MemberQuest','MemberQuestDetail');
  var $session_data;
  var $components = array('Pager');

  function top($page_no){
    $this->session_manage();
    //セッションから会員番号を取得
    $member_id = $this->session_data['id'];
    //セッションから会員番号を取得
    $mdata = $this->Member->findById($member_id);
    $total_members = $mdata['Member']['total_members'];
    $rank_no = $mdata['Member']['rank_no'];
    $own_page = ceil($rank_no/10);
    //ページが設定されていなければ、自分が入っているページ
    if(strlen($page_no)==0){
      $page_no=$own_page;
    }
    $divide_no = 10;
    //ページ表示部分
    $vlist = $this->Pager->pagelink($divide_no,$total_members,'/cake/ranking/top/',$page_no);
    $this->set('vlist',$vlist);
    $page_end_no = $divide_no * $page_no;
    $page_start_no = $page_end_no - ($divide_no - 1) -1;
    $data = $this->Member->find('all',array(null,'order'=>array('rank_no asc'),'limit'=>$divide_no,'page'=>$page_no));
    $this->set('data',$data);
    $this->set('own_page',$own_page);
  }

  function self_rank(){


  }

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['id'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}