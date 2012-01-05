<?php
class StructureSql extends AppModel
{
public $useTable = 'members';

  function select_map_banks($limit_count){
    $strSql = "select * from banks order by id limit ".$limit_count."  \n";
    return $this->query($strSql);
  }

  function select_own_serease_count($member_id,$series_id){
    $strSql   = "select  \n";
    $strSql  .= "count(*) as count  \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_treasures  \n";
    $strSql  .= "where  \n";
    $strSql  .= "series_id = ".$series_id." and  \n";
    $strSql  .= "member_id = ".$member_id."  \n";
    $strSql  .= "group by series_id  \n";
    return $this->query($strSql);
  }

  function select_map_max_id($member_id){
    $strSql   = "select  \n";
    $strSql  .= "    ifnull(max(map_id),'0')+1 as map_max_id  \n";
    $strSql  .= "from  \n";
    $strSql  .= "    (  \n";
    $strSql  .= "    select    \n";
    $strSql  .= "        target_1.map_id as map_id,    \n";
    $strSql  .= "        truncate(count(*)/target_2.count*100,0) as rate  \n";
    $strSql  .= "    from    \n";
    $strSql  .= "        (    \n";
    $strSql  .= "        select    \n";
    $strSql  .= "            member_treasures.treasure_id,    \n";
    $strSql  .= "            treasures.map_id,    \n";
    $strSql  .= "            count(*) as count    \n";
    $strSql  .= "        from    \n";
    $strSql  .= "            member_treasures,  \n";
    $strSql  .= "            treasures    \n";
    $strSql  .= "        where    \n";
    $strSql  .= "            member_treasures.treasure_id = treasures.id   \n";
    $strSql  .= "            and member_treasures.member_id = ".$member_id."   \n";
    $strSql  .= "        group by    \n";
    $strSql  .= "            member_treasures.treasure_id,    \n";
    $strSql  .= "            treasures.map_id    \n";
    $strSql  .= "        ) target_1,    \n";
    $strSql  .= "        (    \n";
    $strSql  .= "        select     \n";
    $strSql  .= "            map_id,    \n";
    $strSql  .= "            count(*) as count     \n";
    $strSql  .= "        from     \n";
    $strSql  .= "            treasures     \n";
    $strSql  .= "        group by     \n";
    $strSql  .= "            map_id    \n";
    $strSql  .= "        ) target_2    \n";
    $strSql  .= "    where    \n";
    $strSql  .= "        target_1.map_id = target_2.map_id    \n";
    $strSql  .= "    group by    \n";
    $strSql  .= "        target_1.map_id,target_2.count  \n";
    $strSql  .= "    ) target_3  \n";
    $strSql  .= "where  \n";
    $strSql  .= "    target_3.rate >= 80  \n";
    return $this->query($strSql);
  }

  function select_map_own_compleate_rate($member_id){
    $strSql   = "select  \n";
    $strSql  .= "    target_1.map_id,  \n";
    $strSql  .= "    count(*) as count,  \n";
    $strSql  .= "    target_2.count  \n";
    $strSql  .= "from  \n";
    $strSql  .= "    (  \n";
    $strSql  .= "    select  \n";
    $strSql  .= "        member_treasures.treasure_id,  \n";
    $strSql  .= "        treasures.map_id,  \n";
    $strSql  .= "        count(*) as count  \n";
    $strSql  .= "    from  \n";
    $strSql  .= "        member_treasures,  \n";
    $strSql  .= "        treasures  \n";
    $strSql  .= "    where  \n";
    $strSql  .= "        member_treasures.treasure_id = treasures.id  \n";
    $strSql  .= "        and member_treasures.member_id = ".$member_id."  \n";
    $strSql  .= "    group by  \n";
    $strSql  .= "        member_treasures.treasure_id,  \n";
    $strSql  .= "        treasures.map_id  \n";
    $strSql  .= "    ) target_1,  \n";
    $strSql  .= "    (  \n";
    $strSql  .= "    select   \n";
    $strSql  .= "        map_id,  \n";
    $strSql  .= "        count(*) as count   \n";
    $strSql  .= "    from   \n";
    $strSql  .= "        treasures   \n";
    $strSql  .= "    group by   \n";
    $strSql  .= "        map_id  \n";
    $strSql  .= "    ) target_2  \n";
    $strSql  .= "where  \n";
    $strSql  .= "    target_1.map_id = target_2.map_id  \n";
    $strSql  .= "group by  \n";
    $strSql  .= "    target_1.map_id,target_2.count  \n";
    return $this->query($strSql);
  }

  function select_map_all_compleate_rate($member_id,$bank_limit){
    $strSql   = "select  \n";
    $strSql  .= "    target_2.map_id,  \n";
    $strSql  .= "    count(*) as count,  \n";
    $strSql  .= "    target_2.count,  \n";
    $strSql  .= "    banks.name,  \n";
    $strSql  .= "    banks.lv,  \n";
    $strSql  .= "    banks.country_name  \n";
    $strSql  .= "from  \n";
    $strSql  .= "    (  \n";
    $strSql  .= "    select  \n";
    $strSql  .= "        member_treasures.treasure_id,  \n";
    $strSql  .= "        treasures.map_id,  \n";
    $strSql  .= "        count(*) as count  \n";
    $strSql  .= "    from  \n";
    $strSql  .= "        member_treasures,  \n";
    $strSql  .= "        treasures  \n";
    $strSql  .= "    where  \n";
    $strSql  .= "        member_treasures.treasure_id = treasures.id  \n";
    $strSql  .= "        and member_treasures.member_id = ".$member_id."  \n";
    $strSql  .= "    group by  \n";
    $strSql  .= "        member_treasures.treasure_id,  \n";
    $strSql  .= "        treasures.map_id  \n";
    $strSql  .= "    ) target_1  \n";
    $strSql  .= "    right join (  \n";
    $strSql  .= "    select   \n";
    $strSql  .= "        map_id,  \n";
    $strSql  .= "        count(*) as count   \n";
    $strSql  .= "    from   \n";
    $strSql  .= "        treasures   \n";
    $strSql  .= "    group by   \n";
    $strSql  .= "        map_id  \n";
    $strSql  .= "    order by  \n";
    $strSql  .= "        map_id  \n";
    $strSql  .= "    limit ".$bank_limit."  \n";
    $strSql  .= "    ) target_2 on (target_1.map_id = target_2.map_id)  \n";
    $strSql  .= "    left join banks on banks.id = target_2.map_id  \n";
    $strSql  .= "group by  \n";
    $strSql  .= "    target_2.map_id,target_2.count,banks.name,banks.lv,banks.country_name  \n";
    return $this->query($strSql);
  }

  function select_list_treasure_own_user($treasure_id){
    $strSql   = "select  \n";
    $strSql  .= "members.id,  \n";
    $strSql  .= "members.name,  \n";
    $strSql  .= "members.thumnail_url,  \n";
    $strSql  .= "member_treasures.id,  \n";
    $strSql  .= "member_treasures.treasure_id,  \n";
    $strSql  .= "member_treasures.treasure_name  \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_treasures,members  \n";
    $strSql  .= "where  \n";
    $strSql  .= "member_treasures.member_id = members.id   \n";
    $strSql  .= "and compleate_item_flag = 0   \n";
    $strSql  .= "and treasure_id = ".$treasure_id."  \n";
    $strSql  .= "order by rand() limit 10 \n";
    return $this->query($strSql);
  }

  function select_send_mail_member(){
    $strSql   = "select   \n";
    $strSql  .= "id,   \n";
    $strSql  .= "count-1 as count \n";
    $strSql  .= "from(   \n";
    $strSql  .= "select   \n";
    $strSql  .= "members.id,   \n";
    $strSql  .= "count(*) as count   \n";
    $strSql  .= "from   \n";
    $strSql  .= "members \n";
    $strSql  .= "left join member_requests on members.id = member_requests.member_id and member_requests.process_status = 0 and member_requests.information_flag = 0 and member_requests.limit_time >= now()  \n";
    $strSql  .= "group by    \n";
    $strSql  .= "members.id \n";
    $strSql  .= ") target   \n";
    $strSql  .= "where   \n";
    $strSql  .= "target.count <= 4   \n";
    return $this->query($strSql);
  }

  function select_treasure_series_list(){
    $strSql   = "select  \n";
    $strSql  .= "treasure_series.id as id,  \n";
    $strSql  .= "treasure_series.name,  \n";
    $strSql  .= "min(treasures.lv) as min_lv,  \n";
    $strSql  .= "max(treasures.lv) as max_lv \n";
    $strSql  .= "from  \n";
    $strSql  .= "treasures,  \n";
    $strSql  .= "treasure_series  \n";
    $strSql  .= "where  \n";
    $strSql  .= "treasures.series_id = treasure_series.id  \n";
    $strSql  .= "group by   \n";
    $strSql  .= "treasure_series.id,  \n";
    $strSql  .= "treasure_series.name  \n";
    return $this->query($strSql);
  }

  function select_min_request_id($max_member_request_id){
    $strSql   = "select min(requests.id) as min_request_id  from requests where  \n";
    $strSql  .= "requests.id > ".$max_member_request_id."   \n";
    return $this->query($strSql);
  }

  function select_own_treasure_list($member_id){
    $strSql   = "select  \n";
    $strSql  .= "treasures.id,ifnull(member_treasures.id,'0') as treasure_id,ifnull(member_treasures.treasure_name,'秘') as treasure_name  \n";
    $strSql  .= "from  \n";
    $strSql  .= "treasures  \n";
    $strSql  .= "left join member_treasures on treasures.id = member_treasures.treasure_id  \n";
    $strSql  .= "and member_treasures.member_id = ".$member_id." \n";
    return $this->query($strSql);
  }

  function select_own_serease_list($member_id){
    $strSql   = "select    \n";
    $strSql  .= "series_id,treasure_series.name,count(*) as count,treasure_series.compleate_count    \n";
    $strSql  .= "from    \n";
    $strSql  .= "(    \n";
    $strSql  .= "select    \n";
    $strSql  .= "treasure_id,series_id,max(insert_time) as insert_time   \n";
    $strSql  .= "from    \n";
    $strSql  .= "member_treasures    \n";
    $strSql  .= "where    \n";
    $strSql  .= "member_id = ".$member_id."  \n";
    $strSql  .= "group by treasure_id,series_id    \n";
    $strSql  .= ") target,    \n";
    $strSql  .= "treasure_series    \n";
    $strSql  .= "where    \n";
    $strSql  .= "target.series_id = treasure_series.id    \n";
    $strSql  .= "group by     \n";
    $strSql  .= "target.series_id  \n";
    $strSql  .= "order by target.series_id desc  \n";
    return $this->query($strSql);
  }

  function select_own_serease_list_order_insert_time($member_id){
    $strSql   = "select    \n";
    $strSql  .= "series_id,treasure_series.name,count(*) as count,treasure_series.compleate_count    \n";
    $strSql  .= "from    \n";
    $strSql  .= "(    \n";
    $strSql  .= "select    \n";
    $strSql  .= "treasure_id,series_id,max(insert_time) as insert_time   \n";
    $strSql  .= "from    \n";
    $strSql  .= "member_treasures    \n";
    $strSql  .= "where    \n";
    $strSql  .= "member_id = ".$member_id."  \n";
    $strSql  .= "group by treasure_id,series_id    \n";
    $strSql  .= ") target,    \n";
    $strSql  .= "treasure_series    \n";
    $strSql  .= "where    \n";
    $strSql  .= "target.series_id = treasure_series.id    \n";
    $strSql  .= "group by     \n";
    $strSql  .= "target.series_id  \n";
    $strSql  .= "order by target.insert_time desc  \n";
    return $this->query($strSql);
  }

  function select_own_serease_detail($member_id,$series_id){
    $strSql   = "select  \n";
    $strSql  .= "treasures.id,ifnull(member_treasures.treasure_id,'0') as treasure_id,ifnull(member_treasures.treasure_name,'秘') as treasure_name  \n";
    $strSql  .= "from  \n";
    $strSql  .= "treasures  \n";
    $strSql  .= "left join member_treasures on treasures.id = member_treasures.treasure_id  \n";
    $strSql  .= "and member_treasures.member_id = ".$member_id." and member_treasures.series_id = ".$series_id."\n";
    $strSql  .= "where  \n";
    $strSql  .= "treasures.series_id = ".$series_id." \n";
    $strSql  .= "group by  \n";
    $strSql  .= "id,treasure_id,treasure_name \n";
    return $this->query($strSql);
  }

  function count_no_read($member_id,$process_status){
    $strSql   = "select  \n";
    $strSql  .= "count(*) as count \n";
    $strSql  .= "from  \n";
    $strSql  .= "member_requests  \n";
    $strSql  .= "where  \n";
    $strSql  .= "read_flag = 0 and process_status = ".$process_status."  \n";
    $strSql  .= "and member_id = ".$member_id." \n";
    return $this->query($strSql);
  }

  function select_count_compleate_treasure($member_id){
    $strSql   = "select \n";
    $strSql  .= "count(*) as count \n";
    $strSql  .= "from( \n";
    $strSql  .= "select \n";
    $strSql  .= "treasure_series.id, \n";
    $strSql  .= "treasure_series.compleate_count, \n";
    $strSql  .= "treasure_series.name, \n";
    $strSql  .= "count(*) as count \n";
    $strSql  .= "from  \n";
    $strSql  .= "treasures  \n";
    $strSql  .= "left join member_treasures on treasures.id = member_treasures.treasure_id \n";
    $strSql  .= "right join treasure_series on treasures.series_id = treasure_series.id \n";
    $strSql  .= "and member_treasures.member_id =".$member_id." \n";
    $strSql  .= "group by treasures.series_id,treasure_series.compleate_count,treasure_series.name \n";
    $strSql  .= ") target \n";
    $strSql  .= "where \n";
    $strSql  .= "target.compleate_count <= target.count \n";
    return $this->query($strSql);
  }

  function select_result_rank($member_id){
    $strSql   = "select \n";
    $strSql  .= "result_ranks.name, \n";
    $strSql  .= "(select count(*) from member_requests where result_rank = result_ranks.name and member_id =  ".$member_id.") as count \n";
    $strSql  .= "from \n";
    $strSql  .= "result_ranks \n";
    $strSql  .= "order by  \n";
    $strSql  .= "result_ranks.id \n";
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

  function select_rand_treasures($lv){
    $strSql  = "select * from treasures where lv <= ".$lv." order by rand() limit 1 \n";
    return $this->query($strSql);
  }

  function select_rand_treasures_by_map_id($map_id){
    $strSql  = "select * from treasures where map_id = ".$map_id." order by rand() limit 1 \n";
    return $this->query($strSql);
  }

  function select_rand_banks($member_lv){
    $strSql  = "select * from banks where lv <= ".$member_lv." order by rand() limit 1 \n";
    return $this->query($strSql);
  }

  function count_compleate_series($member_id){
    $strSql   = "select \n";
    $strSql  .= "count(*) as count \n";
    $strSql  .= "from \n";
    $strSql  .= "( \n";
    $strSql  .= "select \n";
    $strSql  .= "series_id \n";
    $strSql  .= "from \n";
    $strSql  .= "member_treasures \n";
    $strSql  .= "where \n";
    $strSql  .= "member_id = ".$member_id." and compleate_item_flag = 1 \n";
    $strSql  .= "group by series_id \n";
    $strSql  .= ") target \n";
    return $this->query($strSql);
  }

  function already_read_flag(){
    $strSql   = "update member_requests set read_flag = 1 where limit_time <= NOW(); \n";
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

}
?>