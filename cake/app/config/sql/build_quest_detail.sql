delimiter //
drop procedure build_quest_detail//
create procedure build_quest_detail(in local_start_quest_id int)
begin
    declare done int;
    declare local_quest_id int;
    declare local_quest_title varchar(250);
    declare local_quest_comment varchar(250);
    declare local_quest_exp int;
    declare local_quest_price int;
    declare local_quest_challenge_count int;
    declare local_quest_evidence_appear_rate int;
    declare local_randam_num int;
    declare local_title varchar(250);
    declare local_comment varchar(250);
    declare local_all_distance int;
    declare local_exp int;
    declare local_counter_1 int;
    declare local_evidence_id  int;
    declare local_evidence_name  varchar(250);
    declare local_evidence_img_id  varchar(250);

    declare cur cursor for
      select
        id,
        title,
        comment,
        quest_exp,
        quest_price,
        challenge_count,
        evidence_appear_rate
      from
        quests
      where
        id >= local_start_quest_id
      ;
      declare exit handler for not found set done = 0;
    set done = 1;
    delete from quest_details where quest_id >= local_start_quest_id;
    delete from evidences where quest_id >= local_start_quest_id;
    open cur;
      while done do
        fetch cur into
        local_quest_id,
        local_quest_title,
        local_quest_comment,
        local_quest_exp,
        local_quest_price,
        local_quest_challenge_count,
        local_quest_evidence_appear_rate
      ;
      set local_counter_1 = 1;
        select
          FLOOR( REVERSE( RAND() ) ) %(10 - 5 + 1) + 5
        into
          local_randam_num
        ;
        set local_exp = local_randam_num * 10;
        set local_all_distance = local_randam_num * 20;
        insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(local_quest_id,1,'1.現場検証から手掛かりを探せ...','殺害現場には何か証拠になるものがあるかもしれない...',local_exp,local_all_distance,0);
        insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(local_quest_id,2,'2.聞き込みで怪しい人物を探せ...','被害者に関係する人物を洗い出して、被疑者の可能性を探れ....',local_exp,local_all_distance,0);
        insert into quest_details(quest_id,detail_no,title,comment,exp,all_distance,last_marker_flag)values(local_quest_id,3,'3.殺害トリックを導き出せ ','いよいよ殺害を行ったトリックを考え、確信を突くのだ....',local_exp,local_all_distance,1);

        while local_counter_1 <= 5 do
          select id,name,img_id
          into local_evidence_id,local_evidence_name,local_evidence_img_id
          from m_evidences order by rand() limit 1;
          insert into evidences(
            name,img_id,quest_id,quest_detail_id
          )values(
            local_evidence_name,local_evidence_img_id,local_quest_id,0
          );
          set local_counter_1 = local_counter_1 + 1;
        end while;

      end while;
    close cur;
end
//
delimiter ;
call build_quest_detail(57);
select count(*) from quests where id >= 1;
select count(*) from quest_details where quest_id >= 1;
select count(*) from evidences where quest_id >= 1;