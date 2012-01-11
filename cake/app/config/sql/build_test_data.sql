delimiter //
drop procedure build_test_data//
create procedure build_test_data(in local_max_counter_1 int,in local_max_counter_2 int)
begin
  declare local_test_name varchar(250);
  declare local_thumnail_url varchar(250);
  declare local_evidence_id int;
  declare local_evidence_name varchar(250);
  declare local_evidence_img_id int;
  declare local_counter_1 int;
  declare local_counter_2 int;
  declare local_treasure_member int;
  set local_counter_1 = 1;
  set local_counter_2 = 1;
  delete from members;
  delete from member_treasures;
  delete from member_requests;

  while local_counter_1 < local_max_counter_1 do
    select name into local_test_name from test_names order by rand() limit 1;
    select
      concat('http://bank.blamestitch.com/jpg/test/',local_counter_1,'.jpg')
    into
      local_thumnail_url
    ;
    insert into members (
      id,
      mixi_account_id,
      thumnail_url,
      name,
      power,
      max_power,
      money,
      lv,
      exp,
      least_next_exp,
      sum_exp,
      star_count
    )values(
      local_counter_1,
      local_counter_1,
      local_thumnail_url,
      local_test_name,
      1000,
      1000,
      1000,
      1,
      0,
      1000,
      0,
      10
    );
    while local_counter_2 < local_max_counter_2 do
      select id,name,img_id
      into local_evidence_id,local_evidence_name,local_evidence_img_id
      from evidences order by rand() limit 1;
      insert into member_evidences(
        evidence_id,member_id,name,img_id,member_quest_id,member_quest_detail_id
      )values(
        local_evidence_id,local_evidence_name,local_evidence_img_id
      )
      set local_counter_2 = local_counter_2 + 1;
    end while;
    call check_compleate_series(local_counter_1);
    set local_counter_1 = local_counter_1 + 1;
  end while;
end
//
delimiter ;
call build_test_data(800,4000);