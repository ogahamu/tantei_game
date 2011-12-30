delimiter //
drop procedure build_test_data//
create procedure build_test_data(in local_max_counter_1 int,in local_max_counter_2 int)
begin
  declare local_test_name varchar(250);
  declare local_thumnail_url varchar(250);
  declare local_treasure_id int;
  declare local_treasure_name varchar(250);
  declare local_treasures_series_id int;
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
    insert into members(
      id,
      mixi_account_id,
      thumnail_url,
      name,
      money,
      member_request_id,
      power,
      max_power,
      lv,
      exp,
      least_next_exp,
      sum_exp,
      insert_date
    )values(
      local_counter_1,
      local_counter_1,
      local_thumnail_url,
      local_test_name,
      100,
      0,
      500,
      500,
      1,
      0,
      1000,
      0,
      NOW()
    );
    while local_counter_2 < local_max_counter_2 do
      select id into local_treasure_member from test_names where id<=local_max_counter_1 order by rand() limit 1;
      select id,name,series_id
      into local_treasure_id,local_treasure_name,local_treasures_series_id
      from treasures order by rand() limit 1;
      insert into member_treasures(
        member_id,treasure_id,treasure_name,series_id,insert_time,update_time
      )values(
        local_treasure_member,local_treasure_id,local_treasure_name,local_treasures_series_id,NOW(),NOW()
      );
      set local_counter_2 = local_counter_2 + 1;
    end while;
    call check_compleate_series(local_counter_1);
    set local_counter_1 = local_counter_1 + 1;
  end while;
end
//
delimiter ;
call build_test_data(800,4000);