delimiter //
drop procedure test_m_evidence//
create procedure test_m_evidence()
begin
    declare done int;
    declare local_evi_name varchar(250);
    declare local_evi_id varchar(250);
    declare cur cursor for
      select
        name,
        img_id
      from
        evidences;
      declare exit handler for not found set done = 0;
    set done = 1;
    open cur;
      while done do
        fetch cur into
          local_evi_name,
          local_evi_id
      ;
        insert into m_evidences(name,img_id)values(local_evi_name,local_evi_id);
      end while;
    close cur;
end
//
delimiter ;
call test_m_evidence();
select count(*) from m_evidences;