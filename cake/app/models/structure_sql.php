<?php
class StructureSql extends AppModel
{
public $useTable = 'members';

  function call_get_money($member_id,$get_money,$get_star_count){
    $strSql   = "call get_money(".$member_id.",".$get_money.",".$get_star_count.")  \n";
    return $this->query($strSql);
  }

  function update_evidence_compleate_flag($member_quest_id){
    $strSql   = "update member_evidences set compleate_flag = 1 where member_quest_id = ".$member_quest_id."  \n";
    return $this->query($strSql);
  }

  function count_evidence_by_member_quest($member_quest_id){
    $strSql   = "select \n";
    $strSql  .= "  count(*) as count \n";
    $strSql  .= "from \n";
    $strSql  .= "  ( \n";
    $strSql  .= "    select \n";
    $strSql  .= "      evidence_id \n";
    $strSql  .= "    from \n";
    $strSql  .= "      member_evidences \n";
    $strSql  .= "    where \n";
    $strSql  .= "      member_quest_id = ".$member_quest_id." \n";
    $strSql  .= "    group by \n";
    $strSql  .= "      evidence_id \n";
    $strSql  .= "  ) target \n";
    return $this->query($strSql);
  }

  function select_nealy_lv_members($member_id,$start_lv,$end_lv){
    $strSql   = "select \n";
    $strSql  .= "* \n";
    $strSql  .= "from \n";
    $strSql  .= "members \n";
    $strSql  .= "where \n";
    $strSql  .= "id <> ".$member_id." \n";
    $strSql  .= "and lv >= ".$start_lv." \n";
    $strSql  .= "and lv <= ".$end_lv." \n";
    $strSql  .= "order by rand() \n";
    $strSql  .= "limit 10 \n";
    return $this->query($strSql);
  }

  function select_count_group_evidence_id($member_id,$member_quest_id){
    $strSql  .= "select \n";
    $strSql  .= "count(*) as count \n";
    $strSql  .= "from \n";
    $strSql  .= "( \n";
    $strSql  .= "select  \n";
    $strSql  .= "evidence_id \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_evidences  \n";
    $strSql  .= "where  \n";
    $strSql  .= "member_id = ".$member_id."  \n";
    $strSql  .= "and member_quest_id = ".$member_quest_id."  \n";
    $strSql  .= "group by  \n";
    $strSql  .= "evidence_id \n";
    $strSql  .= ")target \n";
    return $this->query($strSql);
  }

  function evidence_own_members($member_id,$evidence_id){
    $strSql   = "select \n";
    $strSql  .= "members.id,members.name,members.thumnail_url,members.lv,members.win_count,members.lose_count,max(member_evidences.id) as member_evidence_id \n";
    $strSql  .= "from \n";
    $strSql  .= "member_evidences, \n";
    $strSql  .= "members \n";
    $strSql  .= "where \n";
    $strSql  .= "member_evidences.member_id = members.id \n";
    $strSql  .= "and member_evidences.member_id <> ".$member_id." \n";
    $strSql  .= "and member_evidences.evidence_id = ".$evidence_id." \n";
    $strSql  .= "and member_evidences.compleate_flag = 0 \n";
    $strSql  .= "group by  \n";
    $strSql  .= "members.id,members.name,members.thumnail_url,members.lv,members.win_count,members.lose_count \n";
    return $this->query($strSql);
  }

  function select_member_ranking_count($member_id){
    $strSql    = "select  \n";
    $strSql   .= "count(*) + 1 as count  \n";
    $strSql   .= "from  \n";
    $strSql   .= "members  \n";
    $strSql   .= "where  \n";
    $strSql   .= "sum_exp > ( \n";
    $strSql   .= "select  \n";
    $strSql   .= "sum_exp  \n";
    $strSql   .= "from  \n";
    $strSql   .= "members  \n";
    $strSql   .= "where  \n";
    $strSql   .= "id = ".$member_id." \n";
    $strSql   .= ") \n";
    return $this->query($strSql);
  }

  function select_own_evidence_list($quest_id,$member_id){
    $strSql   = "select    \n";
    $strSql  .= "evidences.id,  \n";
    $strSql  .= "evidences.name,  \n";
    $strSql  .= "evidences.img_id,  \n";
    $strSql  .= "ifnull(member_evidences.evidence_id,0) as evidence_id,  \n";
    $strSql  .= "ifnull(member_evidences.img_id,'0') as evidence_img_id,  \n";
    $strSql  .= "max(member_evidences.id) as member_evidences_id,  \n";
    $strSql  .= "count(member_evidences.id) as count  \n";
    $strSql  .= "from    \n";
    $strSql  .= "evidences    \n";
    $strSql  .= "left join member_evidences on evidences.id = member_evidences.evidence_id and member_evidences.member_id = ".$member_id."    \n";
    $strSql  .= "where    \n";
    $strSql  .= "evidences.quest_id = ".$quest_id."  \n";
    $strSql  .= "group by    \n";
    $strSql  .= "evidences.id,  \n";
    $strSql  .= "evidences.name,  \n";
    $strSql  .= "evidences.img_id  \n";
    return $this->query($strSql);
  }

  function select_own_evidence_detail($evidence_id){
    $strSql   = "select  \n";
    $strSql  .= "evidences.id,evidences.name,max(member_evidences.id) as member_evidences_id,ifnull(max(member_evidences.img_id),'0') as m_e_img_id,count(*) as count  \n";
    $strSql  .= "from  \n";
    $strSql  .= "evidences  \n";
    $strSql  .= "left join member_evidences on evidences.id = member_evidences.evidence_id  \n";
    $strSql  .= "where  \n";
    $strSql  .= "evidences.id = ".$evidence_id."  \n";
    $strSql  .= "group by  \n";
    $strSql  .= "evidences.id,evidences.name  \n";
    return $this->query($strSql);
  }

  function select_member_quest_details_by_quest_id($quest_id){
    $strSql   = "select * from member_quest_details where quest_id = ".$quest_id."  \n";
    return $this->query($strSql);
  }

  function select_evidence_by_rand($quest_id){
    $strSql   = "select * from evidences where quest_id = ".$quest_id." order by rand() limit 1 \n";
    return $this->query($strSql);
  }

  function select_own_evidence_count($member_id,$quest_id){
    $strSql   = "select  \n";
    $strSql  .= "count(*) as count  \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_evidences  \n";
    $strSql  .= "where  \n";
    $strSql  .= "quest_id = ".$quest_id." and  \n";
    $strSql  .= "member_id = ".$member_id."  \n";
    $strSql  .= "group by quest_id  \n";
    return $this->query($strSql);
  }

  function select_own_quest_list($member_id){
    $strSql   = "select    \n";
    $strSql  .= "quest_id,quests.quest_name,count(*) as count,1    \n";
    $strSql  .= "from    \n";
    $strSql  .= "(    \n";
    $strSql  .= "select    \n";
    $strSql  .= "evidence_id,quest_id,max(insert_time) as insert_time   \n";
    $strSql  .= "from    \n";
    $strSql  .= "member_evidences    \n";
    $strSql  .= "where    \n";
    $strSql  .= "member_id = ".$member_id."  \n";
    $strSql  .= "group by evidence_id,quest_id    \n";
    $strSql  .= ") target,    \n";
    $strSql  .= "quests    \n";
    $strSql  .= "where    \n";
    $strSql  .= "target.quest_id = quests.id    \n";
    $strSql  .= "group by     \n";
    $strSql  .= "target.quest_id  \n";
    $strSql  .= "order by target.quest_id desc  \n";
    return $this->query($strSql);
  }

  function call_get_bank_exp($member_id,$add_point){
    $strSql  = "call get_bank_exp(".$member_id.",".$add_point.") \n";
    $this->query($strSql);
  }

  function call_check_compleate_series($member_id){
    $strSql  = "call check_compleate_series(".$member_id.") \n";
    $this->query($strSql);
  }
}
?>