delimiter //
drop procedure check_compleate_series//
create procedure check_compleate_series(in local_member_id int)
begin
    declare local_series_id int;
    declare local_compleate_count int;
    declare local_treasure_count int;
    declare local_series_name varchar(250);
    declare local_message_title varchar(250);
    declare local_message_body varchar(250);
    select count(*) into local_treasure_count from member_treasures where member_id = local_member_id;
    update members set treasure_count =local_treasure_count where id = local_member_id;
    select
      id,
      compleate_count,
      name
    into
      local_series_id,
      local_compleate_count,
      local_series_name
    from(
      select
        treasure_series.id,
        treasure_series.compleate_count,
        treasure_series.name,
        member_treasures.member_id,
        count(*) as count
      from
        treasures
        left join member_treasures on treasures.id = member_treasures.treasure_id
        right join treasure_series on treasures.series_id = treasure_series.id
      where
        member_treasures.compleate_flag = 0 and
        member_treasures.member_id = local_member_id
      group by
        treasures.series_id,treasure_series.compleate_count,treasure_series.name,member_id
      ) target
    where
      target.compleate_count <= target.count
    ;
    if local_compleate_count > 0 then
      update
        member_treasures
      set
        compleate_flag = 1
      where
        series_id = local_series_id
        and member_id = local_member_id
      ;
      select
          concat('【コンプリート】',local_series_name,'をコンプリートしました！1000Expを受け取りました。')
      into
          local_message_title
      ;
      select
          concat('おめでとうございます。',local_series_name,'をコンプリートしました！1000Expを受け取りました。<br>もっと多くのシリーズをコンプリートできるように頑張って下さい。')
      into
          local_message_body
      ;
      call get_bank_exp(local_member_id,1000);
      insert into member_requests(
        member_id,
        title,
        message_body,
        process_status,
        read_flag,
        information_flag,
        insert_time
      )values(
        local_member_id,
        local_message_title,
        local_message_body,
        9,
        0,
        1,
        now()
      );
    end if;
end
//
delimiter ;
call check_compleate_series(1);